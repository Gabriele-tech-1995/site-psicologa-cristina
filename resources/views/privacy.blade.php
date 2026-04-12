@php
    $privacySeo = config('seo.pages.privacy', []);
@endphp

<x-layout :metaTitle="$privacySeo['title'] ?? 'Privacy Policy | Dott.ssa Cristina Pacifici'" :metaDescription="$privacySeo['description'] ?? 'Informativa privacy del sito della Dott.ssa Cristina Pacifici: finalità, base giuridica, tempi di conservazione e diritti dell\'interessato.'">
    <section class="section privacy-page p-3">
        <div class="container">
            <div class="card shadow-soft privacy-hero mb-4">
                <div class="page-head mb-0">
                    <span class="badge badge-soft mb-3">Privacy Policy</span>
                    <h1 class="page-title mb-2">Informativa sul trattamento dei dati personali</h1>
                    <p class="page-lead mb-0">
                        Ai sensi del Regolamento (UE) 2016/679 (GDPR), questa pagina descrive le modalità di
                        trattamento dei dati personali raccolti tramite il sito web.
                    </p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-4">
                    <aside class="card shadow-soft p-4 privacy-index">
                        <h2 class="h5 mb-3">Indice rapido</h2>
                        <nav aria-label="Indice privacy">
                            <a href="#titolare">1. Titolare del trattamento</a>
                            <a href="#dati">2. Dati trattati</a>
                            <a href="#finalita">3. Finalità e base giuridica</a>
                            <a href="#conservazione">4. Modalità e conservazione</a>
                            <a href="#comunicazione">5. Comunicazione e responsabili esterni</a>
                            <a href="#diritti">6. Diritti dell'interessato</a>
                            <a href="#aggiornamenti">7. Aggiornamenti</a>
                        </nav>
                    </aside>
                </div>

                <div class="col-lg-8">
                    <div class="card shadow-soft p-4 card-chi privacy-content">
                        <section id="titolare">
                            <h2 class="h4 mb-3">1. Titolare del trattamento</h2>
                            <p>
                                Il titolare del trattamento è la Dott.ssa Cristina Pacifici. Per richieste relative
                                alla privacy è possibile scrivere a:
                                <a href="{{ $seoContact['mailto'] }}">{{ $seoContact['email'] }}</a>.
                            </p>
                        </section>

                        <section id="dati">
                            <h2 class="h4 mb-3 mt-4">2. Dati trattati</h2>
                            <p>I dati che possono essere raccolti tramite questo sito sono:</p>
                            <ul>
                                <li>dati anagrafici e di contatto inseriti nei moduli (nome, email, telefono);</li>
                                <li>contenuti del messaggio inviato tramite form contatti o testimonianze;</li>
                                <li>dati tecnici di navigazione e cookie tecnici strettamente necessari al funzionamento del sito
                                    (es. sicurezza dei moduli e gestione della sessione);</li>
                                <li>eventuali log di sistema generati dai server (es. indirizzo IP, data e ora dell’accesso),
                                    nei limiti necessari alla sicurezza e alla manutenzione.</li>
                            </ul>
                        </section>

                        <section id="finalita">
                            <h2 class="h4 mb-3 mt-4">3. Finalità e base giuridica</h2>
                            <p>I dati sono trattati per:</p>
                            <ul>
                                <li>rispondere alle richieste inviate dall'utente;</li>
                                <li>gestire l'eventuale invio e pubblicazione di testimonianze anonime;</li>
                                <li>adempiere a obblighi di legge e tutela dei diritti del titolare.</li>
                            </ul>
                            <p>
                                La base giuridica è il consenso dell'interessato, l'esecuzione di misure precontrattuali
                                richieste dall'interessato e, ove necessario, l'adempimento di obblighi di legge.
                            </p>
                        </section>

                        <section id="conservazione">
                            <h2 class="h4 mb-3 mt-4">4. Modalità di trattamento e conservazione</h2>
                            <p>
                                Il trattamento avviene con strumenti elettronici e misure idonee a garantire riservatezza e
                                sicurezza. I dati sono conservati per il tempo strettamente necessario alle finalità indicate
                                e, comunque, non oltre i termini previsti dalla normativa applicabile.
                            </p>

                            <h3 class="h6 mt-4 mb-2">Tempi di conservazione (indicativi)</h3>
                            <ul>
                                <li>
                                    <strong>Richieste tramite modulo contatti:</strong> i dati sono conservati per il tempo
                                    necessario a gestire la richiesta, agli adempimenti connessi e alla tutela del titolare in
                                    caso di contestazioni; in linea generale, <strong>non oltre 24 mesi</strong> dalla
                                    ricezione, salvo obblighi di legge o esigenze probatorie che impongano tempi diversi.
                                </li>
                                <li>
                                    <strong>Testimonianze inviate dal modulo:</strong> conservate per il tempo necessario
                                    alla valutazione; se pubblicate, per la durata della pubblicazione sul sito. È possibile
                                    chiedere la revisione o la rimozione contattando il titolare agli indirizzi indicati.
                                </li>
                                <li>
                                    <strong>Log e dati tecnici di navigazione:</strong> conservati per periodi limitati in
                                    funzione della configurazione del sistema e delle esigenze di sicurezza (in genere da
                                    pochi giorni a pochi mesi), salvo proroghe motivate da obblighi di legge o accertamenti.
                                </li>
                            </ul>

                            <h3 class="h6 mt-4 mb-2">Cookie</h3>
                            <p class="mb-0">
                                Il sito utilizza <strong>cookie tecnici</strong> strettamente necessari al funzionamento
                                (ad esempio per la sicurezza dell’invio dei moduli e la gestione della sessione). In questa
                                configurazione <strong>non sono attivi strumenti di profilazione o remarketing</strong>
                                che richiedano un consenso preventivo aggiuntivo. In caso di introduzione di tali
                                strumenti, l’informativa sarà aggiornata e, ove previsto dalla legge, sarà richiesto il
                                consenso.
                            </p>
                        </section>

                        <section id="comunicazione">
                            <h2 class="h4 mb-3 mt-4">5. Comunicazione dei dati e responsabili esterni</h2>
                            <p>
                                I dati non sono diffusi. Possono essere trattati, per conto del titolare, da soggetti esterni
                                che forniscono servizi strumentali al sito e alla gestione delle richieste, <strong>nominati
                                    responsabili del trattamento</strong> o coinvolti secondo le modalità previste dal GDPR
                                e dal contratto applicabile. A titolo esemplificativo e non esaustivo:
                            </p>
                            <ul>
                                <li>
                                    <strong>Fornitore di hosting / infrastruttura</strong> (conservazione del sito, database,
                                    backup e sicurezza di rete), in base al contratto di servizio;
                                </li>
                                <li>
                                    <strong>Fornitore di servizi di posta elettronica o di invio messaggi</strong>, ove
                                    utilizzato per l’invio o la ricezione delle comunicazioni legate ai moduli del sito;
                                </li>
                                <li>
                                    <strong>Google Ireland Limited</strong> (o società del gruppo Google) in relazione
                                    all’eventuale <strong>mappa incorporata</strong> (Google Maps) nella pagina Contatti,
                                    secondo le informative e le impostazioni privacy del fornitore.
                                </li>
                            </ul>
                            <p>
                                Il titolare può fornire, su richiesta dell’interessato, <strong>l’elenco aggiornato dei
                                    responsabili del trattamento</strong> con i quali sono in essere specifiche
                                designazioni, ove applicabile.
                            </p>
                            <p class="mb-0">
                                I collegamenti a <strong>servizi di messaggistica esterni</strong> (ad es. WhatsApp)
                                presenti sul sito conducono a piattaforme gestite da terzi: l’eventuale invio di dati a tali
                                piattaforme avviene secondo le informative del rispettivo fornitore e fuori da questo sito,
                                salvo quanto necessario per aprire il collegamento.
                            </p>
                        </section>

                        <section id="diritti">
                            <h2 class="h4 mb-3 mt-4">6. Diritti dell'interessato</h2>
                            <p>
                                L'interessato può esercitare i diritti previsti dagli artt. 15-22 GDPR (accesso, rettifica,
                                cancellazione, limitazione, opposizione, portabilità), oltre al diritto di revocare il
                                consenso e proporre reclamo al
                                <a href="https://www.garanteprivacy.it" target="_blank" rel="noopener noreferrer">Garante per la protezione dei dati personali</a>.
                            </p>
                        </section>

                        <section id="aggiornamenti" class="privacy-update">
                            <h2 class="h4 mb-3 mt-4">7. Aggiornamenti</h2>
                            <p class="mb-0">
                                La presente informativa può essere aggiornata. Ultimo aggiornamento:
                                {{ now()->format('d/m/Y') }}.
                            </p>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
