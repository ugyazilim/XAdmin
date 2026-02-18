@extends('admin.layout')

@section('title', 'Referanslar')

@section('content')
<div class="mb-4"></div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-star me-2"></i>Tüm Referanslar</h5>
        <a href="{{ route('admin.references.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>Yeni Referans
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="referencesTable">
                <thead>
                    <tr>
                        <th>Görsel</th>
                        <th>Başlık</th>
                        <th>Müşteri</th>
                        <th>Proje Tipi</th>
                        <th>Tamamlanma</th>
                        <th>Durum</th>
                        <th width="150">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($references as $reference)
                        <tr>
                            <td>
                                @if($reference->image)
                                    <img src="{{ asset($reference->image) }}" alt="{{ $reference->title }}" 
                                         class="rounded" 
                                         style="width: 80px; height: 50px; object-fit: cover;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $reference->title }}</div>
                                @if($reference->description)
                                    <small class="text-muted">{{ Str::limit($reference->description, 50) }}</small>
                                @endif
                            </td>
                            <td>{{ $reference->client_name ?? '-' }}</td>
                            <td>{{ $reference->project_type ?? '-' }}</td>
                            <td>{{ $reference->completion_date ? $reference->completion_date->format('d.m.Y') : '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $reference->is_published ? 'success' : 'secondary' }}">
                                    {{ $reference->is_published ? 'Yayında' : 'Taslak' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.references.show', $reference) }}" class="btn btn-sm btn-outline-info" title="Görüntüle">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.references.edit', $reference) }}" class="btn btn-sm btn-outline-primary" title="Düzenle">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.references.destroy', $reference) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu referansı silmek istediğinizden emin misiniz?');">
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
                            <td colspan="7" class="text-center text-muted py-4">Henüz referans eklenmemiş.</td>
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
        $('#referencesTable').DataTable({
            responsive: true,
            pageLength: 25,
            order: [[1, 'asc']],
            columnDefs: [
                { orderable: false, targets: [0, 6] },
                { searchable: false, targets: [0, 6] }
            ],
            language: {
                search: "Referans ara:",
                lengthMenu: "Sayfada _MENU_ referans göster",
                info: "_TOTAL_ referanstan _START_ - _END_ arası gösteriliyor",
                infoEmpty: "Referans bulunamadı",
                infoFiltered: "(_MAX_ referans içinden filtrelendi)",
                emptyTable: "Referans bulunamadı"
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip'
        });
    });
</script>
@endpush
