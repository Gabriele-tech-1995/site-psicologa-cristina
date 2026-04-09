<div class="d-flex gap-2 flex-wrap mb-4">
    <a class="btn {{ request()->routeIs('admin.contacts.*') ? 'btn-brand' : 'btn-outline-secondario' }}"
        href="{{ route('admin.contacts.index') }}">
        Richieste contatto
    </a>

    <a class="btn {{ request()->routeIs('admin.testimonials.*') ? 'btn-brand' : 'btn-outline-secondario' }}"
        href="{{ route('admin.testimonials.index') }}">
        Testimonianze
    </a>
</div>
