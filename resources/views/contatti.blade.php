<x-layout>
    <section class="section">
        <span class="badge badge-soft mb-3">Contatti</span>
        <h1 class="mb-3">Contatti</h1>
        <p class="text-muted">
            Ricevo online e in presenza a Tivoli, dal lunedì al venerdì.
        </p>

        <div class="row g-4 mt-1">
            <div class="col-lg-5">
                <div class="card shadow-soft p-4 mb-4">
                    <h5 class="mb-3">Contatti diretti</h5>
                    <p class="mb-2"><strong>Email:</strong> <a
                            href="mailto:cpacifici07@gmail.com">cpacifici07@gmail.com</a>
                    </p>
                    <p class="mb-3"><strong>Telefono / WhatsApp:</strong> <a target="_blank"
                            href="https://wa.me/3441122785">3441122785</a></p>

                    <div class="d-flex gap-2 flex-wrap">
                        <a class="btn btn-brand" target="_blank" href="https://wa.me/3441122785">WhatsApp</a>
                        <a class="btn btn-outline-secondary" href="mailto:cpacifici07@gmail.com">Email</a>
                    </div>

                    <hr class="my-4">

                    <p class="mb-0 small text-muted">
                        Cancellazione entro 24 ore. Durata seduta: 50 minuti.
                    </p>
                </div>

                <div class="card shadow-soft p-4">
                    <h5 class="mb-3">Sedi (Tivoli)</h5>

                    <div class="mb-3">
                        <strong>Centro Imago</strong>
                        <div class="small text-muted">Indirizzo da inserire</div>
                        <a class="btn btn-sm btn-outline-secondary mt-2" target="_blank"
                            href="https://maps.google.com/?q=Centro+Imago+Tivoli">
                            Apri su Google Maps
                        </a>
                    </div>

                    <div class="mb-3">
                        <strong>Centro Empatica</strong>
                        <div class="small text-muted">Indirizzo da inserire</div>
                        <a class="btn btn-sm btn-outline-secondary mt-2" target="_blank"
                            href="https://maps.google.com/?q=Centro+Empatica+Tivoli">
                            Apri su Google Maps
                        </a>
                    </div>

                    <div>
                        <strong>Centro Liberamente</strong>
                        <div class="small text-muted">Indirizzo da inserire</div>
                        <a class="btn btn-sm btn-outline-secondary mt-2" target="_blank"
                            href="https://maps.google.com/?q=Centro+Liberamente+Tivoli">
                            Apri su Google Maps
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card shadow-soft p-4">
                    <h4 class="mb-3">Richiedi un primo colloquio</h4>
                    <p class="text-muted">
                        Compila il modulo e verrai ricontattato/a il prima possibile.
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
                                <label class="form-label">Nome e Cognome</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}">

                                @error('name')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Telefono</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" value="{{ old('phone') }}">

                                @error('phone')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}">

                                @error('email')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Messaggio</label>
                                <textarea class="form-control @error('message') is-invalid @enderror" name="message" rows="5">{{ old('message') }}</textarea>

                                @error('message')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input type="checkbox" name="privacy" value="1"
                                        class="form-check-input @error('privacy') is-invalid @enderror"
                                        @checked(old('privacy'))>

                                    @error('privacy')
                                        <div class="text-danger small mt-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label class="form-check-label" for="privacy">
                                        Acconsento al trattamento dei dati personali secondo la normativa vigente.
                                    </label>
                                </div>
                                <div class="small text-muted mt-2">
                                    Si invita a non inserire nel primo messaggio informazioni cliniche dettagliate.
                                </div>
                            </div>

                            <div class="col-12 d-flex gap-2">
                                <button type="submit" class="btn btn-brand">Invia richiesta</button>
                                <a class="btn btn-outline-secondary" target="_blank" href="https://wa.me/3441122785">
                                    Scrivimi su WhatsApp
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-layout>
