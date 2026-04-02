<nav class="navbar navbar-expand-lg navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            Dott.ssa Cristina Pacifici
            <small>Psicologa • Tivoli</small>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
            aria-controls="mainNavbar" aria-expanded="false" aria-label="Apri menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item">
                    <a class="nav-link @if (request()->routeIs('home')) active @endif"
                        href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (request()->routeIs('about')) active @endif" href="{{ route('about') }}">Chi
                        sono</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (request()->routeIs('areas')) active @endif"
                        href="{{ route('areas') }}">Aree</a>
                </li>

                <li class="nav-item ms-lg-2">
                    <a class="btn btn-brand btn-contatti @if (request()->routeIs('contacts')) active @endif"
                        href="{{ route('contacts') }}">
                        Contatti
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
