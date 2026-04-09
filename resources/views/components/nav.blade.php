<nav class="navbar navbar-expand-lg navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-3" href="{{ route('home') }}">
            <img src="/img/logo.jpg" alt="Logo Dott.ssa Cristina Pacifici" class="navbar-logo">

            <div class="brand-text">
                <span class="brand-title">Dott.ssa Cristina Pacifici</span>
                <small>Psicologa • Tivoli</small>
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
            aria-controls="mainNavbar" aria-expanded="false" aria-label="Apri menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                        Chi sono
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('areas*') ? 'active' : '' }}" href="{{ route('areas') }}">
                        Aree
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('testimonials*') ? 'active' : '' }}"
                        href="{{ route('testimonials') }}">
                        Testimonianze
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contacts*') ? 'active' : '' }}"
                        href="{{ route('contacts') }}">
                        Contatti
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
