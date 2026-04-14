@php
    $navExtraClass = $navExtraClass ?? '';
@endphp
<ul class="navbar-nav {{ $navExtraClass }}">
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
        <a class="nav-link {{ request()->routeIs('first-interview') ? 'active' : '' }}" href="{{ route('first-interview') }}">
            Primo colloquio
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('testimonials*') ? 'active' : '' }}"
            href="{{ route('testimonials') }}">
            Testimonianze
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('contacts*') ? 'active' : '' }}" href="{{ route('contacts') }}">
            Contatti
        </a>
    </li>
</ul>
