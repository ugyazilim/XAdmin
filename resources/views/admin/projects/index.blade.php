@extends('admin.layout')

@section('title', 'Projeler')

@section('content')
<div class="mb-4"></div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-briefcase me-2"></i>Tüm Projeler</h5>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>Yeni Proje
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="projectsTable">
                <thead>
                    <tr>
                        <th>Görsel</th>
                        <th>Başlık</th>
                        <th>Kategori</th>
                        <th>Konum</th>
                        <th>Müşteri</th>
                        <th>Durum</th>
                        <th width="150">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                        <tr>
                            <td>
                                @if($project->image)
                                    <img src="{{ asset($project->image) }}" alt="{{ $project->title }}" 
                                         class="rounded" 
                                         style="width: 80px; height: 50px; object-fit: cover;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $project->title }}</div>
                                @if($project->description)
                                    <small class="text-muted">{{ Str::limit($project->description, 50) }}</small>
                                @endif
                            </td>
                            <td>
                                @if($project->category)
                                    <span class="badge bg-primary">{{ $project->category->name }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $project->location ?? '-' }}</td>
                            <td>{{ $project->client_name ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $project->is_published ? 'success' : 'secondary' }}">
                                    {{ $project->is_published ? 'Yayında' : 'Taslak' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-sm btn-outline-info" title="Görüntüle">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-outline-primary" title="Düzenle">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu projeyi silmek istediğinizden emin misiniz?');">
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
                            <td colspan="7" class="text-center text-muted py-4">Henüz proje eklenmemiş.</td>
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
        $('#projectsTable').DataTable({
            responsive: true,
            pageLength: 25,
            order: [[1, 'asc']],
            columnDefs: [
                { orderable: false, targets: [0, 6] },
                { searchable: false, targets: [0, 6] }
            ],
            language: {
                search: "Proje ara:",
                lengthMenu: "Sayfada _MENU_ proje göster",
                info: "_TOTAL_ projeden _START_ - _END_ arası gösteriliyor",
                infoEmpty: "Proje bulunamadı",
                infoFiltered: "(_MAX_ proje içinden filtrelendi)",
                emptyTable: "Proje bulunamadı"
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip'
        });
    });
</script>
@endpush
