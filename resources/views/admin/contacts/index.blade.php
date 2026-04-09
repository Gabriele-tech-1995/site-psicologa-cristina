<x-layout>
    <section class="section p-4">
        <div class="page-head mb-4">
            <span class="badge badge-soft mb-3">Admin</span>
            <h1 class="page-title">Richieste di contatto</h1>
            <p class="page-lead">
                Qui puoi visualizzare e gestire tutte le richieste inviate dal modulo contatti.
            </p>
        </div>

        @include('admin.partials.nav')

        @if (session('admin_success'))
            <div class="alert alert-success mb-4">
                {{ session('admin_success') }}
            </div>
        @endif

        <div class="card shadow-soft p-4 admin-card">
            @if ($requests->count() === 0)
                <div class="empty-state text-center py-4">
                    <p class="mb-0">Nessuna richiesta ricevuta al momento.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table admin-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Stato</th>
                                <th>Data</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefono</th>
                                <th class="text-end">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requests as $r)
                                <tr id="request-{{ $r->id }}">
                                    <td>
                                        @if ($r->is_read)
                                            <span class="badge bg-secondary">Letta</span>
                                        @else
                                            <span class="badge badge-soft">Nuova</span>
                                        @endif
                                    </td>
                                    <td class="table-date">
                                        {{ $r->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="fw-semibold">{{ $r->name }}</td>
                                    <td>{{ $r->email }}</td>
                                    <td>{{ $r->phone }}</td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-2 flex-wrap">
                                            <a class="btn btn-sm btn-outline-secondary"
                                                href="{{ route('admin.contacts.show', $r) }}">
                                                Apri
                                            </a>

                                            @if (!$r->is_read)
                                                <form action="{{ route('admin.contacts.read', $r) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                        Segna letta
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('admin.contacts.destroy', $r) }}" method="POST"
                                                onsubmit="return confirm('Vuoi eliminare questa richiesta?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                    Elimina
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 admin-pagination">
                    {{ $requests->links() }}
                </div>
            @endif
        </div>
    </section>
</x-layout>
