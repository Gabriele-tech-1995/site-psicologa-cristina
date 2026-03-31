<x-layout>
    <section class="section">
        <div class="page-head">
            <span class="badge badge-soft mb-3">aree di intervento</span>
            <h1 class="page-title mb-2">aree di intervento</h1>
            <p class="page-lead text-muted mb-4">
                uno spazio di ascolto e supporto personalizzato, dedicato al benessere emotivo e relazionale.
            </p>
        </div>

        <div class="row g-4">
            @foreach ($areas as $area)
                <div class="col-md-6">
                    <div class="card card-note shadow-soft p-4 h-100 reveal">
                        <h5 class="mb-2">{{ $area['title'] }}</h5>
                        <p class="text-muted mb-0">{{ $area['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="card shadow-soft p-4 mt-4 card-note">
            <p class="mb-0">
                se vuoi, possiamo capire insieme quale area descrive meglio il tuo momento e costruire un percorso su
                misura.
            </p>
        </div>
    </section>
</x-layout>
