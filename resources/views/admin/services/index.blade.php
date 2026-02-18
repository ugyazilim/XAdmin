@extends('admin.layout')

@section('title', 'Hizmetler')

@section('content')
<div class="container-fluid">
<div class="mb-4"></div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-briefcase me-2"></i>Tüm Hizmetler</h5>
        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-danger" id="bulkDeleteBtn" style="display: none;">
                <i class="bi bi-trash me-1"></i>Seçilenleri Sil
            </button>
            <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>Yeni Hizmet
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="servicesTable">
                <thead>
                    <tr>
                        <th width="40">
                            <input type="checkbox" id="selectAll" title="Tümünü Seç">
                        </th>
                        <th>Görsel</th>
                        <th>Başlık</th>
                        <th>Kısa Açıklama</th>
                        <th>İkon</th>
                        <th>Resim Sayısı</th>
                        <th>Durum</th>
                        <th width="150">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td>
                                <input type="checkbox" class="item-checkbox" value="{{ $service->id }}">
                            </td>
                            <td>
                                @if($service->featured_image)
                                    <img src="{{ asset($service->featured_image) }}" alt="{{ $service->title }}" 
                                         class="rounded service-image-clickable" 
                                         data-service-id="{{ $service->id }}"
                                         data-service-title="{{ $service->title }}"
                                         data-current-image="{{ $service->featured_image }}"
                                         style="width: 80px; height: 50px; object-fit: cover; cursor: pointer; transition: all 0.2s ease;"
                                         title="Fotoğrafı değiştirmek için tıklayın">
                                @else
                                    <div class="service-image-clickable d-inline-flex align-items-center justify-content-center rounded bg-light border" 
                                         data-service-id="{{ $service->id }}"
                                         data-service-title="{{ $service->title }}"
                                         data-current-image=""
                                         style="width: 80px; height: 50px; cursor: pointer; transition: all 0.2s ease;"
                                         title="Fotoğraf eklemek için tıklayın">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $service->title }}</div>
                            </td>
                            <td>{{ Str::limit($service->short_description ?? '', 50) ?: '-' }}</td>
                            <td>
                                @if($service->icon)
                                    <i class="{{ $service->icon }}"></i>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $service->images->count() }}</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $service->is_active ? 'success' : 'secondary' }}">
                                    {{ $service->is_active ? 'Aktif' : 'Pasif' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.services.show', $service) }}" class="btn btn-sm btn-outline-info" title="Görüntüle">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-primary" title="Düzenle">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu hizmeti silmek istediğinizden emin misiniz?');">
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
                            <td colspan="8" class="text-center text-muted py-4">Henüz hizmet eklenmemiş.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Change Service Image Modal -->
<div class="modal fade" id="changeImageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="changeImageForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Hizmet Fotoğrafını Değiştir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="changeImageServiceId" name="service_id">
                    <div class="mb-3">
                        <label for="serviceImage" class="form-label">Yeni Fotoğraf Seç</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-image"></i>
                            </span>
                            <input type="file" class="form-control" id="serviceImage" name="image" accept="image/*" required>
                        </div>
                        <small class="text-muted">Desteklenen formatlar: JPG, PNG, WEBP, SVG (Max: 2MB)</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mevcut Fotoğraf</label>
                        <div class="text-center">
                            <img id="currentServiceImage" src="" alt="Mevcut Fotoğraf" class="img-thumbnail" style="max-width: 200px; max-height: 200px; object-fit: cover;">
                        </div>
                    </div>
                    <div id="imagePreview" class="mb-3" style="display: none;">
                        <label class="form-label">Yeni Fotoğraf Önizleme</label>
                        <div class="text-center">
                            <img id="previewImage" src="" alt="Önizleme" class="img-thumbnail" style="max-width: 200px; max-height: 200px; object-fit: cover;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary" id="saveImageBtn">
                        <i class="bi bi-upload me-1"></i>Fotoğrafı Güncelle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection

@push('styles')
<style>
    .service-image-clickable:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        const dataTable = $('#servicesTable').DataTable({
            responsive: true,
            pageLength: 25,
            order: [[2, 'asc']],
            columnDefs: [
                { orderable: false, targets: [0, 7] },
                { searchable: false, targets: [0, 7] }
            ],
            language: {
                search: "Hizmet ara:",
                lengthMenu: "Sayfada _MENU_ hizmet göster",
                info: "_TOTAL_ hizmetten _START_ - _END_ arası gösteriliyor",
                infoEmpty: "Hizmet bulunamadı",
                infoFiltered: "(_MAX_ hizmet içinden filtrelendi)",
                emptyTable: "Hizmet bulunamadı"
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
                showToast('Lütfen en az bir hizmet seçin.', 'error');
                return;
            }

            if (!confirm(`${selectedIds.length} hizmet silinecek. Emin misiniz?`)) {
                return;
            }

            const form = $('<form>', {
                method: 'POST',
                action: '{{ route("admin.services.bulk-delete") }}'
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

    // Service Image Click Handler
    $(document).on('click', '.service-image-clickable', function() {
        const serviceId = $(this).data('service-id');
        const serviceTitle = $(this).data('service-title');
        const currentImage = $(this).data('current-image');
        
        $('#changeImageServiceId').val(serviceId);
        if (currentImage) {
            $('#currentServiceImage').attr('src', '{{ url("/") }}/' + currentImage);
        } else {
            $('#currentServiceImage').attr('src', '{{ asset("assets/img/portfolio/portfolio-1.jpg") }}');
        }
        $('#imagePreview').hide();
        $('#previewImage').attr('src', '');
        $('#serviceImage').val('');
        
        const modal = new bootstrap.Modal(document.getElementById('changeImageModal'));
        modal.show();
    });

    // Image Preview
    $('#serviceImage').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImage').attr('src', e.target.result);
                $('#imagePreview').show();
            };
            reader.readAsDataURL(file);
        } else {
            $('#imagePreview').hide();
        }
    });

    // Change Image Form Submit
    $('#changeImageForm').on('submit', function(e) {
        e.preventDefault();
        
        const serviceId = $('#changeImageServiceId').val();
        const formData = new FormData(this);
        
        $('#saveImageBtn').prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i>Yükleniyor...');
        
        $.ajax({
            url: `/admin/services/${serviceId}/update-image`,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Update image in table
                const $img = $(`.service-image-clickable[data-service-id="${serviceId}"]`);
                if (response.image_url) {
                    const imageUrl = '{{ url("/") }}/' + response.image_url + '?t=' + new Date().getTime();
                    if ($img.is('img')) {
                        $img.attr('src', imageUrl);
                    } else {
                        // Replace placeholder with image
                        $img.replaceWith(`<img src="${imageUrl}" alt="${$img.data('service-title')}" class="rounded service-image-clickable" data-service-id="${serviceId}" data-service-title="${$img.data('service-title')}" data-current-image="${response.image_url}" style="width: 80px; height: 50px; object-fit: cover; cursor: pointer; transition: all 0.2s ease;" title="Fotoğrafı değiştirmek için tıklayın">`);
                    }
                    $('.service-image-clickable[data-service-id="' + serviceId + '"]').data('current-image', response.image_url);
                }
                
                $('#changeImageModal').modal('hide');
                showToast('Fotoğraf başarıyla güncellendi!', 'success');
                $('#saveImageBtn').prop('disabled', false).html('<i class="bi bi-upload me-1"></i>Fotoğrafı Güncelle');
            },
            error: function(xhr) {
                const error = xhr.responseJSON?.message || 'Fotoğraf güncellenemedi!';
                showToast(error, 'error');
                $('#saveImageBtn').prop('disabled', false).html('<i class="bi bi-upload me-1"></i>Fotoğrafı Güncelle');
            }
        });
    });

    function showToast(message, type = 'info') {
        const bgColor = type === 'success' ? 'bg-success' : type === 'error' ? 'bg-danger' : 'bg-info';
        const toast = $(`
            <div class="toast align-items-center text-white ${bgColor} border-0" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `);
        $('body').append(toast);
        const bsToast = new bootstrap.Toast(toast[0]);
        bsToast.show();
        setTimeout(() => toast.remove(), 3000);
    }
</script>
@endpush
