<x-layout :metaTitle="$metaTitle" :metaDescription="$metaDescription">
    @php
        $areaImageWebp = asset(ltrim($area['image'], '/'));
        $areaImageJpg = asset(ltrim(preg_replace('/\.webp$/', '.jpg', $area['image']), '/'));
        $practiceId = url('/') . '/#practice';
        $psyName = config('seo.psychologist.name', 'Dott.ssa Cristina Pacifici');
        $psyPractice = config('seo.psychologist.practice_name', $psyName);
        $areaPageSchema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        [
                            '@type' => 'ListItem',
                            'position' => 1,
                            'name' => 'Home',
                            'item' => route('home'),
                        ],
                        [
                            '@type' => 'ListItem',
                            'position' => 2,
                            'name' => 'Aree di intervento',
                            'item' => route('areas'),
                        ],
                        [
                            '@type' => 'ListItem',
                            'position' => 3,
                            'name' => $area['title'],
                            'item' => url()->current(),
                        ],
                    ],
                ],
                [
                    '@type' => 'Service',
                    'name' => $area['title'],
                    'description' => $area['preview'],
                    'provider' => [
                        '@id' => $practiceId,
                    ],
                    'areaServed' => ['Tivoli', 'Online'],
                    'url' => url()->current(),
                ],
                [
                    '@type' => 'Article',
                    'headline' => $metaTitle,
                    'description' => $metaDescription,
                    'author' => [
                        '@type' => 'Person',
                        'name' => $psyName,
                    ],
                    'publisher' => [
                        '@type' => 'Organization',
                        'name' => $psyPractice,
                    ],
                    'image' => [$areaImageWebp],
                    'mainEntityOfPage' => [
                        '@type' => 'WebPage',
                        '@id' => url()->current() . '#webpage',
                    ],
                ],
            ],
        ];
    @endphp

    <section class="section area-hero-illustrata"
        style="background-image: url('{{ $areaImageJpg }}'); background-image: image-set(url('{{ $areaImageWebp }}') type('image/webp'), url('{{ $areaImageJpg }}') type('image/jpeg'));">
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
                    <picture>
                        <source srcset="{{ $areaImageWebp }}" type="image/webp">
                        <img src="{{ $areaImageJpg }}" alt="{{ $area['image_alt'] }}" class="area-hero-image-mobile"
                            loading="lazy" decoding="async">
                    </picture>
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
                    <a href="{{ route('areas') }}" class="btn-area-secondary" data-track="cta_area_back">← Tutte le aree</a>
                    <a href="{{ route('contacts') }}" class="btn-area-primary" data-track="cta_area_colloquio">Richiedi un primo colloquio</a>
                </div>

            </div>
        </div>
    </section>

    <script type="application/ld+json"
        @isset($cspNonce) nonce="{{ $cspNonce }}" @endisset>
        {!! json_encode($areaPageSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>

    @if (!empty($areaFaqSchema))
        <script type="application/ld+json"
            @isset($cspNonce) nonce="{{ $cspNonce }}" @endisset>
            {!! json_encode($areaFaqSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
        </script>
    @endif
</x-layout>
