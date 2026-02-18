@extends('admin.layout')

@section('title', 'Haber/Duyuru')

@section('content')
<div class="mb-4"></div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-newspaper me-2"></i>Tüm Haberler ve Duyurular</h5>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>Yeni Haber/Duyuru
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="newsTable">
                <thead>
                    <tr>
                        <th>Görsel</th>
                        <th>Başlık</th>
                        <th>Tip</th>
                        <th>Yayın Tarihi</th>
                        <th>Durum</th>
                        <th width="150">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($news as $item)
                        <tr>
                            <td>
                                <img src="{{ $item->featured_image_url ?? asset('upload/default_news.webp') }}" 
                                     alt="{{ $item->title }}" 
                                     class="rounded news-image-clickable" 
                                     data-news-id="{{ $item->id }}"
                                     data-news-title="{{ $item->title }}"
                                     data-current-image="{{ $item->featured_image ? $item->featured_image : '' }}"
                                     style="width: 80px; height: 50px; object-fit: cover; background: #f3f4f6; cursor: pointer; transition: all 0.2s ease;"
                                     onerror="this.onerror=null; this.src='{{ asset('upload/default_news.webp') }}';"
                                     title="Fotoğrafı değiştirmek için tıklayın">
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $item->title }}</div>
                                @if($item->excerpt)
                                    <small class="text-muted">{{ Str::limit($item->excerpt, 50) }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $item->type === 'news' ? 'primary' : 'warning' }}">
                                    {{ $item->type === 'news' ? 'Haber' : 'Duyuru' }}
                                </span>
                            </td>
                            <td>{{ $item->published_at ? $item->published_at->format('d.m.Y') : '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $item->is_published ? 'success' : 'secondary' }}">
                                    {{ $item->is_published ? 'Yayında' : 'Taslak' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.news.show', $item) }}" class="btn btn-sm btn-outline-info" title="Görüntüle">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-outline-primary" title="Düzenle">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu haberi/duyuruyu silmek istediğinizden emin misiniz?');">
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
                            <td colspan="6" class="text-center text-muted py-4">Henüz haber/duyuru eklenmemiş.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Change News Image Modal -->
<div class="modal fade" id="changeImageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="changeImageForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Haber Fotoğrafını Değiştir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="changeImageNewsId" name="news_id">
                    <div class="mb-3">
                        <label for="newsImage" class="form-label">Yeni Fotoğraf Seç</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-image"></i>
                            </span>
                            <input type="file" class="form-control" id="newsImage" name="image" accept="image/*" required>
                        </div>
                        <small class="text-muted">Desteklenen formatlar: JPG, PNG, WEBP, SVG</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mevcut Fotoğraf</label>
                        <div class="text-center">
                            <img id="currentNewsImage" src="" alt="Mevcut Fotoğraf" class="img-thumbnail" style="max-width: 200px; max-height: 200px; object-fit: cover;">
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
    .news-image-clickable:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#newsTable').DataTable({
            responsive: true,
            pageLength: 25,
            order: [[3, 'desc']],
            columnDefs: [
                { orderable: false, targets: [0, 5] },
                { searchable: false, targets: [0, 5] }
            ],
            language: {
                search: "Haber ara:",
                lengthMenu: "Sayfada _MENU_ haber göster",
                info: "_TOTAL_ haberden _START_ - _END_ arası gösteriliyor",
                infoEmpty: "Haber bulunamadı",
                infoFiltered: "(_MAX_ haber içinden filtrelendi)",
                emptyTable: "Haber bulunamadı"
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip'
        });
    });

    // News Image Click Handler
    $(document).on('click', '.news-image-clickable', function() {
        const newsId = $(this).data('news-id');
        const newsTitle = $(this).data('news-title');
        const currentImage = $(this).data('current-image');
        
        $('#changeImageNewsId').val(newsId);
        if (currentImage) {
            $('#currentNewsImage').attr('src', '{{ url("/") }}/' + currentImage);
        } else {
            $('#currentNewsImage').attr('src', '{{ asset("upload/default_news.webp") }}');
        }
        $('#imagePreview').hide();
        $('#previewImage').attr('src', '');
        $('#newsImage').val('');
        
        const modal = new bootstrap.Modal(document.getElementById('changeImageModal'));
        modal.show();
    });

    // Image Preview
    $('#newsImage').on('change', function(e) {
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
        
        const newsId = $('#changeImageNewsId').val();
        const formData = new FormData(this);
        
        $('#saveImageBtn').prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i>Yükleniyor...');
        
        $.ajax({
            url: `/admin/news/${newsId}/update-image`,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Update image in table
                const $img = $(`.news-image-clickable[data-news-id="${newsId}"]`);
                if (response.image_url) {
                    const imageUrl = '{{ url("/") }}/' + response.image_url + '?t=' + new Date().getTime();
                    $img.attr('src', imageUrl);
                    $img.data('current-image', response.image_url);
                } else {
                    $img.attr('src', '{{ asset("upload/default_news.webp") }}');
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
@endpush
