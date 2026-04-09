<x-layout :metaTitle="$metaTitle" :metaDescription="$metaDescription">

    {{-- INTRO --}}
    <section class="intro-section">
        <div class="container">
            <div class="intro-wrapper">

                <div class="intro-photo">
                    <img src="{{ asset('img/cristina.jpeg') }}" alt="Dott.ssa Cristina Pacifici">
                </div>

                <div class="intro-text">
                    <blockquote class="intro-quote">
                        “Non contano i passi che fai, ma la direzione in cui stai andando.”
                    </blockquote>

                    <div class="intro-name">
                        Dott.ssa Cristina Pacifici
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- FORMAZIONE --}}
    <section class="section formazione-section">
        <div class="container">
            <div class="formazione-wrapper">

                <div class="formazione-box">
                    <h3 class="formazione-title">Formazione</h3>
                    <ul class="formazione-list">
                        <li>Laurea magistrale in Psicologia</li>
                        <li>Iscrizione Albo Psicologi del Lazio n. 32019</li>
                        <li>Specializzanda in psicoterapia umanistico-esperienziale - ASPIC</li>
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
                        Il percorso nasce dall’ascolto e dalla valorizzazione
                        delle risorse personali. Ogni intervento viene costruito
                        insieme, con obiettivi chiari e condivisi, attraverso un approccio
                        che considera la persona nella sua globalità, promuovendone
                        benessere e autonomia all’interno di <strong>uno spazio sicuro</strong>
                        in cui esplorare emozioni,
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

    {{-- HERO PRINCIPALE --}}
    <section class="hero">
        <div class="container">
            <div class="hero-box shadow-soft">
                <div class="row align-items-center g-4">
                    <div class="col-lg-7">
                        <span class="hero-kicker">Supporto psicologico • Tivoli e online</span>

                        <h1 class="hero-title mt-3 mb-3">
                            Psicologa a Tivoli per bambini, adolescenti e genitori
                        </h1>

                        <p class="hero-subtitle mb-0">
                            Sono la <strong>Dott.ssa Cristina Pacifici</strong>, psicologa e specializzanda in
                            psicoterapia a orientamento <strong>umanistico-esperienziale</strong>.
                            Lavoro con bambini, adolescenti e genitori, costruendo insieme un percorso cucito sui
                            bisogni della persona.
                        </p>

                        <div class="hero-points mt-3">
                            <div class="hero-point">
                                <span class="hero-dot"></span>
                                <span><strong>Ricevo</strong> online o in presenza • durata seduta: <strong>50
                                        minuti</strong></span>
                            </div>

                            <div class="hero-point">
                                <span class="hero-dot"></span>
                                <span>Disponibile dal <strong>lunedì al venerdì</strong> • cancellazione entro
                                    <strong>24 ore</strong></span>
                            </div>

                            <div class="hero-point">
                                <span class="hero-dot"></span>
                                <span>Collaboro con <strong>Centro Imago</strong>, <strong>Centro Empathia</strong>,
                                    <strong>Centro Liberamente</strong></span>
                            </div>
                        </div>

                        <div class="hero-actions mt-4 d-flex gap-2 flex-wrap justify-content-center">
                            <a class="btn btn-brand" href="{{ route('contacts') }}">
                                Richiedi un primo colloquio
                            </a>

                            <a class="btn btn-outline-secondario" target="_blank" rel="noopener noreferrer"
                                href="https://wa.me/3441122785">
                                Scrivimi su WhatsApp
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="card shadow-soft p-4 h-100 card-aree">
                            <span class="badge badge-soft mb-3">AREE PRINCIPALI</span>

                            <ul class="mb-0 lista-aree">
                                <li>
                                    <a href="{{ route('areas.show', ['slug' => 'ansia-e-gestione-dello-stress']) }}"
                                        title="Ansia e gestione dello stress">
                                        Ansia e gestione dello stress
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('areas.show', ['slug' => 'umore-basso']) }}" title="Umore basso">
                                        Umore basso
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('areas.show', ['slug' => 'difficolta-relazionali']) }}"
                                        title="Difficoltà relazionali">
                                        Difficoltà relazionali
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('areas.show', ['slug' => 'autostima']) }}" title="Autostima">
                                        Autostima
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('areas.show', ['slug' => 'difficolta-scolastiche']) }}"
                                        title="Difficoltà scolastiche">
                                        Difficoltà scolastiche
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('areas.show', ['slug' => 'disturbi-del-neurosviluppo']) }}"
                                        title="Disturbi del neurosviluppo">
                                        Disturbi del neurosviluppo
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('areas.show', ['slug' => 'genitorialita']) }}"
                                        title="Sostegno alla genitorialità">
                                        Sostegno alla genitorialità
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('areas.show', ['slug' => 'valutazioni-psicodiagnostiche']) }}"
                                        title="Valutazioni psicodiagnostiche">
                                        Valutazioni psicodiagnostiche
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('areas.show', ['slug' => 'intervento-di-gruppo-area-emotiva-relazionale']) }}"
                                        title="Intervento di gruppo – area emotiva e relazionale">
                                        Intervento di gruppo – area emotiva e relazionale
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('areas.show', ['slug' => 'potenziamento-abilita-scolastiche']) }}"
                                        title="Potenziamento delle abilità scolastiche">
                                        Potenziamento cognitivo e degli apprendimenti
                                    </a>
                                </li>
                            </ul>

                            <div class="d-flex justify-content-center mt-4">
                                <a class="btn btn-outline-secondario btn-sm" href="{{ route('areas') }}">
                                    Scopri tutte le aree
                                </a>
                            </div>
                        </div>
                    </div>
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
                <div class="col-md-4">
                    <div class="card shadow-soft p-4 h-100">
                        <h4>Bambini</h4>
                        <p class="mb-0">
                            Supporto nelle difficoltà emotive,
                            <a href="{{ route('areas.show', ['slug' => 'difficolta-scolastiche']) }}"
                                title="Difficoltà scolastiche">
                                scolastiche
                            </a>
                            e
                            <a href="{{ route('areas.show', ['slug' => 'difficolta-relazionali']) }}"
                                title="Difficoltà relazionali">
                                relazionali
                            </a>,
                            con interventi adeguati all’età e al contesto familiare.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-soft p-4 h-100">
                        <h4>Adolescenti</h4>
                        <p class="mb-0">
                            Spazio di ascolto e accompagnamento nei momenti di cambiamento,
                            crescita e costruzione dell’identità personale, anche in presenza di
                            <a href="{{ route('areas.show', ['slug' => 'autostima']) }}" title="Autostima">
                                difficoltà legate all’autostima
                            </a>
                            o all’
                            <a href="{{ route('areas.show', ['slug' => 'umore-basso']) }}" title="Umore basso">
                                umore basso
                            </a>.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-soft p-4 h-100">
                        <h4>Genitori</h4>
                        <p class="mb-0">
                            Percorsi di
                            <a href="{{ route('areas.show', ['slug' => 'genitorialita']) }}"
                                title="Sostegno alla genitorialità">
                                sostegno alla genitorialità
                            </a>
                            per affrontare difficoltà educative
                            e favorire un clima familiare più sereno.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- PRIMO COLLOQUIO --}}
    <section class="section">
        <div class="container">
            <div class="card shadow-soft p-4">
                <h3 class="mb-3">Come si svolge il primo colloquio</h3>

                <p class="mb-0">
                    Il primo colloquio ha una durata di circa <strong>50 minuti</strong> ed è uno spazio
                    dedicato all’ascolto e alla comprensione della richiesta.
                    Durante l’incontro verranno raccolte le informazioni utili e inizieremo a definire insieme
                    i possibili obiettivi del percorso. In base alla situazione, il percorso potrà orientarsi verso un
                    supporto mirato su aspetti come
                    <a href="{{ route('areas.show', ['slug' => 'ansia-e-gestione-dello-stress']) }}"
                        title="Ansia e gestione dello stress">
                        ansia e gestione dello stress
                    </a>,
                    <a href="{{ route('areas.show', ['slug' => 'difficolta-relazionali']) }}"
                        title="Difficoltà relazionali">
                        difficoltà relazionali
                    </a>,
                    <a href="{{ route('areas.show', ['slug' => 'difficolta-scolastiche']) }}"
                        title="Difficoltà scolastiche">
                        difficoltà scolastiche
                    </a>
                    o
                    <a href="{{ route('areas.show', ['slug' => 'valutazioni-psicodiagnostiche']) }}"
                        title="Valutazioni psicodiagnostiche">
                        valutazioni psicodiagnostiche
                    </a>.
                </p>
            </div>
        </div>
    </section>

    {{-- CTA FINALE --}}
    <section class="section text-center">
        <div class="container">
            <h3 class="mb-3">
                Se senti il bisogno di un supporto, puoi richiedere un primo colloquio
            </h3>

            <div class="d-flex justify-content-center gap-2 flex-wrap mt-3">
                <a class="btn btn-brand" href="{{ route('contacts') }}">
                    Richiedi un primo colloquio
                </a>

                <a class="btn btn-outline-secondario" target="_blank" rel="noopener noreferrer"
                    href="https://wa.me/3441122785">
                    Scrivimi su WhatsApp
                </a>
            </div>
        </div>
    </section>

</x-layout>
