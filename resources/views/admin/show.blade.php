<x-layout>
    <section class="section">
        <div class="page-head mb-4 d-flex justify-content-between align-items-start flex-wrap gap-3">
            <div>
                <span class="badge badge-soft mb-3">Admin</span>
                <h1 class="page-title mb-2">Dettaglio richiesta</h1>
                <p class="page-lead mb-0">
                    Ricevuta il {{ $contactRequest->created_at->format('d/m/Y H:i') }}
                </p>
            </div>

            <a class="btn btn-outline-secondary" href="{{ route('admin.contacts.index') }}">
                ← Torna alla lista
            </a>
        </div>

        @if (session('admin_success'))
            <div class="alert alert-success mb-4">
                {{ session('admin_success') }}
            </div>
        @endif

        <div class="card shadow-soft p-4 admin-card admin-detail-card">
            <div class="admin-detail-grid">
                <div class="admin-detail-item">
                    <div class="admin-label">Nome</div>
                    <div class="admin-value fw-semibold">{{ $contactRequest->name }}</div>
                </div>

                <div class="admin-detail-item">
                    <div class="admin-label">Email</div>
                    <a class="admin-value-link" href="mailto:{{ $contactRequest->email }}">
                        {{ $contactRequest->email }}
                    </a>
                </div>

                <div class="admin-detail-item">
                    <div class="admin-label">Telefono</div>
                    <a class="admin-value-link" href="tel:{{ $contactRequest->phone }}">
                        {{ $contactRequest->phone }}
                    </a>
                </div>
            </div>

            <div class="admin-message-box mt-4">
                <div class="admin-label mb-2">Messaggio</div>
                <div class="admin-message-content">
                    {{ $contactRequest->message }}
                </div>
            </div>

            <div class="d-flex gap-2 flex-wrap mt-4">
                <a href="mailto:{{ $contactRequest->email }}" class="btn btn-outline-secondary">
                    Rispondi via email
                </a>

                @if (!$contactRequest->is_read)
                    <form action="{{ route('admin.contacts.read', $contactRequest) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-secondary">
                            Segna letta
                        </button>
                    </form>
                @endif

                <form action="{{ route('admin.contacts.destroy', $contactRequest) }}" method="POST"
                    onsubmit="return confirm('Vuoi eliminare questa richiesta?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-secondary">
                        Elimina
                    </button>
                </form>
            </div>
        </div>
    </section>
</x-layout>
