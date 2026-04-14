<?php

namespace App\Http\Controllers;

use App\Mail\ContactRequestConfirmMail;
use App\Mail\ContactRequestMail;
use App\Models\ContactRequest;
use App\Models\Testimonial;
use App\Support\SpamDetector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class PublicController extends Controller
{
    private function seo(string $page): array
    {
        $pages = config('seo.pages', []);

        return is_array($pages) ? ($pages[$page] ?? []) : [];
    }

    public function home()
    {
        $seo = $this->seo('home');

        return view('home', [
            'metaTitle' => $seo['title'] ?? 'Dott.ssa Cristina Pacifici | Psicologa a Tivoli',
            'metaDescription' => $seo['description'] ?? 'Psicologa a Tivoli per supporto psicologico rivolto a bambini, adolescenti e genitori. Colloqui in presenza e online.',
        ]);
    }

    public function about()
    {
        $seo = $this->seo('about');

        return view('chi-sono', [
            'metaTitle' => $seo['title'] ?? 'Chi sono | Psicologa a Tivoli',
            'metaDescription' => $seo['description'] ?? 'Scopri il profilo professionale della Dott.ssa Cristina Pacifici, psicologa a Tivoli. Supporto psicologico per bambini, adolescenti, adulti e genitori.',
        ]);
    }

    public function areas()
    {
        $areas = $this->getAreas();
        $seo = $this->seo('areas');

        return view('aree', [
            'areas' => $areas,
            'metaTitle' => $seo['title'] ?? 'Aree di intervento | Psicologa a Tivoli per bambini, adolescenti e genitori',
            'metaDescription' => $seo['description'] ?? 'Scopri le aree di intervento della Dott.ssa Cristina Pacifici, psicologa a Tivoli: supporto per ansia, umore basso, difficoltà relazionali, autostima, genitorialità, difficoltà scolastiche e benessere emotivo.',
        ]);
    }

    public function firstInterview()
    {
        $seo = $this->seo('firstInterview');

        return view('primo-colloquio', [
            'metaTitle' => $seo['title'] ?? 'Primo colloquio psicologico a Tivoli | Dott.ssa Cristina Pacifici',
            'metaDescription' => $seo['description'] ?? 'Scopri come si svolge il primo colloquio psicologico con la Dott.ssa Cristina Pacifici, psicologa a Tivoli: online o in presenza, in un clima accogliente e senza pressioni.',
        ]);
    }

    public function areaShow(string $slug)
    {
        $area = collect($this->getAreas())->firstWhere('slug', $slug);

        abort_if(! $area, 404);

        $faqPairs = $this->extractAreaFaqPairs($area['body']);
        $areaFaqSchema = $faqPairs !== [] ? $this->buildAreaFaqPageSchema($faqPairs) : null;

        $area['image_alt'] = $area['image_alt'] ?? sprintf('%s — psicologa a Tivoli', $area['title']);
        $area['body'] = $this->formatAreaFaqAsAccordion($area['body'], $area['slug']);

        $localSuffix = config('seo.defaults.site_suffix_local', ' | Psicologa a Tivoli');

        $relatedSlugs = $this->relatedAreaSlugsFor($slug);
        $allAreas = $this->getAreas();
        $relatedAreas = collect($relatedSlugs)
            ->map(fn (string $s) => collect($allAreas)->firstWhere('slug', $s))
            ->filter()
            ->values()
            ->all();

        return view('area-show', [
            'area' => $area,
            'metaTitle' => $area['meta_title'] ?? $area['title'].$localSuffix,
            'metaDescription' => $area['meta_description'] ?? $area['preview'],
            'areaFaqSchema' => $areaFaqSchema,
            'relatedAreas' => $relatedAreas,
        ]);
    }

    /**
     * Aree correlate per link interni (SEO e navigazione).
     *
     * @return list<string>
     */
    private function relatedAreaSlugsFor(string $slug): array
    {
        $map = [
            'ansia-e-gestione-dello-stress' => ['autostima', 'difficolta-relazionali', 'umore-basso'],
            'umore-basso' => ['ansia-e-gestione-dello-stress', 'autostima', 'difficolta-relazionali'],
            'difficolta-relazionali' => ['autostima', 'genitorialita', 'ansia-e-gestione-dello-stress'],
            'autostima' => ['ansia-e-gestione-dello-stress', 'difficolta-relazionali', 'umore-basso'],
            'difficolta-scolastiche' => ['disturbi-del-neurosviluppo', 'potenziamento-abilita-scolastiche', 'genitorialita'],
            'disturbi-del-neurosviluppo' => ['difficolta-scolastiche', 'valutazioni-psicodiagnostiche', 'tutor-dsa-bes-adhd'],
            'genitorialita' => ['difficolta-relazionali', 'difficolta-scolastiche', 'disturbi-del-neurosviluppo'],
            'valutazioni-psicodiagnostiche' => ['disturbi-del-neurosviluppo', 'potenziamento-funzioni-esecutive', 'difficolta-scolastiche'],
            'potenziamento-funzioni-esecutive' => ['valutazioni-psicodiagnostiche', 'disturbi-del-neurosviluppo', 'potenziamento-abilita-scolastiche'],
            'potenziamento-abilita-scolastiche' => ['difficolta-scolastiche', 'tutor-dsa-bes-adhd', 'disturbi-del-neurosviluppo'],
            'intervento-di-gruppo-area-emotiva-relazionale' => ['difficolta-relazionali', 'genitorialita', 'umore-basso'],
            'tutor-dsa-bes-adhd' => ['disturbi-del-neurosviluppo', 'difficolta-scolastiche', 'potenziamento-abilita-scolastiche'],
        ];

        return $map[$slug] ?? ['ansia-e-gestione-dello-stress', 'difficolta-relazionali', 'genitorialita'];
    }

    /**
     * @return array<int, array{question: string, answer: string}>
     */
    private function extractAreaFaqPairs(string $body): array
    {
        $faqHeading = '<h2>Domande frequenti</h2>';
        $faqPos = stripos($body, $faqHeading);

        if ($faqPos === false) {
            return [];
        }

        $faqSection = substr($body, $faqPos + strlen($faqHeading));
        preg_match_all('/<h4>(.*?)<\/h4>\s*<p>(.*?)<\/p>/si', $faqSection, $matches, PREG_SET_ORDER);

        if ($matches === []) {
            return [];
        }

        $pairs = [];

        foreach ($matches as $match) {
            $question = trim(html_entity_decode(strip_tags($match[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            $answer = trim(preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags($match[2]), ENT_QUOTES | ENT_HTML5, 'UTF-8')));

            if ($question !== '' && $answer !== '') {
                $pairs[] = ['question' => $question, 'answer' => $answer];
            }
        }

        return $pairs;
    }

    /**
     * @param  array<int, array{question: string, answer: string}>  $pairs
     */
    private function buildAreaFaqPageSchema(array $pairs): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array_map(fn (array $p) => [
                '@type' => 'Question',
                'name' => $p['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $p['answer'],
                ],
            ], $pairs),
        ];
    }

    private function formatAreaFaqAsAccordion(string $body, string $slug): string
    {
        $faqHeading = '<h2>Domande frequenti</h2>';
        $faqPos = stripos($body, $faqHeading);

        if ($faqPos === false) {
            return $body;
        }

        $beforeFaq = substr($body, 0, $faqPos);
        $faqSection = substr($body, $faqPos + strlen($faqHeading));

        preg_match_all('/<h4>(.*?)<\/h4>\s*<p>(.*?)<\/p>/si', $faqSection, $matches, PREG_SET_ORDER);

        if (empty($matches)) {
            return $body;
        }

        $accordionId = 'areaFaqAccordion'.preg_replace('/[^a-zA-Z0-9]/', '', ucfirst($slug));
        $itemsHtml = '';

        foreach ($matches as $index => $match) {
            $question = trim($match[1]);
            $answer = trim($match[2]);
            $itemId = $accordionId.'Item'.$index;
            $headingId = $accordionId.'Heading'.$index;
            $collapseId = $accordionId.'Collapse'.$index;

            $itemsHtml .= '
                <div class="accordion-item">
                    <h3 class="accordion-header" id="'.$headingId.'">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#'.$collapseId.'" aria-expanded="false" aria-controls="'.$collapseId.'">
                            '.$question.'
                        </button>
                    </h3>
                    <div id="'.$collapseId.'" class="accordion-collapse collapse" aria-labelledby="'.$headingId.'" data-bs-parent="#'.$accordionId.'">
                        <div class="accordion-body">
                            <p class="mb-0">'.$answer.'</p>
                        </div>
                    </div>
                </div>';
        }

        return $beforeFaq.'
            <h2>Domande frequenti</h2>
            <div class="accordion contact-faq-accordion area-faq-accordion mt-3" id="'.$accordionId.'">
                '.$itemsHtml.'
            </div>';
    }

    public function contact()
    {
        $seo = $this->seo('contacts');

        return view('contatti', [
            'metaTitle' => $seo['title'] ?? 'Contatti | Dott.ssa Cristina Pacifici, Psicologa a Tivoli',
            'metaDescription' => $seo['description'] ?? 'Contatta la Dott.ssa Cristina Pacifici, psicologa a Tivoli. Colloqui in presenza e online per bambini, adolescenti e genitori.',
        ]);
    }

    public function submit(Request $request)
    {
        $honeypotField = (string) config('antispam.contact.honeypot_field', 'contact_website');

        // Honeypot invisibile: i bot compilano campi non mostrati agli utenti reali.
        if (trim((string) $request->input($honeypotField)) !== '') {
            return redirect()
                ->route('contacts')
                ->with('success', 'Grazie per aver scritto. Riceverà una risposta da me nel più breve tempo possibile, di solito entro 24 ore lavorative.');
        }

        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\pL\s\'’-]+$/u'],
                'email' => ['required', 'email:rfc', 'max:150'],
                /*
                 * Su mobile i tastierini inseriscono spesso punti, parentesi o slash: la vecchia regex
                 * rigettava il numero e il modulo tornava indietro senza inviare nulla (percepito come “mail ko”).
                 */
                'phone' => [
                    'required',
                    'string',
                    'max:42',
                    function (string $attribute, mixed $value, \Closure $fail): void {
                        if (! is_string($value)) {
                            $fail('Puoi indicarmi un numero di telefono, così posso ricontattarti se serve.');

                            return;
                        }
                        $trimmed = trim($value);
                        if ($trimmed === '' || ! preg_match('/^[\d\s\+\.\-\(\)\/]+$/u', $trimmed)) {
                            $fail('Puoi usare solo cifre e i separatori abituali (spazio, +, trattino, punto, parentesi).');

                            return;
                        }
                        $digits = preg_replace('/\D+/', '', $trimmed);
                        if (strlen($digits) < 8) {
                            $fail('Il numero sembra un po’ corto: puoi ricontrollare?');

                            return;
                        }
                        if (strlen($digits) > 15) {
                            $fail('Il numero contiene troppe cifre: puoi ricontrollare?');
                        }
                    },
                ],
                'message' => ['required', 'string', 'min:10', 'max:2000'],
                'privacy' => ['accepted'],
            ],
            [
                'name.required' => 'Puoi aggiungere nome e cognome: mi aiuta a risponderti con cura.',
                'name.min' => 'Il nome deve avere almeno :min caratteri.',
                'name.max' => 'Il nome non può superare :max caratteri.',
                'name.regex' => 'Il nome può contenere solo lettere, spazi, apostrofi e trattini.',

                'email.required' => 'Puoi indicarmi anche un indirizzo email, così posso ricontattarti.',
                'email.email' => 'L’indirizzo email non sembra valido: puoi ricontrollare?',
                'email.max' => 'L’email non può superare :max caratteri.',

                'phone.required' => 'Puoi lasciarmi anche un recapito telefonico.',

                'message.required' => 'Puoi scrivermi qualche riga (anche poche): così capisco meglio cosa ti porta qui.',
                'message.min' => 'Il messaggio deve avere almeno :min caratteri.',
                'message.max' => 'Il messaggio non può superare :max caratteri.',

                'privacy.accepted' => 'Per completare l’invio, ti chiedo anche il segno di consenso sulla privacy, in calce al modulo.',
            ]
        );

        if ($validator->fails()) {
            return redirect()
                ->route('contacts')
                ->withErrors($validator)
                ->withInput()
                ->withFragment('richiesta-colloquio');
        }

        $validated = $validator->validated();
        $validated['phone'] = preg_replace('/\s+/u', ' ', trim((string) $validated['phone']));

        if (SpamDetector::isLikelySpam((string) $validated['message'])) {
            return redirect()
                ->route('contacts')
                ->withErrors([
                    'message' => 'Il messaggio sembra contenere contenuti promozionali automatici. Se vuoi, puoi riscriverlo in modo più diretto e personale.',
                ])
                ->withInput($request->except(['message', $honeypotField]))
                ->withFragment('richiesta-colloquio');
        }

        $contact = ContactRequest::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'message' => $validated['message'],
            'consent_privacy' => true,
        ]);

        try {
            Mail::to(config('mail.contact.address'), config('mail.contact.name'))
                ->send(new ContactRequestMail($contact));

            Mail::to($contact->email, $contact->name)
                ->send(new ContactRequestConfirmMail($contact));
        } catch (TransportExceptionInterface $e) {
            Log::warning('Invio email modulo contatti fallito', [
                'contact_id' => $contact->id,
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->route('contacts')
                ->with('warning', 'Il tuo messaggio è arrivato a me, ma in questo momento le notifiche automatiche via email non sono partite (rete o server di posta). Ti ricontatterò io comunque; se preferisci, puoi scrivermi anche su WhatsApp o al numero in alto in pagina.')
                ->withFragment('richiesta-colloquio');
        }

        return redirect()
            ->route('contacts')
            ->with('success', 'Grazie per aver scritto. Riceverà una risposta da me nel più breve tempo possibile, di solito entro 24 ore lavorative.');
    }

    public function testimonials()
    {
        $testimonials = Testimonial::where('is_approved', true)
            ->latest()
            ->get();
        $seo = $this->seo('testimonials');

        return view('testimonianze', [
            'metaTitle' => $seo['title'] ?? 'Testimonianze | Psicologa a Tivoli',
            'metaDescription' => $seo['description'] ?? 'Leggi le testimonianze condivise da chi ha intrapreso un percorso di supporto psicologico con la Dott.ssa Cristina Pacifici, psicologa a Tivoli.',
            'testimonials' => $testimonials,
        ]);
    }

    public function storeTestimonial(Request $request)
    {
        $validated = $request->validate([
            'name_label' => ['required', 'string', 'max:100', 'regex:/^[\pL][\pL\s\'’-]*\s[\pL]\.$/u'],
            'message' => ['required', 'string', 'min:20', 'max:2000'],
            'consent_publish' => ['accepted'],
        ], [
                'name_label.required' => 'Puoi indicare come desideri firmare (es. nome e iniziale del cognome).',
                'name_label.regex' => 'Puoi usare nome e iniziale del cognome con il punto finale (es. Maria R.).',
                'message.required' => 'Puoi aggiungere il testo della testimonianza, anche breve.',
                'message.min' => 'La testimonianza deve contenere almeno 20 caratteri.',
                'consent_publish.accepted' => 'Per poterla valutare in vista di una pubblicazione, ti chiedo anche il consenso qui sotto.',
        ]);

        Testimonial::create([
            'name_label' => $validated['name_label'],
            'message' => $validated['message'],
            'consent_publish' => true,
            'is_approved' => false,
        ]);

        return redirect()
            ->route('testimonials')
            ->with('success', 'Grazie: ho ricevuto la tua testimonianza e la leggerò con attenzione prima di una eventuale pubblicazione.');
    }

    private function getAreas(): array
    {
        return [
            [
                'slug' => 'ansia-e-gestione-dello-stress',
                'title' => 'Ansia e gestione dello stress',
                'meta_title' => 'Ansia e gestione dello stress | Psicologa a Tivoli',
                'meta_description' => 'Supporto psicologico a Tivoli per ansia, stress e momenti di forte agitazione emotiva. Percorsi personalizzati in presenza e online.',
                'preview' => 'Un percorso di supporto psicologico per comprendere e gestire ansia, stress e momenti di forte agitazione emotiva.',
                'image' => '/img/stress.webp',
                'intro' => 'L’ansia può manifestarsi in modi diversi e con intensità differenti, influenzando il sonno, le relazioni, la quotidianità e la capacità di affrontare impegni, responsabilità o momenti di cambiamento.',

                'body' => '
    <p>
        Se sta vivendo <strong>ansia</strong>, agitazione costante o momenti di forte attivazione emotiva, affrontare tutto in solitudine può diventare faticoso.
        Come <strong>psicologa a Tivoli</strong>, offro supporto psicologico ad adolescenti, giovani adulti e genitori per comprendere l’origine dell’ansia e sviluppare strumenti concreti per gestirla nella vita quotidiana, ritrovando maggiore equilibrio e serenità.
    </p>

    <h2>Cos’è l’ansia e quando diventa un problema</h2>

    <p>
        L’ansia è una risposta naturale dell’organismo di fronte a situazioni percepite come stressanti, nuove o impegnative.
        In alcuni momenti può avere una funzione protettiva, perché prepara la persona ad affrontare ciò che sta vivendo.
        Diventa però un problema quando è troppo intensa, persistente o compare anche in assenza di un pericolo reale, interferendo con la qualità della vita.
    </p>

    <p>
        In questi casi, l’ansia può incidere sul benessere personale, sullo studio, sul lavoro, sulle relazioni e sulla possibilità di sentirsi sereni nella quotidianità.
    </p>

    <h2>Come può manifestarsi l’ansia</h2>

    <p>
        L’ansia può presentarsi con sintomi fisici, cognitivi ed emotivi anche molto diversi tra loro. Alcune persone descrivono una sensazione di costante allerta, altre sperimentano un forte senso di agitazione o di perdita di controllo.
    </p>

    <ul>
        <li>tachicardia o sensazione di respiro corto</li>
        <li>tensione muscolare e difficoltà a rilassarsi</li>
        <li>pensieri ripetitivi e preoccupazioni continue</li>
        <li>difficoltà ad addormentarsi o sonno poco riposante</li>
        <li>senso di agitazione, irrequietezza o allarme costante</li>
    </ul>

    <p>
        Quando questi segnali diventano frequenti o intensi, un <strong>supporto psicologico</strong> può aiutare a comprendere meglio ciò che sta accadendo e a intervenire in modo mirato.
    </p>

    <h2>Come posso accompagnarla nella gestione di ansia e stress</h2>

    <p>
        Il percorso psicologico è uno spazio sicuro in cui poter parlare liberamente, senza giudizio, e dare significato a ciò che si sta vivendo.
        Nel percorso si lavora insieme per comprendere i meccanismi che alimentano l’ansia e costruire modalità più efficaci per affrontarla nel quotidiano.
    </p>

    <p>
        Durante il percorso potrà:
    </p>

    <ul>
        <li>riconoscere i pensieri e le situazioni che aumentano l’ansia</li>
        <li>imparare a gestire i momenti di forte attivazione emotiva</li>
        <li>ridurre il peso delle preoccupazioni e dei pensieri ripetitivi</li>
        <li>sviluppare una maggiore stabilità emotiva e senso di controllo</li>
    </ul>

    <p>
        In alcuni casi, il lavoro sull’ansia si intreccia anche con aspetti legati all’
        <a href="'.route('areas.show', ['slug' => 'autostima']).'">autostima</a>
        e con
        <a href="'.route('areas.show', ['slug' => 'difficolta-relazionali']).'">difficoltà relazionali</a>,
        rendendo utile un percorso di supporto più ampio e personalizzato.
    </p>

    <p>
        Ogni percorso viene costruito in modo personalizzato, nel rispetto della storia, dei tempi e dei bisogni della persona.
    </p>

    <h2>Quando rivolgersi a una psicologa per l’ansia</h2>

    <p>
        Rivolgersi a una psicologa può essere utile quando l’ansia non è più un episodio occasionale, ma una presenza che condiziona la quotidianità e limita il benessere personale.
    </p>

    <ul>
        <li>l’ansia è presente da tempo e fatica a diminuire</li>
        <li>ha sperimentato momenti di forte agitazione o perdita di controllo</li>
        <li>evita situazioni per paura, disagio o senso di insicurezza</li>
        <li>lo stress incide sul lavoro, sullo studio o sulle relazioni</li>
        <li>ha difficoltà a dormire, a rilassarsi o a ritrovare un senso di calma</li>
    </ul>

    <p>
        Intervenire in questi momenti può aiutare a prevenire un’intensificazione del disagio e a recuperare più rapidamente un senso di stabilità.
    </p>

    <h2>Psicologa a Tivoli e colloqui online</h2>

    <p>
        Ricevo a <strong>Tivoli</strong> e offro colloqui anche online, così da rendere il supporto accessibile a chi ne ha bisogno, indipendentemente dal luogo in cui vive.
    </p>

    <h2>Domande frequenti</h2>

    <h4>Quanto dura un percorso per l’ansia o lo stress?</h4>
    <p>
        La durata del percorso dipende dalla situazione individuale, dall’intensità dei sintomi e dagli obiettivi condivisi.
        Alcuni percorsi possono essere più brevi e focalizzati sulla gestione di momenti specifici di ansia o stress, mentre altri richiedono tempi più graduali e approfonditi.
        Durante il lavoro, il percorso viene sempre adattato ai bisogni della persona.
    </p>

    <h4>Serve una diagnosi per iniziare un percorso psicologico?</h4>
    <p>
        No. Non è necessario avere una diagnosi per chiedere supporto.
        È sufficiente sentire il bisogno di comprendere meglio ciò che si sta vivendo, ridurre l’ansia o affrontare un momento di difficoltà.
        Il primo colloquio serve proprio a valutare insieme la situazione e definire il percorso più adeguato.
    </p>

    <h4>Come capire se l’ansia richiede un supporto professionale?</h4>
    <p>
        Può essere utile chiedere supporto quando l’ansia diventa frequente, intensa o inizia a interferire con il sonno, il lavoro, lo studio o le relazioni.
        Anche la presenza di preoccupazioni costanti, forte agitazione o difficoltà a rilassarsi può essere un segnale importante da ascoltare.
    </p>',
            ],

            [
                'slug' => 'umore-basso',
                'title' => 'Umore basso',
                'meta_title' => 'Umore basso | Psicologa a Tivoli',
                'meta_description' => 'Supporto psicologico a Tivoli per umore basso, tristezza e momenti di demotivazione. Percorsi personalizzati in presenza e online.',
                'preview' => 'Un percorso di supporto psicologico per comprendere tristezza, demotivazione e perdita di energia emotiva.',
                'image' => '/img/umoreBasso.webp',
                'intro' => 'I momenti di umore basso possono influenzare la percezione di sé, la motivazione, le relazioni e la capacità di affrontare la quotidianità con continuità e fiducia.',

                'body' => '
    <p>
        Attraversare un periodo di <strong>umore basso</strong>, tristezza o demotivazione può rendere più faticoso affrontare la quotidianità, le relazioni e gli impegni di ogni giorno.
        Come <strong>psicologa a Tivoli</strong>, offro uno spazio di ascolto e supporto psicologico per aiutare adolescenti, giovani adulti e genitori a comprendere meglio ciò che stanno vivendo e a ritrovare progressivamente maggiore equilibrio emotivo.
    </p>

    <h2>Quando l’umore basso diventa un segnale da ascoltare</h2>

    <p>
        È normale attraversare momenti di stanchezza emotiva, delusione o tristezza in risposta a eventi difficili, cambiamenti o fasi di particolare vulnerabilità.
        Tuttavia, quando questi vissuti diventano persistenti o iniziano a influenzare il benessere personale, è importante dare loro attenzione.
    </p>

    <p>
        L’umore basso può incidere sul modo in cui la persona percepisce sé stessa, sul rapporto con gli altri, sulla motivazione e sulla capacità di affrontare la vita quotidiana con continuità e fiducia.
    </p>

    <h2>Come può manifestarsi l’umore basso</h2>

    <p>
        Ogni persona può vivere questo stato in modo diverso. In alcuni casi prevale la tristezza, in altri la stanchezza, la perdita di energia o una sensazione di distanza da sé stessi e da ciò che accade intorno.
    </p>

    <ul>
        <li>senso di tristezza o vuoto che tende a durare nel tempo</li>
        <li>stanchezza emotiva e riduzione dell’energia</li>
        <li>difficoltà a trovare motivazione nelle attività quotidiane</li>
        <li>sensazione di sentirsi bloccati, spenti o distanti da sé stessi</li>
        <li>riduzione dell’interesse verso attività prima vissute con piacere</li>
    </ul>

    <p>
        Quando questi segnali diventano frequenti o iniziano a condizionare il benessere personale, un <strong>supporto psicologico</strong> può aiutare a comprendere meglio il significato del disagio e a orientare un percorso di cambiamento.
    </p>

    <h2>Come posso accompagnarla in un percorso di supporto psicologico</h2>

    <p>
        Il percorso si sviluppa in uno spazio di ascolto autentico, in cui la persona può sentirsi accolta, compresa e accompagnata nel riconoscere i vissuti che stanno emergendo.
        L’obiettivo non è soltanto ridurre il malessere, ma anche dare significato a ciò che si sta vivendo e costruire modalità più sostenibili di stare in relazione con il proprio mondo interno.
    </p>

    <p>
        Durante il percorso sarà possibile:
    </p>

    <ul>
        <li>riconoscere i vissuti emotivi che accompagnano l’umore basso</li>
        <li>comprendere i bisogni emotivi spesso rimasti in secondo piano</li>
        <li>ritrovare gradualmente senso, direzione e continuità nel quotidiano</li>
        <li>sviluppare una percezione di sé più stabile e rispettosa</li>
    </ul>

    <p>
        In alcuni casi, l’umore basso può intrecciarsi anche con stati di
        <a href="'.route('areas.show', ['slug' => 'ansia-e-gestione-dello-stress']).'">ansia e stress</a>
        oppure con aspetti legati all’
        <a href="'.route('areas.show', ['slug' => 'autostima']).'">autostima</a>,
        rendendo utile un lavoro più ampio e personalizzato.
    </p>

    <h2>Quando può essere utile rivolgersi a una psicologa</h2>

    <p>
        Chiedere un supporto può essere utile quando il senso di tristezza, svuotamento o demotivazione persiste nel tempo e rende più difficile affrontare lavoro, studio, relazioni o attività quotidiane.
    </p>

    <ul>
        <li>si sente spesso senza energia o senza motivazione</li>
        <li>fa fatica a provare interesse o piacere nelle attività quotidiane</li>
        <li>avverte un senso di blocco, vuoto o distanza da sé</li>
        <li>si percepisce più fragile, scoraggiato o disorientato</li>
        <li>il malessere influisce sulle relazioni o sulla qualità della vita</li>
    </ul>

    <p>
        In questi momenti, iniziare un percorso può aiutare a dare voce al disagio e a costruire nuove possibilità di comprensione e benessere.
    </p>

    <h2>Psicologa a Tivoli e colloqui online</h2>

    <p>
        Ricevo a <strong>Tivoli</strong> e offro colloqui anche online, così da rendere il supporto accessibile a chi ne ha bisogno, indipendentemente dal luogo in cui vive.
    </p>

    <h2>Domande frequenti</h2>

    <h4>L’umore basso è sempre legato a un evento specifico?</h4>
    <p>
        Non sempre. In alcuni casi può essere collegato a un cambiamento, a una perdita o a un momento difficile; in altri può emergere in modo più graduale e senza una causa immediatamente chiara.
    </p>

    <h4>Quando è utile chiedere un supporto psicologico?</h4>
    <p>
        È utile chiedere supporto quando il malessere dura nel tempo, si intensifica oppure inizia a influire sulla qualità della vita, sulle relazioni, sul lavoro o sulla motivazione quotidiana.
    </p>

    <h4>È possibile svolgere il percorso anche online?</h4>
    <p>
        Sì. Quando necessario, è possibile valutare anche un percorso online, mantenendo continuità e qualità del lavoro psicologico.
    </p>

    <h4>Il primo colloquio serve già a iniziare un percorso?</h4>
    <p>
        Il primo colloquio è uno spazio dedicato all’ascolto e alla comprensione della richiesta. Permette di inquadrare il momento che la persona sta vivendo e di valutare insieme come procedere.
    </p>
    ',
            ],

            [
                'slug' => 'difficolta-relazionali',
                'title' => 'Difficoltà relazionali',
                'meta_title' => 'Difficoltà relazionali | Psicologa a Tivoli',
                'meta_description' => 'Supporto psicologico a Tivoli per difficoltà relazionali, conflitti e problemi di comunicazione. Percorsi personalizzati per migliorare la qualità delle relazioni.',
                'preview' => 'Un percorso di supporto psicologico per comprendere e migliorare la qualità delle relazioni familiari, scolastiche, lavorative o sociali.',
                'image' => '/img/relazionali.webp',
                'intro' => 'Le difficoltà relazionali possono emergere in diversi contesti della vita: nella coppia, in famiglia, con i figli, a scuola, nel lavoro o nelle amicizie, influenzando il benessere emotivo e la qualità della vita quotidiana.',

                'body' => '
    <p>
        Le relazioni rappresentano una parte fondamentale della vita quotidiana. Quando emergono difficoltà nella comunicazione, incomprensioni o conflitti ripetuti, può diventare faticoso sentirsi compresi, ascoltati e rispettati.
        Come <strong>psicologa a Tivoli</strong>, offro uno spazio di supporto psicologico per aiutare adolescenti, giovani adulti e genitori a comprendere meglio le dinamiche relazionali e sviluppare modalità di comunicazione più efficaci e consapevoli.
    </p>

    <h2>Quando le difficoltà relazionali diventano fonte di disagio</h2>

    <p>
        Ogni relazione attraversa momenti di tensione o disaccordo. Tuttavia, quando le difficoltà diventano frequenti o persistenti, possono generare stress, frustrazione e senso di solitudine.
        In questi casi, è utile fermarsi a osservare ciò che accade nella relazione e comprendere quali bisogni, emozioni o aspettative sono coinvolti.
    </p>

    <p>
        Le difficoltà relazionali possono riguardare diversi contesti, come la coppia, la famiglia, le relazioni con i figli, l’ambiente scolastico o lavorativo e le amicizie.
    </p>

    <h2>Come possono manifestarsi le difficoltà relazionali</h2>

    <p>
        Le difficoltà nelle relazioni possono assumere forme diverse e spesso si esprimono attraverso tensioni, incomprensioni o difficoltà nel comunicare in modo chiaro ed efficace.
    </p>

    <ul>
        <li>incomprensioni frequenti o conflitti ripetuti</li>
        <li>fatica nell’esprimere bisogni, emozioni o limiti personali</li>
        <li>sensazione di non sentirsi compresi o riconosciuti</li>
        <li>difficoltà nel creare o mantenere relazioni soddisfacenti</li>
        <li>tensione emotiva nelle relazioni familiari o lavorative</li>
    </ul>

    <p>
        Quando queste situazioni si ripetono nel tempo, possono incidere sul benessere personale e sulla qualità delle relazioni.
        Un percorso psicologico può aiutare a comprendere meglio ciò che accade e a individuare modalità più funzionali di stare in relazione con gli altri.
    </p>

    <h2>Come posso accompagnarla a migliorare la qualità delle relazioni</h2>

    <p>
        Il percorso psicologico permette di osservare con maggiore consapevolezza il proprio modo di comunicare, reagire e relazionarsi agli altri.
        Attraverso il lavoro terapeutico, è possibile riconoscere schemi ricorrenti, comprendere le emozioni coinvolte e sviluppare modalità relazionali più equilibrate e rispettose di sé e dell’altro.
    </p>

    <p>
        Durante il percorso sarà possibile:
    </p>

    <ul>
        <li>migliorare la comunicazione e la capacità di ascolto</li>
        <li>imparare a esprimere bisogni, emozioni e limiti in modo chiaro</li>
        <li>gestire conflitti e tensioni relazionali con maggiore consapevolezza</li>
        <li>costruire relazioni più stabili, rispettose e soddisfacenti</li>
    </ul>

    <p>
        In alcune situazioni, le difficoltà relazionali possono essere collegate anche a vissuti legati all’
        <a href="'.route('areas.show', ['slug' => 'autostima']).'">autostima</a>
        oppure al ruolo educativo e alle dinamiche familiari, come accade nei percorsi di
        <a href="'.route('areas.show', ['slug' => 'genitorialita']).'">sostegno alla genitorialità</a>.
        In questi casi, il lavoro viene costruito in modo personalizzato, tenendo conto della storia e dei bisogni della persona o della famiglia.
    </p>

    <h2>Quando può essere utile un supporto psicologico</h2>

    <p>
        Chiedere un supporto può essere utile quando le relazioni diventano fonte di stress, tensione o sofferenza e quando le difficoltà sembrano ripetersi nel tempo senza trovare una soluzione soddisfacente.
    </p>

    <ul>
        <li>le discussioni o i conflitti si ripetono frequentemente</li>
        <li>si fatica a comunicare in modo chiaro e costruttivo</li>
        <li>si prova senso di distanza, incomprensione o solitudine nelle relazioni</li>
        <li>le relazioni generano stress, frustrazione o insicurezza</li>
        <li>si desidera migliorare la qualità dei rapporti con gli altri</li>
    </ul>

    <p>
        In questi momenti, un percorso psicologico può aiutare a comprendere le dinamiche relazionali e a sviluppare strumenti più efficaci per affrontarle.
    </p>

    <h2>Psicologa a Tivoli e colloqui online</h2>

    <p>
        Ricevo a <strong>Tivoli</strong> e offro colloqui anche online, così da rendere il supporto accessibile a chi ne ha bisogno, indipendentemente dal luogo in cui vive.
    </p>

    <h2>Domande frequenti</h2>

    <h4>Le difficoltà relazionali sono sempre legate all’altra persona?</h4>
    <p>
        Non necessariamente. Spesso le difficoltà relazionali nascono dall’incontro tra bisogni, emozioni e modalità comunicative diverse.
        Il percorso psicologico aiuta a comprendere il proprio ruolo nella relazione e a sviluppare modalità più efficaci di comunicazione e gestione dei conflitti.
    </p>

    <h4>È utile chiedere supporto anche se il problema riguarda una sola relazione?</h4>
    <p>
        Sì. Anche una singola relazione può influenzare profondamente il benessere emotivo.
        Lavorare su quella relazione può aiutare a comprendere meglio sé stessi e migliorare la qualità dei rapporti futuri.
    </p>

    <h4>Il percorso può aiutare a migliorare la comunicazione con i figli o con il partner?</h4>
    <p>
        Sì. Il percorso psicologico offre strumenti per comprendere meglio le dinamiche relazionali e sviluppare modalità comunicative più chiare, rispettose ed efficaci, favorendo relazioni più equilibrate e soddisfacenti.
    </p>
    ',
            ],

            [
                'slug' => 'autostima',
                'title' => 'Autostima',
                'meta_title' => 'Autostima | Psicologa a Tivoli',
                'meta_description' => 'Supporto psicologico a Tivoli per rafforzare autostima, fiducia in sé e sicurezza personale. Percorsi personalizzati in presenza e online.',
                'preview' => 'Un percorso psicologico per rafforzare fiducia in sé, sicurezza personale e consapevolezza delle proprie risorse.',
                'image' => '/img/autostima.webp',
                'intro' => 'L’autostima riguarda il modo in cui una persona percepisce sé stessa, il proprio valore e le proprie capacità nelle diverse aree della vita, influenzando scelte, relazioni e benessere emotivo.',

                'body' => '
    <p>
        L’<strong>autostima</strong> rappresenta la percezione che una persona ha di sé, del proprio valore e delle proprie capacità.
        Quando è fragile o instabile, può influenzare la sicurezza personale, le relazioni e la possibilità di affrontare le sfide quotidiane con fiducia.
        Come <strong>psicologa a Tivoli</strong>, offro uno spazio di ascolto e supporto psicologico per aiutare adolescenti, giovani adulti e genitori a sviluppare una percezione di sé più equilibrata, realistica e rispettosa.
    </p>

    <h2>Quando l’autostima diventa fonte di difficoltà</h2>

    <p>
        Tutte le persone possono vivere momenti di insicurezza o dubbio su sé stesse.
        Tuttavia, quando la percezione di sé diventa costantemente negativa o svalutante, può emergere una sensazione di inadeguatezza che influenza il modo di stare nelle relazioni, prendere decisioni e affrontare nuove esperienze.
    </p>

    <p>
        Una bassa autostima può portare a evitare situazioni, rinunciare a opportunità o vivere con timore del giudizio degli altri, generando nel tempo frustrazione e senso di blocco.
    </p>

    <h2>Come può manifestarsi una difficoltà legata all’autostima</h2>

    <p>
        Le difficoltà legate all’autostima possono emergere in modo diverso da persona a persona e influenzare diversi ambiti della vita quotidiana.
    </p>

    <ul>
        <li>tendenza a svalutarsi o a sentirsi “mai abbastanza”</li>
        <li>insicurezza nelle relazioni o nelle scelte personali</li>
        <li>difficoltà a riconoscere i propri punti di forza</li>
        <li>timore del giudizio e forte autocritica</li>
        <li>sensazione di non meritare successi o riconoscimenti</li>
    </ul>

    <p>
        Quando questi vissuti diventano frequenti o persistenti, possono influenzare il benessere emotivo e la qualità della vita.
        In questi casi, un percorso psicologico può aiutare a comprendere le origini di tali difficoltà e a costruire una percezione di sé più stabile e positiva.
    </p>

    <h2>Come posso accompagnarla a rafforzare l’autostima</h2>

    <p>
        Il lavoro psicologico si orienta al riconoscimento delle risorse personali, alla comprensione dei meccanismi di autosvalutazione e alla costruzione di un rapporto più autentico con sé stessi.
        L’obiettivo è sviluppare maggiore consapevolezza, sicurezza e capacità di affrontare le situazioni quotidiane con fiducia.
    </p>

    <p>
        Durante il percorso sarà possibile:
    </p>

    <ul>
        <li>riconoscere e valorizzare le proprie risorse personali</li>
        <li>comprendere i pensieri e le convinzioni che influenzano l’immagine di sé</li>
        <li>ridurre l’autocritica e sviluppare maggiore fiducia nelle proprie capacità</li>
        <li>costruire modalità più sicure e consapevoli di stare nelle relazioni</li>
    </ul>

    <p>
        In alcuni casi, una bassa autostima può essere collegata a periodi di
        <a href="'.route('areas.show', ['slug' => 'umore-basso']).'">umore basso</a>
        oppure a difficoltà nel gestire le relazioni con gli altri, come avviene nelle
        <a href="'.route('areas.show', ['slug' => 'difficolta-relazionali']).'">difficoltà relazionali</a>.
        In questi casi, il percorso viene costruito in modo personalizzato, tenendo conto della storia e dei bisogni della persona.
    </p>

    <h2>Quando può essere utile un supporto psicologico</h2>

    <p>
        Rivolgersi a una psicologa può essere utile quando la percezione di sé diventa fonte di sofferenza o limita la possibilità di vivere con serenità le relazioni, il lavoro o le scelte personali.
    </p>

    <ul>
        <li>si sente spesso insicuro o inadeguato</li>
        <li>ha difficoltà a prendere decisioni o a fidarsi delle proprie capacità</li>
        <li>teme il giudizio degli altri o evita alcune situazioni</li>
        <li>tende a svalutarsi o a minimizzare i propri successi</li>
        <li>fa fatica a riconoscere il proprio valore personale</li>
    </ul>

    <p>
        In questi momenti, un percorso psicologico può aiutare a sviluppare maggiore sicurezza, consapevolezza e fiducia in sé stessi.
    </p>

    <h2>Psicologa a Tivoli e colloqui online</h2>

    <p>
        Ricevo a <strong>Tivoli</strong> e offro colloqui anche online, così da rendere il supporto accessibile a chi ne ha bisogno, indipendentemente dal luogo in cui vive.
    </p>

    <h2>Domande frequenti</h2>

    <h4>L’autostima può migliorare nel tempo?</h4>
    <p>
        Sì. L’autostima non è una caratteristica fissa, ma un processo che può evolvere nel tempo.
        Attraverso un percorso psicologico è possibile sviluppare una percezione di sé più stabile, realistica e rispettosa.
    </p>

    <h4>Da cosa dipende una bassa autostima?</h4>
    <p>
        La percezione di sé si costruisce nel tempo attraverso esperienze personali, relazioni e contesti di vita.
        Eventi difficili, critiche ripetute o esperienze di fallimento possono influenzare l’immagine di sé, ma è possibile lavorare per modificarla in modo positivo.
    </p>

    <h4>Un percorso psicologico può aiutare anche nelle relazioni?</h4>
    <p>
        Sì. Rafforzare l’autostima aiuta spesso a migliorare la comunicazione, la sicurezza personale e la qualità delle relazioni, favorendo un maggiore equilibrio emotivo e relazionale.
    </p>
    ',
            ],

            [
                'slug' => 'difficolta-scolastiche',
                'title' => 'Difficoltà scolastiche',
                'meta_title' => 'Difficoltà scolastiche | Psicologa a Tivoli',
                'meta_description' => 'Supporto psicologico a Tivoli per difficoltà scolastiche, studio e motivazione. Percorsi personalizzati per bambini e adolescenti in presenza e online.',
                'preview' => 'Un percorso di supporto psicologico per comprendere e affrontare difficoltà scolastiche, studio e motivazione.',
                'image' => '/img/scuola.webp',
                'intro' => 'Le difficoltà scolastiche possono riguardare l’apprendimento, la concentrazione, l’organizzazione, il metodo di studio oppure il vissuto emotivo legato all’esperienza scolastica, influenzando il benessere del bambino o dell’adolescente.',

                'body' => '
    <p>
        Le <strong>difficoltà scolastiche</strong> possono manifestarsi in momenti diversi del percorso di crescita e coinvolgere aspetti cognitivi, emotivi e relazionali.
        Quando lo studio diventa fonte di stress, frustrazione o senso di inadeguatezza, è importante comprendere le cause del disagio e individuare strategie adeguate.
        Come <strong>psicologa a Tivoli</strong>, offro supporto a bambini, adolescenti e famiglie per affrontare le difficoltà scolastiche in modo sereno e costruttivo.
    </p>

    <h2>Quando le difficoltà scolastiche diventano un segnale da ascoltare</h2>

    <p>
        Tutti i bambini possono incontrare momenti di fatica nello studio o nella concentrazione. Tuttavia, quando queste difficoltà diventano persistenti o influenzano il benessere emotivo, è utile approfondire la situazione.
    </p>

    <p>
        In alcuni casi, le difficoltà scolastiche possono essere collegate a caratteristiche specifiche del funzionamento cognitivo, come avviene nei
        <a href="'.route('areas.show', ['slug' => 'disturbi-del-neurosviluppo']).'">disturbi del neurosviluppo</a>,
        oppure a difficoltà nei processi attentivi e organizzativi, che possono essere affrontate attraverso interventi di
        <a href="'.route('areas.show', ['slug' => 'potenziamento-funzioni-esecutive']).'">potenziamento delle funzioni esecutive</a>.
    </p>

    <h2>Come possono manifestarsi le difficoltà scolastiche</h2>

    <p>
        Le difficoltà scolastiche possono presentarsi in modi diversi e coinvolgere sia il rendimento scolastico sia il vissuto emotivo legato alla scuola.
    </p>

    <ul>
        <li>fatica nello studio e nella gestione dei compiti</li>
        <li>demotivazione o senso di inadeguatezza a scuola</li>
        <li>difficoltà di concentrazione e organizzazione</li>
        <li>ansia o frustrazione legate alle richieste scolastiche</li>
        <li>difficoltà nel mantenere attenzione e continuità nello studio</li>
    </ul>

    <p>
        Quando queste difficoltà si ripetono nel tempo, possono influenzare l’autostima e la motivazione del bambino o dell’adolescente.
        In questi casi, un intervento mirato può aiutare a comprendere le cause del disagio e a costruire modalità di studio più efficaci.
    </p>

    <h2>Supporto a bambini e adolescenti con difficoltà scolastiche</h2>

    <p>
        L’intervento viene costruito in base alle caratteristiche del minore, tenendo conto degli aspetti cognitivi, emotivi e relazionali coinvolti.
        Il lavoro può integrare sostegno psicologico, potenziamento delle abilità e confronto con la famiglia.
    </p>

    <p>
        Durante il percorso sarà possibile:
    </p>

    <ul>
        <li>comprendere le cause delle difficoltà scolastiche</li>
        <li>sviluppare strategie di studio più efficaci</li>
        <li>rafforzare motivazione e fiducia nelle proprie capacità</li>
        <li>ridurre ansia e frustrazione legate alla scuola</li>
    </ul>

    <p>
        Quando necessario, il percorso può essere affiancato da interventi specifici di
        <a href="'.route('areas.show', ['slug' => 'potenziamento-abilita-scolastiche']).'">potenziamento delle abilità scolastiche</a>
        oppure da attività di supporto allo studio come il
        <a href="'.route('areas.show', ['slug' => 'tutor-dsa-bes-adhd']).'">tutor DSA, BES e ADHD</a>.
        Un ruolo fondamentale è svolto anche dal confronto con i genitori, attraverso percorsi di
        <a href="'.route('areas.show', ['slug' => 'genitorialita']).'">sostegno alla genitorialità</a>.
    </p>

    <h2>Quando può essere utile un supporto psicologico</h2>

    <p>
        Chiedere supporto può essere utile quando le difficoltà scolastiche generano stress, insicurezza o senso di fallimento e quando il bambino o l’adolescente fatica a vivere l’esperienza scolastica con serenità.
    </p>

    <ul>
        <li>le difficoltà scolastiche persistono nel tempo</li>
        <li>lo studio diventa fonte di stress o frustrazione</li>
        <li>si osserva un calo della motivazione o della fiducia in sé</li>
        <li>emergono difficoltà nella concentrazione o nell’organizzazione</li>
        <li>la scuola viene vissuta con ansia o rifiuto</li>
    </ul>

    <p>
        In questi momenti, un intervento mirato può aiutare a favorire un’esperienza scolastica più serena, sostenibile e coerente con i bisogni della persona.
    </p>

    <h2>Psicologa a Tivoli e colloqui online</h2>

    <p>
        Ricevo a <strong>Tivoli</strong> e offro colloqui anche online, così da rendere il supporto accessibile a chi ne ha bisogno, indipendentemente dal luogo in cui vive.
    </p>

    <h2>Domande frequenti</h2>

    <h4>Le difficoltà scolastiche sono sempre legate allo studio?</h4>
    <p>
        Non sempre. Le difficoltà scolastiche possono essere influenzate anche da aspetti emotivi, relazionali o attentivi.
        Comprendere l’origine del problema è il primo passo per individuare un intervento efficace.
    </p>

    <h4>È utile intervenire anche quando le difficoltà sembrano lievi?</h4>
    <p>
        Sì. Intervenire precocemente permette spesso di prevenire un peggioramento della situazione e di favorire uno sviluppo più sereno e stabile del percorso scolastico.
    </p>

    <h4>Il supporto coinvolge anche i genitori?</h4>
    <p>
        Quando necessario, il lavoro prevede un confronto con i genitori per condividere strategie educative e sostenere il bambino o l’adolescente nel modo più adeguato possibile.
    </p>
    ',
            ],

            [
                'slug' => 'disturbi-del-neurosviluppo',
                'title' => 'Disturbi del neurosviluppo',
                'meta_title' => 'Disturbi del neurosviluppo | Psicologa a Tivoli',
                'meta_description' => 'Supporto psicologico a Tivoli per disturbi del neurosviluppo. Percorsi personalizzati per bambini e famiglie, con attenzione agli aspetti cognitivi, emotivi e relazionali.',
                'preview' => 'Interventi dedicati ai disturbi del neurosviluppo con attenzione ai bisogni del bambino, della famiglia e del contesto scolastico.',
                'image' => '/img/neuro.webp',
                'intro' => 'I disturbi del neurosviluppo richiedono un’attenzione specifica alle caratteristiche cognitive, emotive, comportamentali e relazionali della persona, oltre che al contesto familiare e scolastico in cui cresce.',

                'body' => '
    <p>
        I <strong>disturbi del neurosviluppo</strong> riguardano il modo in cui una persona apprende, si concentra, regola le emozioni e si relaziona con l’ambiente.
        Possono emergere già nei primi anni di vita o durante il percorso scolastico, influenzando l’autonomia, l’apprendimento e il benessere emotivo.
        Come <strong>psicologa a Tivoli</strong>, offro supporto a bambini, adolescenti e famiglie per comprendere meglio il funzionamento del minore e costruire interventi mirati e sostenibili.
    </p>

    <h2>Che cosa si intende per disturbi del neurosviluppo</h2>

    <p>
        I disturbi del neurosviluppo comprendono condizioni che interessano lo sviluppo cognitivo, attentivo, comportamentale e relazionale.
        Possono manifestarsi con difficoltà nell’apprendimento, nella gestione delle emozioni, nell’organizzazione delle attività o nella regolazione del comportamento.
    </p>

    <p>
        In molti casi, queste difficoltà diventano evidenti nel contesto scolastico, attraverso
        <a href="'.route('areas.show', ['slug' => 'difficolta-scolastiche']).'">difficoltà scolastiche</a>,
        problemi di attenzione o fatica nell’adattarsi alle richieste quotidiane.
    </p>

    <h2>Come possono manifestarsi i disturbi del neurosviluppo</h2>

    <p>
        Ogni bambino o adolescente può presentare caratteristiche diverse. Alcuni mostrano difficoltà legate all’apprendimento, altri alla regolazione emotiva o al comportamento.
    </p>

    <ul>
        <li>difficoltà di apprendimento o regolazione emotiva</li>
        <li>fatiche attentive, organizzative o comportamentali</li>
        <li>bisogno di una lettura più chiara del funzionamento del minore</li>
        <li>difficoltà nella gestione delle attività quotidiane</li>
        <li>necessità di un supporto condiviso con la famiglia e la scuola</li>
    </ul>

    <p>
        In queste situazioni, può essere utile effettuare una
        <a href="'.route('areas.show', ['slug' => 'valutazioni-psicodiagnostiche']).'">valutazione psicodiagnostica</a>,
        che permette di comprendere con maggiore precisione i punti di forza e le difficoltà della persona.
    </p>

    <h2>Supporto a bambini e famiglie</h2>

    <p>
        Il supporto psicologico aiuta a comprendere il funzionamento della persona in modo più chiaro, individuare i bisogni specifici e costruire interventi mirati, rispettosi della sua unicità.
        Il lavoro viene svolto in collaborazione con la famiglia e, quando necessario, con la scuola.
    </p>

    <p>
        Durante il percorso sarà possibile:
    </p>

    <ul>
        <li>comprendere il profilo cognitivo ed emotivo del minore</li>
        <li>sviluppare strategie educative e relazionali più efficaci</li>
        <li>rafforzare autonomia e capacità di autoregolazione</li>
        <li>ridurre stress e difficoltà nella vita quotidiana</li>
    </ul>

    <p>
        In alcuni casi, il percorso può includere interventi specifici di
        <a href="'.route('areas.show', ['slug' => 'potenziamento-funzioni-esecutive']).'">potenziamento delle funzioni esecutive</a>
        oppure attività di supporto allo studio, come il
        <a href="'.route('areas.show', ['slug' => 'tutor-dsa-bes-adhd']).'">tutor DSA, BES e ADHD</a>.
        Un ruolo fondamentale è svolto anche dal sostegno alla famiglia, attraverso percorsi di
        <a href="'.route('areas.show', ['slug' => 'genitorialita']).'">genitorialità</a>.
    </p>

    <h2>Quando può essere utile un supporto psicologico</h2>

    <p>
        Chiedere supporto può essere utile quando emergono difficoltà persistenti nello sviluppo, nell’apprendimento o nella gestione delle emozioni e del comportamento.
        Un intervento precoce permette spesso di favorire uno sviluppo più armonico e di ridurre il rischio di difficoltà future.
    </p>

    <ul>
        <li>si osservano difficoltà persistenti nell’apprendimento o nell’attenzione</li>
        <li>il bambino fatica a organizzarsi o a gestire le attività quotidiane</li>
        <li>emergono difficoltà emotive o comportamentali</li>
        <li>la famiglia sente il bisogno di maggiore chiarezza sul funzionamento del minore</li>
        <li>si desidera individuare strategie educative più efficaci</li>
    </ul>

    <p>
        In questi momenti, un percorso di supporto può aiutare a comprendere meglio la situazione e a costruire interventi adeguati alle esigenze del bambino e della famiglia.
    </p>

    <h2>Psicologa a Tivoli e colloqui online</h2>

    <p>
        Ricevo a <strong>Tivoli</strong> e offro colloqui anche online, così da rendere il supporto accessibile a chi ne ha bisogno, indipendentemente dal luogo in cui vive.
    </p>

    <h2>Domande frequenti</h2>

    <h4>Come si capisce se un bambino ha un disturbo del neurosviluppo?</h4>
    <p>
        Alcuni segnali possono riguardare difficoltà persistenti nell’apprendimento, nell’attenzione, nella comunicazione o nella gestione delle emozioni.
        Una valutazione professionale permette di comprendere meglio il funzionamento del bambino e di individuare eventuali bisogni specifici.
    </p>

    <h4>È possibile intervenire anche in età scolare?</h4>
    <p>
        Sì. Molti interventi vengono avviati proprio durante il percorso scolastico, quando emergono difficoltà più evidenti.
        Un intervento tempestivo può favorire un miglior adattamento e una maggiore autonomia.
    </p>

    <h4>Il percorso coinvolge anche la famiglia?</h4>
    <p>
        Sì. Il coinvolgimento della famiglia è fondamentale per sostenere il bambino in modo coerente e favorire un ambiente educativo stabile e supportivo.
    </p>
    ',
            ],

            [
                'slug' => 'genitorialita',
                'title' => 'Genitorialità',
                'meta_title' => 'Genitorialità | Psicologa a Tivoli',
                'meta_description' => 'Supporto psicologico a Tivoli per genitori e famiglie. Percorsi di sostegno alla genitorialità per affrontare difficoltà educative, relazionali e fasi delicate della crescita dei figli.',
                'preview' => 'Sostegno ai genitori nelle diverse fasi evolutive dei figli e nelle dinamiche familiari.',
                'image' => '/img/genitori.webp',
                'intro' => 'La genitorialità può portare con sé domande, dubbi, fatiche e momenti di disorientamento, soprattutto quando i figli attraversano fasi delicate di crescita o presentano difficoltà specifiche.',

                'body' => '
    <p>
        Essere genitori significa affrontare ogni giorno nuove sfide educative, emotive e relazionali.
        In alcuni momenti può emergere il bisogno di un confronto professionale per comprendere meglio i comportamenti dei figli e individuare modalità educative più efficaci.
        Come <strong>psicologa a Tivoli</strong>, offro percorsi di <strong>sostegno alla genitorialità</strong> pensati per accompagnare le famiglie nelle diverse fasi della crescita dei figli.
    </p>

    <h2>Quando la genitorialità diventa più complessa</h2>

    <p>
        Ogni fase dello sviluppo può presentare difficoltà diverse. Alcuni genitori si trovano ad affrontare momenti di incertezza legati allo studio, al comportamento o alle relazioni dei figli.
    </p>

    <p>
        In molti casi, le difficoltà emergono nel contesto scolastico, attraverso
        <a href="'.route('areas.show', ['slug' => 'difficolta-scolastiche']).'">difficoltà scolastiche</a>,
        oppure in presenza di caratteristiche specifiche dello sviluppo, come avviene nei
        <a href="'.route('areas.show', ['slug' => 'disturbi-del-neurosviluppo']).'">disturbi del neurosviluppo</a>.
    </p>

    <h2>Le situazioni più frequenti che portano a chiedere supporto</h2>

    <p>
        Il sostegno alla genitorialità può essere utile in molte situazioni, anche quando non è presente un problema definito ma emerge il bisogno di orientamento e confronto.
    </p>

    <ul>
        <li>fatica nella gestione quotidiana delle dinamiche familiari</li>
        <li>dubbi educativi o difficoltà nel comprendere i bisogni dei figli</li>
        <li>senso di stanchezza, frustrazione o incertezza nel ruolo genitoriale</li>
        <li>difficoltà relazionali tra genitori e figli</li>
        <li>preoccupazione per il benessere emotivo o scolastico del figlio</li>
    </ul>

    <p>
        In alcune situazioni può essere utile approfondire il funzionamento del bambino attraverso una
        <a href="'.route('areas.show', ['slug' => 'valutazioni-psicodiagnostiche']).'">valutazione psicodiagnostica</a>,
        che permette di individuare bisogni specifici e orientare gli interventi in modo più mirato.
    </p>

    <h2>Come si sviluppa il percorso di sostegno alla genitorialità</h2>

    <p>
        Il lavoro si sviluppa attraverso ascolto, confronto e valorizzazione delle risorse genitoriali già presenti.
        L’obiettivo non è offrire soluzioni standard, ma accompagnare la famiglia nella ricerca di un equilibrio più adatto alla propria storia e ai propri bisogni.
    </p>

    <p>
        Durante il percorso sarà possibile:
    </p>

    <ul>
        <li>comprendere meglio i comportamenti e i bisogni dei figli</li>
        <li>sviluppare strategie educative più efficaci</li>
        <li>migliorare la comunicazione all’interno della famiglia</li>
        <li>gestire momenti di conflitto o difficoltà relazionali</li>
    </ul>

    <p>
        Il lavoro può integrare interventi specifici legati allo sviluppo dell’
        <a href="'.route('areas.show', ['slug' => 'autostima']).'">autostima</a>
        oppure al miglioramento delle
        <a href="'.route('areas.show', ['slug' => 'difficolta-relazionali']).'">difficoltà relazionali</a>,
        favorendo un clima familiare più sereno e collaborativo.
    </p>

    <h2>Quando può essere utile chiedere un supporto</h2>

    <p>
        Chiedere aiuto non significa essere genitori in difficoltà, ma prendersi cura del benessere della famiglia.
        Un supporto tempestivo può aiutare a prevenire situazioni più complesse e a favorire uno sviluppo equilibrato del bambino.
    </p>

    <ul>
        <li>si osservano cambiamenti nel comportamento del figlio</li>
        <li>emergono difficoltà nella gestione delle emozioni</li>
        <li>la comunicazione in famiglia diventa difficile</li>
        <li>si desidera maggiore sicurezza nel proprio ruolo educativo</li>
        <li>si sente il bisogno di confronto e orientamento</li>
    </ul>

    <p>
        Il sostegno viene costruito in modo condiviso, nel rispetto della specificità di ogni famiglia e della fase evolutiva che sta attraversando.
    </p>

    <h2>Psicologa a Tivoli e colloqui online</h2>

    <p>
        Ricevo a <strong>Tivoli</strong> e offro colloqui anche online, così da rendere il supporto accessibile a chi ne ha bisogno, indipendentemente dal luogo in cui vive.
    </p>

    <h2>Domande frequenti</h2>

    <h4>Il sostegno alla genitorialità è utile anche senza un problema specifico?</h4>
    <p>
        Sì. Molti genitori richiedono supporto per confrontarsi su dubbi educativi o per migliorare la comunicazione con i figli, anche in assenza di difficoltà particolari.
    </p>

    <h4>Il percorso coinvolge solo i genitori o anche i figli?</h4>
    <p>
        Dipende dalla situazione. In alcuni casi il lavoro si svolge solo con i genitori, in altri può coinvolgere anche il bambino o l’adolescente.
    </p>

    <h4>Quante sedute sono necessarie?</h4>
    <p>
        La durata del percorso varia in base agli obiettivi condivisi e alle esigenze della famiglia. Alcuni percorsi sono brevi e focalizzati, altri più approfonditi.
    </p>
    ',
            ],

            [
                'slug' => 'valutazioni-psicodiagnostiche',
                'title' => 'Valutazioni psicodiagnostiche',
                'meta_title' => 'Valutazioni psicodiagnostiche | Psicologa a Tivoli',
                'meta_description' => 'Valutazioni psicodiagnostiche a Tivoli per bambini e ragazzi. Un percorso per comprendere difficoltà di apprendimento, attenzione e funzionamento emotivo e cognitivo.',
                'preview' => 'Percorso di valutazione per comprendere il funzionamento cognitivo, emotivo e degli apprendimenti della persona.',
                'image' => '/img/valutazione.webp',
                'intro' => 'Le valutazioni psicodiagnostiche rappresentano un percorso fondamentale per comprendere in modo approfondito il funzionamento cognitivo, emotivo e degli apprendimenti della persona.',

                'body' => '
    <p>
        La <strong>valutazione psicodiagnostica</strong> è un percorso strutturato che permette di comprendere in modo chiaro e approfondito il funzionamento cognitivo, emotivo e comportamentale della persona.
        Viene utilizzata quando emergono dubbi o difficoltà legate all’apprendimento, all’attenzione, al comportamento o alla gestione delle emozioni.
        Come <strong>psicologa a Tivoli</strong>, svolgo valutazioni psicodiagnostiche con l’obiettivo di fornire indicazioni concrete e utili per la vita quotidiana e scolastica.
    </p>

    <h2>Quando è utile una valutazione psicodiagnostica</h2>

    <p>
        Una valutazione può essere richiesta quando si osservano difficoltà persistenti nello sviluppo, nell’apprendimento o nella regolazione emotiva.
        In questi casi, comprendere il funzionamento della persona è il primo passo per individuare un intervento adeguato.
    </p>

    <p>
        Spesso la richiesta nasce in presenza di
        <a href="'.route('areas.show', ['slug' => 'difficolta-scolastiche']).'">difficoltà scolastiche</a>,
        problemi di attenzione o caratteristiche riconducibili ai
        <a href="'.route('areas.show', ['slug' => 'disturbi-del-neurosviluppo']).'">disturbi del neurosviluppo</a>.
    </p>

    <h2>Le situazioni più frequenti che portano a richiedere una valutazione</h2>

    <p>
        La valutazione psicodiagnostica può essere utile in diverse situazioni, anche quando non è presente una diagnosi ma emerge il bisogno di maggiore chiarezza.
    </p>

    <ul>
        <li>difficoltà di apprendimento o rendimento scolastico</li>
        <li>difficoltà di attenzione, concentrazione o organizzazione</li>
        <li>fatica nella gestione delle emozioni o del comportamento</li>
        <li>bisogno di comprendere meglio il funzionamento cognitivo ed emotivo</li>
        <li>necessità di orientare in modo più mirato il percorso di supporto</li>
    </ul>

    <p>
        Comprendere con precisione i bisogni della persona permette di costruire interventi più efficaci, come percorsi di
        <a href="'.route('areas.show', ['slug' => 'potenziamento-abilita-scolastiche']).'">potenziamento delle abilità scolastiche</a>
        oppure interventi di
        <a href="'.route('areas.show', ['slug' => 'potenziamento-funzioni-esecutive']).'">potenziamento delle funzioni esecutive</a>.
    </p>

    <h2>Come si svolge una valutazione psicodiagnostica</h2>

    <p>
        La valutazione viene svolta con attenzione e gradualità, integrando osservazione clinica, colloqui e strumenti standardizzati.
        Il percorso è pensato per raccogliere informazioni complete e restituire una comprensione chiara e condivisa della situazione.
    </p>

    <p>
        Il percorso può includere:
    </p>

    <ul>
        <li>colloqui con i genitori e con il minore</li>
        <li>somministrazione di test e strumenti standardizzati</li>
        <li>osservazione del comportamento e delle modalità di apprendimento</li>
        <li>restituzione dei risultati e indicazioni operative</li>
    </ul>

    <p>
        Il lavoro viene svolto in collaborazione con la famiglia, favorendo un confronto costruttivo e orientato al benessere del bambino o dell’adolescente.
        In alcuni casi, può essere utile affiancare il percorso con un intervento di
        <a href="'.route('areas.show', ['slug' => 'genitorialita']).'">sostegno alla genitorialità</a>,
        per supportare i genitori nella gestione delle difficoltà emerse.
    </p>

    <h2>Qual è l’obiettivo della valutazione</h2>

    <p>
        L’obiettivo della valutazione psicodiagnostica non è solo formulare una diagnosi, ma comprendere il funzionamento della persona e individuare strategie concrete per favorire il suo benessere.
    </p>

    <ul>
        <li>chiarire la natura delle difficoltà presenti</li>
        <li>individuare punti di forza e bisogni specifici</li>
        <li>orientare interventi educativi e terapeutici</li>
        <li>favorire uno sviluppo più equilibrato e consapevole</li>
    </ul>

    <p>
        Il percorso di valutazione fornisce indicazioni utili sia in ambito scolastico sia nella vita quotidiana, sostenendo la persona e la famiglia nella scelta del percorso più adeguato.
    </p>

    <h2>Psicologa a Tivoli e colloqui online</h2>

    <p>
        Ricevo a <strong>Tivoli</strong> e offro colloqui anche online, così da rendere il supporto accessibile a chi ne ha bisogno, indipendentemente dal luogo in cui vive.
    </p>

    <h2>Domande frequenti</h2>

    <h4>Quanto dura una valutazione psicodiagnostica?</h4>
    <p>
        La durata varia in base alla situazione e agli strumenti utilizzati. In genere il percorso si articola in più incontri, distribuiti nell’arco di alcune settimane.
    </p>

    <h4>È necessaria una richiesta della scuola per iniziare?</h4>
    <p>
        No. La valutazione può essere richiesta direttamente dalla famiglia quando emergono dubbi o difficoltà nello sviluppo o nell’apprendimento.
    </p>

    <h4>Dopo la valutazione cosa succede?</h4>
    <p>
        Al termine del percorso viene fornita una restituzione chiara e condivisa, con indicazioni pratiche sui possibili interventi da intraprendere.
    </p>
    ',
            ],

            [
                'slug' => 'potenziamento-funzioni-esecutive',
                'title' => 'Potenziamento delle funzioni esecutive',
                'meta_title' => 'Potenziamento delle funzioni esecutive | Psicologa a Tivoli',
                'meta_description' => 'Percorsi di potenziamento delle funzioni esecutive a Tivoli per bambini e ragazzi con difficoltà di attenzione, memoria di lavoro e organizzazione. Interventi personalizzati in presenza e online.',
                'preview' => 'Intervento mirato al rafforzamento dei processi cognitivi che regolano comportamento, organizzazione e autoregolazione.',
                'image' => '/img/funzioni.webp',
                'intro' => 'Il potenziamento delle funzioni esecutive è un intervento mirato al rafforzamento dei processi cognitivi che regolano il comportamento, l’organizzazione e la gestione delle attività quotidiane.',

                'body' => '
    <p>
        Le <strong>funzioni esecutive</strong> sono l’insieme di abilità cognitive che permettono di organizzare le attività, mantenere l’attenzione, controllare gli impulsi e adattarsi alle situazioni.
        Quando queste abilità risultano fragili, il bambino o l’adolescente può incontrare difficoltà nello studio, nella gestione dei compiti e nelle relazioni quotidiane.
        Come <strong>psicologa a Tivoli</strong>, propongo percorsi di potenziamento delle funzioni esecutive per migliorare autonomia, concentrazione e capacità di organizzazione.
    </p>

    <h2>Cosa sono le funzioni esecutive</h2>

    <p>
        Le funzioni esecutive comprendono abilità fondamentali per la vita quotidiana e scolastica, come la pianificazione, la memoria di lavoro, l’attenzione e il controllo dell’impulsività.
        Queste competenze permettono di affrontare le richieste della scuola, gestire il tempo e adattarsi ai cambiamenti.
    </p>

    <p>
        In alcuni casi, le difficoltà nelle funzioni esecutive possono essere associate ai
        <a href="'.route('areas.show', ['slug' => 'disturbi-del-neurosviluppo']).'">disturbi del neurosviluppo</a>
        oppure manifestarsi attraverso
        <a href="'.route('areas.show', ['slug' => 'difficolta-scolastiche']).'">difficoltà scolastiche</a>
        legate all’organizzazione e alla concentrazione.
    </p>

    <h2>Segnali che possono indicare difficoltà nelle funzioni esecutive</h2>

    <p>
        Le difficoltà nelle funzioni esecutive possono manifestarsi in modo diverso a seconda dell’età e delle richieste dell’ambiente.
    </p>

    <ul>
        <li>difficoltà di attenzione e concentrazione</li>
        <li>fatica nella pianificazione e nell’organizzazione dei compiti</li>
        <li>difficoltà nella memoria di lavoro</li>
        <li>impulsività o difficoltà nel controllare le emozioni</li>
        <li>difficoltà nel rispettare tempi e regole</li>
    </ul>

    <p>
        In presenza di questi segnali, può essere utile effettuare una
        <a href="'.route('areas.show', ['slug' => 'valutazioni-psicodiagnostiche']).'">valutazione psicodiagnostica</a>,
        che permette di comprendere in modo più preciso il funzionamento cognitivo e individuare gli interventi più adeguati.
    </p>

    <h2>Come si svolge il potenziamento delle funzioni esecutive</h2>

    <p>
        Il percorso viene definito in modo personalizzato sulla base delle caratteristiche e dei bisogni della persona.
        L’intervento utilizza attività strutturate e graduali, con l’obiettivo di rafforzare le competenze cognitive e migliorare la gestione delle attività quotidiane.
    </p>

    <p>
        Durante il percorso si lavora su:
    </p>

    <ul>
        <li>attenzione e concentrazione</li>
        <li>memoria di lavoro</li>
        <li>pianificazione e organizzazione</li>
        <li>flessibilità cognitiva</li>
        <li>controllo dell’impulsività</li>
    </ul>

    <p>
        Quando necessario, il lavoro può essere integrato con interventi di
        <a href="'.route('areas.show', ['slug' => 'potenziamento-abilita-scolastiche']).'">potenziamento delle abilità scolastiche</a>
        oppure con attività di supporto allo studio come il
        <a href="'.route('areas.show', ['slug' => 'tutor-dsa-bes-adhd']).'">tutor DSA, BES e ADHD</a>.
    </p>

    <h2>Quali benefici può portare il potenziamento delle funzioni esecutive</h2>

    <p>
        Il rafforzamento delle funzioni esecutive favorisce un funzionamento più efficace e stabile nella vita quotidiana, scolastica e relazionale.
    </p>

    <ul>
        <li>migliore capacità di organizzare lo studio</li>
        <li>aumento dell’autonomia nelle attività quotidiane</li>
        <li>maggiore controllo delle emozioni e del comportamento</li>
        <li>riduzione della frustrazione e dello stress</li>
        <li>migliore adattamento alle richieste scolastiche</li>
    </ul>

    <p>
        Intervenire su queste competenze permette di sostenere lo sviluppo del bambino o dell’adolescente e di favorire una maggiore sicurezza nelle proprie capacità.
    </p>

    <h2>Psicologa a Tivoli e colloqui online</h2>

    <p>
        Ricevo a <strong>Tivoli</strong> e offro colloqui anche online, così da rendere il supporto accessibile a chi ne ha bisogno, indipendentemente dal luogo in cui vive.
    </p>

    <h2>Domande frequenti</h2>

    <h4>Il potenziamento delle funzioni esecutive è utile solo per chi ha una diagnosi?</h4>
    <p>
        No. Questo intervento può essere utile anche in assenza di una diagnosi, quando emergono difficoltà di attenzione, organizzazione o gestione delle attività quotidiane.
    </p>

    <h4>Quanto dura un percorso di potenziamento?</h4>
    <p>
        La durata varia in base alle esigenze della persona e agli obiettivi condivisi. In genere il percorso si sviluppa attraverso incontri regolari e progressivi.
    </p>

    <h4>A che età si può iniziare?</h4>
    <p>
        Il potenziamento delle funzioni esecutive può essere proposto già in età scolare e adattato alle caratteristiche del bambino o dell’adolescente.
    </p>
    ',
            ],

            [
                'slug' => 'potenziamento-abilita-scolastiche',
                'title' => 'Potenziamento delle abilità scolastiche',
                'meta_title' => 'Potenziamento delle abilità scolastiche | Psicologa a Tivoli',
                'meta_description' => 'Percorsi di potenziamento delle abilità scolastiche a Tivoli per bambini e ragazzi con difficoltà di lettura, scrittura, calcolo e metodo di studio. Interventi personalizzati in presenza e online.',
                'preview' => 'Percorso finalizzato al miglioramento dei processi implicati negli apprendimenti scolastici, come lettura, scrittura e calcolo.',
                'image' => '/img/scolastiche.webp',
                'intro' => 'Il potenziamento delle abilità scolastiche è un percorso mirato al miglioramento dei processi coinvolti negli apprendimenti, con particolare attenzione a lettura, scrittura e calcolo.',

                'body' => '
    <p>
        Il <strong>potenziamento delle abilità scolastiche</strong> è un intervento specifico pensato per aiutare bambini e adolescenti a sviluppare competenze più solide nello studio e negli apprendimenti.
        Quando leggere, scrivere o svolgere i compiti diventa difficile o faticoso, è importante intervenire con strategie adeguate e personalizzate.
        Come <strong>psicologa a Tivoli</strong>, propongo percorsi di potenziamento che permettono di migliorare le abilità scolastiche e rafforzare la fiducia nelle proprie capacità.
    </p>

    <h2>Quando è utile il potenziamento delle abilità scolastiche</h2>

    <p>
        Questo intervento può essere utile quando il bambino o l’adolescente incontra difficoltà nel rendimento scolastico o fatica a sviluppare modalità efficaci nello studio.
        In molti casi, queste difficoltà si manifestano attraverso
        <a href="'.route('areas.show', ['slug' => 'difficolta-scolastiche']).'">difficoltà scolastiche</a>
        persistenti o lentezza nell’apprendimento.
    </p>

    <p>
        In alcune situazioni, le difficoltà possono essere legate a caratteristiche specifiche dello sviluppo, come nei
        <a href="'.route('areas.show', ['slug' => 'disturbi-del-neurosviluppo']).'">disturbi del neurosviluppo</a>,
        oppure a fragilità nei processi attentivi e organizzativi che possono essere affrontate attraverso il
        <a href="'.route('areas.show', ['slug' => 'potenziamento-funzioni-esecutive']).'">potenziamento delle funzioni esecutive</a>.
    </p>

    <h2>Segnali che possono indicare la necessità di un potenziamento</h2>

    <p>
        Le difficoltà negli apprendimenti possono presentarsi in modo diverso a seconda dell’età e delle richieste scolastiche.
    </p>

    <ul>
        <li>difficoltà nella lettura, scrittura o calcolo</li>
        <li>lentezza o scarsa accuratezza nelle attività scolastiche</li>
        <li>fatica nel gestire i compiti in autonomia</li>
        <li>difficoltà nel comprendere o memorizzare le informazioni</li>
        <li>bisogno di strategie più efficaci nello studio</li>
    </ul>

    <p>
        In presenza di questi segnali, può essere utile effettuare una
        <a href="'.route('areas.show', ['slug' => 'valutazioni-psicodiagnostiche']).'">valutazione psicodiagnostica</a>,
        che permette di comprendere con maggiore precisione il funzionamento dell’apprendimento e orientare l’intervento.
    </p>

    <h2>Come si svolge il potenziamento delle abilità scolastiche</h2>

    <p>
        Il percorso viene costruito in base alle caratteristiche del bambino o dell’adolescente e agli obiettivi condivisi con la famiglia.
        L’intervento si concentra sull’efficienza e sull’accuratezza delle prestazioni, supportando lo sviluppo di strategie funzionali e stabili nello studio.
    </p>

    <p>
        Durante il percorso si lavora su:
    </p>

    <ul>
        <li>lettura e comprensione del testo</li>
        <li>scrittura e ortografia</li>
        <li>calcolo e problem solving</li>
        <li>metodo di studio e organizzazione dei compiti</li>
        <li>autonomia e sicurezza nelle attività scolastiche</li>
    </ul>

    <p>
        Quando necessario, il percorso può essere integrato con attività di supporto allo studio come il
        <a href="'.route('areas.show', ['slug' => 'tutor-dsa-bes-adhd']).'">tutor DSA, BES e ADHD</a>,
        favorendo una maggiore continuità tra intervento specialistico e vita scolastica.
    </p>

    <h2>Quali benefici può portare il potenziamento</h2>

    <p>
        Il potenziamento delle abilità scolastiche favorisce apprendimenti più solidi e una maggiore autonomia nello studio.
        Intervenire in modo mirato permette di ridurre la fatica e migliorare il rapporto con la scuola.
    </p>

    <ul>
        <li>migliore efficacia nello studio</li>
        <li>aumento della sicurezza nelle proprie capacità</li>
        <li>riduzione della frustrazione legata ai compiti</li>
        <li>maggiore autonomia nelle attività scolastiche</li>
        <li>rapporto più sereno con l’esperienza scolastica</li>
    </ul>

    <p>
        L’obiettivo è favorire uno sviluppo equilibrato delle competenze e sostenere il benessere del bambino o dell’adolescente nel percorso scolastico.
    </p>

    <h2>Psicologa a Tivoli e colloqui online</h2>

    <p>
        Ricevo a <strong>Tivoli</strong> e offro colloqui anche online, così da rendere il supporto accessibile a chi ne ha bisogno, indipendentemente dal luogo in cui vive.
    </p>

    <h2>Domande frequenti</h2>

    <h4>Il potenziamento è utile anche senza una diagnosi?</h4>
    <p>
        Sì. Il potenziamento può essere utile anche in assenza di una diagnosi, quando emergono difficoltà nello studio o negli apprendimenti.
    </p>

    <h4>Quanto dura un percorso di potenziamento delle abilità scolastiche?</h4>
    <p>
        La durata varia in base agli obiettivi e alle esigenze della persona. In genere il percorso si sviluppa attraverso incontri regolari e progressivi.
    </p>

    <h4>Il potenziamento sostituisce il supporto scolastico?</h4>
    <p>
        No. Il potenziamento non sostituisce lo studio, ma aiuta a sviluppare strategie più efficaci per affrontare le richieste scolastiche in modo autonomo.
    </p>
    ',
            ],

            [
                'slug' => 'intervento-di-gruppo-area-emotiva-relazionale',
                'title' => 'Intervento in gruppo – Area emotiva e relazionale',
                'meta_title' => 'Intervento di gruppo – Area emotiva e relazionale | Psicologa a Tivoli',
                'meta_description' => 'Percorsi di gruppo a Tivoli per bambini e ragazzi, pensati per sviluppare autostima, competenze sociali, regolazione emotiva e capacità relazionali.',
                'preview' => 'Percorsi di gruppo per sviluppare competenze sociali, sicurezza personale e capacità di relazione con i pari.',
                'image' => '/img/gruppo.webp',
                'intro' => 'Il lavoro di gruppo rappresenta uno spazio protetto in cui bambini e ragazzi possono sperimentarsi nella relazione con i pari, sviluppando maggiore consapevolezza di sé e degli altri.',

                'body' => '
    <p>
        L’<strong>intervento di gruppo in area emotiva e relazionale</strong> offre a bambini e ragazzi uno spazio protetto in cui sperimentarsi nella relazione con i pari, confrontarsi con gli altri e sviluppare nuove competenze personali e sociali.
        Come <strong>psicologa a Tivoli</strong>, propongo percorsi di gruppo pensati per favorire una maggiore sicurezza personale, migliorare la comunicazione e sostenere la crescita emotiva e relazionale.
    </p>

    <h2>Perché il lavoro di gruppo può essere utile</h2>

    <p>
        Il gruppo rappresenta un contesto attivo di apprendimento, in cui bambini e ragazzi possono sperimentare nuove modalità di relazione, espressione e ascolto.
        Attraverso il confronto con i pari, è possibile sviluppare una maggiore consapevolezza di sé, delle proprie emozioni e del proprio modo di stare con gli altri.
    </p>

    <p>
        Questo tipo di intervento può essere particolarmente utile quando emergono fragilità legate all’
        <a href="'.route('areas.show', ['slug' => 'autostima']).'">autostima</a>,
        difficoltà nelle relazioni o fatica nel vivere il gruppo in modo sereno e sicuro.
    </p>

    <h2>Quando può essere indicato un percorso di gruppo</h2>

    <p>
        Il lavoro di gruppo può essere proposto quando il bambino o il ragazzo incontra difficoltà nel rapporto con i coetanei, nella gestione delle emozioni o nell’inserimento nei contesti sociali e scolastici.
    </p>

    <ul>
        <li>difficoltà nelle relazioni con i coetanei</li>
        <li>insicurezza nelle situazioni sociali o di gruppo</li>
        <li>fatica nel gestire emozioni e conflitti interpersonali</li>
        <li>bisogno di rafforzare autostima e competenze sociali</li>
        <li>difficoltà nel comunicare in modo efficace e rispettoso</li>
    </ul>

    <p>
        In questi casi, il gruppo può diventare uno spazio di crescita concreto, in cui sperimentare modalità relazionali più sicure e funzionali.
    </p>

    <h2>Come si svolge l’intervento di gruppo</h2>

    <p>
        Il percorso si sviluppa attraverso attività guidate, esperienziali e strutturate, pensate per favorire l’espressione emotiva, il confronto, la cooperazione e la regolazione delle dinamiche interpersonali.
        Il gruppo non è solo un luogo di osservazione, ma uno spazio in cui allenare competenze che possono avere ricadute positive nella vita quotidiana e scolastica.
    </p>

    <p>
        Durante il percorso si lavora su:
    </p>

    <ul>
        <li>autostima e senso di autoefficacia</li>
        <li>competenze sociali e capacità di cooperazione</li>
        <li>abilità relazionali e comunicative</li>
        <li>riconoscimento e regolazione delle emozioni</li>
        <li>gestione dei conflitti e rispetto dei confini</li>
    </ul>

    <p>
        In alcuni casi, il lavoro di gruppo può affiancarsi a un percorso individuale su aree come le
        <a href="'.route('areas.show', ['slug' => 'difficolta-relazionali']).'">difficoltà relazionali</a>
        oppure l’
        <a href="'.route('areas.show', ['slug' => 'umore-basso']).'">umore basso</a>,
        offrendo al minore un contesto più ampio in cui sperimentare ciò che sta apprendendo.
    </p>

    <h2>Quali benefici può offrire il gruppo</h2>

    <p>
        Il gruppo può favorire una crescita emotiva e relazionale concreta, sostenendo il bambino o il ragazzo nello sviluppo di maggiore sicurezza personale e nella qualità delle relazioni con gli altri.
    </p>

    <ul>
        <li>maggiore fiducia nelle proprie capacità relazionali</li>
        <li>migliore gestione delle emozioni nelle situazioni sociali</li>
        <li>più sicurezza nell’esprimere bisogni e pensieri</li>
        <li>maggiore capacità di ascolto, confronto e collaborazione</li>
        <li>ricadute positive nella vita quotidiana e scolastica</li>
    </ul>

    <p>
        Il percorso di gruppo viene sempre costruito con attenzione all’età, alle caratteristiche dei partecipanti e agli obiettivi del lavoro, in modo da offrire un’esperienza realmente utile, protetta e significativa.
    </p>

    <h2>Il ruolo della famiglia</h2>

    <p>
        Quando necessario, il lavoro può prevedere momenti di confronto con i genitori, così da condividere il significato del percorso e sostenere il bambino o il ragazzo anche nel contesto familiare.
        In questi casi, il gruppo può essere integrato con un percorso di
        <a href="'.route('areas.show', ['slug' => 'genitorialita']).'">sostegno alla genitorialità</a>,
        per favorire maggiore continuità tra il lavoro svolto nel gruppo e la vita quotidiana.
    </p>

        <h2>Psicologa a Tivoli e colloqui online</h2>

    <p>
        Ricevo a <strong>Tivoli</strong> e offro colloqui anche online, così da rendere il supporto accessibile a chi ne ha bisogno, indipendentemente dal luogo in cui vive.
    </p>

    <h2>Domande frequenti</h2>

    <h4>Il percorso di gruppo è adatto a tutti i bambini o ragazzi?</h4>
    <p>
        Non sempre. L’inserimento in un gruppo viene valutato con attenzione in base all’età, alle caratteristiche del minore e agli obiettivi del percorso, così da garantire un’esperienza adeguata e realmente utile.
    </p>

    <h4>Il gruppo sostituisce un percorso individuale?</h4>
    <p>
        Non necessariamente. In alcuni casi il gruppo può essere il percorso più indicato, in altri può affiancarsi a un lavoro individuale, a seconda dei bisogni della persona.
    </p>

    <h4>Quali aspetti si possono migliorare attraverso il lavoro di gruppo?</h4>
    <p>
        Il gruppo può aiutare a sviluppare autostima, competenze sociali, regolazione emotiva, capacità comunicative e maggiore sicurezza nelle relazioni con i pari.
    </p>
    ',
            ],

            [
                'slug' => 'tutor-dsa-bes-adhd',
                'title' => 'Tutor DSA, BES e ADHD',
                'meta_title' => 'Tutor DSA, BES e ADHD | Psicologa a Tivoli',
                'meta_description' => 'Supporto allo studio a Tivoli per bambini e ragazzi con DSA, BES e ADHD. Percorsi personalizzati per organizzazione, metodo di studio e autonomia scolastica.',
                'preview' => 'Supporto allo studio per bambini e ragazzi con DSA, BES e difficoltà attentive e di autoregolazione.',
                'image' => '/img/dsa.webp',
                'intro' => 'Il servizio di tutor DSA, BES e ADHD è rivolto a bambini e ragazzi che incontrano difficoltà nello studio, nell’organizzazione dei compiti e nella gestione delle attività scolastiche quotidiane.',

                'body' => '
    <p>
        Il servizio di <strong>tutor DSA, BES e ADHD</strong> offre un supporto concreto e personalizzato per aiutare bambini e ragazzi a sviluppare un metodo di studio efficace e a gestire in modo più autonomo le richieste scolastiche.
        Come <strong>psicologa a Tivoli</strong>, accompagno il minore nel rafforzamento delle competenze organizzative e attentive, favorendo maggiore sicurezza e continuità nello studio.
    </p>

    <h2>Quando può essere utile il supporto di un tutor</h2>

    <p>
        Il tutor può essere utile quando il bambino o il ragazzo incontra difficoltà nel mantenere l’attenzione, organizzare il lavoro scolastico o gestire i compiti in autonomia.
        Spesso queste difficoltà si manifestano attraverso
        <a href="'.route('areas.show', ['slug' => 'difficolta-scolastiche']).'">difficoltà scolastiche</a>
        persistenti o lentezza nello svolgimento delle attività.
    </p>

    <p>
        In alcuni casi, le difficoltà possono essere legate a caratteristiche specifiche dello sviluppo, come nei
        <a href="'.route('areas.show', ['slug' => 'disturbi-del-neurosviluppo']).'">disturbi del neurosviluppo</a>,
        oppure a fragilità nei processi attentivi e organizzativi che possono essere affrontate attraverso il
        <a href="'.route('areas.show', ['slug' => 'potenziamento-funzioni-esecutive']).'">potenziamento delle funzioni esecutive</a>.
    </p>

    <h2>Le difficoltà più frequenti nello studio</h2>

    <p>
        Le difficoltà nello studio possono riguardare diversi aspetti dell’apprendimento e dell’organizzazione delle attività scolastiche.
    </p>

    <ul>
        <li>fatica nello studio e nell’organizzazione dei compiti</li>
        <li>difficoltà nell’uso di un metodo di studio efficace</li>
        <li>bisogno di strategie personalizzate e strumenti compensativi</li>
        <li>difficoltà nel mantenere attenzione e concentrazione</li>
        <li>stanchezza e demotivazione legate allo studio</li>
    </ul>

    <p>
        In presenza di queste difficoltà, può essere utile integrare il lavoro con interventi di
        <a href="'.route('areas.show', ['slug' => 'potenziamento-abilita-scolastiche']).'">potenziamento delle abilità scolastiche</a>,
        così da rafforzare le competenze necessarie per affrontare le richieste della scuola.
    </p>

    <h2>Come si svolge il lavoro con il tutor</h2>

    <p>
        Il percorso è orientato allo sviluppo di un metodo di studio efficace e personalizzato.
        L’intervento si concentra sull’acquisizione di strategie funzionali, sull’organizzazione del tempo e sull’utilizzo consapevole degli strumenti compensativi.
    </p>

    <p>
        Durante il percorso si lavora su:
    </p>

    <ul>
        <li>organizzazione dello studio e pianificazione dei compiti</li>
        <li>gestione del tempo e delle priorità</li>
        <li>strategie di memorizzazione e comprensione</li>
        <li>uso di strumenti compensativi</li>
        <li>autonomia e continuità nello studio</li>
    </ul>

    <p>
        Il lavoro si svolge in collaborazione con la famiglia e, quando necessario, con la scuola.
        In alcune situazioni può essere utile affiancare il percorso con un intervento di
        <a href="'.route('areas.show', ['slug' => 'genitorialita']).'">sostegno alla genitorialità</a>,
        così da favorire coerenza e continuità tra casa e scuola.
    </p>

    <h2>Quali benefici può offrire il supporto di un tutor</h2>

    <p>
        Il supporto di un tutor aiuta il bambino o il ragazzo a sviluppare maggiore autonomia nello studio e a ridurre la fatica legata alle attività scolastiche.
    </p>

    <ul>
        <li>maggiore organizzazione nello studio</li>
        <li>migliore gestione del tempo</li>
        <li>aumento dell’autonomia nei compiti</li>
        <li>riduzione della frustrazione e dello stress</li>
        <li>maggiore fiducia nelle proprie capacità</li>
    </ul>

    <p>
        L’obiettivo è sostenere lo sviluppo di competenze solide e favorire un rapporto più sereno con la scuola e con lo studio.
    </p>

    <h2>Psicologa a Tivoli e colloqui online</h2>

    <p>
        Ricevo a <strong>Tivoli</strong> e offro colloqui anche online, così da rendere il supporto accessibile a chi ne ha bisogno, indipendentemente dal luogo in cui vive.
    </p>

    <h2>Domande frequenti</h2>

    <h4>Il tutor è utile anche senza una diagnosi?</h4>
    <p>
        Sì. Il supporto allo studio può essere utile anche in assenza di una diagnosi, quando emergono difficoltà nell’organizzazione o nella gestione dei compiti.
    </p>

    <h4>Quante volte a settimana si svolge il tutoraggio?</h4>
    <p>
        La frequenza degli incontri viene definita in base alle esigenze del bambino o del ragazzo e agli obiettivi del percorso.
    </p>

    <h4>Il tutor sostituisce lo studio a casa?</h4>
    <p>
        No. Il tutor aiuta a sviluppare strategie e autonomia nello studio, così da rendere il lavoro a casa più efficace e sostenibile.
    </p>
    ',
            ],
        ];
    }
}
