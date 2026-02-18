@extends('admin.layout')

@section('title', 'Slider')

@section('content')
<div class="mb-4"></div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-images me-2"></i>Tüm Sliderlar</h5>
        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-danger" id="bulkDeleteBtn" style="display: none;">
                <i class="bi bi-trash me-1"></i>Seçilenleri Sil
            </button>
            <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary" id="addSliderBtn" style="font-weight: 600; box-shadow: 0 2px 4px rgba(0,123,255,0.25);">
                <i class="bi bi-plus-circle me-1"></i>Yeni Slider
            </a>
            <button class="btn btn-sm btn-outline-secondary" id="toggleSortMode">
                <i class="bi bi-arrows-move me-1"></i>Sıralama Modu
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="slidersTable">
                <thead>
                    <tr>
                        <th width="40">
                            <input type="checkbox" id="selectAll" title="Tümünü Seç">
                        </th>
                        <th width="40"><i class="bi bi-grip-vertical"></i></th>
                        <th>Görsel</th>
                        <th>Başlık</th>
                        <th>Açıklama</th>
                        <th>Link</th>
                        <th>Buton Metni</th>
                        <th>Durum</th>
                        <th>Sıra</th>
                        <th width="150">İşlemler</th>
                    </tr>
                </thead>
                <tbody id="sortable">
                    @foreach($sliders as $slider)
                        <tr data-id="{{ $slider->id }}" data-sort-order="{{ $slider->sort_order }}" data-is-active="{{ $slider->is_active ? 'active' : 'inactive' }}">
                            <td>
                                <input type="checkbox" class="item-checkbox" value="{{ $slider->id }}">
                            </td>
                            <td class="drag-handle">
                                <i class="bi bi-grip-vertical"></i>
                            </td>
                            <td>
                                @if($slider->isVideo())
                                    <div class="position-relative">
                                        <video src="{{ $slider->video_url }}" style="width: 80px; height: 50px; object-fit: cover; background: #f3f4f6;" class="rounded"></video>
                                        <span class="badge bg-danger position-absolute top-0 end-0 m-1" style="font-size: 0.6rem;">
                                            <i class="bi bi-camera-video"></i>
                                        </span>
                                    </div>
                                @else
                                    <img src="{{ $slider->image_url }}" alt="{{ $slider->title }}" 
                                         class="rounded" 
                                         style="width: 80px; height: 50px; object-fit: cover; background: #f3f4f6;">
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $slider->title ?? '-' }}</div>
                            </td>
                            <td>
                                <div class="text-muted small">{{ Str::limit($slider->description ?? '-', 50) }}</div>
                            </td>
                            <td>
                                @if($slider->link)
                                    <a href="{{ $slider->link }}" target="_blank" class="text-primary">
                                        <i class="bi bi-link-45deg"></i> Link
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $slider->button_text ?? '-' }}</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $slider->is_active ? 'success' : 'secondary' }}">
                                    {{ $slider->is_active ? 'Aktif' : 'Pasif' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $slider->sort_order }}</span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.sliders.show', $slider) }}" class="btn btn-sm btn-outline-info" title="Görüntüle">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-sm btn-outline-primary" title="Düzenle">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu sliderı silmek istediğinizden emin misiniz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Sil">
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
    </div>
</div>
@endsection

@push('styles')
<style>
    div.dataTables_wrapper {
        position: relative;
        padding: 9px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    let sortableInstance = null;
    let isSortMode = false;
    let dataTable = null;

    $(document).ready(function() {
        dataTable = $('#slidersTable').DataTable({
            responsive: true,
            pageLength: 25,
            order: [[8, 'asc']],
            columnDefs: [
                { orderable: false, targets: [0, 1, 9] },
                { searchable: false, targets: [0, 1, 9] }
            ],
            language: {
                search: "Slider ara:",
                lengthMenu: "Sayfada _MENU_ slider göster",
                info: "_TOTAL_ sliderdan _START_ - _END_ arası gösteriliyor",
                infoEmpty: "Slider bulunamadı",
                infoFiltered: "(_MAX_ slider içinden filtrelendi)",
                emptyTable: "Slider bulunamadı"
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
            drawCallback: function() {
                if (isSortMode) {
                    initSortable();
                }
            }
        });

        // Status filter
        let statusFilterValue = '';
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                if (!statusFilterValue) return true;
                const row = dataTable.row(dataIndex).node();
                const isActive = $(row).data('is-active');
                return isActive === statusFilterValue;
            }
        );

        // Toggle sort mode
        $('#toggleSortMode').on('click', function() {
            isSortMode = !isSortMode;
            
            if (isSortMode) {
                dataTable.destroy();
                $('#slidersTable').addClass('sort-mode');
                initSortable();
                $(this).html('<i class="bi bi-x-circle me-1"></i>Sıralamayı Kapat');
                $(this).removeClass('btn-outline-secondary').addClass('btn-warning');
                $('#addSliderBtn').removeClass('btn-primary').addClass('btn-primary').addClass('btn-lg').css({
                    'font-weight': 'bold',
                    'box-shadow': '0 4px 8px rgba(0,123,255,0.3)'
                });
            } else {
                if (sortableInstance) {
                    sortableInstance.destroy();
                }
                $('#slidersTable').removeClass('sort-mode');
                dataTable = $('#slidersTable').DataTable({
                    responsive: true,
                    pageLength: 25,
                    order: [[8, 'asc']],
                    columnDefs: [
                        { orderable: false, targets: [0, 1, 9] },
                        { searchable: false, targets: [0, 1, 9] }
                    ],
                    language: {
                        search: "Slider ara:",
                        lengthMenu: "Sayfada _MENU_ slider göster",
                        info: "_TOTAL_ sliderdan _START_ - _END_ arası gösteriliyor",
                        infoEmpty: "Slider bulunamadı",
                        infoFiltered: "(_MAX_ slider içinden filtrelendi)",
                        emptyTable: "Slider bulunamadı"
                    },
                    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip'
                });
                $(this).html('<i class="bi bi-arrows-move me-1"></i>Sıralama Modu');
                $(this).removeClass('btn-warning').addClass('btn-outline-secondary');
                $('#addSliderBtn').removeClass('btn-lg').css({
                    'font-weight': '600',
                    'box-shadow': '0 2px 4px rgba(0,123,255,0.25)'
                });
            }
        });

        function initSortable() {
            const tbody = document.querySelector('#sortable');
            if (!tbody) return;

            sortableInstance = new Sortable(tbody, {
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'sortable-ghost',
                chosenClass: 'sortable-chosen',
                dragClass: 'sortable-drag',
                onEnd: function(evt) {
                    const orders = [];
                    $('#sortable tr').each(function() {
                        orders.push($(this).data('id'));
                    });

                    showToast('Sıralama güncelleniyor...', 'info');

                    $.ajax({
                        url: '{{ route("admin.sliders.update-order") }}',
                        method: 'POST',
                        data: {
                            orders: orders,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            showToast('Sıralama başarıyla güncellendi!', 'success');
                            $('#sortable tr').each(function(index) {
                                $(this).data('sort-order', index + 1);
                                $(this).find('td:eq(8) .badge').text(index + 1);
                            });
                        },
                        error: function() {
                            showToast('Sıralama güncellenirken hata oluştu. Lütfen tekrar deneyin.', 'error');
                        }
                    });
                }
            });
        }

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
                showToast('Lütfen en az bir slider seçin.', 'error');
                return;
            }

            if (!confirm(`${selectedIds.length} slider silinecek. Emin misiniz?`)) {
                return;
            }

            $.ajax({
                url: '{{ route("admin.sliders.bulk-delete") }}',
                method: 'POST',
                data: {
                    ids: selectedIds,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    showToast(response.message || 'Sliderlar başarıyla silindi.', 'success');
                    setTimeout(() => location.reload(), 1000);
                },
                error: function(xhr) {
                    const error = xhr.responseJSON?.message || 'Silme işlemi başarısız!';
                    showToast(error, 'error');
                }
            });
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

    function showToast(message, type = 'info') {
        const bgColor = type === 'success' ? 'bg-success' : type === 'error' ? 'bg-danger' : 'bg-info';
        const toast = $(
            `<div class="toast align-items-center text-white ${bgColor} border-0" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>`
        );
        $('body').append(toast);
        const bsToast = new bootstrap.Toast(toast[0]);
        bsToast.show();
        setTimeout(() => toast.remove(), 3000);
    }
</script>

<style>
    .sortable-ghost {
        opacity: 0.4;
        background: #f3f4f6;
    }

    .sortable-chosen {
        cursor: grabbing;
    }

    .sortable-drag {
        opacity: 0.8;
    }

    .sort-mode tbody tr {
        cursor: move;
    }

    .sort-mode tbody tr:hover {
        background: #f9fafb;
    }
</style>
@endpush

