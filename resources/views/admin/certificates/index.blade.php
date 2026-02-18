@extends('admin.layout')

@section('title', 'Sertifikalar')

@push('styles')
<style>
    .certificate-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 1.5rem;
    }
    .certificate-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        position: relative;
    }
    .certificate-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }
    .certificate-card.inactive {
        opacity: 0.5;
    }
    .certificate-image {
        width: 100%;
        height: 140px;
        object-fit: contain;
        padding: 1rem;
        background: #f8f9fa;
    }
    .certificate-image[src$=".svg"] {
        padding: 0.5rem;
    }
    .certificate-actions {
        padding: 0.75rem;
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        border-top: 1px solid #eee;
    }
    .certificate-checkbox {
        position: absolute;
        top: 0.5rem;
        left: 0.5rem;
        z-index: 10;
    }
    .certificate-status {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
    }
    .upload-zone {
        border: 2px dashed #dee2e6;
        border-radius: 12px;
        padding: 3rem 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #fafbfc;
    }
    .upload-zone:hover, .upload-zone.dragover {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.05);
    }
    .upload-zone i {
        font-size: 3rem;
        color: #667eea;
        margin-bottom: 1rem;
    }
    .preview-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
    }
    .preview-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        background: #f8f9fa;
    }
    .preview-item img {
        width: 100%;
        height: 80px;
        object-fit: contain;
        padding: 0.5rem;
    }
    .preview-item .remove-btn {
        position: absolute;
        top: 0.25rem;
        right: 0.25rem;
        background: #ef4444;
        color: white;
        border: none;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        font-size: 0.75rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Sertifikalar</h1>
            <small class="text-muted">Ana sayfada "Mutlu Müşteriler" bölümünde gösterilir</small>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-danger" id="bulkDeleteBtn" style="display: none;">
                <i class="bi bi-trash me-1"></i> Seçilenleri Sil
            </button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                <i class="bi bi-cloud-upload me-1"></i> Yeni Yükle
            </button>
        </div>
    </div>

    @if($certificates->count() > 0)
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="selectAll">
                <label class="form-check-label" for="selectAll">Tümünü Seç</label>
            </div>
            <span class="badge bg-secondary">{{ $certificates->count() }} sertifika</span>
        </div>
        <div class="card-body">
            <div class="certificate-grid" id="certificateGrid">
                @foreach($certificates as $certificate)
                <div class="certificate-card {{ !$certificate->is_active ? 'inactive' : '' }}" data-id="{{ $certificate->id }}">
                    <div class="certificate-checkbox">
                        <input class="form-check-input certificate-check" type="checkbox" value="{{ $certificate->id }}">
                    </div>
                    <div class="certificate-status">
                        @if($certificate->is_active)
                            <span class="badge bg-success"><i class="bi bi-check"></i></span>
                        @else
                            <span class="badge bg-secondary"><i class="bi bi-x"></i></span>
                        @endif
                    </div>
                    <img src="{{ $certificate->image_url }}" alt="{{ $certificate->title ?? 'Sertifika' }}" class="certificate-image">
                    <div class="certificate-actions">
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editCertificate({{ $certificate->id }})">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form action="{{ route('admin.certificates.toggle-status', $certificate) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-{{ $certificate->is_active ? 'warning' : 'success' }}">
                                <i class="bi bi-{{ $certificate->is_active ? 'eye-slash' : 'eye' }}"></i>
                            </button>
                        </form>
                        <form action="{{ route('admin.certificates.destroy', $certificate) }}" method="POST" class="d-inline" onsubmit="return confirm('Bu sertifikayı silmek istediğinize emin misiniz?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @else
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bi bi-award display-1 text-muted"></i>
            <h4 class="mt-3 mb-2">Henüz sertifika eklenmemiş</h4>
            <p class="text-muted mb-4">Sertifika/logo eklemek için yukarıdaki "Yeni Yükle" butonuna tıklayın.</p>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                <i class="bi bi-cloud-upload me-1"></i> İlk Sertifikayı Yükle
            </button>
        </div>
    </div>
    @endif
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sertifika Yükle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.certificates.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                @csrf
                <div class="modal-body">
                    <div class="upload-zone" id="uploadZone">
                        <i class="bi bi-cloud-arrow-up"></i>
                        <h5>Sertifika/Logo Yükleyin</h5>
                        <p class="text-muted mb-0">Sürükle bırak veya tıklayarak seçin</p>
                        <small class="text-muted">PNG, JPG, SVG, WEBP (Max: 2MB)</small>
                        <input type="file" name="images[]" id="fileInput" multiple accept="image/jpeg,image/jpg,image/png,image/gif,image/svg+xml,image/svg,image/webp,.svg" class="d-none">
                    </div>
                    <div class="preview-container" id="previewContainer"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                        <i class="bi bi-cloud-upload me-1"></i> Yükle
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sertifika Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <img id="editImage" src="" alt="" style="max-height: 120px; object-fit: contain;">
                    </div>
                    <div class="mb-3">
                        <label for="editTitle" class="form-label">Başlık (Opsiyonel)</label>
                        <input type="text" class="form-control" id="editTitle" name="title">
                    </div>
                    <div class="mb-3">
                        <label for="editLink" class="form-label">Link (Opsiyonel)</label>
                        <input type="url" class="form-control" id="editLink" name="link" placeholder="https://...">
                    </div>
                    <div class="mb-3">
                        <label for="editSortOrder" class="form-label">Sıra</label>
                        <input type="number" class="form-control" id="editSortOrder" name="sort_order">
                    </div>
                    <div class="mb-3">
                        <label for="editNewImage" class="form-label">Yeni Görsel</label>
                        <input type="file" class="form-control" id="editNewImage" name="image" accept="image/jpeg,image/jpg,image/png,image/gif,image/svg+xml,image/svg,image/webp,.svg">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="editActive" name="is_active" value="1">
                        <label class="form-check-label" for="editActive">Aktif</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const certificates = @json($certificates);

// Upload Zone
const uploadZone = document.getElementById('uploadZone');
const fileInput = document.getElementById('fileInput');
const previewContainer = document.getElementById('previewContainer');
const submitBtn = document.getElementById('submitBtn');
let selectedFiles = [];

uploadZone.addEventListener('click', () => fileInput.click());

uploadZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    uploadZone.classList.add('dragover');
});

uploadZone.addEventListener('dragleave', () => {
    uploadZone.classList.remove('dragover');
});

uploadZone.addEventListener('drop', (e) => {
    e.preventDefault();
    uploadZone.classList.remove('dragover');
    handleFiles(e.dataTransfer.files);
});

fileInput.addEventListener('change', () => {
    handleFiles(fileInput.files);
});

function handleFiles(files) {
    const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'];
    const allowedMimeTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/svg+xml', 'image/svg', 'image/webp'];
    
    Array.from(files).forEach(file => {
        const ext = file.name.split('.').pop().toLowerCase();
        const mimeType = file.type.toLowerCase();
        
        // Check by extension or MIME type (SVG can have different MIME types)
        if (allowedExtensions.includes(ext) || allowedMimeTypes.includes(mimeType) || file.type.startsWith('image/')) {
            selectedFiles.push(file);
            addPreview(file);
        } else {
            alert(`"${file.name}" dosyası desteklenmiyor. Sadece JPEG, JPG, PNG, GIF, SVG ve WEBP formatları kabul edilir.`);
        }
    });
    updateSubmitBtn();
    updateFileInput();
}

function addPreview(file) {
    const reader = new FileReader();
    reader.onload = (e) => {
        const div = document.createElement('div');
        div.className = 'preview-item';
        div.innerHTML = `
            <img src="${e.target.result}" alt="">
            <button type="button" class="remove-btn" onclick="removePreview(this, '${file.name}')">×</button>
        `;
        previewContainer.appendChild(div);
    };
    reader.readAsDataURL(file);
}

function removePreview(btn, filename) {
    btn.parentElement.remove();
    selectedFiles = selectedFiles.filter(f => f.name !== filename);
    updateSubmitBtn();
    updateFileInput();
}

function updateSubmitBtn() {
    submitBtn.disabled = selectedFiles.length === 0;
}

function updateFileInput() {
    const dt = new DataTransfer();
    selectedFiles.forEach(file => dt.items.add(file));
    fileInput.files = dt.files;
}

// Edit Certificate
function editCertificate(id) {
    const cert = certificates.find(c => c.id === id);
    if (!cert) return;

    document.getElementById('editForm').action = `/admin/certificates/${id}`;
    document.getElementById('editImage').src = cert.image ? '/' + cert.image : '/theme/img/brand/01.svg';
    document.getElementById('editTitle').value = cert.title || '';
    document.getElementById('editLink').value = cert.link || '';
    document.getElementById('editSortOrder').value = cert.sort_order || 0;
    document.getElementById('editActive').checked = cert.is_active;

    new bootstrap.Modal(document.getElementById('editModal')).show();
}

// Select All
document.getElementById('selectAll')?.addEventListener('change', function() {
    document.querySelectorAll('.certificate-check').forEach(cb => cb.checked = this.checked);
    toggleBulkDelete();
});

document.querySelectorAll('.certificate-check').forEach(cb => {
    cb.addEventListener('change', toggleBulkDelete);
});

function toggleBulkDelete() {
    const checked = document.querySelectorAll('.certificate-check:checked').length;
    document.getElementById('bulkDeleteBtn').style.display = checked > 0 ? 'block' : 'none';
}

// Bulk Delete
document.getElementById('bulkDeleteBtn')?.addEventListener('click', function() {
    if (!confirm('Seçili sertifikaları silmek istediğinize emin misiniz?')) return;
    
    const ids = Array.from(document.querySelectorAll('.certificate-check:checked')).map(cb => cb.value);
    
    fetch('{{ route("admin.certificates.bulk-delete") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ ids })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
});

// Reset modal on close
document.getElementById('uploadModal').addEventListener('hidden.bs.modal', function() {
    selectedFiles = [];
    previewContainer.innerHTML = '';
    fileInput.value = '';
    updateSubmitBtn();
});
</script>
@endpush
