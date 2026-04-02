<x-layout>
    <section class="section">
        <div class="page-head mb-4 area-show-head">
            <span class="badge badge-soft mb-3">Area di intervento</span>
            <h1 class="page-title mb-2">{{ $area['title'] }}</h1>
            <p class="page-lead mb-0">
                {{ $area['preview'] }}
            </p>
        </div>

        <div class="row g-4 align-items-stretch area-detail-layout">
            <div class="col-lg-7 d-flex">
                <div class="card shadow-soft p-4 card-area-detail w-100">
                    <div class="area-detail-block mb-4">
                        <h4 class="area-detail-title">Di cosa si tratta</h4>
                        <p class="mb-0">{{ $area['intro'] }}</p>
                    </div>

                    <div class="area-detail-block mb-4">
                        <h4 class="area-detail-title">Come può manifestarsi</h4>
                        <ul class="area-detail-list mb-0">
                            @foreach ($area['manifestazioni'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="area-detail-block mb-4">
                        <h4 class="area-detail-title">Quando può essere utile un supporto</h4>
                        <p class="mb-0">{{ $area['supporto'] }}</p>
                    </div>

                    <div class="area-detail-block mb-4">
                        <h4 class="area-detail-title">Come lavoro su quest’area</h4>
                        <p class="mb-0">{{ $area['come_lavoro'] }}</p>
                    </div>

                    <div class="area-detail-block area-detail-closing">
                        <p class="mb-0">{{ $area['chiusura'] }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="area-image-sticky">
                    <div class="card shadow-soft p-3 card-area-image-wrap">
                        <img src="{{ $area['image'] }}" alt="{{ $area['title'] }}"
                            class="img-fluid rounded area-detail-image">
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 d-flex gap-2 flex-wrap">
            <a href="{{ route('areas') }}" class="btn btn-outline-secondario">
                Torna alle aree
            </a>

            <a href="{{ route('contacts') }}" class="btn btn-brand">
                Richiedi un primo colloquio
            </a>
        </div>
    </section>
</x-layout>
