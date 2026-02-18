@extends('admin.layout')

@section('title', 'Hizmet Düzenle')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Hizmet Düzenle</h2>
        <p class="text-muted mb-0">{{ $service->title }}</p>
    </div>
    <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Hizmetlere Dön
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="title" class="form-label">Başlık <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $service->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Kategori</label>
                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                            <option value="">Kategori Seçin (Opsiyonel)</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $service->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="short_description" class="form-label">Kısa Açıklama</label>
                        <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                  id="short_description" name="short_description" rows="3">{{ old('short_description', $service->short_description) }}</textarea>
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">İçerik</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" name="content" rows="10">{{ old('content', $service->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="icon" class="form-label">İkon Sınıfı</label>
                            <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                                   id="icon" name="icon" value="{{ old('icon', $service->icon) }}" placeholder="Örn: flaticon-cyber-security">
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="sort_order" class="form-label">Sıralama</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', $service->sort_order) }}" min="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Aktif</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="meta_title" class="form-label">SEO Başlık</label>
                        <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                               id="meta_title" name="meta_title" value="{{ old('meta_title', $service->meta_title) }}">
                        @error('meta_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="meta_description" class="form-label">SEO Açıklama</label>
                        <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                  id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $service->meta_description) }}</textarea>
                        @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-light mb-3">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Öne Çıkan Görsel</h6>
                            @if($service->featured_image)
                                <div class="mb-3">
                                    <img src="{{ asset($service->featured_image) }}" alt="{{ $service->title }}" class="img-fluid rounded mb-2">
                                </div>
                            @endif
                            <div class="mb-3">
                                <input type="file" class="form-control @error('featured_image') is-invalid @enderror" 
                                       id="featured_image" name="featured_image" accept="image/*" onchange="previewImage(this, 'featuredPreview')">
                                @error('featured_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div id="featuredPreview" class="text-center" style="display: none;">
                                <img id="featuredPreviewImg" src="" alt="Önizleme" class="img-fluid rounded" style="max-height: 200px;">
                            </div>
                        </div>
                    </div>

                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Hizmet Görselleri</h6>
                            <p class="small text-muted mb-3">Mevcut görselleri düzenleyin veya yeni görseller ekleyin.</p>
                            
                            @if($service->images->count() > 0)
                            <div id="existingImages" class="mb-3">
                                @foreach($service->images as $index => $image)
                                <div class="mb-3 p-2 border rounded existing-image-item" data-image-id="{{ $image->id }}">
                                    <input type="hidden" name="existing_image_ids[]" value="{{ $image->id }}">
                                    <img src="{{ asset($image->image) }}" alt="{{ $image->alt_text }}" class="img-fluid rounded mb-2" style="max-height: 100px; width: 100%; object-fit: cover;">
                                    <input type="text" name="existing_image_alt_texts[]" class="form-control form-control-sm" value="{{ $image->alt_text }}" placeholder="Alt metin">
                                    <button type="button" class="btn btn-sm btn-danger mt-1 w-100" onclick="removeExistingImage(this)">
                                        <i class="bi bi-trash"></i> Kaldır
                                    </button>
                                </div>
                                @endforeach
                            </div>
                            @endif

                            <div class="mb-3">
                                <input type="file" class="form-control" 
                                       id="images" name="images[]" accept="image/*" multiple onchange="previewMultipleImages(this)">
                                <small class="form-text text-muted">Yeni görseller eklemek için çoklu seçim yapın.</small>
                            </div>
                            <div id="imagesPreview" class="row g-2"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">İptal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Güncelle
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId + 'Img');
        const previewDiv = document.getElementById(previewId);
        
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

    function previewMultipleImages(input) {
        const previewDiv = document.getElementById('imagesPreview');
        previewDiv.innerHTML = '';
        
        if (input.files && input.files.length > 0) {
            Array.from(input.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-6 col-md-4';
                    col.innerHTML = `
                        <div class="position-relative">
                            <img src="${e.target.result}" alt="Önizleme ${index + 1}" class="img-fluid rounded" style="max-height: 100px; width: 100%; object-fit: cover;">
                            <input type="text" name="image_alt_texts[]" class="form-control form-control-sm mt-1" placeholder="Alt metin">
                        </div>
                    `;
                    previewDiv.appendChild(col);
                };
                reader.readAsDataURL(file);
            });
        }
    }

    function removeExistingImage(button) {
        const item = button.closest('.existing-image-item');
        const hiddenInput = item.querySelector('input[type="hidden"]');
        hiddenInput.value = ''; // Mark for deletion
        item.style.display = 'none';
    }
</script>
@endpush
