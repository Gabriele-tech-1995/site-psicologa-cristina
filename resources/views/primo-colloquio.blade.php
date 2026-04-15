<x-layout :metaTitle="$metaTitle" :metaDescription="$metaDescription">
    @php
        $firstInterviewFaqs = [
            [
                'question' => 'Il primo colloquio mi obbliga a iniziare un percorso?',
                'answer' => 'No. Il primo incontro è uno spazio di ascolto e orientamento: serve a capire se ti senti a tuo agio e se questo percorso fa per te. Al termine scegli tu, con calma, se proseguire.',
            ],
            [
                'question' => 'E se non so bene cosa dire?',
                'answer' => 'Va benissimo così. Non devi prepararti in anticipo: puoi partire anche da poche parole, da un dubbio o da una sensazione confusa. Ti aiuto io a mettere ordine, passo dopo passo.',
            ],
            [
                'question' => 'Posso scegliere tra online e presenza?',
                'answer' => 'Sì. Puoi scegliere il primo colloquio online o in presenza. Decidiamo insieme la modalità più adatta al tuo momento, ai tuoi tempi e alla tua quotidianità.',
            ],
            [
                'question' => 'Il primo colloquio è adatto anche per genitori o adolescenti?',
                'answer' => 'Sì. Il primo colloquio è pensato per bambini, adolescenti, adulti e genitori. Ogni incontro viene adattato alla storia personale e al bisogno specifico di chi ho davanti.',
            ],
            [
                'question' => 'Quanto tempo passa prima di ricevere risposta dopo il messaggio?',
                'answer' => 'Di norma ricevi una risposta personale entro 24 ore (lun-ven), salvo periodi di maggiore richiesta.',
            ],
        ];

        $firstInterviewFaqSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => collect($firstInterviewFaqs)->map(fn (array $item) => [
                '@type' => 'Question',
                'name' => $item['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $item['answer'],
                ],
            ])->all(),
        ];
    @endphp

    <section class="section first-interview-page">
        <div class="container">
            <div class="page-head mb-4">
                <span class="badge badge-soft mb-3">Primo colloquio</span>
                <h1 class="page-title mb-2">Primo colloquio psicologico: cosa aspettarti</h1>
                <p class="page-lead mb-0">
                    Se stai pensando di chiedere supporto, è normale sentirti incerto o preoccupato.
                    In questa pagina trovi una guida semplice e umana su come funziona il primo incontro,
                    per aiutarti a sentirti più tranquillo già da adesso.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <article class="card shadow-soft p-4 p-lg-5">
                        <h2 class="h4 mb-3">A volte il primo passo è anche il più difficile</h2>
                        <p>
                            Chiedere aiuto non è semplice, e non c’è nulla di sbagliato in questo.
                            Potresti chiederti: “Da dove comincio?”, “Riuscirò a spiegarmi?”, “E se mi blocco?”.
                            Sono dubbi comuni, e meritano rispetto.
                        </p>
                        <p>
                            Con la <strong>Dott.ssa Cristina Pacifici, psicologa a Tivoli</strong>, il primo incontro è uno
                            spazio protetto in cui puoi sentirti accolto, ascoltato e mai giudicato.
                            Se vuoi <a href="{{ route('about') }}">scoprire qualcosa in più su di me</a>,
                            nella pagina <a href="{{ route('about') }}">chi sono</a> trovi il mio approccio e il modo in cui lavoro.
                        </p>
                        <div class="card shadow-soft border-0 p-3 p-lg-4 mt-3 first-interview-quick-cta">
                            <p class="small mb-3">
                                <strong>Ti rispondo io personalmente entro 24 ore lavorative</strong>, così possiamo
                                capire insieme da dove partire.
                            </p>
                            <div class="d-flex gap-2 flex-wrap cta-row cta-row-center-desktop">
                                <a class="btn btn-brand" href="{{ route('contacts') }}#richiesta-colloquio">
                                    Richiedi il primo colloquio
                                </a>
                                <a class="btn btn-outline-secondario" target="_blank" rel="noopener noreferrer"
                                    href="{{ $seoContact['whatsapp_url'] }}">
                                    Scrivimi su WhatsApp
                                </a>
                            </div>
                        </div>

                        <h2 class="h4 mt-4 mb-3">Cosa succede durante il primo colloquio</h2>
                        <p>
                            Nel primo colloquio non devi dimostrare nulla e non devi “essere pronto”.
                            L’obiettivo è capire cosa stai vivendo e offrirti un orientamento chiaro, concreto e rispettoso.
                        </p>
                        <ul>
                            <li>ti ascolto con attenzione, partendo da quello che senti più urgente;</li>
                            <li>mettiamo a fuoco insieme il momento che stai attraversando;</li>
                            <li>chiariamo bisogni, obiettivi e possibili direzioni del percorso;</li>
                            <li>ti spiego in modo semplice modalità, tempi e aspetti organizzativi;</li>
                            <li>valutiamo insieme, senza fretta, se e come proseguire.</li>
                        </ul>
                        <p class="mb-0">
                            È un incontro per fare chiarezza e iniziare a respirare un po’ di più, non una prova da superare.
                        </p>

                        <h2 class="h4 mt-4 mb-3">Cosa puoi portare o raccontare</h2>
                        <p>
                            Puoi portare ciò che in questo momento pesa di più, anche se ti sembra “disordinato” o difficile da spiegare.
                            Per esempio:
                        </p>
                        <ul>
                            <li>
                                un periodo di
                                <a href="{{ route('areas.show', ['slug' => 'ansia-e-gestione-dello-stress']) }}">ansia e gestione dello stress</a>,
                                stanchezza emotiva o preoccupazione costante;
                            </li>
                            <li>difficoltà relazionali o familiari;</li>
                            <li>
                                dubbi legati a tuo figlio o a tua figlia, oppure bisogno di
                                <a href="{{ route('areas.show', ['slug' => 'genitorialita']) }}">sostegno alla genitorialità</a>;
                            </li>
                            <li>fatica scolastica, organizzativa o motivazionale;</li>
                            <li>una sensazione di blocco che non riesci a decifrare.</li>
                        </ul>
                        <p class="mb-0">
                            Anche poche parole possono bastare: da lì possiamo costruire insieme un primo filo.
                        </p>

                        <h2 class="h4 mt-4 mb-3">Possiamo partire anche se ti senti confuso</h2>
                        <p>
                            Molte persone rimandano perché pensano di dover avere già tutto chiaro.
                            In realtà non è così: non devi trovare per forza le parole perfette
                            e non devi arrivare con una “spiegazione giusta”.
                        </p>
                        <p class="mb-0">
                            Il primo colloquio nasce proprio per questo: aiutarti a fare ordine, insieme, un passo alla volta.
                        </p>

                        <h2 class="h4 mt-4 mb-3">Quanto dura il primo colloquio</h2>
                        <p class="mb-0">
                            Il primo colloquio dura circa <strong>50 minuti</strong>, come le sedute successive.
                            È un tempo pensato per permetterti di parlare senza fretta e sentirti davvero ascoltato.
                        </p>

                        <h2 class="h4 mt-4 mb-3">Modalità: online o in presenza</h2>
                        <p>Puoi scegliere la modalità che in questo momento ti fa sentire più comodo:</p>
                        <ul>
                            <li><strong>online</strong>, se preferisci comodità, continuità o distanza;</li>
                            <li><strong>in presenza</strong>, presso le sedi di riferimento a Tivoli e zona.</li>
                        </ul>
                        <p class="mb-0">
                            Possiamo valutare insieme la soluzione migliore in base alle tue esigenze pratiche e personali.
                        </p>

                        <h2 class="h4 mt-4 mb-3">Se senti paura, imbarazzo o incertezza</h2>
                        <p>
                            È assolutamente normale. Molte persone arrivano al primo incontro con emozioni contrastanti:
                            sollievo, timore, vergogna, confusione.
                        </p>
                        <p>
                            In colloquio trovi uno spazio professionale e accogliente in cui puoi parlare al tuo ritmo,
                            anche iniziando da poche parole.
                        </p>
                        <p class="mb-0">
                            Chiedere un primo confronto non significa “stare male abbastanza”:
                            significa scegliere di prenderti cura di te, con rispetto.
                        </p>
                    </article>
                </div>

                <div class="col-lg-4">
                    <aside class="about-sidebar-sticky">
                        <div class="card shadow-soft p-4 mb-4">
                            <h2 class="h5 mb-3">In breve</h2>
                            <ul class="small mb-0 ps-3">
                                <li>Durata: circa 50 minuti</li>
                                <li>Modalità: online o in presenza</li>
                                <li>Nessun obbligo di proseguire</li>
                                <li>Risposta: di norma entro 24 ore</li>
                            </ul>
                        </div>

                        <div class="card shadow-soft p-4">
                            <h2 class="h5 mb-2">Quando vuoi, puoi iniziare da qui</h2>
                            <p class="small text-muted mb-3">
                                Se senti che è il momento, puoi scrivermi per un primo colloquio, online o in presenza.
                                Ti rispondo personalmente e capiamo insieme, con calma, da dove partire.
                            </p>
                            <div class="d-flex flex-column align-items-center gap-2">
                                <a class="btn btn-brand" href="{{ route('contacts') }}#richiesta-colloquio">
                                    Richiedi il primo colloquio
                                </a>
                                <a class="btn btn-outline-secondario" target="_blank" rel="noopener noreferrer"
                                    href="{{ $seoContact['whatsapp_url'] }}">
                                    Scrivimi su WhatsApp
                                </a>
                            </div>
                            <p class="small text-muted mt-3 mb-0">
                                Ricevi una risposta personale, di norma entro 24 ore (lun-ven).
                            </p>
                        </div>
                    </aside>
                </div>
            </div>

            <div class="card shadow-soft p-4 mt-4 text-center">
                <h2 class="h4 mb-2">Se senti che può esserti utile, possiamo fare un primo passo insieme</h2>
                <p class="text-muted mb-3">
                    Anche solo un messaggio può bastare per iniziare.
                    Se vuoi <a href="{{ route('contacts') }}#richiesta-colloquio">contattarmi</a>,
                    trovi tutto nella <a href="{{ route('contacts') }}">pagina contatti</a>.
                    Da lì puoi anche <a href="{{ route('contacts') }}#richiesta-colloquio">richiedere un primo colloquio</a>.
                </p>
                <div class="d-flex justify-content-center gap-2 flex-wrap cta-row cta-row-center-desktop">
                    <a class="btn btn-brand" href="{{ route('contacts') }}#richiesta-colloquio">
                        Richiedi il primo colloquio
                    </a>
                    <a class="btn btn-outline-secondario" target="_blank" rel="noopener noreferrer"
                        href="{{ $seoContact['whatsapp_url'] }}">
                        Scrivimi su WhatsApp
                    </a>
                </div>
            </div>

            <div class="card shadow-soft p-4 mt-4">
                <h2 class="h4 mb-3">Domande frequenti</h2>
                <div class="accordion accordion-flush contact-faq-accordion" id="firstInterviewFaq">
                    @foreach ($firstInterviewFaqs as $index => $faq)
                        @php
                            $collapseId = 'firstInterviewFaq'.$index;
                        @endphp
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#{{ $collapseId }}" aria-expanded="false" aria-controls="{{ $collapseId }}">
                                    {{ $faq['question'] }}
                                </button>
                            </h3>
                            <div id="{{ $collapseId }}" class="accordion-collapse collapse" data-bs-parent="#firstInterviewFaq">
                                <div class="accordion-body">
                                    <p class="mb-0">{{ $faq['answer'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <script type="application/ld+json"
        @isset($cspNonce) nonce="{{ $cspNonce }}" @endisset>
        {!! json_encode($firstInterviewFaqSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
</x-layout>
