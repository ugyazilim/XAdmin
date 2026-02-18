@extends('admin.layout')

@section('title', 'Sayfalar')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1" style="font-weight: 700; color: #1f2937;">Sayfalar</h2>
        <p class="text-muted mb-0">Statik sayfa içeriklerini yönetin</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-sm btn-danger" id="bulkDeleteBtn" style="display: none;">
            <i class="bi bi-trash me-1"></i>Seçilenleri Sil
        </button>
        <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Yeni Sayfa
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($pages->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover" id="pagesTable">
                    <thead>
                        <tr>
                            <th width="40">
                                <input type="checkbox" id="selectAll" title="Tümünü Seç">
                            </th>
                            <th width="50">#</th>
                            <th>Başlık</th>
                            <th>URL</th>
                            <th>Şablon</th>
                            <th>Durum</th>
                            <th width="150">İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pages as $page)
                            <tr>
                                <td>
                                    <input type="checkbox" class="item-checkbox" value="{{ $page->id }}">
                                </td>
                                <td>{{ $page->sort_order }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $page->title }}</div>
                                </td>
                                <td>
                                    <code class="bg-light px-2 py-1 rounded">/{{ $page->slug }}</code>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">{{ ucfirst($page->template) }}</span>
                                </td>
                                <td>
                                    @if($page->is_published)
                                        <span class="badge bg-success">Yayında</span>
                                    @else
                                        <span class="badge bg-warning">Taslak</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.pages.show', $page) }}" class="btn btn-outline-primary" title="Görüntüle">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-outline-secondary" title="Düzenle">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.pages.toggle-publish', $page) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-{{ $page->is_published ? 'warning' : 'success' }}" title="{{ $page->is_published ? 'Yayından Kaldır' : 'Yayınla' }}">
                                                <i class="bi bi-{{ $page->is_published ? 'eye-slash' : 'eye' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu sayfayı silmek istediğinize emin misiniz?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Sil">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-file-text text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3">Henüz sayfa eklenmemiş</p>
                <a href="{{ route('admin.pages.create') }}" class="btn btn-primary mt-3">
                    <i class="bi bi-plus-lg me-1"></i> İlk Sayfayı Ekle
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        const dataTable = $('#pagesTable').DataTable({
            responsive: true,
            pageLength: 25,
            order: [[1, 'asc']],
            columnDefs: [
                { orderable: false, targets: [0, 6] },
                { searchable: false, targets: [0, 6] }
            ],
            language: {
                search: "Sayfa ara:",
                lengthMenu: "Sayfada _MENU_ sayfa göster",
                info: "_TOTAL_ sayfadan _START_ - _END_ arası gösteriliyor",
                infoEmpty: "Sayfa bulunamadı",
                infoFiltered: "(_MAX_ sayfa içinden filtrelendi)",
                emptyTable: "Sayfa bulunamadı"
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip'
        });

        // Select All checkbox
        $('#selectAll').on('change', function() {
            $('.item-checkbox').prop('checked', $(this).prop('checked'));
            toggleBulkDeleteBtn();
        });

        // Individual checkbox change
        $(document).on('change', '.item-checkbox', function() {
            const total = $('.item-checkbox').length;
            const checked = $('.item-checkbox:checked').length;
            $('#selectAll').prop('checked', total === checked);
            toggleBulkDeleteBtn();
        });

        // Bulk delete
        $('#bulkDeleteBtn').on('click', function() {
            const selectedIds = $('.item-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            if (selectedIds.length === 0) {
                alert('Lütfen en az bir sayfa seçin.');
                return;
            }

            if (!confirm(`${selectedIds.length} sayfa silinecek. Emin misiniz?`)) {
                return;
            }

            const form = $('<form>', {
                method: 'POST',
                action: '{{ route("admin.pages.bulk-delete") }}'
            });

            form.append($('<input>', {
                type: 'hidden',
                name: '_token',
                value: '{{ csrf_token() }}'
            }));

            selectedIds.forEach(function(id) {
                form.append($('<input>', {
                    type: 'hidden',
                    name: 'ids[]',
                    value: id
                }));
            });

            $('body').append(form);
            form.submit();
        });

        function toggleBulkDeleteBtn() {
            const checkedCount = $('.item-checkbox:checked').length;
            if (checkedCount > 0) {
                $('#bulkDeleteBtn').show().html(`<i class="bi bi-trash me-1"></i>Seçilenleri Sil (${checkedCount})`);
            } else {
                $('#bulkDeleteBtn').hide();
            }
        }
    });
</script>
@endpush
