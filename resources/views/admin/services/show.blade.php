@extends('admin.layout')

@section('title', $service->title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">{{ $service->title }}</h2>
        <p class="text-muted mb-0">Hizmet Detayları</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.services.edit', $service) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-2"></i>Düzenle
        </a>
        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Hizmetlere Dön
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Hizmet Bilgileri</h5>
                <p><strong>Slug:</strong> {{ $service->slug }}</p>
                <p><strong>İkon:</strong> {{ $service->icon ?? '-' }}</p>
                <p><strong>Sıralama:</strong> {{ $service->sort_order }}</p>
                <p><strong>Durum:</strong> 
                    <span class="badge bg-{{ $service->is_active ? 'success' : 'secondary' }}">
                        {{ $service->is_active ? 'Aktif' : 'Pasif' }}
                    </span>
                </p>
                @if($service->short_description)
                    <div class="mt-3">
                        <strong>Kısa Açıklama:</strong>
                        <p>{{ $service->short_description }}</p>
                    </div>
                @endif
                @if($service->content)
                    <div class="mt-3">
                        <strong>İçerik:</strong>
                        <div>{!! $service->content !!}</div>
                    </div>
                @endif
                @if($service->meta_title || $service->meta_description)
                    <div class="mt-3">
                        <h6>SEO Bilgileri</h6>
                        <p><strong>Meta Başlık:</strong> {{ $service->meta_title ?? '-' }}</p>
                        <p><strong>Meta Açıklama:</strong> {{ $service->meta_description ?? '-' }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Öne Çıkan Görsel</h5>
                @if($service->featured_image)
                    <img src="{{ asset($service->featured_image) }}" alt="{{ $service->title }}" class="img-fluid rounded">
                @else
                    <p class="text-muted">Görsel yok</p>
                @endif
            </div>
        </div>

        @if($service->images->count() > 0)
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Hizmet Görselleri ({{ $service->images->count() }})</h5>
                <div class="row g-2">
                    @foreach($service->images as $image)
                    <div class="col-6">
                        <img src="{{ asset($image->image) }}" alt="{{ $image->alt_text ?? $service->title }}" class="img-fluid rounded" style="max-height: 100px; width: 100%; object-fit: cover;">
                        @if($image->alt_text)
                            <small class="d-block text-muted mt-1">{{ $image->alt_text }}</small>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
