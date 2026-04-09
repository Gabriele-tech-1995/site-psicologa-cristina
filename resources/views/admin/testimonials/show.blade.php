<x-layout>
    <section class="section p-4">
        <div class="page-head mb-4">
            <span class="badge badge-soft mb-3">Admin</span>
            <h1 class="page-title">Dettaglio testimonianza</h1>
            <p class="page-lead">
                Qui puoi leggere il contenuto completo della testimonianza e decidere se pubblicarla.
            </p>
        </div>

        @include('admin.partials.nav')

        @if (session('admin_success'))
            <div class="alert alert-success mb-4">
                {{ session('admin_success') }}
            </div>
        @endif

        <div class="card shadow-soft p-4 admin-card">
            <div class="mb-3">
                <strong>Stato:</strong>
                @if ($testimonial->is_approved)
                    <span class="badge bg-secondary">Pubblicata</span>
                @else
                    <span class="badge badge-soft">In attesa</span>
                @endif
            </div>

            <div class="mb-3">
                <strong>Data invio:</strong>
                {{ $testimonial->created_at->format('d/m/Y H:i') }}
            </div>

            <div class="mb-3">
                <strong>Firma:</strong>
                {{ $testimonial->name_label }}
            </div>

            <div class="mb-4">
                <strong>Messaggio:</strong>
                <div class="mt-2 p-3 border rounded bg-white">
                    {{ $testimonial->message }}
                </div>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondario">
                    Torna alle testimonianze
                </a>

                @if (!$testimonial->is_approved)
                    <form action="{{ route('admin.testimonials.approve', $testimonial) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-brand">
                            Approva e pubblica
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.testimonials.unapprove', $testimonial) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-secondario">
                            Rimuovi dalla pubblicazione
                        </button>
                    </form>
                @endif

                <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST"
                    onsubmit="return confirm('Vuoi eliminare questa testimonianza?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-secondario">
                        Elimina
                    </button>
                </form>
            </div>
        </div>
    </section>
</x-layout>
