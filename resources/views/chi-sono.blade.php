<x-layout :metaTitle="$metaTitle" :metaDescription="$metaDescription">
    <section class="section about-section p-3">
        <div class="container about-shell">
            <div class="page-head about-head">
                <span class="badge badge-soft mb-3">Chi sono</span>
                <h1 class="page-title mb-2">Dott.ssa Cristina Pacifici</h1>
                <p class="page-lead about-lead">
                    Psicologa · Esperta in valutazione e trattamento dei Disturbi Specifici dell’Apprendimento ·
                    Specializzanda in psicoterapia umanistico-esperienziale @if ($seoContact['aspic_url'] !== '')
                        (<a href="{{ $seoContact['aspic_url'] }}" target="_blank" rel="noopener noreferrer">ASPIC</a>)
                    @endif
                </p>
            </div>

            <div class="row g-4 mt-2 about-layout">
                <div class="col-lg-8">
                    <div class="about-main-col">

                        <div class="card shadow-soft p-4 mb-4 card-chi">
                            <p class="mb-3">
                                Sono la <strong>Dott.ssa Cristina Pacifici</strong>,
                                <strong>psicologa a Tivoli</strong>
                                @if ($seoContact['albo_registration_url'] !== '')
                                    <a href="{{ $seoContact['albo_registration_url'] }}" target="_blank"
                                        rel="noopener noreferrer">iscritta all’Albo degli Psicologi del Lazio
                                        (<strong>n. 32019</strong>)</a>
                                @else
                                    iscritta all’Albo degli Psicologi del Lazio (<strong>n. 32019</strong>)
                                @endif
                                con <strong>Laurea magistrale in Psicologia conseguita con votazione <span aria-hidden="true">🎓</span> 110/110 e
                                    lode</strong>, e specializzanda in <strong>psicoterapia ad orientamento
                                    umanistico-esperienziale</strong>
                                @if ($seoContact['aspic_url'] !== '')
                                    (
                                    <a href="{{ $seoContact['aspic_url'] }}" target="_blank"
                                        rel="noopener noreferrer">ASPIC</a>)
                                @endif.
                                Ogni persona porta con sé una storia, delle fragilità e delle risorse che meritano uno
                                spazio di
                                ascolto autentico.
                            </p>

                            <p class="mb-3">
                                Nel mio lavoro metto al centro la <strong>relazione terapeutica</strong>, creando un
                                ambiente
                                accogliente e rispettoso in cui <strong>bambini, adolescenti, adulti e genitori</strong>
                                possano sentirsi compresi e sostenuti.
                                Offro <strong><a href="{{ route('areas') }}" title="Aree di intervento psicologico">sostegno psicologico</a></strong> nei momenti di difficoltà, disorientamento o
                                cambiamento, accompagnando la persona in un percorso di maggiore
                                <strong>consapevolezza emotiva</strong> e stabilità.
                            </p>

                            <p class="mb-3">
                                Mi occupo di <strong>valutazione e trattamento dei disturbi del neurosviluppo</strong>,
                                con particolare attenzione ai <strong><a href="{{ route('areas.show', ['slug' => 'disturbi-del-neurosviluppo']) }}"
                                        title="Supporto per disturbi del neurosviluppo e DSA">Disturbi Specifici dell’Apprendimento
                                        (DSA)</a></strong>.
                                Integro il lavoro sugli aspetti cognitivi con una costante attenzione alla dimensione
                                emotiva e
                                relazionale, promuovendo un approccio globale al benessere della persona.
                            </p>

                            <p class="mb-3">
                                Realizzo <strong><a href="{{ route('areas.show', ['slug' => 'valutazioni-psicodiagnostiche']) }}"
                                        title="Valutazioni psicodiagnostiche">valutazioni psicodiagnostiche</a></strong>, percorsi di
                                <strong>potenziamento degli apprendimenti</strong> e delle
                                <strong>funzioni esecutive</strong>, con l’obiettivo di comprendere in modo chiaro e
                                condiviso
                                il funzionamento della persona e individuare strategie efficaci e sostenibili nel tempo.
                            </p>

                            <p class="mb-3">
                                Affianco inoltre i genitori attraverso percorsi di
                                <strong><a href="{{ route('areas.show', ['slug' => 'genitorialita']) }}"
                                        title="Percorsi di sostegno alla genitorialità">sostegno alla genitorialità</a></strong>, offrendo uno spazio di confronto e
                                orientamento
                                nel delicato compito educativo e nella gestione delle difficoltà evolutive dei figli.
                            </p>

                            <p class="mb-0">
                                Attualmente mi sto specializzando in psicoterapia presso una scuola ad orientamento
                                <strong>umanistico-esperienziale</strong>, che considera la relazione terapeutica e
                                l’esperienza
                                emotiva elementi centrali del cambiamento.
                                <strong>Ogni percorso è costruito su misura</strong>, nel rispetto dei tempi e
                                dell’unicità di
                                chi ho di fronte.
                            </p>
                        </div>

                        <h2 class="mb-3 section-subtitle">Come lavoro</h2>

                        <div class="card shadow-soft p-4 mb-4 card-chi">
                            <p class="mb-3">
                                Il mio lavoro si basa su un approccio attento alla persona nella sua unicità, con
                                l’obiettivo di
                                offrire uno spazio sicuro in cui sentirsi accolti e compresi.
                                Ritengo che la relazione sia uno strumento centrale del percorso: è attraverso un clima
                                di
                                fiducia e collaborazione che diventa possibile esplorare le difficoltà e avviare un
                                cambiamento.
                            </p>

                            <p class="mb-3">
                                Gli interventi vengono costruiti in modo personalizzato, tenendo conto delle
                                caratteristiche,
                                delle difficoltà e delle risorse della persona.
                                Mi rivolgo a bambini, adolescenti, adulti e genitori che stanno attraversando momenti di
                                difficoltà o che desiderano comprendere meglio sé stessi e il proprio funzionamento.
                            </p>

                            <p class="mb-2">
                                Offro supporto in situazioni di:
                            </p>

                            <ul class="mb-0">
                                <li><a href="{{ route('areas.show', ['slug' => 'difficolta-relazionali']) }}"
                                        title="Supporto per difficoltà emotive e relazionali">difficoltà emotive e relazionali</a></li>
                                <li><a href="{{ route('areas.show', ['slug' => 'ansia-e-gestione-dello-stress']) }}"
                                        title="Supporto per ansia e gestione dello stress">ansia, stress e difficoltà nella gestione delle emozioni</a></li>
                                <li><a href="{{ route('areas.show', ['slug' => 'difficolta-scolastiche']) }}"
                                        title="Supporto per difficoltà scolastiche e apprendimento">difficoltà scolastiche e di apprendimento</a></li>
                                <li><a href="{{ route('areas.show', ['slug' => 'potenziamento-funzioni-esecutive']) }}"
                                        title="Potenziamento delle funzioni cognitive e apprendimenti">potenziamento delle funzioni cognitive e degli apprendimenti</a></li>
                                <li><a href="{{ route('areas.show', ['slug' => 'genitorialita']) }}"
                                        title="Sostegno alla genitorialità">sostegno alla genitorialità</a></li>
                            </ul>
                        </div>

                        <h2 class="mb-3 section-subtitle">Primo colloquio</h2>

                        <div class="card shadow-soft p-4 card-chi">
                            <p class="mb-0">
                                Il primo colloquio ha una durata di circa 50 minuti, in linea con le sedute successive,
                                ed è uno
                                spazio dedicato all’ascolto e alla comprensione della richiesta.
                                Durante l’incontro verrà data attenzione alla storia e alla situazione portata,
                                raccogliendo le
                                informazioni utili e iniziando a delineare insieme i possibili obiettivi del percorso.
                                In questa fase verranno inoltre fornite le principali informazioni relative al percorso,
                                compresi gli aspetti organizzativi e il consenso informato.
                                Al termine del colloquio sarà possibile valutare come proseguire, nel rispetto dei tempi
                                e delle
                                esigenze della persona.
                            </p>
                        </div>

                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="about-sidebar">
                        <aside class="about-sidebar-sticky">
                            <div class="card shadow-soft p-4 card-chi">
                                <h5 class="mb-3">Info utili</h5>

                                <ul class="list-unstyled mb-0 info-list">
                                    <li><strong>Albo:</strong>
                                        @if ($seoContact['albo_registration_url'] !== '')
                                            <a href="{{ $seoContact['albo_registration_url'] }}" target="_blank"
                                                rel="noopener noreferrer">Psicologi del Lazio n. 32019</a>
                                        @else
                                            Psicologi del Lazio n. 32019
                                        @endif
                                    </li>
                                    <li><strong>Riceve:</strong> online e in presenza a Tivoli</li>
                                    <li><strong>Disponibilità:</strong> lun–ven</li>
                                    <li><strong>Durata seduta:</strong> 50 minuti</li>
                                    <li><strong>Cancellazione:</strong> entro 24 ore</li>
                                </ul>
                            </div>

                            <div class="card shadow-soft p-4 mt-4 card-chi">
                                <h5 class="mb-3">Collaborazioni</h5>

                                <ul class="mb-0 collaborazione-list">
                                    <li>Centro Imago</li>
                                    <li>Centro Empathia</li>
                                    <li>Centro Liberamente</li>
                                </ul>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex container-btn flex-wrap about-actions">
                <a class="btn btn-brand" href="{{ route('contacts') }}">
                    Richiedi un primo colloquio
                </a>

                <a class="btn btn-outline-secondario" target="_blank" rel="noopener noreferrer"
                    href="{{ $seoContact['whatsapp_url'] }}">
                    Scrivimi su WhatsApp
                </a>
            </div>
        </div>
    </section>
</x-layout>
