@extends('admin.layout')

@section('title', 'Yeni Sayfa')

@push('styles')
<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css" rel="stylesheet">
<style>
    .note-editor.note-frame {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
    }
    .note-editor .note-toolbar {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1" style="font-weight: 700; color: #1f2937;">Yeni Sayfa</h2>
        <p class="text-muted mb-0">Yeni bir statik sayfa oluşturun</p>
    </div>
    <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Geri
    </a>
</div>

<form action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Sayfa Başlığı <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>


                    <div class="mb-3">
                        <label class="form-label">İçerik</label>
                        <textarea name="content" id="summernote" class="form-control @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
                        @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">SEO Ayarları</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Meta Başlık</label>
                        <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}" maxlength="255">
                        <small class="text-muted">Arama motorlarında görünecek başlık</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Meta Açıklama</label>
                        <textarea name="meta_description" class="form-control" rows="2" maxlength="500">{{ old('meta_description') }}</textarea>
                        <small class="text-muted">Arama motorlarında görünecek açıklama</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Yayın Ayarları</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Şablon <span class="text-danger">*</span></label>
                        <select name="template" class="form-select @error('template') is-invalid @enderror" required>
                            @foreach($templates as $key => $label)
                                <option value="{{ $key }}" {{ old('template', 'default') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('template') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Sıralama</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Öne Çıkan Görsel</label>
                        <input type="file" name="featured_image" class="form-control @error('featured_image') is-invalid @enderror" accept="image/*">
                        @error('featured_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <hr>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_published">Yayınla</label>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-lg me-1"></i> Kaydet
                </button>
                <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">İptal</a>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/lang/summernote-tr-TR.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            lang: 'tr-TR',
            height: 400,
            placeholder: 'Sayfa içeriğini buraya yazın...',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video', 'hr']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Georgia', 'Helvetica', 'Impact', 'Tahoma', 'Times New Roman', 'Verdana'],
            fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '22', '24', '28', '32', '36', '48', '64'],
            callbacks: {
                onImageUpload: function(files) {
                    // Görsel yükleme için basit base64 dönüşümü
                    for (let i = 0; i < files.length; i++) {
                        let reader = new FileReader();
                        reader.onloadend = function() {
                            let img = $('<img>').attr('src', reader.result);
                            $('#summernote').summernote('insertNode', img[0]);
                        };
                        reader.readAsDataURL(files[i]);
                    }
                }
            }
        });
    });
</script>
@endpush
