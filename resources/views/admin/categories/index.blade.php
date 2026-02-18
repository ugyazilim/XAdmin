@extends('admin.layout')

@section('title', 'Kategoriler')

@section('content')
<div class="mb-4"></div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-folder me-2"></i>Tüm Kategoriler</h5>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary" id="addCategoryBtn" style="font-weight: 600; box-shadow: 0 2px 4px rgba(0,123,255,0.25);">
                <i class="bi bi-plus-circle me-1"></i>Yeni Kategori
            </a>
            <button class="btn btn-sm btn-outline-secondary" id="toggleSortMode">
                <i class="bi bi-arrows-move me-1"></i>Sıralama Modu
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="categoriesTable">
                <thead>
                    <tr>
                        <th width="40"><i class="bi bi-grip-vertical"></i></th>
                        <th>İsim</th>
                        <th>Slug</th>
                        <th>Üst Kategori</th>
                        <th>Durum</th>
                        <th>Sıra</th>
                        <th>Projeler</th>
                        <th width="150">İşlemler</th>
                    </tr>
                </thead>
                <tbody id="sortable">
                    @foreach($categories as $category)
                        <tr data-id="{{ $category->id }}" data-sort-order="{{ $category->sort_order }}">
                            <td class="drag-handle">
                                <i class="bi bi-grip-vertical"></i>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <img src="{{ $category->image_url }}" 
                                             alt="{{ $category->name }}" 
                                             class="rounded category-image-clickable" 
                                             data-category-id="{{ $category->id }}"
                                             data-category-name="{{ $category->name }}"
                                             data-current-image="{{ $category->image ? $category->image : '' }}"
                                             style="width: 50px; height: 50px; object-fit: cover; background: #f3f4f6; cursor: pointer; transition: all 0.2s ease;"
                                             onerror="this.onerror=null; this.src='{{ asset('upload/default_category.webp') }}';"
                                             title="Fotoğrafı değiştirmek için tıklayın">
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold editable-field" 
                                             data-field="name" 
                                             data-id="{{ $category->id }}" 
                                             data-value="{{ $category->name }}"
                                             style="cursor: pointer; padding: 2px 4px; border-radius: 4px;"
                                             onmouseover="this.style.background='#f3f4f6'" 
                                             onmouseout="this.style.background='transparent'"
                                             title="Düzenlemek için tıklayın">
                                            {{ $category->name }}
                                        </div>
                                        @if($category->description)
                                            <small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <code class="text-muted">{{ $category->slug }}</code>
                            </td>
                            <td>
                                @if($category->parent)
                                    <span class="badge bg-info">{{ $category->parent->name }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $category->status === 'active' ? 'success' : 'secondary' }}">
                                    {{ $category->status === 'active' ? 'Aktif' : 'Pasif' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $category->sort_order }}</span>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $category->projects_count }}</span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-sm btn-outline-info" title="Görüntüle">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary" title="Düzenle">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu kategoriyi silmek istediğinizden emin misiniz?');">
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

<!-- Change Category Image Modal -->
<div class="modal fade" id="changeImageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="changeImageForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Kategori Fotoğrafını Değiştir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="changeImageCategoryId" name="category_id">
                    <div class="mb-3">
                        <label for="categoryImage" class="form-label">Yeni Fotoğraf Seç</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-image"></i>
                            </span>
                            <input type="file" class="form-control" id="categoryImage" name="image" accept="image/*" required>
                        </div>
                        <small class="text-muted">Desteklenen formatlar: JPG, PNG, WEBP, SVG</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mevcut Fotoğraf</label>
                        <div class="text-center">
                            <img id="currentCategoryImage" src="" alt="Mevcut Fotoğraf" class="img-thumbnail" style="max-width: 200px; max-height: 200px; object-fit: cover;">
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
@endsection

@push('styles')
<style>
    div.dataTables_wrapper {
        position: relative;
        padding: 9px;
    }

    .editable-field.editing {
        background: #fff3cd !important;
        border: 1px solid #ffc107;
    }
    .editable-input {
        width: 100%;
        border: 1px solid #667eea;
        border-radius: 4px;
        padding: 4px 8px;
        font-size: inherit;
        font-weight: inherit;
    }
    
    .category-image-clickable:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
</style>
@endpush

@push('scripts')
<script>
    let sortableInstance = null;
    let isSortMode = false;
    let dataTable = null;

    // Inline Editing for Categories
    $(document).on('click', '.editable-field', function() {
        if ($(this).hasClass('editing')) return;
        
        const $field = $(this);
        const field = $field.data('field');
        const id = $field.data('id');
        const currentValue = $field.data('value');
        const originalText = $field.text().trim();
        
        $field.addClass('editing');
        const $input = $('<input>', {
            type: 'text',
            class: 'editable-input',
            value: originalText
        });
        
        $field.html($input);
        $input.focus().select();
        
        const save = () => {
            const newValue = $input.val();
            if (newValue === originalText || !newValue.trim()) {
                if (!newValue.trim()) {
                    alert('Kategori adı boş olamaz!');
                    $input.focus();
                    return;
                }
                $field.removeClass('editing').html(originalText);
                return;
            }
            
            // Show loading
            $field.html('<i class="bi bi-hourglass-split"></i> Kaydediliyor...');
            
            $.ajax({
                url: `/admin/categories/${id}/quick-update`,
                method: 'POST',
                data: {
                    field: field,
                    value: newValue.trim(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $field.data('value', newValue.trim());
                    $field.html(newValue.trim());
                    $field.removeClass('editing');
                    showToast('Kategori başarıyla güncellendi!', 'success');
                },
                error: function(xhr) {
                    const error = xhr.responseJSON?.message || 'Güncelleme başarısız!';
                    $field.removeClass('editing').html(originalText);
                    showToast(error, 'error');
                }
            });
        };
        
        $input.on('blur', save);
        $input.on('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                save();
            } else if (e.key === 'Escape') {
                $field.removeClass('editing').html(originalText);
            }
        });
    });

    $(document).ready(function() {
        // Initialize DataTable
        dataTable = $('#categoriesTable').DataTable({
            responsive: true,
            pageLength: 25,
            order: [[5, 'asc']],
            columnDefs: [
                { orderable: false, targets: [0, 7] },
                { searchable: false, targets: [0, 7] }
            ],
            language: {
                search: "Kategori ara:",
                lengthMenu: "Sayfada _MENU_ kategori göster",
                info: "_TOTAL_ kategoriden _START_ - _END_ arası gösteriliyor",
                infoEmpty: "Kategori bulunamadı",
                infoFiltered: "(_MAX_ kategori içinden filtrelendi)",
                emptyTable: "Kategori bulunamadı"
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
            drawCallback: function() {
                if (isSortMode) {
                    initSortable();
                }
            }
        });

        // Toggle sort mode
        $('#toggleSortMode').on('click', function() {
            isSortMode = !isSortMode;
            
            if (isSortMode) {
                dataTable.destroy();
                $('#categoriesTable').addClass('sort-mode');
                initSortable();
                $(this).html('<i class="bi bi-x-circle me-1"></i>Sıralamayı Kapat');
                $(this).removeClass('btn-outline-secondary').addClass('btn-warning');
                // Make add button more prominent in sort mode
                $('#addCategoryBtn').removeClass('btn-success').addClass('btn-primary').addClass('btn-lg').css({
                    'font-weight': 'bold',
                    'box-shadow': '0 4px 8px rgba(0,123,255,0.3)'
                });
            } else {
                if (sortableInstance) {
                    sortableInstance.destroy();
                }
                $('#categoriesTable').removeClass('sort-mode');
                dataTable = $('#categoriesTable').DataTable({
                    responsive: true,
                    pageLength: 25,
                    order: [[5, 'asc']],
                    columnDefs: [
                        { orderable: false, targets: [0, 7] },
                        { searchable: false, targets: [0, 7] }
                    ],
                    language: {
                        search: "Kategori ara:",
                        lengthMenu: "Sayfada _MENU_ kategori göster",
                        info: "_TOTAL_ kategoriden _START_ - _END_ arası gösteriliyor",
                        infoEmpty: "Kategori bulunamadı",
                        infoFiltered: "(_MAX_ kategori içinden filtrelendi)",
                        emptyTable: "Kategori bulunamadı"
                    },
                    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip'
                });
                $(this).html('<i class="bi bi-arrows-move me-1"></i>Sıralama Modu');
                $(this).removeClass('btn-warning').addClass('btn-outline-secondary');
                // Reset add button style to normal prominent state
                $('#addCategoryBtn').removeClass('btn-lg').css({
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
                    const categories = [];
                    $('#sortable tr').each(function(index) {
                        categories.push({
                            id: $(this).data('id'),
                            sort_order: index
                        });
                    });

                    showToast('Sıralama güncelleniyor...', 'info');

                    $.ajax({
                        url: '{{ route("admin.categories.update-order") }}',
                        method: 'POST',
                        data: {
                            categories: categories,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            showToast('Sıralama başarıyla güncellendi!', 'success');
                            $('#sortable tr').each(function(index) {
                                $(this).data('sort-order', index);
                                $(this).find('td:eq(5) .badge').text(index);
                            });
                        },
                        error: function() {
                            showToast('Sıralama güncellenirken hata oluştu. Lütfen tekrar deneyin.', 'error');
                        }
                    });
                }
            });
        }
    });

    // Category Image Click Handler
    $(document).on('click', '.category-image-clickable', function() {
        const categoryId = $(this).data('category-id');
        const categoryName = $(this).data('category-name');
        const currentImage = $(this).data('current-image');
        
        $('#changeImageCategoryId').val(categoryId);
        if (currentImage) {
            $('#currentCategoryImage').attr('src', '{{ url("/") }}/' + currentImage);
        } else {
            $('#currentCategoryImage').attr('src', '{{ asset("upload/default_category.webp") }}');
        }
        $('#imagePreview').hide();
        $('#previewImage').attr('src', '');
        $('#categoryImage').val('');
        
        const modal = new bootstrap.Modal(document.getElementById('changeImageModal'));
        modal.show();
    });

    // Image Preview
    $('#categoryImage').on('change', function(e) {
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
        
        const categoryId = $('#changeImageCategoryId').val();
        const formData = new FormData(this);
        
        $('#saveImageBtn').prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i>Yükleniyor...');
        
        $.ajax({
            url: `/admin/categories/${categoryId}/update-image`,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Update image in table
                const $img = $(`.category-image-clickable[data-category-id="${categoryId}"]`);
                if (response.image_url) {
                    const imageUrl = '{{ url("/") }}/' + response.image_url + '?t=' + new Date().getTime();
                    $img.attr('src', imageUrl);
                    $img.data('current-image', response.image_url);
                } else {
                    $img.attr('src', '{{ asset("upload/default_category.webp") }}');
                    $img.data('current-image', '');
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
