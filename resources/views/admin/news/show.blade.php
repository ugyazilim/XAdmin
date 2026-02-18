@extends('admin.layout')

@section('title', $news->title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">{{ $news->title }}</h2>
        <p class="text-muted mb-0">Haber/Duyuru Detayları</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-2"></i>Düzenle
        </a>
        <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Haber/Duyurulara Dön
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">İçerik Bilgileri</h5>
                <p><strong>Tip:</strong> 
                    <span class="badge bg-{{ $news->type === 'news' ? 'primary' : 'warning' }}">
                        {{ $news->type === 'news' ? 'Haber' : 'Duyuru' }}
                    </span>
                </p>
                <p><strong>Yayın Tarihi:</strong> {{ $news->published_at ? $news->published_at->format('d.m.Y') : '-' }}</p>
                <p><strong>Durum:</strong> 
                    <span class="badge bg-{{ $news->is_published ? 'success' : 'secondary' }}">
                        {{ $news->is_published ? 'Yayında' : 'Taslak' }}
                    </span>
                </p>
                @if($news->excerpt)
                    <p><strong>Özet:</strong> {{ $news->excerpt }}</p>
                @endif
                @if($news->content)
                    <div class="mt-3">
                        <strong>İçerik:</strong>
                        <div>{!! $news->content !!}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Öne Çıkan Görsel</h5>
                @if($news->featured_image)
                    <img src="{{ asset($news->featured_image) }}" alt="{{ $news->title }}" class="img-fluid rounded">
                @else
                    <p class="text-muted">Görsel yok</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
