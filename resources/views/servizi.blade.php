<x-layout>
    <section class="section">
        <div class="page-head">
            <span class="badge badge-soft mb-3">servizi</span>
            <h1 class="page-title mb-2">servizi</h1>
            <p class="page-lead">
                percorsi personalizzati online e in presenza a tivoli. durata seduta: 50 minuti.
            </p>
        </div>

        <div class="row g-4 mt-2">
            @foreach ($services as $service)
                <div class="col-md-6">
                    <div class="card shadow-soft p-4 h-100 reveal card-servizio">
                        <h5 class="mb-2">{{ $service['title'] }}</h5>
                        <p class="text-muted mb-0">{{ $service['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex gap-2 flex-wrap">
            <a class="btn btn-brand" href="{{ route('contacts') }}">richiedi un primo colloquio</a>
            <a class="btn btn-outline-secondario" target="_blank" href="https://wa.me/393441122785">
                scrivimi su whatsapp
            </a>
        </div>
    </section>
</x-layout>
