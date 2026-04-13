<nav class="navbar navbar-expand-lg navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('img/logo.webp') }}" alt="Logo Dott.ssa Cristina Pacifici" class="navbar-logo"
                width="165" height="160" loading="eager" decoding="async" fetchpriority="low">

            <div class="brand-text">
                <span class="brand-title">Dott.ssa Cristina Pacifici – Psicologa</span>
                <small>Tivoli · online e in presenza</small>
            </div>
        </a>

        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#navOffcanvas" aria-controls="navOffcanvas" aria-label="Apri menu">
            <span class="navbar-toggler-icon hamburger-icon" aria-hidden="true">
                <span class="hamburger-icon__bar"></span>
                <span class="hamburger-icon__bar"></span>
                <span class="hamburger-icon__bar"></span>
            </span>
        </button>

        <div class="navbar-collapse d-none d-lg-flex align-items-center" id="mainNavbar">
            @include('components.nav-menu', ['navExtraClass' => 'ms-auto'])
        </div>
    </div>
</nav>

@php
    $psyNav = config('seo.psychologist', []);
    $waNav = $psyNav['whatsapp_url'] ?? null;
    $telNav = $psyNav['telephone'] ?? null;
    $telHrefNav = $telNav ? preg_replace('/\s+/', '', $telNav) : null;
    $alboNavUrl = $psyNav['albo_registration_url'] ?? null;
    $nameNav = $psyNav['name'] ?? 'Dott.ssa Cristina Pacifici';
    $jobNav = $psyNav['job_title'] ?? 'Psicologa';
    $emailNav = $psyNav['email'] ?? null;
@endphp

<div class="offcanvas offcanvas-end navbar-offcanvas d-lg-none" id="navOffcanvas" tabindex="-1"
    aria-labelledby="navOffcanvasLabel" data-bs-scroll="false" data-bs-backdrop="true">
    <div class="offcanvas-header navbar-offcanvas__header d-flex align-items-center justify-content-between">
        <p class="navbar-offcanvas__menu-label mb-0" id="navOffcanvasLabel">Menu</p>
        <button type="button" class="btn-close flex-shrink-0" data-bs-dismiss="offcanvas"
            aria-label="Chiudi menu"></button>
    </div>
    <div class="offcanvas-body navbar-offcanvas__body">
        <div class="navbar-offcanvas__fill">
            <header class="navbar-offcanvas__intro">
                <a href="{{ route('home') }}" class="navbar-offcanvas__intro-name">{{ $nameNav }}</a>
                <p class="navbar-offcanvas__intro-tag">{{ $jobNav }} · Tivoli e online</p>
                <p class="navbar-offcanvas__intro-quote">Uno spazio accogliente per adolescenti, genitori e adulti.</p>
                @if ($emailNav)
                    <a class="navbar-offcanvas__intro-mail" href="mailto:{{ $emailNav }}"
                        data-track="nav_offcanvas_mail">{{ $emailNav }}</a>
                @endif
            </header>

            <nav class="navbar-offcanvas__main-nav" aria-label="Pagine del sito">
                <div class="navbar-offcanvas__nav">
                    @include('components.nav-menu', ['navExtraClass' => 'flex-column navbar-offcanvas__nav-list w-100'])
                </div>
            </nav>

            <div class="navbar-offcanvas__footer" role="region" aria-labelledby="navOffcanvasContactsLabel">
                <p class="navbar-offcanvas__footer-label navbar-offcanvas__footer-label--pill"
                    id="navOffcanvasContactsLabel">Contattami</p>
                <div class="navbar-offcanvas__actions">
                    @if ($waNav)
                        <a class="btn btn-brand navbar-offcanvas__action-btn" href="{{ $waNav }}" target="_blank"
                            rel="noopener noreferrer" data-track="nav_offcanvas_whatsapp">Messaggio WhatsApp</a>
                    @endif
                    @if ($telHrefNav)
                        <a class="btn btn-outline-secondario navbar-offcanvas__action-btn navbar-offcanvas__action-btn--stacked"
                            href="tel:{{ $telHrefNav }}" aria-label="Chiama al numero {{ $telNav }}"
                            data-track="nav_offcanvas_tel">
                            <span class="navbar-offcanvas__action-primary">Telefono</span>
                            <span class="navbar-offcanvas__action-secondary">{{ $telNav }}</span>
                        </a>
                    @endif
                    <a class="btn btn-outline-secondario navbar-offcanvas__action-btn"
                        href="{{ route('contacts') }}" data-track="nav_offcanvas_contacts">Modulo, sede e orari</a>
                </div>

                <div class="navbar-offcanvas__finale">
                    <div class="navbar-offcanvas__finale-glow" aria-hidden="true"></div>
                    <p class="navbar-offcanvas__finale-quote">
                        Insieme, <span class="navbar-offcanvas__finale-quote-accent">al proprio ritmo.</span>
                    </p>
                    @if ($alboNavUrl)
                        <a class="navbar-offcanvas__finale-albo" href="{{ $alboNavUrl }}" target="_blank"
                            rel="noopener noreferrer">Iscrizione Ordine Psicologi del Lazio</a>
                    @endif
                    <button type="button" class="navbar-offcanvas__finale-dismiss" data-bs-dismiss="offcanvas"
                        data-track="nav_offcanvas_close">
                        <span class="navbar-offcanvas__finale-dismiss-icon" aria-hidden="true"></span>
                        Chiudi menu
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
