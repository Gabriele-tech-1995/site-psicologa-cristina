<x-layout>
    <section class="section">
        <span class="badge badge-soft mb-3">Admin</span>
        <h1 class="mb-4">Richieste contatto</h1>

        <div class="card shadow-soft p-4">

            @if ($requests->count() === 0)
                <p class="mb-0 text-muted">Nessuna richiesta ricevuta.</p>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefono</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requests as $r)
                                <tr>
                                    <td class="text-muted">
                                        {{ $r->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td>{{ $r->name }}</td>
                                    <td>{{ $r->email }}</td>
                                    <td>{{ $r->phone }}</td>
                                    <td class="text-end">
                                        <a class="btn btn-sm btn-outline-secondary"
                                            href="{{ route('admin.contacts.show', $r) }}">
                                            Apri
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $requests->links() }}
                </div>
            @endif

        </div>
    </section>
</x-layout>
