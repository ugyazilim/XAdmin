@extends('admin.layout')

@section('title', 'İletişim Mesajları')

@section('content')
<div class="mb-4"></div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-envelope me-2"></i>İletişim Mesajları</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="contactsTable">
                <thead>
                    <tr>
                        <th>Ad Soyad</th>
                        <th>E-posta</th>
                        <th>Telefon</th>
                        <th>Konu</th>
                        <th>Durum</th>
                        <th>Tarih</th>
                        <th width="150">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $contact)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $contact->name }}</div>
                            </td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->phone ?? '-' }}</td>
                            <td>{{ $contact->subject ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $contact->status === 'new' ? 'warning' : ($contact->status === 'read' ? 'info' : ($contact->status === 'replied' ? 'success' : 'secondary')) }}">
                                    @if($contact->status === 'new')
                                        Yeni
                                    @elseif($contact->status === 'read')
                                        Okundu
                                    @elseif($contact->status === 'replied')
                                        Yanıtlandı
                                    @else
                                        Arşivlendi
                                    @endif
                                </span>
                            </td>
                            <td>{{ $contact->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-sm btn-outline-info" title="Görüntüle">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu mesajı silmek istediğinizden emin misiniz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Sil">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Henüz iletişim mesajı yok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#contactsTable').DataTable({
            responsive: true,
            pageLength: 25,
            order: [[5, 'desc']],
            columnDefs: [
                { orderable: false, targets: [6] },
                { searchable: false, targets: [6] }
            ],
            language: {
                search: "Mesaj ara:",
                lengthMenu: "Sayfada _MENU_ mesaj göster",
                info: "_TOTAL_ mesajdan _START_ - _END_ arası gösteriliyor",
                infoEmpty: "Mesaj bulunamadı",
                infoFiltered: "(_MAX_ mesaj içinden filtrelendi)",
                emptyTable: "Mesaj bulunamadı"
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip'
        });
    });
</script>
@endpush
