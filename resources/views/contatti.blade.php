<x-layout>
    <section class="section page-head">
        <span class="badge badge-soft mb-3">contatti</span>
        <h1 class="mb-2 page-title">contatti</h1>
        <p class="page-lead">
            ricevo online e in presenza a tivoli, dal lunedì al venerdì.
        </p>

        <div class="row g-4 mt-1">
            <div class="col-lg-5">
                <div class="card shadow-soft p-4 mb-4 card-info">
                    <h5 class="mb-3">contatti diretti</h5>

                    <p class="mb-2">
                        <strong>email:</strong>
                        <a href="mailto:Dott.ssapacifici24@gmail.com">Dott.ssapacifici24@gmail.com</a>
                    </p>

                    <p class="mb-3">
                        <strong>telefono / whatsapp:</strong>
                        <a target="_blank" href="https://wa.me/3441122785">3441122785</a>
                    </p>

                    <div class="d-flex gap-2 flex-wrap">
                        <a class="btn btn-brand" target="_blank" href="https://wa.me/3441122785">whatsapp</a>
                        <a class="btn btn-outline-secondario" href="mailto:Dott.ssapacifici24@gmail.com">email</a>
                    </div>

                    <hr class="my-4">

                    <p class="mb-0 small text-muted">
                        cancellazione entro 24 ore. durata seduta: 50 minuti.
                    </p>
                </div>

                <div class="card shadow-soft p-4 card-sedi">
                    <h5 class="mb-3">sedi (tivoli)</h5>

                    <div class="mb-3">
                        <strong>centro imago</strong>
                        <div class="small text-muted">indirizzo da inserire</div>
                        <a class="btn btn-sm btn-outline-secondario mt-2" target="_blank"
                            href="https://maps.google.com/?q=Centro+Imago+Tivoli">
                            apri su google maps
                        </a>
                    </div>

                    <div class="mb-3">
                        <strong>centro empatica</strong>
                        <div class="small text-muted">indirizzo da inserire</div>
                        <a class="btn btn-sm btn-outline-secondario mt-2" target="_blank"
                            href="https://maps.google.com/?q=Centro+Empatica+Tivoli">
                            apri su google maps
                        </a>
                    </div>

                    <div>
                        <strong>centro liberamente</strong>
                        <div class="small text-muted">indirizzo da inserire</div>
                        <a class="btn btn-sm btn-outline-secondario mt-2" target="_blank"
                            href="https://maps.google.com/?q=Centro+Liberamente+Tivoli">
                            apri su google maps
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card shadow-soft p-4 card-form">
                    <h4 class="mb-3">richiedi un primo colloquio</h4>
                    <p class="text-muted">
                        compila il modulo e verrai ricontattato/a il prima possibile.
                    </p>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contacts.submit') }}">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">nome e cognome</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}">

                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">telefono</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" value="{{ old('phone') }}">

                                @error('phone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}">

                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">messaggio</label>
                                <textarea class="form-control @error('message') is-invalid @enderror" name="message" rows="5">{{ old('message') }}</textarea>

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
                                        acconsento al trattamento dei dati personali secondo la normativa vigente.
                                    </label>

                                    @error('privacy')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="small text-muted mt-2">
                                    si invita a non inserire nel primo messaggio informazioni cliniche dettagliate.
                                </div>
                            </div>

                            <div class="col-12 d-flex gap-2 flex-wrap">
                                <button type="submit" class="btn btn-brand">invia richiesta</button>

                                <a class="btn btn-outline-secondario" target="_blank" href="https://wa.me/3441122785">
                                    scrivimi su whatsapp
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-layout>
