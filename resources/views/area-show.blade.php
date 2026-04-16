@php
    $areaImageWebp = asset(ltrim($area['image'], '/'));
    $areaImageJpg = asset(ltrim(preg_replace('/\.webp$/', '.jpg', $area['image']), '/'));
@endphp

<x-layout :metaTitle="$metaTitle" :metaDescription="$metaDescription" :ogImage="$areaImageWebp" :ogImageAlt="$area['image_alt']">
    @php
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

                @if (!empty($relatedAreas))
                    <div class="area-internal-links card shadow-soft border-0 p-4 mb-4">
                        <h2 class="h5 mb-3 card-heading-oro">Altri percorsi e contatti</h2>
                        <p class="small text-muted mb-3">
                            Se ti fa comodo, qui trovi anche altre aree vicine a questo tema, la pagina Chi sono e i
                            contatti per un primo colloquio:
                        </p>
                        <ul class="mb-0 small">
                            @foreach ($relatedAreas as $rel)
                                <li>
                                    <a href="{{ route('areas.show', ['slug' => $rel['slug']]) }}"
                                        data-track="internal_area_{{ $rel['slug'] }}">{{ $rel['title'] }}</a>
                                </li>
                            @endforeach
                            <li><a href="{{ route('about') }}" data-track="internal_about_from_area">Chi sono</a></li>
                            <li>
                                <a href="{{ route('contacts') }}#richiesta-colloquio"
                                    data-track="internal_contacts_from_area">Contatti e richiesta di primo colloquio</a>
                            </li>
                            <li><a href="{{ route('areas') }}" data-track="internal_all_areas">Tutte le aree di intervento</a></li>
                        </ul>
                    </div>
                @endif

                <div class="area-closing-text">
                    <p>
                        Se senti che questa area riguarda il momento che stai vivendo, puoi contattarmi per un primo
                        colloquio: sarà l’occasione per incontrarci e capire insieme, con calma, quale percorso può essere più adatto a te.
                    </p>
                </div>

                <div class="area-detail-actions">
                    <a href="{{ route('areas') }}" class="btn-area-secondary" data-track="cta_area_back">← Tutte le aree</a>
                    <a href="{{ route('contacts') }}#richiesta-colloquio" class="btn-area-primary"
                        data-track="cta_area_colloquio">Richiedi il primo colloquio</a>
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
