<?php

namespace Tests\Feature;

use App\Mail\ContactRequestConfirmMail;
use App\Mail\ContactRequestMail;
use App\Models\ContactRequest;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PublicSiteTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('publicPageProvider')]
    public function test_public_pages_return_ok(string $path, array $expectedSubstrings): void
    {
        $response = $this->get($path);

        $response->assertOk();
        foreach ($expectedSubstrings as $fragment) {
            $response->assertSee($fragment, false);
        }
    }

    /**
     * @return array<string, array{0: string, 1: array<int, string>}>
     */
    public static function publicPageProvider(): array
    {
        return [
            'home' => ['/', ['Dott.ssa Cristina Pacifici', 'Domande frequenti']],
            'about' => ['/chi-sono', ['Chi sono']],
            'areas' => ['/aree', ['Aree di intervento']],
            'first-interview' => ['/primo-colloquio', ['Primo colloquio psicologico', 'Domande frequenti']],
            'contacts' => ['/contatti', ['Contatti', 'Modulo per il primo colloquio', 'Come si svolge il primo colloquio?']],
            'testimonials' => ['/testimonianze', ['Testimonianze']],
            'privacy' => ['/privacy-policy', ['Privacy', 'titolare del trattamento']],
        ];
    }

    /**
     * Allineato a routes/web.php ($areaSlugs in sitemap): ogni area ha FAQ nel body → accordion + FAQPage + Article.
     */
    #[DataProvider('areaSlugProvider')]
    public function test_each_area_page_includes_faq_section_and_json_ld(string $slug): void
    {
        $response = $this->get(route('areas.show', ['slug' => $slug]));

        $response->assertOk();
        $response->assertSee('Domande frequenti', false);
        $response->assertSee('"@type":"FAQPage"', false);
        $response->assertSee('"@type":"Article"', false);
        $response->assertSee('Altri percorsi e contatti', false);
    }

    /**
     * @return array<string, array{0: string}>
     */
    public static function areaSlugProvider(): array
    {
        $slugs = [
            'ansia-e-gestione-dello-stress',
            'umore-basso',
            'difficolta-relazionali',
            'autostima',
            'difficolta-scolastiche',
            'disturbi-del-neurosviluppo',
            'genitorialita',
            'valutazioni-psicodiagnostiche',
            'potenziamento-funzioni-esecutive',
            'potenziamento-abilita-scolastiche',
            'intervento-di-gruppo-area-emotiva-relazionale',
            'tutor-dsa-bes-adhd',
        ];

        return collect($slugs)->mapWithKeys(fn (string $s) => [$s => [$s]])->all();
    }

    public function test_unknown_area_slug_returns_404(): void
    {
        $this->get('/aree/questa-pagina-non-esiste')->assertNotFound();
    }

    public function test_sitemap_is_xml_and_lists_core_routes(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/xml');
        $content = $response->getContent();
        $this->assertStringContainsString('<urlset', $content);
        $this->assertStringContainsString(route('home'), $content);
        $this->assertStringContainsString(route('areas.show', ['slug' => 'genitorialita']), $content);
    }

    public function test_robots_allows_public_and_points_to_sitemap(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertOk();
        $response->assertSee('User-agent: *', false);
        $response->assertSee('Disallow: /admin', false);
        $response->assertSee('Sitemap: '.route('sitemap'), false);
    }

    public function test_admin_routes_require_authentication(): void
    {
        $this->get('/admin/contatti')->assertUnauthorized();
    }

    public function test_contact_form_validation_errors_on_empty_payload(): void
    {
        $response = $this->from(route('contacts'))
            ->post(route('contacts.submit'), []);

        $response->assertRedirect(route('contacts').'#richiesta-colloquio');
        $response->assertSessionHasErrors(['name', 'email', 'phone', 'message', 'privacy']);
        $this->assertSame(0, ContactRequest::count());
    }

    public function test_contact_form_success_sends_mails_and_persists(): void
    {
        Mail::fake();

        $payload = [
            'name' => 'Mario Rossi',
            'email' => 'mario.rossi@example.com',
            'phone' => '+39 340 1234567',
            'message' => 'Messaggio di prova per il test automatico, almeno dieci caratteri.',
            'privacy' => '1',
        ];

        $response = $this->from(route('contacts'))
            ->post(route('contacts.submit'), $payload);

        $response->assertRedirect(route('contacts'));
        $response->assertSessionHas('success');

        $this->get(route('contacts'))
            ->assertOk()
            ->assertSee('id="contactFormFeedbackModal"', false)
            ->assertSee('Richiesta inviata', false)
            ->assertSee('Chiudi e continua', false);

        $this->assertDatabaseHas('contact_requests', [
            'email' => 'mario.rossi@example.com',
            'name' => 'Mario Rossi',
        ]);

        Mail::assertSent(ContactRequestMail::class);
        Mail::assertSent(ContactRequestConfirmMail::class);
    }

    public function test_contact_form_accepts_phone_formats_common_on_mobile(): void
    {
        Mail::fake();

        $payload = [
            'name' => 'Mario Rossi',
            'email' => 'mario.rossi@example.com',
            'phone' => '+39 (344) 112-27-85',
            'message' => 'Messaggio di prova per il test automatico, almeno dieci caratteri.',
            'privacy' => '1',
        ];

        $response = $this->from(route('contacts'))
            ->post(route('contacts.submit'), $payload);

        $response->assertRedirect(route('contacts'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_requests', [
            'email' => 'mario.rossi@example.com',
        ]);
    }

    public function test_contact_form_honeypot_blocks_submission(): void
    {
        Mail::fake();

        $payload = [
            'name' => 'Mario Rossi',
            'email' => 'mario.rossi@example.com',
            'phone' => '+39 340 1234567',
            'message' => 'Messaggio di prova per il test automatico, almeno dieci caratteri.',
            'privacy' => '1',
            'contact_website' => 'https://spam.example.com',
        ];

        $response = $this->from(route('contacts'))
            ->post(route('contacts.submit'), $payload);

        $response->assertRedirect(route('contacts'));
        $response->assertSessionHas('success');
        $this->assertSame(0, ContactRequest::count());
        Mail::assertNothingSent();
    }

    public function test_contact_form_blocks_obvious_commercial_spam_copy(): void
    {
        Mail::fake();

        $payload = [
            'name' => 'Mario Rossi',
            'email' => 'mario.rossi@example.com',
            'phone' => '+39 340 1234567',
            'message' => 'Hi, we offer SEO services with backlinks to boost traffic and rank on Google first page.',
            'privacy' => '1',
        ];

        $response = $this->from(route('contacts'))
            ->post(route('contacts.submit'), $payload);

        $response->assertRedirect(route('contacts').'#richiesta-colloquio');
        $response->assertSessionHasErrors(['message']);
        $this->assertSame(0, ContactRequest::count());
        Mail::assertNothingSent();
    }

    public function test_contact_form_throttle_limits_repeated_submissions(): void
    {
        Mail::fake();
        Config::set('antispam.contact.max_attempts_per_minute', 2);
        Config::set('antispam.contact.max_attempts_per_hour', 20);
        Config::set('antispam.contact.max_attempts_per_hour_per_email', 20);
        Cache::flush();

        $payload = [
            'name' => 'Mario Rossi',
            'email' => 'mario.rossi@example.com',
            'phone' => '+39 340 1234567',
            'message' => 'Messaggio di prova per il test automatico, almeno dieci caratteri.',
            'privacy' => '1',
        ];

        $first = $this->from(route('contacts'))->post(route('contacts.submit'), $payload);
        $first->assertRedirect(route('contacts'));

        $second = $this->from(route('contacts'))->post(route('contacts.submit'), $payload);
        $second->assertRedirect(route('contacts'));

        $third = $this->from(route('contacts'))->post(route('contacts.submit'), $payload);
        $third->assertRedirect(route('contacts').'#richiesta-colloquio');
        $third->assertSessionHasErrors(['message']);
    }

    public function test_testimonial_form_validation_errors_on_empty_payload(): void
    {
        $response = $this->from(route('testimonials'))
            ->post(route('testimonials.store'), []);

        $response->assertRedirect(route('testimonials'));
        $response->assertSessionHasErrors(['name_label', 'message', 'consent_publish']);
        $this->assertSame(0, Testimonial::count());
    }

    public function test_testimonial_form_success_persists_unapproved_row(): void
    {
        $payload = [
            'name_label' => 'Maria R.',
            'message' => 'Esperienza molto positiva, consiglio il percorso di supporto ricevuto.',
            'consent_publish' => '1',
        ];

        $response = $this->from(route('testimonials'))
            ->post(route('testimonials.store'), $payload);

        $response->assertRedirect(route('testimonials'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('testimonials', [
            'name_label' => 'Maria R.',
            'is_approved' => false,
            'consent_publish' => true,
        ]);
    }
}
