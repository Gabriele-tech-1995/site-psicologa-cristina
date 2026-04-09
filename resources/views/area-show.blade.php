<x-layout :metaTitle="$metaTitle" :metaDescription="$metaDescription">
    <section class="section area-hero-illustrata" style="background-image: url('{{ $area['image'] }}');">
        <div class="area-hero-gradient"></div>

        <div class="container-fluid px-lg-5 area-hero-wrapper">
            <div class="area-hero-text">

                <nav class="area-breadcrumb mb-3" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}">Home</a>
                    <span>/</span>
                    <a href="{{ route('areas') }}">Aree di intervento</a>
                    <span>/</span>
                    <span aria-current="page">{{ $area['title'] }}</span>
                </nav>

                <span class="badge badge-soft area-badge">Area di intervento</span>

                <h1 class="page-title area-page-title">{{ $area['title'] }}</h1>

                <div class="area-hero-image-mobile-wrap">
                    <img src="{{ $area['image'] }}" alt="{{ $area['title'] }}" class="area-hero-image-mobile">
                </div>

                <p class="page-lead area-page-lead">{{ $area['preview'] }}</p>

                @if (!empty($area['intro']))
                    <p class="area-intro">{{ $area['intro'] }}</p>
                @endif

                <div class="area-detail-content">
                    {!! $area['body'] !!}
                </div>

                <div class="area-closing-text">
                    <p>
                        Se senti che questa area riguarda il momento che stai vivendo, puoi richiedere un primo
                        colloquio per valutare insieme il percorso più adatto.
                    </p>
                </div>

                <div class="area-detail-actions">
                    <a href="{{ route('areas') }}" class="btn-area-secondary">← Tutte le aree</a>
                    <a href="{{ route('contacts') }}" class="btn-area-primary">Richiedi un colloquio</a>
                </div>

            </div>
        </div>
    </section>
</x-layout>
