<x-layout :metaTitle="$metaTitle" :metaDescription="$metaDescription">
    <section class="section p-3">
        <div class="page-head">
            <span class="badge badge-soft mb-3">Testimonianze</span>
            <h1 class="page-title mb-2">Esperienze e testimonianze</h1>
            <p class="page-lead">
                Le parole di chi ha intrapreso un percorso possono aiutare altre persone a sentirsi
                più serene nel chiedere supporto.
            </p>
        </div>

        <div class="row g-4 mt-2">
            <div class="col-lg-7">

                <div class="card shadow-soft p-4 mb-4 card-chi">
                    <p class="mb-3">
                        In questa pagina vengono raccolte le <strong>testimonianze</strong> condivise da chi ha scelto
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
                    <div class="row g-4">
                        @foreach ($testimonials as $testimonial)
                            <div class="col-12">
                                <article class="card shadow-soft p-4 card-chi">
                                    <p class="mb-3">
                                        “{{ $testimonial->message }}”
                                    </p>

                                    <span class="text-muted small">
                                        {{ $testimonial->name_label }}
                                    </span>
                                </article>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="card shadow-soft p-4 card-chi">
                        <p class="mb-0">
                            Al momento non sono ancora presenti testimonianze pubblicate.
                        </p>
                    </div>
                @endif

            </div>

            <div class="col-lg-5">
                <aside class="about-sidebar-sticky">

                    <div class="card shadow-soft p-4 card-chi">
                        <h4 class="mb-3 section-subtitle">Invia la tua testimonianza</h4>

                        <p class="mb-3">
                            Se desideri condividere la tua esperienza, puoi inviare una testimonianza
                            che verrà valutata prima della pubblicazione.
                        </p>

                        <form method="POST" action="{{ route('testimonials.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Come vuoi firmarti</label>
                                <input type="text" name="name_label"
                                    class="form-control @error('name_label') is-invalid @enderror"
                                    value="{{ old('name_label') }}" placeholder="Es. Genitore, Adulta, Giovane adulto">

                                @error('name_label')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">La tua testimonianza</label>
                                <textarea name="message" rows="6" class="form-control @error('message') is-invalid @enderror"
                                    placeholder="Scrivi qui la tua esperienza in modo spontaneo e rispettoso della tua privacy.">{{ old('message') }}</textarea>

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
                                </label>

                                @error('consent_publish')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="small text-muted mb-3">
                                Ti invitiamo a non inserire dati personali sensibili o informazioni cliniche troppo
                                dettagliate.
                            </div>

                            <div class="d-flex gap-2 flex-wrap">
                                <button type="submit" class="btn btn-brand">
                                    Invia testimonianza
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
    </section>
</x-layout>
