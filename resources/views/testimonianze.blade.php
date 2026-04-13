<x-layout :metaTitle="$metaTitle" :metaDescription="$metaDescription">
    <section class="section testimonials-page">
        <div class="container">
            <div class="page-head mb-4">
                <span class="badge badge-soft mb-3">Testimonianze</span>
                <h1 class="page-title mb-2">Esperienze e testimonianze</h1>
                <p class="page-lead">
                    Le parole di chi ha intrapreso un percorso possono aiutare altre persone a sentirsi
                    più serene nel chiedere supporto.
                </p>
                <div class="d-lg-none mt-2">
                    <a href="#form-testimonianza" class="area-link">Lasci una testimonianza</a>
                </div>
            </div>

            <div class="row g-4 mt-2 testimonials-layout">
                <div class="col-lg-7">

                    <div class="card shadow-soft p-4 mb-4 card-chi testimonials-intro-card">
                        <p class="mb-3">
                            In questa pagina vengono raccolte le <strong>testimonianze</strong> condivise da chi ha
                            scelto
                            di intraprendere un percorso di supporto psicologico.
                        </p>

                        <p class="mb-0">
                            Ogni esperienza è personale e unica. Le testimonianze pubblicate vengono condivise
                            nel rispetto della privacy e in forma non riconoscibile.
                        </p>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($testimonials->count())
                        <div class="row g-3 testimonials-list">
                            @foreach ($testimonials as $testimonial)
                                <div class="col-12">
                                    <article class="card shadow-soft p-4 card-chi testimonial-entry">
                                        <p class="mb-3 testimonial-quote">
                                            «{{ $testimonial->message }}»
                                        </p>

                                        <span class="text-muted small testimonial-author">
                                            {{ $testimonial->name_label }}
                                        </span>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="card shadow-soft p-4 card-chi testimonial-entry">
                            <p class="mb-0">
                                Al momento non sono ancora presenti testimonianze pubblicate.
                            </p>
                        </div>
                    @endif

                </div>

                <div class="col-lg-5">
                    <aside class="about-sidebar-sticky">

                        <div id="form-testimonianza" class="card shadow-soft p-4 card-chi testimonial-form-card">
                            <h2 class="h4 mb-3 section-subtitle">Invii una testimonianza</h2>

                            <p class="mb-3">
                                Se desidera condividere la sua esperienza, può inviare una testimonianza
                                che leggo con attenzione prima di una eventuale pubblicazione.
                            </p>

                            <form method="POST" action="{{ route('testimonials.store') }}">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label" for="testimonial-name-label">Firma</label>
                                    <input id="testimonial-name-label" type="text" name="name_label"
                                        class="form-control @error('name_label') is-invalid @enderror"
                                        value="{{ old('name_label') }}" placeholder="Es. Francesco M."
                                        autocomplete="name">
                                    <div class="small text-muted mt-1">Può firmare con nome e iniziale del cognome, punto finale incluso (es. Maria R.).</div>

                                    @error('name_label')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="testimonial-message">Testo della testimonianza</label>
                                    <textarea id="testimonial-message" name="message" rows="6"
                                        class="form-control @error('message') is-invalid @enderror"
                                        placeholder="Scriva qui la sua esperienza in modo spontaneo, nel rispetto della privacy.">{{ old('message') }}</textarea>

                                    @error('message')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-check mb-3">
                                    <input id="consent_publish" type="checkbox" name="consent_publish" value="1"
                                        class="form-check-input @error('consent_publish') is-invalid @enderror"
                                        @checked(old('consent_publish'))>

                                    <label class="form-check-label" for="consent_publish">
                                        Acconsento alla pubblicazione della testimonianza in forma anonima sul sito.
                                        <a href="{{ route('privacy') }}" target="_blank" rel="noopener noreferrer">
                                            Leggi la Privacy Policy
                                        </a>.
                                    </label>

                                    @error('consent_publish')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="small text-muted mb-3">
                                    Si invita a non inserire dati personali sensibili o informazioni cliniche troppo
                                    dettagliate.
                                </div>

                                <div class="d-flex gap-2 flex-wrap justify-content-center">
                                    <button type="submit" class="btn btn-brand">
                                        Invii la testimonianza
                                    </button>

                                    <a class="btn btn-outline-secondario" href="{{ route('contacts') }}">
                                        Contatti
                                    </a>
                                </div>
                            </form>
                        </div>

                    </aside>
                </div>
            </div>
        </div>
    </section>

    @if ($errors->any())
        <script @isset($cspNonce) nonce="{{ $cspNonce }}" @endisset>
            document.addEventListener('DOMContentLoaded', function () {
                var el = document.getElementById('form-testimonianza');
                if (el) {
                    el.scrollIntoView({ block: 'start', behavior: 'smooth' });
                }
            });
        </script>
    @endif

</x-layout>
