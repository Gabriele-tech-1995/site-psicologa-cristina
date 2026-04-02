<x-layout>
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
    <section class="section formazione-section">
        <div class="container">
            <div class="formazione-wrapper">

                <div class="formazione-box">
                    <h3 class="formazione-title">Formazione</h3>
                    <ul class="formazione-list">
                        <li>Laurea magistrale in Psicologia</li>
                        <li>Iscrizione Albo Psicologi del Lazio n. 32019</li>
                        <li>Specializzanda in psicoterapia umanistico-esperienziale - ASPIC</li>
                        <li>Esperta nei disturbi del neurosviluppo</li>
                    </ul>
                </div>

                <div class="formazione-box">
                    <h3 class="formazione-title">Approccio</h3>
                    <p>
                        Il percorso nasce dall’ascolto e dalla valorizzazione
                        delle risorse personali. Ogni intervento viene costruito
                        insieme, con obiettivi chiari e condivisi, attraverso un approccio
                        integrato che volge il suo sguardo alla persona nella sua
                        globalità, promuovendone benessere e autonomia
                        all'interno di un spazio sicuro in cui esplorare emozioni,
                        difficoltà e potenzialità.
                    </p>
                </div>

            </div>
        </div>
    </section>
    <section class="hero">
        <div class="container">
            <div class="hero-box shadow-soft">
                <div class="row align-items-center g-4">
                    <div class="col-lg-7">
                        <span class="hero-kicker">Spazio di ascolto • Tivoli e online</span>

                        <h1 class="hero-title mt-3 mb-3">
                            Un percorso su misura per ritrovare equilibrio e benessere
                        </h1>

                        <p class="hero-subtitle mb-0">
                            Sono la <strong>Dott.ssa Cristina Pacifici</strong>, psicologa e specializzanda in
                            psicoterapia
                            a orientamento <strong>umanistico-esperienziale</strong>.
                            Lavoro con bambini, adolescenti e genitori, costruendo insieme un percorso cucito sui
                            bisogni della persona.
                        </p>

                        <div class="hero-points">
                            <div class="hero-point">
                                <span class="hero-dot"></span>
                                <hr>
                                <span><strong>Ricevo</strong> online o in presenza • durata seduta: <strong>50
                                        minuti</strong></span>
                            </div>
                            <div class="hero-point">
                                <span class="hero-dot"></span>
                                <span>Disponibile dal <strong>lunedì al venerdì</strong> • cancellazione entro
                                    <strong>24
                                        ore</strong></span>
                            </div>
                            <div class="hero-point">
                                <span class="hero-dot"></span>
                                <span>Collaboro con <strong>Centro Imago</strong>, <strong>Centro Empathia</strong>,
                                    <strong>Centro Liberamente</strong></span>
                            </div>
                        </div>

                        <div class="hero-actions mt-4 d-flex gap-2 flex-wrap justify-content-center">
                            <a class="btn btn-brand" href="{{ route('contacts') }}">Richiedi un primo colloquio</a>
                            <a class="btn btn-outline-secondario" target="_blank" href="https://wa.me/3441122785">
                                Scrivimi su whatsapp
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="card shadow-soft p-4 h-100 card-aree">
                            <span class="badge badge-soft mb-3">AREE PRINCIPALI</span>

                            <ul class="mb-0  lista-aree">
                                <li>Ansia e gestione dello stress</li>
                                <li>Umore basso</li>
                                <li>Difficoltà relazionali</li>
                                <li>Autostima</li>
                                <li>Difficoltà scolastiche</li>
                                <li>Disturbi del neurosviluppo</li>
                                <li>Sostegno alla Genitorialità</li>
                                <li>Valutazioni psicodiagnostiche</li>
                                <li>Sostegno individuale</li>
                                <li>Potenziamento cognitivo e degli apprendimenti</li>
                            </ul>

                            <a class="btn btn-outline-secondario btn-sm mt-4 align-self-start btn-aree"
                                href="{{ route('areas') }}">
                                Scopri tutte le aree
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
