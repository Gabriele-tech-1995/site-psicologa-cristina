<x-layout :metaTitle="$metaTitle" :metaDescription="$metaDescription">
    @php
        $faqSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => [
                [
                    '@type' => 'Question',
                    'name' => 'In quanto tempo ricevo risposta?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Solitamente rispondo entro 24 ore lavorative. Nei periodi di maggiore richiesta i tempi possono estendersi leggermente.',
                    ],
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Il primo colloquio è online o in presenza?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'Entrambe le modalità sono disponibili: insieme valutiamo quella più adatta in base alle esigenze.',
                    ],
                ],
                [
                    '@type' => 'Question',
                    'name' => 'Quanto dura una seduta?',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'La durata standard è di circa 50 minuti.',
                    ],
                ],
            ],
        ];
    @endphp
    <section class="section contacts-page">
        <div class="container">
            <div class="page-head mb-4">
                <span class="badge badge-soft mb-3">Contatti</span>

                <h1 class="mb-2 page-title">Contatti</h1>

                <p class="page-lead">
                    Puoi richiedere un primo colloquio <strong>online</strong> o <strong>in presenza a Tivoli</strong>
                    compilando il modulo qui sotto: rispondo in tempi brevi e concordiamo insieme la modalità più adatta.
                    Se prima vuoi orientarti meglio, puoi consultare le
                    <a href="{{ route('areas') }}" title="Aree di intervento della psicologa a Tivoli">aree di intervento</a>
                    o approfondire il mio
                    <a href="{{ route('about') }}" title="Chi sono e come lavoro">approccio professionale</a>.
                </p>
            </div>

            <div class="contacts-layout mt-1">
                <div class="contacts-layout__sidebar">
                    <div class="contacts-left d-flex flex-column w-100">

                    <div class="card shadow-soft p-4 mb-4 card-info">
                        <h2 class="h5 mb-3">Contatti diretti</h2>

                        <p class="mb-2">
                            <strong>Email:</strong>
                            <a href="{{ $seoContact['mailto'] }}">{{ $seoContact['email'] }}</a>
                        </p>

                        <p class="mb-3">
                            <strong>Telefono / WhatsApp:</strong>
                            <a target="_blank" rel="noopener noreferrer"
                                href="{{ $seoContact['whatsapp_url'] }}">{{ $seoContact['telephone_display'] }}</a>
                        </p>

                        <div class="d-flex gap-2 flex-wrap justify-content-center">
                            <a class="btn btn-brand" target="_blank" rel="noopener noreferrer" data-track="click_whatsapp_contatti_box"
                                href="{{ $seoContact['whatsapp_url'] }}">
                                WhatsApp
                            </a>

                            <a class="btn btn-outline-secondario" href="{{ $seoContact['mailto'] }}">
                                Email
                            </a>
                        </div>

                        <hr class="my-4">

                        <p class="mb-0 small text-muted">
                            Cancellazione entro 24 ore. Durata della seduta: 50 minuti.
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
                                @if (!empty($loc['maps_open_url']))
                                    <div class="contact-map-teaser mt-2">
                                        <a class="btn btn-outline-secondario btn-sm contact-map-teaser__btn"
                                            href="{{ $loc['maps_open_url'] }}" target="_blank" rel="noopener noreferrer"
                                            title="Apri {{ $loc['name'] ?? 'la sede' }} su Google Maps (si apre in una nuova scheda)">
                                            Apri in Google Maps
                                        </a>
                                        <span class="contact-map-teaser__hint small text-muted">Si apre fuori dal sito,
                                            senza cookie di Google su questa pagina.</span>
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
                    <h2 class="h4 mb-3">Richiedi un primo colloquio</h2>

                    <p class="text-muted">
                        Inserisci i tuoi recapiti e una breve descrizione della richiesta.
                        Ti ricontatterò il prima possibile per definire insieme il primo colloquio.
                    </p>

                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <p class="mb-1 fw-semibold">Non è stato possibile inviare il modulo. Controlla:</p>
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
                                    Si invita a non inserire nel primo messaggio informazioni cliniche dettagliate.
                                </div>
                            </div>
                            @error('privacy')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror

                            <div class="col-12 contact-actions mt-3 d-grid gap-2 d-sm-flex align-items-center">
                                <button type="submit" class="btn btn-brand">
                                    Invia richiesta
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
                    <h2 class="h4 mb-3">Domande frequenti</h2>
                    <div class="accordion accordion-flush contact-faq-accordion" id="contactFaq">
                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faqOne" aria-expanded="false" aria-controls="faqOne">
                                    In quanto tempo ricevo risposta?
                                </button>
                            </h3>
                            <div id="faqOne" class="accordion-collapse collapse" data-bs-parent="#contactFaq">
                                <div class="accordion-body">
                                    Solitamente rispondo entro 24 ore lavorative. Nei periodi di maggiore richiesta i
                                    tempi possono estendersi leggermente.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faqTwo" aria-expanded="false" aria-controls="faqTwo">
                                    Il primo colloquio è online o in presenza?
                                </button>
                            </h3>
                            <div id="faqTwo" class="accordion-collapse collapse" data-bs-parent="#contactFaq">
                                <div class="accordion-body">
                                    Entrambe le modalità sono disponibili: insieme valutiamo quella più adatta in base
                                    alle esigenze.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#faqThree" aria-expanded="false" aria-controls="faqThree">
                                    Quanto dura una seduta?
                                </button>
                            </h3>
                            <div id="faqThree" class="accordion-collapse collapse" data-bs-parent="#contactFaq">
                                <div class="accordion-body">
                                    La durata standard è di circa 50 minuti.
                                </div>
                            </div>
                        </div>
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
