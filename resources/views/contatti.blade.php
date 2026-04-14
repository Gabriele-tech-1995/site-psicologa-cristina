<x-layout :metaTitle="$metaTitle" :metaDescription="$metaDescription">
    @php
        $strategicFaqs = config('strategic_faqs', []);
        $faqSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => collect($strategicFaqs)->map(fn (array $item) => [
                '@type' => 'Question',
                'name' => $item['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $item['answer'],
                ],
            ])->all(),
        ];
    @endphp
    <section class="section contacts-page">
        <div class="container">
            <div class="page-head mb-4">
                <span class="badge badge-soft mb-3">Contatti</span>

                <h1 class="mb-2 page-title">Contatti</h1>

                <p class="page-lead mb-3 contact-lead-primary">
                    Sono la <strong>Dott.ssa Cristina Pacifici</strong>, <strong>psicologa a Tivoli</strong>; ricevo su
                    appuntamento <strong>online</strong> e <strong>in presenza</strong> presso
                    <strong>Centro Imago</strong>, <strong>Centro Empathia</strong> (Tivoli) e
                    <strong>Centro Liberamente</strong> (Villanova di Guidonia).
                    Per un primo contatto puoi usare il <strong>modulo</strong> qui sotto, l’<strong>email</strong> o
                    <strong>WhatsApp</strong> (stesso numero del telefono).
                    Di solito rispondo entro <strong>24 ore</strong> (lun–ven); nei periodi di maggiore richiesta i tempi possono allungarsi leggermente.
                </p>

                <div class="card shadow-soft border-0 contact-summary-highlight p-4 mb-4">
                    <p class="mb-0">
                        Puoi contattarmi tramite <strong>modulo</strong>,
                        <strong>email</strong> o <strong>WhatsApp</strong>.
                        Ricevi una risposta nel più breve tempo possibile: leggo io ogni messaggio e, di norma, rispondo entro <strong>24 ore</strong> (lun–ven).
                        È possibile svolgere il <strong>primo colloquio</strong> <strong>online</strong> oppure <strong>in presenza</strong>, in base a esigenze e preferenze.
                        Non serve una richiesta perfetta: basta un messaggio sincero; se vuoi, puoi aggiungere qualche riga su ciò che senti importante condividere.
                    </p>
                </div>

                <div class="row g-3 g-lg-4 mb-2 contact-at-a-glance">
                    <div class="col-md-4">
                        <div class="card shadow-soft h-100 border-0 p-3 contact-glance-card">
                            <h2 class="h6 mb-2 card-heading-oro">Chi è</h2>
                            <p class="small mb-0">
                                Psicologa, iscritta all’<strong>Albo degli Psicologi del Lazio</strong> (n. 32019), con
                                percorso di specializzanda in psicoterapia umanistico-esperienziale.
                                <a href="{{ route('about') }}">Approfondisci in Chi sono</a>.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-soft h-100 border-0 p-3 contact-glance-card">
                            <h2 class="h6 text-uppercase text-muted mb-2">Dove ricevo</h2>
                            <p class="small mb-0">
                                Sedute in presenza su appuntamento ai centri indicati; colloqui anche da remoto quando è la modalità più adatta.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-soft h-100 border-0 p-3 contact-glance-card">
                            <h2 class="h6 mb-2 card-heading-oro">Modalità</h2>
                            <p class="small mb-0">
                                È possibile svolgere il primo colloquio <strong>online</strong> oppure <strong>in presenza</strong>, in base a esigenze e preferenze;
                                la scelta si affronta con calma nel colloquio conoscitivo.
                                Durata seduta: circa <strong>50 minuti</strong>.
                            </p>
                        </div>
                    </div>
                </div>

                <p class="page-lead mb-0 small text-muted">
                    Se ti è utile farti un’idea prima sul tipo di percorsi che offro, puoi dare un’occhiata alle
                    <a href="{{ route('areas') }}">Aree di intervento</a>.
                </p>
            </div>

            <div class="card shadow-soft p-4 mb-4 contact-steps">
                <h2 class="h5 mb-3">Cosa succede dopo aver scritto</h2>
                <ol class="contact-steps-list mb-0 ps-3">
                    <li><strong>Ricevi una mia risposta</strong> — di solito entro <strong>24 ore</strong> (lun–ven).</li>
                    <li><strong>Insieme</strong> troviamo la modalità più adatta: <strong>online</strong>, <strong>in presenza</strong> o quale sede ti è più comoda.</li>
                    <li><strong>Primo colloquio</strong> (circa 50 minuti): ascolto della richiesta, informazioni utili e
                        spazio per le tue domande, senza pressioni sulla durata del percorso.</li>
                </ol>
            </div>

            <div class="card shadow-soft p-4 mb-4">
                <h2 class="h5 mb-2">Hai dubbi sul primo colloquio?</h2>
                <p class="small text-muted mb-3">
                    Se vuoi capire meglio come funziona il primo incontro (cosa succede, cosa puoi portare, durata e modalità),
                    trovi una guida semplice e rassicurante nella pagina dedicata.
                </p>
                <a class="btn btn-outline-secondario" href="{{ route('first-interview') }}">
                    Leggi la pagina sul primo colloquio
                </a>
            </div>

            <div class="contacts-layout mt-1">
                <div class="contacts-layout__sidebar">
                    <div class="contacts-left d-flex flex-column w-100">

                    <div class="card shadow-soft p-4 mb-4 card-info">
                        <h2 class="h5 mb-2">Contatto rapido</h2>
                        <p class="small text-muted mb-3">Per un contatto rapido: stesso numero su WhatsApp.</p>

                        <p class="mb-2">
                            <strong>Email:</strong>
                            <a href="{{ $seoContact['mailto'] }}">{{ $seoContact['email'] }}</a>
                        </p>

                        <p class="mb-3">
                            <strong>Telefono / WhatsApp:</strong>
                            <a target="_blank" rel="noopener noreferrer"
                                href="{{ $seoContact['whatsapp_url'] }}">{{ $seoContact['telephone_display'] }}</a>
                        </p>

                        <div class="d-flex gap-2 flex-wrap contact-actions">
                            <a class="btn btn-brand" target="_blank" rel="noopener noreferrer" data-track="click_whatsapp_contatti_box"
                                href="{{ $seoContact['whatsapp_url'] }}">
                                WhatsApp
                            </a>

                            <a class="btn btn-outline-secondario" href="{{ $seoContact['mailto'] }}">
                                Invia un’email
                            </a>
                        </div>

                        <hr class="my-4">

                        <p class="mb-0 small text-muted">
                            Sedute di circa 50 minuti. Per disdire o spostare: preavviso di 24 ore quando possibile.
                        </p>
                    </div>

                    <div class="card shadow-soft p-4 card-sedi">
                        <h2 class="h5 mb-3">Sedi in presenza</h2>

                        @forelse ($seoContact['locations'] as $loc)
                            <div @class(['mb-3' => ! $loop->last])>
                                <strong>{{ $loc['name'] ?? 'Sede' }}</strong>
                                <div class="small text-muted">
                                    {{ collect([$loc['street_address'] ?? null, $loc['address_locality'] ?? null])->filter()->implode(', ') }}@if (!empty($loc['address_region']))
                                        ({{ $loc['address_region'] }})
                                    @endif
                                </div>
                                @if (!empty($loc['maps_embed_src']))
                                    <div class="contact-map-embed mt-2">
                                        <iframe
                                            title="Mappa: {{ $loc['name'] ?? 'Sede' }}"
                                            src="{{ $loc['maps_embed_src'] }}"
                                            loading="lazy"
                                            referrerpolicy="no-referrer-when-downgrade"
                                            allowfullscreen
                                            credentialless></iframe>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p class="small text-muted mb-0">Sedi in aggiornamento: contattami per disponibilità in presenza.</p>
                        @endforelse
                    </div>

                    </div>
                </div>

                <div class="contacts-layout__form">
                    <div class="contact-form-sticky">
                        <div id="richiesta-colloquio" class="card shadow-soft p-4 card-form w-100">
                    <h2 class="h4 mb-2">Modulo per il primo colloquio</h2>

                    <p class="text-muted mb-0">
                        Se desideri un primo contatto o maggiori informazioni, puoi scrivermi tramite il modulo qui sotto:
                        anche poche righe vanno bene. Rispondo di persona per capire come posso esserti utile e, se vuoi,
                        proporre un colloquio conoscitivo.
                    </p>

                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <p class="mb-1 fw-semibold">Non è stato possibile inviare il modulo. Puoi controllare quanto segue:</p>
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contacts.submit') }}" data-track-submit="submit_form_contatti"
                        class="contact-form-layout">
                        @csrf
                        <input type="text" name="{{ config('antispam.contact.honeypot_field', 'contact_website') }}" value="" tabindex="-1" autocomplete="off"
                            class="contact-honeypot" aria-hidden="true">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="contact-name">Nome e cognome</label>
                                <input id="contact-name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" autocomplete="name">

                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="contact-phone">Telefono</label>
                                <input id="contact-phone" type="tel"
                                    class="form-control @error('phone') is-invalid @enderror" name="phone"
                                    value="{{ old('phone') }}" autocomplete="tel">

                                @error('phone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="contact-email">Email</label>
                                <input id="contact-email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" autocomplete="email">

                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="contact-message">Messaggio</label>
                                <textarea id="contact-message"
                                    class="form-control @error('message') is-invalid @enderror" name="message"
                                    rows="5" autocomplete="off">{{ old('message') }}</textarea>

                                @error('message')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input id="privacy" type="checkbox" name="privacy" value="1"
                                        class="form-check-input @error('privacy') is-invalid @enderror"
                                        @checked(old('privacy'))>

                                    <label class="form-check-label" for="privacy">
                                        Acconsento al trattamento dei dati personali secondo la normativa vigente.
                                        <a href="{{ route('privacy') }}" target="_blank" rel="noopener noreferrer">
                                            Leggi la Privacy Policy
                                        </a>.
                                    </label>
                                </div>

                                <div class="small text-muted mt-2">
                                    Nel primo messaggio, se puoi, evita dettagli clinici molto specifici: ne potremo parlare con più calma dal vivo o online.
                                </div>
                            </div>
                            @error('privacy')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror

                            <div class="col-12 contact-actions mt-3 d-grid gap-2 d-sm-flex align-items-center">
                                <button type="submit" class="btn btn-brand btn-lg">
                                    Invia il messaggio
                                </button>

                                <a class="btn btn-outline-secondario" target="_blank" rel="noopener noreferrer" data-track="click_whatsapp_contatti_form"
                                    href="{{ $seoContact['whatsapp_url'] }}">
                                    Scrivimi su WhatsApp
                                </a>
                            </div>
                        </div>
                    </form>
                        </div>
                    </div>
                </div>

                <div class="contacts-layout__faq mt-4" id="domande-frequenti-contatti">
                <div class="card shadow-soft p-4 contact-faq">
                    <h2 class="h4 mb-3 card-heading-oro">Domande frequenti</h2>
                    <div class="accordion accordion-flush contact-faq-accordion" id="contactFaq">
                        @foreach ($strategicFaqs as $index => $faq)
                            @php
                                $collapseId = 'contactStrategicFaq'.$index;
                            @endphp
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#{{ $collapseId }}" aria-expanded="false" aria-controls="{{ $collapseId }}">
                                        {{ $faq['question'] }}
                                    </button>
                                </h3>
                                <div id="{{ $collapseId }}" class="accordion-collapse collapse" data-bs-parent="#contactFaq">
                                    @include('partials.strategic-faq-answer', ['faq' => $faq])
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                </div>
            </div>
        </div>
    </section>

    <script type="application/ld+json"
        @isset($cspNonce) nonce="{{ $cspNonce }}" @endisset>
        {!! json_encode($faqSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>

    @if ($errors->any())
        <script @isset($cspNonce) nonce="{{ $cspNonce }}" @endisset>
            document.addEventListener('DOMContentLoaded', function () {
                var el = document.getElementById('richiesta-colloquio');
                if (el) {
                    el.scrollIntoView({ block: 'start', behavior: 'smooth' });
                }
            });
        </script>
    @endif

    @push('modals')
        @if (session('success') || session('warning'))
            @php
                $contactFeedbackIsWarning = session()->has('warning');
            @endphp
            <div class="modal contact-feedback-modal" id="contactFormFeedbackModal" tabindex="-1"
                aria-labelledby="contactFormFeedbackModalTitle" aria-describedby="contactFormFeedbackModalDesc"
                aria-modal="true" role="alertdialog" data-bs-backdrop="static" data-bs-keyboard="false"
                aria-hidden="true">
                <div class="modal-dialog contact-feedback-modal__dialog">
                    <div
                        class="modal-content contact-feedback-modal__panel {{ $contactFeedbackIsWarning ? 'contact-feedback-modal__panel--warning' : 'contact-feedback-modal__panel--success' }}">
                        <div class="modal-body contact-feedback-modal__alert-body">
                            <h2 class="contact-feedback-modal__heading" id="contactFormFeedbackModalTitle">
                                @if ($contactFeedbackIsWarning)
                                    Attenzione
                                @else
                                    Richiesta inviata
                                @endif
                            </h2>
                            <p class="contact-feedback-modal__text mb-0" id="contactFormFeedbackModalDesc">
                                @if ($contactFeedbackIsWarning)
                                    {{ session('warning') }}
                                @else
                                    {{ session('success') }}
                                @endif
                            </p>
                            <div class="contact-feedback-modal__actions">
                                <button type="button" class="btn contact-feedback-modal__ok-btn" data-bs-dismiss="modal">
                                    Chiudi e continua
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endpush
</x-layout>
