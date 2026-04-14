<x-layout :metaTitle="$metaTitle" :metaDescription="$metaDescription">

    <section class="section areas-page">
        <div class="container">
            <div class="page-head mb-4">
                <span class="badge badge-soft mb-3">Aree di intervento</span>

                <h1 class="page-title mb-2">Aree di intervento</h1>

                <p class="page-lead mb-4">
                    Offro percorsi di supporto psicologico a <strong>Tivoli</strong> per bambini, adolescenti e genitori.
                    In questa sezione puoi approfondire le principali aree di intervento, tra cui
                    <a href="{{ route('areas.show', ['slug' => 'ansia-e-gestione-dello-stress']) }}"
                        title="Ansia e gestione dello stress">
                        ansia e gestione dello stress
                    </a>,
                    <a href="{{ route('areas.show', ['slug' => 'umore-basso']) }}" title="Umore basso">
                        umore basso
                    </a>,
                    <a href="{{ route('areas.show', ['slug' => 'difficolta-relazionali']) }}" title="Difficoltà relazionali">
                        difficoltà relazionali
                    </a>,
                    <a href="{{ route('areas.show', ['slug' => 'autostima']) }}" title="Autostima">
                        autostima
                    </a>
                    e
                    <a href="{{ route('areas.show', ['slug' => 'genitorialita']) }}" title="Sostegno alla genitorialità">
                        sostegno alla genitorialità
                    </a>.
                </p>
            </div>

            <div class="row g-4">
                @foreach ($areas as $area)
                    <div class="col-md-6 col-xl-4">
                        <article class="card p-4 h-100 card-area-preview reveal">
                            <div class="d-flex flex-column h-100">

                                <h2 class="mb-3 area-card-title h4">
                                    <a href="{{ route('areas.show', ['slug' => $area['slug']]) }}"
                                        class="text-decoration-none" title="{{ $area['title'] }}">
                                        {{ $area['title'] }}
                                    </a>
                                </h2>

                                <p class="mb-4 area-preview-text">
                                    {{ $area['preview'] }}
                                </p>

                                <div class="mt-auto">
                                    <a href="{{ route('areas.show', ['slug' => $area['slug']]) }}" class="area-link"
                                        title="Approfondisci l’area {{ $area['title'] }}">
                                        Approfondisci l’area →
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            <div class="mt-5 text-center">
                <p class="mb-3">
                    Se desideri un primo contatto o maggiori informazioni, puoi scrivermi dalla pagina Contatti
                    o richiedere un colloquio conoscitivo: sarà uno spazio per capire insieme quale percorso può avere più senso per te.
                </p>

                <div class="d-flex justify-content-center gap-2 flex-wrap">
                    <a class="btn btn-brand" href="{{ route('contacts') }}">
                        Richiedi un primo colloquio
                    </a>

                    <a class="btn btn-outline-secondario" target="_blank" rel="noopener noreferrer"
                        href="{{ $seoContact['whatsapp_url'] }}">
                        Scrivimi su WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layout>
