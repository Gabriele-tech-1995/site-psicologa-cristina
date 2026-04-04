<x-layout :metaTitle="$metaTitle" :metaDescription="$metaDescription">
    <section class="section area-hero-illustrata" style="background-image: url('{{ $area['image'] }}');">
        <div class="area-hero-gradient"></div>

        <div class="container-fluid px-lg-5 area-hero-wrapper">
            <div class="area-hero-text">
                <span class="badge badge-soft area-badge">Area di intervento</span>

                <h1 class="page-title area-page-title">
                    {{ $area['title'] }}
                </h1>

                <div class="area-hero-image-mobile-wrap d-block d-lg-none">
                    <img src="{{ $area['image'] }}" alt="{{ $area['title'] }}" class="area-hero-image-mobile">
                </div>

                <p class="page-lead area-page-lead">
                    {{ $area['preview'] }}
                </p>

                <div class="area-detail-content">
                    {!! $area['body'] !!}
                </div>

                <div class="area-actions">
                    <a href="{{ route('areas') }}" class="btn btn-outline-secondario">
                        Torna alle aree
                    </a>

                    <a href="{{ route('contacts') }}" class="btn btn-brand">
                        Richiedi un primo colloquio
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layout>
