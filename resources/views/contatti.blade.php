<x-layout>
    <section class="section page-head">
        <span class="badge badge-soft mb-3">Contatti</span>
        <h1 class="mb-2 page-title">Contatti</h1>
        <p class="page-lead">
            Ricevo online e in presenza a tivoli, dal lunedì al venerdì.
        </p>

        <div class="row g-4 mt-1 align-items-stretch contacts-row">
            <div class="col-lg-5 d-flex">
                <div class="contacts-left d-flex flex-column w-100 h-100">
                    <div class="card shadow-soft p-4 mb-4 card-info">
                        <h5 class="mb-3">Contatti diretti</h5>

                        <p class="mb-2">
                            <strong>Email:</strong>
                            <a href="mailto:Dott.ssapacifici24@gmail.com">Dott.ssapacifici24@gmail.com</a>
                        </p>

                        <p class="mb-3">
                            <strong>Telefono / Whatsapp:</strong>
                            <a target="_blank" href="https://wa.me/3441122785">3441122785</a>
                        </p>

                        <div class="d-flex gap-2 flex-wrap">
                            <a class="btn btn-brand" target="_blank" href="https://wa.me/3441122785">Whatsapp</a>
                            <a class="btn btn-outline-secondario" href="mailto:Dott.ssapacifici24@gmail.com">Email</a>
                        </div>

                        <hr class="my-4">

                        <p class="mb-0 small text-muted">
                            Cancellazione entro 24 ore. durata seduta: 50 minuti.
                        </p>
                    </div>

                    <div class="card shadow-soft p-4 card-sedi flex-grow-1">
                        <h5 class="mb-3">Sedi (Tivoli)</h5>

                        <div class="mb-3">
                            <strong>Centro Imago</strong>
                            <div class="small text-muted">Piazza Santa Croce 12,Tivoli (RM)</div>
                            <a class="btn btn-sm btn-outline-secondario mt-2" target="_blank"
                                href="https://maps.google.com/?q=Centro+Imago+Tivoli">
                                Apri su google maps
                            </a>
                        </div>

                        <div class="mb-3">
                            <strong>Centro Empathia</strong>
                            <div class="small text-muted">Piazzale delle Nazioni Unite 16, Tivoli (RM)</div>
                            <a class="btn btn-sm btn-outline-secondario mt-2" target="_blank"
                                href="https://maps.google.com/?q=Centro+Empatica+Tivoli">
                                Apri su google maps
                            </a>
                        </div>

                        <div>
                            <strong>Centro Liberamente</strong>
                            <div class="small text-muted">Via Tito Bernardini 13, Villanova (RM)</div>
                            <a class="btn btn-sm btn-outline-secondario mt-2" target="_blank"
                                href="https://maps.google.com/?q=Centro+Liberamente+Tivoli">
                                Apri su google maps
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 d-flex">
                <div class="card shadow-soft p-4 card-form w-100 h-100">
                    <h4 class="mb-3">Richiedi un primo colloquio</h4>
                    <p class="text-muted">
                        Compila il modulo e verrai ricontattato/a il prima possibile.
                    </p>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div id="toast" class="custom-toast">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contacts.submit') }}"
                        class="contact-form-layout h-100 d-flex flex-column">
                        @csrf

                        <div class="row g-3 flex-grow-1">
                            <div class="col-md-6">
                                <label class="form-label">Nome e Cognome</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}">

                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Telefono</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" value="{{ old('phone') }}">

                                @error('phone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}">

                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label">Messaggio</label>
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
                                        Acconsento al trattamento dei dati personali secondo la normativa vigente.
                                    </label>

                                    @error('privacy')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="small text-muted mt-2">
                                    Si invita a non inserire nel primo messaggio informazioni cliniche dettagliate.
                                </div>
                            </div>

                            <div class="col-12 d-flex gap-2 flex-wrap contact-actions align-items-center">
                                <button type="submit" class="btn btn-brand">Invia richiesta</button>

                                <a class="btn btn-outline-secondario" target="_blank" href="https://wa.me/3441122785">
                                    Scrivimi su whatsapp
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-layout>
