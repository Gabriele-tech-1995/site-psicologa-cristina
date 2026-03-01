<x-layout>
    <section class="section">
        <span class="badge badge-soft mb-3">Servizi</span>
        <h1 class="mb-3">Servizi</h1>
        <p class="text-muted mb-4">
            Percorsi personalizzati online e in presenza a Tivoli. Durata seduta: 50 minuti.
        </p>

        <div class="row g-4">
            @foreach ($services as $service)
                <div class="col-md-6">
                    <div class="card shadow-soft p-4 h-100">
                        <h5>{{ $service['title'] }}</h5>
                        <p class="text-muted mb-0">{{ $service['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex gap-2 flex-wrap">
            <a class="btn btn-brand" href="{{ route('contacts') }}">Richiedi un primo colloquio</a>
            <a class="btn btn-outline-secondary" target="_blank" href="https://wa.me/393441122785">Scrivimi su
                WhatsApp</a>
        </div>
    </section>
</x-layout>
