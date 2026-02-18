@extends('admin.layout')

@section('title', 'SSS Yönetimi')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">SSS Yönetimi</h1>
        <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Yeni SSS Ekle
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <form action="" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Soru ara..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">Tüm Kategoriler</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                {{ ucfirst($category) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100">
                        <i class="bi bi-search me-1"></i> Filtrele
                    </button>
                </div>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="faqsTable">
                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th>Soru</th>
                            <th width="120">Kategori</th>
                            <th width="100">Sıra</th>
                            <th width="100">Durum</th>
                            <th width="150">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($faqs as $faq)
                        <tr>
                            <td>{{ $faq->id }}</td>
                            <td>
                                <strong>{{ Str::limit($faq->question, 80) }}</strong>
                                <br>
                                <small class="text-muted">{{ Str::limit(strip_tags($faq->answer), 100) }}</small>
                            </td>
                            <td>
                                @if($faq->category)
                                    <span class="badge bg-secondary">{{ ucfirst($faq->category) }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $faq->sort_order }}</td>
                            <td>
                                @if($faq->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Pasif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu soruyu silmek istediğinize emin misiniz?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <p class="text-muted mb-0">Henüz SSS eklenmemiş.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#faqsTable').DataTable({
            responsive: true,
            pageLength: 25,
            order: [[3, 'asc']],
            columnDefs: [
                { orderable: false, targets: [5] },
                { searchable: false, targets: [5] }
            ],
            language: {
                search: "SSS ara:",
                lengthMenu: "Sayfada _MENU_ soru göster",
                info: "_TOTAL_ sorudan _START_ - _END_ arası gösteriliyor",
                infoEmpty: "Soru bulunamadı",
                infoFiltered: "(_MAX_ soru içinden filtrelendi)",
                emptyTable: "Soru bulunamadı"
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip'
        });
    });
</script>
@endpush
