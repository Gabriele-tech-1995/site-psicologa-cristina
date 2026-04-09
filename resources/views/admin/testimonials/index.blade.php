<x-layout>
    <section class="section p-4">
        <div class="page-head mb-4">
            <span class="badge badge-soft mb-3">Admin</span>
            <h1 class="page-title">Testimonianze</h1>
            <p class="page-lead">
                Qui puoi visualizzare, approvare o eliminare le testimonianze inviate dal sito.
            </p>
        </div>

        @include('admin.partials.nav')

        @if (session('admin_success'))
            <div class="alert alert-success mb-4">
                {{ session('admin_success') }}
            </div>
        @endif

        <div class="card shadow-soft p-4 admin-card">
            @if ($testimonials->count() === 0)
                <div class="empty-state text-center py-4">
                    <p class="mb-0">Nessuna testimonianza ricevuta al momento.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table admin-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Stato</th>
                                <th>Data</th>
                                <th>Firma</th>
                                <th>Messaggio</th>
                                <th class="text-end">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($testimonials as $testimonial)
                                <tr>
                                    <td>
                                        @if ($testimonial->is_approved)
                                            <span class="badge bg-secondary">Pubblicata</span>
                                        @else
                                            <span class="badge badge-soft">In attesa</span>
                                        @endif
                                    </td>

                                    <td class="table-date">
                                        {{ $testimonial->created_at->format('d/m/Y H:i') }}
                                    </td>

                                    <td class="fw-semibold">
                                        {{ $testimonial->name_label }}
                                    </td>

                                    <td style="max-width: 360px;">
                                        {{ \Illuminate\Support\Str::limit($testimonial->message, 120) }}
                                    </td>

                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-2 flex-wrap">
                                            <a class="btn btn-sm btn-outline-secondary"
                                                href="{{ route('admin.testimonials.show', $testimonial) }}">
                                                Apri
                                            </a>

                                            @if (!$testimonial->is_approved)
                                                <form action="{{ route('admin.testimonials.approve', $testimonial) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                        Approva
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.testimonials.unapprove', $testimonial) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                        Rimuovi
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('admin.testimonials.destroy', $testimonial) }}"
                                                method="POST"
                                                onsubmit="return confirm('Vuoi eliminare questa testimonianza?')">
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
                    {{ $testimonials->links() }}
                </div>
            @endif
        </div>
    </section>
</x-layout>
