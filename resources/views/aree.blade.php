<x-layout>
    <section class="section p-3">
        <div class="page-head">
            <span class="badge badge-soft mb-3">Aree di intervento</span>
            <h1 class="page-title mb-2">Aree di intervento</h1>
            <p class="page-lead mb-4">
                Uno spazio di ascolto e supporto personalizzato, dedicato al benessere emotivo e relazionale.
            </p>
        </div>

        <div class="row g-4">
            @foreach ($areas as $area)
                <div class="col-md-6 col-xl-4">
                    <article class="card shadow-soft p-4 h-100 card-area-preview reveal">
                        <div class="d-flex flex-column h-100">
                            <h4 class="mb-3 area-card-title">{{ $area['title'] }}</h4>

                            <p class="mb-4 area-preview-text">
                                {{ $area['preview'] }}
                            </p>

                            <div class="mt-auto">
                                <a href="{{ route('areas.show', ['slug' => $area['slug']]) }}" class="btn btn-brand">
                                    scopri di più
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>

    </section>
</x-layout>
