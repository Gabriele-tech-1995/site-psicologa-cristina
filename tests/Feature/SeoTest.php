<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Concerns\ParsesHtmlMeta;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use ParsesHtmlMeta;
    use RefreshDatabase;

    #[DataProvider('staticSeoRouteProvider')]
    public function test_static_pages_use_config_meta_title_and_description(string $routeName, string $configKey): void
    {
        $expected = config("seo.pages.$configKey");
        $this->assertIsArray($expected);
        $this->assertArrayHasKey('title', $expected);
        $this->assertArrayHasKey('description', $expected);

        $response = $this->get(route($routeName));
        $response->assertOk();
        $html = $response->getContent();

        $this->assertSame($expected['title'], $this->parseHtmlTitle($html), 'Missing o <title> errato.');
        $this->assertSame($expected['description'], $this->parseMetaDescription($html), 'Missing o meta description errata.');

        $this->assertLessThanOrEqual(85, mb_strlen($expected['title']), 'Meta title: resta sotto ~85 caratteri (linea guida indicativa).');
        $this->assertLessThanOrEqual(230, mb_strlen($expected['description']), 'Meta description: resta sotto ~230 caratteri (snippet spesso tronca prima).');
    }

    /**
     * @return array<string, array{0: string, 1: string}>
     */
    public static function staticSeoRouteProvider(): array
    {
        return [
            'home' => ['home', 'home'],
            'about' => ['about', 'about'],
            'areas' => ['areas', 'areas'],
            'first interview' => ['first-interview', 'firstInterview'],
            'contacts' => ['contacts', 'contacts'],
            'testimonials' => ['testimonials', 'testimonials'],
            'privacy' => ['privacy', 'privacy'],
        ];
    }

    #[DataProvider('staticSeoRouteProvider')]
    public function test_static_pages_have_canonical_hreflang_robots_and_og_core(string $routeName): void
    {
        $response = $this->get(route($routeName));
        $response->assertOk();
        $html = $response->getContent();

        $canonicalUrl = route($routeName);

        $this->assertStringContainsString(
            '<link rel="canonical" href="'.$canonicalUrl.'"',
            $html
        );
        $this->assertStringContainsString(
            '<link rel="alternate" hreflang="it-IT" href="'.$canonicalUrl.'"',
            $html
        );
        $this->assertStringContainsString(
            '<link rel="alternate" hreflang="x-default" href="'.$canonicalUrl.'"',
            $html
        );

        $this->assertStringContainsString('<meta name="robots" content="index, follow">', $html);
        $this->assertStringContainsString(
            '<meta name="referrer" content="strict-origin-when-cross-origin">',
            $html,
        );
        $this->assertStringContainsString('<html lang="it">', $html);

        $expectedOgType = $routeName === 'home' ? 'website' : 'article';
        $this->assertStringContainsString('<meta property="og:type" content="'.$expectedOgType.'">', $html);
        $this->assertStringContainsString('<meta property="og:url" content="'.$canonicalUrl.'">', $html);
        $this->assertStringContainsString('<meta property="og:image" content="http', $html);
        $this->assertStringContainsString('<meta property="og:image:alt" content="', $html);
        $this->assertStringContainsString('<meta name="twitter:card" content="summary_large_image">', $html);
        $this->assertStringContainsString('<meta name="twitter:image" content="http', $html);
    }

    #[DataProvider('singleH1PageProvider')]
    public function test_main_pages_have_exactly_one_h1(string $routeName): void
    {
        $response = $this->get(route($routeName));
        $response->assertOk();
        $this->assertSame(
            1,
            $this->countH1($response->getContent()),
            "La pagina {$routeName} deve avere esattamente un <h1>."
        );
    }

    /**
     * @return array<string, array{0: string}>
     */
    public static function singleH1PageProvider(): array
    {
        return [
            'home' => ['home'],
            'about' => ['about'],
            'areas' => ['areas'],
            'first interview' => ['first-interview'],
            'contacts' => ['contacts'],
            'testimonials' => ['testimonials'],
            'privacy' => ['privacy'],
        ];
    }

    public function test_area_pages_match_get_areas_meta_and_canonical(): void
    {
        $suffix = config('seo.defaults.site_suffix_local', ' | Psicologa a Tivoli');

        foreach ($this->areasFromController() as $area) {
            $slug = $area['slug'];
            $expectedTitle = $area['meta_title'] ?? $area['title'].$suffix;
            $expectedDescription = $area['meta_description'] ?? $area['preview'];
            $areaImagePath = (string) ($area['image'] ?? '');
            $expectedOgImage = asset(ltrim((string) preg_replace('/\.webp$/', '.jpg', $areaImagePath), '/'));

            $response = $this->get(route('areas.show', ['slug' => $slug]));
            $response->assertOk();
            $html = $response->getContent();

            $this->assertSame(
                $expectedTitle,
                $this->parseHtmlTitle($html),
                "Title SEO errato per area [{$slug}]"
            );
            $this->assertSame(
                $expectedDescription,
                $this->parseMetaDescription($html),
                "Meta description errata per area [{$slug}]"
            );

            $canonical = $this->parseCanonicalHref($html);
            $this->assertSame(
                route('areas.show', ['slug' => $slug]),
                $canonical,
                "Canonical errato per area [{$slug}]"
            );

            $this->assertStringContainsString(
                '<meta property="og:title" content="'.$expectedTitle.'">',
                $html,
                "og:title non allineato per [{$slug}]"
            );
            $this->assertStringContainsString(
                '<meta property="og:url" content="'.$canonical.'">',
                $html,
                "og:url non allineato per [{$slug}]"
            );
            $this->assertStringContainsString(
                '<meta property="og:image" content="'.$expectedOgImage.'">',
                $html,
                "og:image non allineata all'immagine area per [{$slug}]"
            );
            $this->assertStringContainsString(
                '<meta name="twitter:image" content="'.$expectedOgImage.'">',
                $html,
                "twitter:image non allineata all'immagine area per [{$slug}]"
            );

            $this->assertStringContainsString(
                '"headline":"'.$expectedTitle.'"',
                $html,
                "JSON-LD Article.headline non allineato per [{$slug}]"
            );

            $this->assertLessThanOrEqual(95, mb_strlen($expectedTitle), "Titolo area [{$slug}] molto lungo.");
            $this->assertLessThanOrEqual(240, mb_strlen($expectedDescription), "Description area [{$slug}] molto lunga.");
        }
    }

    public function test_each_area_detail_page_has_exactly_one_h1(): void
    {
        foreach ($this->areasFromController() as $area) {
            $response = $this->get(route('areas.show', ['slug' => $area['slug']]));
            $response->assertOk();
            $this->assertSame(
                1,
                $this->countH1($response->getContent()),
                'Area '.$area['slug'].' deve avere un solo <h1>.'
            );
        }
    }

    public function test_every_sitemap_url_returns_ok(): void
    {
        $sitemap = $this->get(route('sitemap'))->getContent();
        $locs = array_map(
            static fn (array $entry): string => $entry['loc'],
            $this->parseSitemapEntries($sitemap)
        );
        $this->assertNotEmpty($locs);

        foreach ($locs as $loc) {
            $parts = parse_url($loc);
            $this->assertIsArray($parts);
            $path = $parts['path'] ?? '/';
            if (! empty($parts['query'])) {
                $path .= '?'.$parts['query'];
            }

            $this->get($path)->assertOk();
        }
    }

    public function test_global_json_ld_includes_core_types(): void
    {
        $response = $this->get(route('home'));
        $response->assertOk();
        $html = $response->getContent();

        $this->assertSame(1, substr_count($html, 'application/ld+json'), 'Un solo blocco JSON-LD globale nel layout.');
        $this->assertStringContainsString('"@type":"WebSite"', $html);
        $this->assertStringContainsString('"@type":"Person"', $html);
        $this->assertStringContainsString('"@type":"Psychologist"', $html);
        $this->assertStringContainsString('"@type":"WebPage"', $html);
        $this->assertStringContainsString('"inLanguage":"it-IT"', $html);
    }

    #[DataProvider('staticSchemaProvider')]
    public function test_static_pages_have_route_specific_schema_nodes(
        string $routeName,
        string $expectedWebPageType,
        string $expectedBreadcrumbLabel
    ): void {
        $response = $this->get(route($routeName));
        $response->assertOk();
        $html = $response->getContent();

        $this->assertStringContainsString('"@type":"'.$expectedWebPageType.'"', $html);
        $this->assertStringContainsString('"@type":"BreadcrumbList"', $html);
        $this->assertStringContainsString('"name":"'.$expectedBreadcrumbLabel.'"', $html);
    }

    /**
     * @return array<string, array{0: string, 1: string, 2: string}>
     */
    public static function staticSchemaProvider(): array
    {
        return [
            'about' => ['about', 'ProfilePage', 'Chi sono'],
            'areas' => ['areas', 'WebPage', 'Aree di intervento'],
            'first interview' => ['first-interview', 'WebPage', 'Primo colloquio'],
            'contacts' => ['contacts', 'ContactPage', 'Contatti'],
            'testimonials' => ['testimonials', 'WebPage', 'Testimonianze'],
        ];
    }

    public function test_psychologist_json_ld_contains_address_and_locations(): void
    {
        $response = $this->get(route('home'));
        $html = $response->getContent();

        $this->assertStringContainsString('Piazza Santa Croce 12', $html);
        $this->assertStringContainsString('"@type":"PostalAddress"', $html);
        $this->assertStringContainsString('Riceve in presenza presso Centro Imago', $html);
    }

    public function test_contacts_page_has_additional_faq_json_ld(): void
    {
        $response = $this->get(route('contacts'));
        $response->assertOk();
        $html = $response->getContent();

        $this->assertGreaterThanOrEqual(2, substr_count($html, 'application/ld+json'));
        $this->assertStringContainsString('"@type":"FAQPage"', $html);
    }

    public function test_first_interview_page_has_additional_faq_json_ld(): void
    {
        $response = $this->get(route('first-interview'));
        $response->assertOk();
        $html = $response->getContent();

        $this->assertGreaterThanOrEqual(2, substr_count($html, 'application/ld+json'));
        $this->assertStringContainsString('"@type":"FAQPage"', $html);
        $this->assertStringContainsString('Primo colloquio psicologico: cosa aspettarti', $html);
    }

    public function test_area_page_json_ld_includes_service_and_breadcrumb(): void
    {
        $response = $this->get(route('areas.show', ['slug' => 'autostima']));
        $response->assertOk();
        $html = $response->getContent();

        $this->assertStringContainsString('"@type":"BreadcrumbList"', $html);
        $this->assertStringContainsString('"@type":"Service"', $html);
        $this->assertStringContainsString('"@type":"Article"', $html);
        $this->assertStringContainsString('"@type":"FAQPage"', $html);
    }

    public function test_sitemap_xml_urls_are_unique_and_include_priorities_and_lastmod(): void
    {
        $response = $this->get(route('sitemap'));
        $response->assertOk();

        $entries = $this->parseSitemapEntries($response->getContent());
        $this->assertNotEmpty($entries);

        $locs = [];
        foreach ($entries as $entry) {
            $locs[] = $entry['loc'];
            $this->assertNotSame('', $entry['loc']);
            $this->assertStringContainsString('http', $entry['loc']);
            $this->assertNotSame('', $entry['priority']);
            $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2}T/', $entry['lastmod']);
        }

        $this->assertSame(count($locs), count(array_unique($locs)), 'Le URL nella sitemap devono essere uniche.');
        $this->assertGreaterThanOrEqual(18, count($locs));
    }

    public function test_robots_txt_references_sitemap_and_blocks_admin(): void
    {
        $response = $this->get('/robots.txt');
        $response->assertOk();
        $body = $response->getContent();

        $this->assertStringContainsString('Sitemap: '.route('sitemap'), $body);
        $this->assertStringContainsString('Disallow: /admin', $body);
    }

    /**
     * @return list<array{loc: string, priority: string, lastmod: string}>
     */
    private function parseSitemapEntries(string $xml): array
    {
        $doc = simplexml_load_string($xml);
        if ($doc === false) {
            return [];
        }

        $ns = $doc->getNamespaces(true);
        $sitemapNs = $ns[''] ?? null;
        $urls = $sitemapNs ? $doc->children($sitemapNs)->url : $doc->url;

        $entries = [];
        foreach ($urls as $url) {
            $entries[] = [
                'loc' => trim((string) $url->loc),
                'priority' => trim((string) $url->priority),
                'lastmod' => trim((string) $url->lastmod),
            ];
        }

        return $entries;
    }
}
