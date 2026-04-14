<x-layout :metaTitle="$metaTitle" :metaDescription="$metaDescription">
    @php
        $firstInterviewFaqs = [
            [
                'question' => 'Il primo colloquio mi obbliga a iniziare un percorso?',
                'answer' => 'No. Il primo incontro è uno spazio di conoscenza e orientamento. Al termine puoi valutare con calma se proseguire.',
            ],
            [
                'question' => 'E se non so bene cosa dire?',
                'answer' => 'Va benissimo così. Puoi partire da come ti senti oggi o da ciò che ti sta pesando di più. Costruiamo insieme il filo del discorso.',
            ],
            [
                'question' => 'Posso scegliere tra online e presenza?',
                'answer' => 'Sì. Puoi fare il primo colloquio online o in presenza. La modalità viene scelta in base a ciò che è più adatto per te.',
            ],
            [
                'question' => 'Il primo colloquio è adatto anche per genitori o adolescenti?',
                'answer' => 'Sì. La Dott.ssa Cristina Pacifici lavora con bambini, adolescenti, adulti e genitori, con un approccio personalizzato.',
            ],
            [
                'question' => 'Quanto tempo passa prima di ricevere risposta dopo il messaggio?',
                'answer' => 'Di norma ricevi una risposta entro 24 ore lavorative (lun-ven), salvo periodi di maggiore richiesta.',
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

    <section class="section">
        <div class="container">
            <div class="page-head mb-4">
                <span class="badge badge-soft mb-3">Primo colloquio</span>
                <h1 class="page-title mb-2">Primo colloquio psicologico: cosa aspettarti, con calma</h1>
                <p class="page-lead mb-0">
                    Se stai pensando di chiedere supporto, è normale avere dubbi: non devi arrivare con tutto chiaro.
                    Il primo incontro è uno spazio accogliente e professionale in cui iniziare a capire insieme da dove partire.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <article class="card shadow-soft p-4 p-lg-5">
                        <h2 class="h4 mb-3">A volte il primo passo è anche il più difficile</h2>
                        <p>
                            Potresti chiederti: “Da dove comincio?”, “Cosa devo dire?”, “E se non riesco a spiegarmi bene?”.
                            Sono domande frequenti e comprensibili. Il primo colloquio serve proprio a offrire uno spazio
                            chiaro, rispettoso e senza giudizio, dove puoi portare quello che senti adesso.
                        </p>
                        <p>
                            Con la <strong>Dott.ssa Cristina Pacifici, psicologa a Tivoli</strong>, il primo incontro è un
                            momento di ascolto autentico, costruito sui tuoi tempi.
                        </p>

                        <h2 class="h4 mt-4 mb-3">Cosa succede durante il primo colloquio</h2>
                        <p>
                            Nel primo incontro non devi dimostrare nulla. L’obiettivo è capire insieme la tua situazione e
                            orientarti con chiarezza.
                        </p>
                        <ul>
                            <li>ti ascolto e raccolgo la tua richiesta;</li>
                            <li>esploriamo il momento che stai attraversando;</li>
                            <li>chiarisco con te bisogni, obiettivi e priorità;</li>
                            <li>rispondo alle tue domande su percorso, modalità e organizzazione;</li>
                            <li>valutiamo insieme se e come proseguire.</li>
                        </ul>
                        <p class="mb-0">È un incontro utile per fare ordine, non un esame da superare.</p>

                        <h2 class="h4 mt-4 mb-3">Cosa puoi portare o raccontare</h2>
                        <p>Puoi partire da ciò che per te è più urgente oggi, ad esempio:</p>
                        <ul>
                            <li>un periodo di ansia, stress o stanchezza emotiva;</li>
                            <li>difficoltà relazionali o familiari;</li>
                            <li>dubbi legati a tuo figlio o a tua figlia;</li>
                            <li>fatica scolastica, organizzativa o motivazionale;</li>
                            <li>una sensazione di blocco che non riesci a decifrare.</li>
                        </ul>
                        <p class="mb-0">Puoi anche portare poche informazioni: basta un punto di partenza sincero.</p>

                        <h2 class="h4 mt-4 mb-3">Non serve arrivare con tutto chiaro</h2>
                        <p>
                            Molte persone rimandano perché pensano di dover avere già le idee ordinate. In realtà non è così:
                            non devi avere già le parole giuste, né sapere già quale sia il problema preciso.
                        </p>
                        <p class="mb-0">Il primo colloquio serve proprio a costruire chiarezza, passo dopo passo, insieme.</p>

                        <h2 class="h4 mt-4 mb-3">Quanto dura il primo colloquio</h2>
                        <p class="mb-0">
                            Il primo colloquio dura circa <strong>50 minuti</strong>, in linea con la durata delle sedute successive.
                            Questo tempo permette di affrontare con calma ciò che per te è importante, senza fretta e senza pressione.
                        </p>

                        <h2 class="h4 mt-4 mb-3">Modalità: online o in presenza</h2>
                        <p>Puoi scegliere la modalità che senti più adatta:</p>
                        <ul>
                            <li><strong>online</strong>, se preferisci comodità, continuità o distanza;</li>
                            <li><strong>in presenza</strong>, presso le sedi di riferimento a Tivoli e zona.</li>
                        </ul>
                        <p class="mb-0">
                            La scelta della modalità può essere valutata insieme, in base al tuo momento e alle tue esigenze pratiche.
                        </p>

                        <h2 class="h4 mt-4 mb-3">Se senti paura, imbarazzo o incertezza</h2>
                        <p>
                            È assolutamente normale. Capita spesso di arrivare al primo incontro con emozioni contrastanti:
                            sollievo, timore, vergogna o confusione.
                        </p>
                        <p>
                            In colloquio trovi uno spazio professionale e accogliente in cui puoi parlare con il tuo ritmo,
                            anche iniziando da poche parole.
                        </p>
                        <p class="mb-0">
                            Chiedere un primo confronto non significa “stare male abbastanza”: significa darti la possibilità
                            di prenderti cura di te.
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
                                <li>Risposta: di norma entro 24 ore lavorative</li>
                            </ul>
                        </div>

                        <div class="card shadow-soft p-4">
                            <h2 class="h5 mb-2">Vuoi fare un primo passo?</h2>
                            <p class="small text-muted mb-3">
                                Se vuoi, puoi scrivermi per un primo colloquio: online o in presenza.
                                Ti rispondo personalmente e possiamo capire insieme da dove partire.
                            </p>
                            <div class="d-grid gap-2">
                                <a class="btn btn-brand" href="{{ route('contacts') }}#richiesta-colloquio">
                                    Richiedi il primo colloquio
                                </a>
                                <a class="btn btn-outline-secondario" target="_blank" rel="noopener noreferrer"
                                    href="{{ $seoContact['whatsapp_url'] }}">
                                    Scrivimi su WhatsApp
                                </a>
                            </div>
                        </div>
                    </aside>
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
