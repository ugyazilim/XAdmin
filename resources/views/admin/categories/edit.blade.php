@extends('admin.layout')

@section('title', 'Kategori Düzenle')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1" style="font-weight: 700; color: #1f2937;">Kategori Düzenle</h2>
        <p class="text-muted mb-0">Kategori bilgilerini güncelleyin</p>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Kategorilere Dön
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Kategori Bilgileri</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-4">
                        <label for="name" class="form-label fw-semibold">Kategori Adı <span class="text-danger">*</span></label>
                        <div class="input-group-icon">
                            <span class="input-group-text">
                                <i class="bi bi-tag"></i>
                            </span>
                            <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $category->name) }}" required>
                        </div>
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold">Açıklama</label>
                        <div class="input-group-icon">
                            <span class="input-group-text" style="align-items: flex-start; padding-top: 0.75rem;">
                                <i class="bi bi-text-paragraph"></i>
                            </span>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4">{{ old('description', $category->description) }}</textarea>
                        </div>
                        @error('description')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="status" class="form-label fw-semibold">Durum <span class="text-danger">*</span></label>
                            <div class="input-group-icon">
                                <span class="input-group-text">
                                    <i class="bi bi-toggle-on"></i>
                                </span>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="active" {{ old('status', $category->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ old('status', $category->status) === 'inactive' ? 'selected' : '' }}>Pasif</option>
                                </select>
                            </div>
                            @error('status')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="parent_id" class="form-label fw-semibold">Üst Kategori</label>
                            <div class="input-group-icon">
                                <span class="input-group-text">
                                    <i class="bi bi-folder"></i>
                                </span>
                                <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                                    <option value="">Yok (Ana Kategori)</option>
                                    @foreach($parentCategories as $parent)
                                        <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('parent_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="sort_order" class="form-label fw-semibold">Sıralama</label>
                        <div class="input-group-icon">
                            <span class="input-group-text">
                                <i class="bi bi-sort-numeric-down"></i>
                            </span>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0">
                        </div>
                        @error('sort_order')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Kapak Resmi</h6>
                            @if($category->image)
                                <div class="mb-3 text-center">
                                    <img src="{{ $category->image_url }}" alt="Kapak" class="img-fluid rounded" style="max-height: 200px;">
                                </div>
                            @endif
                            <div class="mb-3">
                                <div class="input-group-icon">
                                    <span class="input-group-text">
                                        <i class="bi bi-image"></i>
                                    </span>
                                    <input type="file" class="form-control @error('cover_image') is-invalid @enderror" 
                                           id="cover_image" name="cover_image" accept="image/*"
                                           onchange="previewImage(this)">
                                </div>
                                @error('cover_image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div id="imagePreview" class="text-center" style="display: none;">
                                <img id="preview" src="" alt="Önizleme" class="img-fluid rounded" style="max-height: 200px;">
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">İptal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Kategoriyi Güncelle
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
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
</script>
@endpush
