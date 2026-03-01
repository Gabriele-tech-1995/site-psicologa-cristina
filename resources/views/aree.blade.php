<x-layout>
    <section class="section">
        <span class="badge badge-soft mb-3">Aree di intervento</span>
        <h1 class="mb-3">Aree di intervento</h1>
        <p class="text-muted mb-4">
            Uno spazio di ascolto e supporto personalizzato, dedicato al benessere emotivo e relazionale.
        </p>

        <div class="row g-4">
            @foreach ($areas as $area)
                <div class="col-md-6">
                    <div class="card shadow-soft p-4 h-100">
                        <h5>{{ $area['title'] }}</h5>
                        <p class="text-muted mb-0">{{ $area['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="card shadow-soft p-4 mt-4">
            <p class="mb-0">
                Se vuoi, possiamo capire insieme quale area descrive meglio il tuo momento e costruire un percorso
                su
                misura.
            </p>
        </div>
    </section>
</x-layout>
