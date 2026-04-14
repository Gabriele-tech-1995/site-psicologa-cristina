<x-layout :metaTitle="$metaTitle" :metaDescription="$metaDescription">
    @php
        $aree = [
            [
                'slug' => 'ansia-e-gestione-dello-stress',
                'title' => 'Ansia e gestione dello stress',
                'label' => 'Ansia e gestione dello stress',
            ],
            ['slug' => 'umore-basso', 'title' => 'Umore basso', 'label' => 'Umore basso'],
            [
                'slug' => 'difficolta-relazionali',
                'title' => 'Difficoltà relazionali',
                'label' => 'Difficoltà relazionali',
            ],
            ['slug' => 'autostima', 'title' => 'Autostima', 'label' => 'Autostima'],
            [
                'slug' => 'difficolta-scolastiche',
                'title' => 'Difficoltà scolastiche',
                'label' => 'Difficoltà scolastiche',
            ],
            [
                'slug' => 'disturbi-del-neurosviluppo',
                'title' => 'Disturbi del neurosviluppo',
                'label' => 'Disturbi del neurosviluppo',
            ],
            [
                'slug' => 'genitorialita',
                'title' => 'Sostegno alla genitorialità',
                'label' => 'Sostegno alla genitorialità',
            ],
            [
                'slug' => 'valutazioni-psicodiagnostiche',
                'title' => 'Valutazioni psicodiagnostiche',
                'label' => 'Valutazioni psicodiagnostiche',
            ],
            [
                'slug' => 'intervento-di-gruppo-area-emotiva-relazionale',
                'title' => 'Intervento di gruppo – area emotiva e relazionale',
                'label' => 'Intervento di gruppo – area emotiva e relazionale',
            ],
            [
                'slug' => 'potenziamento-abilita-scolastiche',
                'title' => 'Potenziamento delle abilità scolastiche',
                'label' => 'Potenziamento cognitivo e degli apprendimenti',
            ],
        ];

        $targetCards = [
            [
                'title' => 'Bambini',
                'html' =>
                    'Supporto nelle difficoltà emotive,
                    <a href="' .
                    route('areas.show', ['slug' => 'difficolta-scolastiche']) .
                    '" title="Difficoltà scolastiche">scolastiche</a>
                    e
                    <a href="' .
                    route('areas.show', ['slug' => 'difficolta-relazionali']) .
                    '" title="Difficoltà relazionali">relazionali</a>,
                    con interventi adeguati all’età e al contesto familiare.',
            ],
            [
                'title' => 'Adolescenti',
                'html' =>
                    'Spazio di ascolto e accompagnamento nei momenti di cambiamento, crescita e costruzione dell’identità personale, anche in presenza di
                    <a href="' .
                    route('areas.show', ['slug' => 'autostima']) .
                    '" title="Autostima">difficoltà legate all’autostima</a>
                    o all’
                    <a href="' .
                    route('areas.show', ['slug' => 'umore-basso']) .
                    '" title="Umore basso">umore basso</a>.',
            ],
            [
                'title' => 'Genitori',
                'html' =>
                    'Percorsi di
                    <a href="' .
                    route('areas.show', ['slug' => 'genitorialita']) .
                    '" title="Sostegno alla genitorialità">sostegno alla genitorialità</a>
                    per affrontare difficoltà educative e favorire un clima familiare più sereno.',
            ],
        ];

        $homeStrategicFaqs = config('strategic_faqs', []);
    @endphp

    {{-- INTRO --}}
    <section class="intro-section">
        <div class="container">
            <div class="intro-wrapper">
                <div class="intro-photo">
                    <img src="{{ asset('img/cristina-296.webp') }}" alt="Dott.ssa Cristina Pacifici" width="148"
                        height="148" loading="eager" decoding="async" fetchpriority="high">
                </div>
                <div class="intro-text">
                    <p class="intro-eyebrow">Chi sono · in sintesi</p>
                    <p class="intro-lead">La Dott.ssa Cristina Pacifici è psicologa a Tivoli e offre supporto
                        psicologico a bambini, adolescenti, adulti e genitori, in presenza e online.</p>
                    <blockquote class="intro-quote">«Non contano i passi che fai, ma la direzione in cui stai
                        andando.»</blockquote>
                    <div class="intro-name">Dott.ssa Cristina Pacifici – Psicologa</div>
                </div>
            </div>
        </div>
    </section>

    {{-- HERO PRINCIPALE --}}
    <section class="hero">
        <div class="container">
            <div class="hero-box hero-box-home shadow-soft">
                <div class="row align-items-center g-4 hero-home-row">
                    <div class="col-lg-7">
                        <span class="hero-kicker">Dott.ssa Cristina Pacifici · Psicologa · Tivoli, online e in
                            presenza</span>

                        <h1 class="hero-title mt-3 mb-3">Psicologa a Tivoli per bambini, adolescenti e genitori</h1>

                        <p class="hero-subtitle mb-2">
                            Sono la <strong>Dott.ssa Cristina Pacifici</strong>, psicologa e specializzanda in
                            psicoterapia <strong>umanistico-esperienziale</strong>.
                            Accompagno <strong>bambini, adolescenti, adulti e genitori</strong> con un ascolto attento e
                            percorsi costruiti insieme, senza fretta e nel rispetto dei tempi di ciascuno.
                        </p>
                        <p class="hero-micro mb-0">
                            <strong>Primo passo:</strong> un colloquio conoscitivo (circa 50 minuti): è possibile svolgerlo
                            <strong>online</strong> oppure <strong>in presenza</strong>, in base a ciò che le è più comodo,
                            per capire il bisogno e vedere se il percorso può esserle utile — in modo chiaro e senza impegno sulla durata.
                        </p>

                        <div class="hero-points mt-3">
                            <div class="hero-point"><span class="hero-dot"></span><span><strong>Primo colloquio</strong>
                                    online o in presenza • durata seduta: <strong>50 minuti</strong></span></div>
                            <div class="hero-point"><span class="hero-dot"></span><span><strong>Disponibilità</strong>
                                    lun–ven: di solito riscontro entro <strong>24 ore lavorative</strong></span></div>
                            <div class="hero-point"><span class="hero-dot"></span><span>In presenza riceve presso
                                    <strong>Centro Imago</strong>, <strong>Centro Empathia</strong> (Tivoli) e
                                    <strong>Centro Liberamente</strong> (Villanova di Guidonia), su appuntamento; anche
                                    <strong>online</strong></span></div>
                        </div>

                        <div class="hero-actions mt-4 hero-actions-stack">
                            <div class="d-flex flex-column align-items-stretch align-items-sm-center gap-2">
                                <a class="btn btn-brand btn-lg px-4" href="{{ route('contacts') }}#richiesta-colloquio"
                                    data-track="cta_hero_colloquio">Richieda il primo colloquio</a>
                                <span class="hero-cta-note text-center">Modulo sul sito · di solito riscontro entro
                                    <strong>24 ore lavorative</strong> (lun–ven)</span>
                            </div>
                            <p class="hero-cta-alt mb-0 text-center">
                                Preferisce scrivere prima su WhatsApp?
                                <a target="_blank" rel="noopener noreferrer" data-track="click_whatsapp_hero"
                                    href="{{ $seoContact['whatsapp_url'] }}">Apra la chat</a>
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="card shadow-soft p-4 h-100 card-aree">
                            <span class="badge badge-soft mb-3">Aree principali</span>

                            <ul class="mb-0 lista-aree">
                                @foreach ($aree as $area)
                                    <li>
                                        <a href="{{ route('areas.show', ['slug' => $area['slug']]) }}"
                                            title="{{ $area['title'] }}">
                                            {{ $area['label'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="d-flex justify-content-center mt-4">
                                <a class="btn btn-outline-secondario btn-sm" href="{{ route('areas') }}">Scopri tutte le
                                    aree</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- TRUST BAR --}}
    <section class="section pt-0">
        <div class="container">
            <div class="card p-3 p-md-4 trust-strip">
                <div class="row g-3 text-center">
                    <div class="col-md-4">
                        <div class="trust-item">
                            <strong>Iscritta all’Albo</strong>
                            <span>
                                @if ($seoContact['albo_registration_url'] !== '')
                                    <a href="{{ $seoContact['albo_registration_url'] }}" target="_blank" rel="noopener noreferrer">Psicologi del Lazio n. 32019</a>
                                @else
                                    Psicologi del Lazio n. 32019
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="trust-item">
                            <strong>Dove e come</strong>
                            <span>Online · In presenza a Tivoli (Centro Imago, Empathia) e a Villanova (Liberamente)</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="trust-item">
                            <strong>Sedute e tempi</strong>
                            <span>50 minuti · Cancellazione con 24 ore di preavviso</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FORMAZIONE (dopo hero: credenziali senza bloccare la CTA) --}}
    <section class="section formazione-section">
        <div class="container">
            <div class="formazione-wrapper">
                <div class="formazione-box">
                    <h3 class="formazione-title">Formazione</h3>
                    <ul class="formazione-list">
                        <li>Laurea magistrale in Psicologia <strong><span aria-hidden="true">🎓</span> (votazione 110/110 e lode)</strong></li>
                        <li>
                            @if ($seoContact['albo_registration_url'] !== '')
                                <a href="{{ $seoContact['albo_registration_url'] }}" target="_blank" rel="noopener noreferrer">Iscrizione Albo Psicologi del Lazio n. 32019</a>
                            @else
                                Iscrizione Albo Psicologi del Lazio n. 32019
                            @endif
                        </li>
                        <li>Specializzanda in psicoterapia umanistico-esperienziale @if ($seoContact['aspic_url'] !== '')
                                - <a href="{{ $seoContact['aspic_url'] }}" target="_blank" rel="noopener noreferrer">ASPIC</a>
                            @else
                                - ASPIC
                            @endif
                        </li>
                        <li>
                            Esperta nei
                            <a href="{{ route('areas.show', ['slug' => 'disturbi-del-neurosviluppo']) }}"
                                title="Disturbi del neurosviluppo">
                                disturbi del neurosviluppo
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="formazione-box">
                    <h3 class="formazione-title">Approccio</h3>
                    <p>
                        Il percorso nasce dall’ascolto e dalla valorizzazione delle risorse personali.
                        Ogni intervento viene costruito insieme, con obiettivi chiari e condivisi, attraverso un
                        approccio
                        che considera la persona nella sua globalità, promuovendone benessere e autonomia all’interno di
                        <strong>uno spazio sicuro</strong> in cui esplorare emozioni,
                        <a href="{{ route('areas.show', ['slug' => 'difficolta-relazionali']) }}"
                            title="Supporto per difficoltà relazionali">
                            difficoltà relazionali
                        </a>
                        e potenzialità.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- A CHI MI RIVOLGO --}}
    <section class="section">
        <div class="container">
            <div class="page-head text-center mb-4">
                <span class="badge badge-soft mb-3">A chi mi rivolgo</span>
                <h2 class="page-title">Percorsi pensati per diverse fasi della vita</h2>
            </div>

            <div class="row g-4">
                @foreach ($targetCards as $card)
                    <div class="col-md-4">
                        <div class="card shadow-soft p-4 h-100">
                            <h3 class="h4">{{ $card['title'] }}</h3>
                            <p class="mb-0">{!! $card['html'] !!}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- PRIMO COLLOQUIO --}}
    <section class="section">
        <div class="container">
            <div class="card shadow-soft p-4">
                <h3 class="mb-3">Come si svolge il primo colloquio</h3>
                <p class="mb-0">
                    Il primo colloquio ha una durata di circa <strong>50 minuti</strong> ed è uno spazio dedicato
                    all’ascolto e alla comprensione della richiesta.
                    Durante l’incontro sarà possibile chiarire insieme esigenze, obiettivi e modalità del percorso,
                    con il tempo per le informazioni utili e per le sue domande.
                    In base alla situazione, il percorso potrà orientarsi verso un supporto mirato su aspetti come
                    <a href="{{ route('areas.show', ['slug' => 'ansia-e-gestione-dello-stress']) }}"
                        title="Ansia e gestione dello stress">ansia e gestione dello stress</a>,
                    <a href="{{ route('areas.show', ['slug' => 'difficolta-relazionali']) }}"
                        title="Difficoltà relazionali">difficoltà relazionali</a>,
                    <a href="{{ route('areas.show', ['slug' => 'difficolta-scolastiche']) }}"
                        title="Difficoltà scolastiche">difficoltà scolastiche</a>
                    o
                    <a href="{{ route('areas.show', ['slug' => 'valutazioni-psicodiagnostiche']) }}"
                        title="Valutazioni psicodiagnostiche">valutazioni psicodiagnostiche</a>.
                </p>
            </div>
        </div>
    </section>

    {{-- FAQ STRATEGICHE (stesso contenuto della pagina Contatti; schema FAQPage solo su Contatti) --}}
    <section class="section pt-0" id="domande-frequenti-home" aria-labelledby="home-faq-heading">
        <div class="container">
            <div class="card shadow-soft p-4 contact-faq">
                <h2 class="h4 mb-2 card-heading-oro" id="home-faq-heading">Domande frequenti</h2>
                <p class="text-muted small mb-3">
                    Qui ho raccolto alcune risposte alle domande che mi vengono rivolte più spesso.
                    Se desidera scrivermi o concordare un colloquio, può visitare la pagina
                    <a href="{{ route('contacts') }}">Contatti</a>: lì trova il modulo, l’email e il numero anche su WhatsApp.
                </p>
                <div class="accordion accordion-flush contact-faq-accordion" id="homeStrategicFaq">
                    @foreach ($homeStrategicFaqs as $index => $faq)
                        @php
                            $homeFaqCollapseId = 'homeStrategicFaq'.$index;
                        @endphp
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#{{ $homeFaqCollapseId }}" aria-expanded="false" aria-controls="{{ $homeFaqCollapseId }}">
                                    {{ $faq['question'] }}
                                </button>
                            </h3>
                            <div id="{{ $homeFaqCollapseId }}" class="accordion-collapse collapse" data-bs-parent="#homeStrategicFaq">
                                @include('partials.strategic-faq-answer', ['faq' => $faq])
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- CTA FINALE --}}
    <section class="section text-center">
        <div class="container">
            <h3 class="mb-2">Desidera fare un primo passo?</h3>
            <p class="text-muted mb-4 mx-auto cta-final-lead">
                Bastano un messaggio o il modulo: rispondo personalmente e, se lo desidera, si può fissare insieme un
                colloquio conoscitivo.
            </p>
            <div class="d-flex justify-content-center gap-2 flex-wrap mt-2">
                <a class="btn btn-brand btn-lg px-4" href="{{ route('contacts') }}#richiesta-colloquio"
                    data-track="cta_bottom_colloquio">Richieda il primo colloquio</a>
                <a class="btn btn-outline-secondario" target="_blank" rel="noopener noreferrer"
                    data-track="click_whatsapp_bottom" href="{{ $seoContact['whatsapp_url'] }}">Mi scriva su WhatsApp</a>
            </div>
        </div>
    </section>
</x-layout>
