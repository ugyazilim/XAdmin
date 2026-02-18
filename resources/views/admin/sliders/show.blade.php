@extends('admin.layout')

@section('title', 'Slider Detayları')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1" style="font-weight: 700; color: #1f2937;">{{ $slider->title ?? 'Slider' }}</h2>
        <p class="text-muted mb-0">Slider detayları ve bilgileri</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-2"></i>Düzenle
        </a>
        <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Geri
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Slider Bilgileri</h5>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    @if($slider->title)
                        <dt class="col-sm-3">Başlık:</dt>
                        <dd class="col-sm-9">{{ $slider->title }}</dd>
                    @endif

                    @if($slider->description)
                        <dt class="col-sm-3">Açıklama:</dt>
                        <dd class="col-sm-9">{{ $slider->description }}</dd>
                    @endif

                    @if($slider->link)
                        <dt class="col-sm-3">Link:</dt>
                        <dd class="col-sm-9">
                            <a href="{{ $slider->link }}" target="_blank" class="text-primary">
                                {{ $slider->link }} <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                        </dd>
                    @endif

                    @if($slider->button_text)
                        <dt class="col-sm-3">Buton Metni:</dt>
                        <dd class="col-sm-9">
                            <span class="badge bg-info">{{ $slider->button_text }}</span>
                        </dd>
                    @endif

                    <dt class="col-sm-3">Durum:</dt>
                    <dd class="col-sm-9">
                        <span class="badge bg-{{ $slider->is_active ? 'success' : 'secondary' }}">
                            {{ $slider->is_active ? 'Aktif' : 'Pasif' }}
                        </span>
                    </dd>

                    <dt class="col-sm-3">Sıralama:</dt>
                    <dd class="col-sm-9">{{ $slider->sort_order }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-image me-2"></i>Slider Görseli</h5>
            </div>
            <div class="card-body text-center">
                <img src="{{ $slider->image_url }}" alt="Slider" class="img-fluid rounded">
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-gear me-2"></i>Hızlı İşlemler</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-outline-primary">
                        <i class="bi bi-pencil me-2"></i>Slider'ı Düzenle
                    </a>
                    <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" onsubmit="return confirm('Emin misiniz?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-trash me-2"></i>Slider'ı Sil
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

