@extends('admin.layout')

@section('title', 'Yeni Slider Oluştur')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1" style="font-weight: 700; color: #1f2937;">Yeni Slider Oluştur</h2>
        <p class="text-muted mb-0">Ana sayfa slider'ı ekleyin</p>
    </div>
    <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Sliderlara Dön
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-images me-2"></i>Slider Bilgileri</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-4">
                        <label for="title" class="form-label fw-semibold">Başlık</label>
                        <div class="input-group-icon">
                            <span class="input-group-text">
                                <i class="bi bi-type-h1"></i>
                            </span>
                            <input type="text" class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}"
                                   placeholder="Örn: Özel Kampanya">
                        </div>
                        @error('title')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="subtitle" class="form-label fw-semibold">Alt Başlık / Açıklama</label>
                        <div class="input-group-icon">
                            <span class="input-group-text" style="align-items: flex-start; padding-top: 0.75rem;">
                                <i class="bi bi-text-paragraph"></i>
                            </span>
                            <textarea class="form-control @error('subtitle') is-invalid @enderror" 
                                      id="subtitle" name="subtitle" rows="4"
                                      placeholder="Slider alt başlığı veya açıklaması">{{ old('subtitle') }}</textarea>
                        </div>
                        @error('subtitle')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="link" class="form-label fw-semibold">Link</label>
                        <div class="input-group-icon">
                            <span class="input-group-text">
                                <i class="bi bi-link-45deg"></i>
                            </span>
                            <input type="url" class="form-control @error('link') is-invalid @enderror" 
                                   id="link" name="link" value="{{ old('link') }}"
                                   placeholder="https://example.com">
                        </div>
                        <small class="text-muted">Slider'a tıklandığında yönlendirilecek URL</small>
                        @error('link')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="button_text" class="form-label fw-semibold">Buton Metni</label>
                        <div class="input-group-icon">
                            <span class="input-group-text">
                                <i class="bi bi-cursor"></i>
                            </span>
                            <input type="text" class="form-control @error('button_text') is-invalid @enderror" 
                                   id="button_text" name="button_text" value="{{ old('button_text') }}"
                                   placeholder="Örn: Hemen Keşfet">
                        </div>
                        @error('button_text')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_active">
                                Aktif
                            </label>
                        </div>
                        <small class="text-muted">Slider'ın görünür olup olmayacağını belirler</small>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Medya Tipi <span class="text-danger">*</span></h6>
                            <div class="mb-3">
                                <div class="btn-group w-100" role="group">
                                    <input type="radio" class="btn-check" name="media_type" id="media_type_image" value="image" checked>
                                    <label class="btn btn-outline-primary" for="media_type_image">
                                        <i class="bi bi-image me-1"></i>Resim
                                    </label>
                                    
                                    <input type="radio" class="btn-check" name="media_type" id="media_type_video" value="video">
                                    <label class="btn btn-outline-primary" for="media_type_video">
                                        <i class="bi bi-camera-video me-1"></i>Video
                                    </label>
                                </div>
                                @error('media_type')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="imageSection">
                                <h6 class="fw-semibold mb-3">Slider Görseli <span class="text-danger">*</span></h6>
                                <div class="mb-3">
                                    <div class="input-group-icon">
                                        <span class="input-group-text">
                                            <i class="bi bi-image"></i>
                                        </span>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                               id="image" name="image" accept="image/*"
                                               onchange="previewImage(this)">
                                    </div>
                                    @error('image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Mobil Görsel (Opsiyonel)</label>
                                    <div class="input-group-icon">
                                        <span class="input-group-text">
                                            <i class="bi bi-phone"></i>
                                        </span>
                                        <input type="file" class="form-control @error('mobile_image') is-invalid @enderror" 
                                               id="mobile_image" name="mobile_image" accept="image/*">
                                    </div>
                                    @error('mobile_image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div id="imagePreview" class="text-center" style="display: none;">
                                    <img id="preview" src="" alt="Önizleme" class="img-fluid rounded" style="max-height: 300px;">
                                </div>
                            </div>

                            <div id="videoSection" style="display: none;">
                                <h6 class="fw-semibold mb-3">Slider Videosu <span class="text-danger">*</span></h6>
                                <div class="mb-3">
                                    <div class="input-group-icon">
                                        <span class="input-group-text">
                                            <i class="bi bi-camera-video"></i>
                                        </span>
                                        <input type="file" class="form-control @error('video') is-invalid @enderror" 
                                               id="video" name="video" accept="video/*"
                                               onchange="previewVideo(this)">
                                    </div>
                                    <small class="text-muted">MP4, WebM, OGG formatları desteklenir (Max: 10MB)</small>
                                    @error('video')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div id="videoPreview" class="text-center" style="display: none;">
                                    <video id="videoPreviewElement" src="" controls class="img-fluid rounded" style="max-height: 300px;"></video>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-secondary">İptal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Slider Oluştur
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Media type değiştiğinde
    document.querySelectorAll('input[name="media_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const imageSection = document.getElementById('imageSection');
            const videoSection = document.getElementById('videoSection');
            const imageInput = document.getElementById('image');
            const videoInput = document.getElementById('video');

            if (this.value === 'image') {
                imageSection.style.display = 'block';
                videoSection.style.display = 'none';
                imageInput.setAttribute('required', 'required');
                videoInput.removeAttribute('required');
                videoInput.value = '';
                document.getElementById('videoPreview').style.display = 'none';
            } else {
                imageSection.style.display = 'none';
                videoSection.style.display = 'block';
                videoInput.setAttribute('required', 'required');
                imageInput.removeAttribute('required');
                imageInput.value = '';
                document.getElementById('imagePreview').style.display = 'none';
            }
        });
    });

    function previewImage(input) {
        const preview = document.getElementById('preview');
        const previewDiv = document.getElementById('imagePreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewDiv.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            previewDiv.style.display = 'none';
        }
    }

    function previewVideo(input) {
        const preview = document.getElementById('videoPreviewElement');
        const previewDiv = document.getElementById('videoPreview');
        
        if (input.files && input.files[0]) {
            const url = URL.createObjectURL(input.files[0]);
            preview.src = url;
            previewDiv.style.display = 'block';
        } else {
            previewDiv.style.display = 'none';
        }
    }
</script>
@endpush

