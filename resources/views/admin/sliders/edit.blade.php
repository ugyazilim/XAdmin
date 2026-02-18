@extends('admin.layout')

@section('title', 'Slider Düzenle')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1" style="font-weight: 700; color: #1f2937;">Slider Düzenle</h2>
        <p class="text-muted mb-0">Slider bilgilerini güncelleyin</p>
    </div>
    <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Sliderlara Dön
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Slider Bilgileri</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.sliders.update', $slider) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-4">
                        <label for="title" class="form-label fw-semibold">Başlık</label>
                        <div class="input-group-icon">
                            <span class="input-group-text">
                                <i class="bi bi-type-h1"></i>
                            </span>
                            <input type="text" class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $slider->title) }}">
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
                                      id="subtitle" name="subtitle" rows="4">{{ old('subtitle', $slider->subtitle) }}</textarea>
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
                                   id="link" name="link" value="{{ old('link', $slider->link) }}">
                        </div>
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
                                   id="button_text" name="button_text" value="{{ old('button_text', $slider->button_text) }}">
                        </div>
                        @error('button_text')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $slider->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_active">
                                Aktif
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Medya Tipi <span class="text-danger">*</span></h6>
                            <div class="mb-3">
                                <div class="btn-group w-100" role="group">
                                    <input type="radio" class="btn-check" name="media_type" id="media_type_image" value="image" {{ old('media_type', $slider->media_type) === 'image' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary" for="media_type_image">
                                        <i class="bi bi-image me-1"></i>Resim
                                    </label>
                                    
                                    <input type="radio" class="btn-check" name="media_type" id="media_type_video" value="video" {{ old('media_type', $slider->media_type) === 'video' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary" for="media_type_video">
                                        <i class="bi bi-camera-video me-1"></i>Video
                                    </label>
                                </div>
                                @error('media_type')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="imageSection" style="display: {{ old('media_type', $slider->media_type) === 'image' ? 'block' : 'none' }};">
                                <h6 class="fw-semibold mb-3">Slider Görseli</h6>
                                @if($slider->image_url && $slider->isImage())
                                    <div class="mb-3 text-center">
                                        <img src="{{ $slider->image_url }}" alt="Slider" class="img-fluid rounded" style="max-height: 300px;">
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <div class="input-group-icon">
                                        <span class="input-group-text">
                                            <i class="bi bi-image"></i>
                                        </span>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                               id="image" name="image" accept="image/*"
                                               onchange="previewImage(this)">
                                    </div>
                                    <small class="text-muted">Yeni görsel yüklemek için seçin</small>
                                    @error('image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Mobil Görsel (Opsiyonel)</label>
                                    @if($slider->mobile_image_url && $slider->isImage())
                                        <div class="mb-2 text-center">
                                            <img src="{{ $slider->mobile_image_url }}" alt="Mobil Slider" class="img-fluid rounded" style="max-height: 150px;">
                                        </div>
                                    @endif
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

                            <div id="videoSection" style="display: {{ old('media_type', $slider->media_type) === 'video' ? 'block' : 'none' }};">
                                <h6 class="fw-semibold mb-3">Slider Videosu</h6>
                                @if($slider->video_url && $slider->isVideo())
                                    <div class="mb-3 text-center">
                                        <video src="{{ $slider->video_url }}" controls class="img-fluid rounded" style="max-height: 300px;"></video>
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <div class="input-group-icon">
                                        <span class="input-group-text">
                                            <i class="bi bi-camera-video"></i>
                                        </span>
                                        <input type="file" class="form-control @error('video') is-invalid @enderror" 
                                               id="video" name="video" accept="video/*"
                                               onchange="previewVideo(this)">
                                    </div>
                                    <small class="text-muted">Yeni video yüklemek için seçin (MP4, WebM, OGG - Max: 10MB)</small>
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
                    <i class="bi bi-check-circle me-2"></i>Slider'ı Güncelle
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
                if (!imageInput.value) {
                    imageInput.setAttribute('required', 'required');
                }
                videoInput.removeAttribute('required');
            } else {
                imageSection.style.display = 'none';
                videoSection.style.display = 'block';
                if (!videoInput.value) {
                    videoInput.setAttribute('required', 'required');
                }
                imageInput.removeAttribute('required');
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

