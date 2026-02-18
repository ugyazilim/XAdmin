@extends('admin.layout')

@section('title', $page->title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1" style="font-weight: 700; color: #1f2937;">{{ $page->title }}</h2>
        <p class="text-muted mb-0">
            <code class="bg-light px-2 py-1 rounded">/{{ $page->slug }}</code>
        </p>
    </div>
    <div>
        <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-primary me-2">
            <i class="bi bi-pencil me-1"></i> Düzenle
        </a>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Geri
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm mb-4">
            @if($page->featured_image)
                <img src="{{ asset($page->featured_image) }}" alt="{{ $page->title }}" class="card-img-top" style="max-height: 300px; object-fit: cover;">
            @endif
            <div class="card-body">
                <div class="prose content-area">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Sayfa Bilgileri</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted d-block">Durum</small>
                    @if($page->is_published)
                        <span class="badge bg-success">Yayında</span>
                    @else
                        <span class="badge bg-warning">Taslak</span>
                    @endif
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">Şablon</small>
                    <span class="fw-semibold">{{ ucfirst($page->template) }}</span>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">Sıralama</small>
                    <span class="fw-semibold">{{ $page->sort_order }}</span>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">Oluşturulma</small>
                    <span class="fw-semibold">{{ $page->created_at->format('d.m.Y H:i') }}</span>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">Son Güncelleme</small>
                    <span class="fw-semibold">{{ $page->updated_at->format('d.m.Y H:i') }}</span>
                </div>
            </div>
        </div>

        @if($page->meta_title || $page->meta_description)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">SEO Bilgileri</h5>
                </div>
                <div class="card-body">
                    @if($page->meta_title)
                        <div class="mb-3">
                            <small class="text-muted d-block">Meta Başlık</small>
                            <span class="fw-semibold">{{ $page->meta_title }}</span>
                        </div>
                    @endif

                    @if($page->meta_description)
                        <div>
                            <small class="text-muted d-block">Meta Açıklama</small>
                            <span>{{ $page->meta_description }}</span>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
