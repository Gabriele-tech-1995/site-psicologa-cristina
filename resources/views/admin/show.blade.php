<x-layout>
    <section class="section">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <span class="badge badge-soft">Admin</span>
                <h1 class="mt-2 mb-0">Dettaglio richiesta</h1>
                <p class="text-muted mb-0">
                    {{ $contactRequest->created_at->format('d/m/Y H:i') }}
                </p>
            </div>

            <a class="btn btn-outline-secondary" href="{{ route('admin.contacts.index') }}">
                ← Torna alla lista
            </a>
        </div>

        <div class="card shadow-soft p-4">

            <div class="mb-3">
                <div class="text-muted small">Nome</div>
                <div class="fw-semibold">{{ $contactRequest->name }}</div>
            </div>

            <div class="mb-3">
                <div class="text-muted small">Email</div>
                <a href="mailto:{{ $contactRequest->email }}">{{ $contactRequest->email }}</a>
            </div>

            <div class="mb-3">
                <div class="text-muted small">Telefono</div>
                <a href="tel:{{ $contactRequest->phone }}">{{ $contactRequest->phone }}</a>
            </div>

            <div>
                <div class="text-muted small">Messaggio</div>
                <div class="mt-2 p-3 bg-light rounded">
                    {{ $contactRequest->message }}
                </div>
            </div>

        </div>

    </section>
</x-layout>
