@extends('admin.layout')

@section('title', $reference->title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">{{ $reference->title }}</h2>
        <p class="text-muted mb-0">Referans Detayları</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.references.edit', $reference) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-2"></i>Düzenle
        </a>
        <a href="{{ route('admin.references.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Referanslara Dön
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Referans Bilgileri</h5>
                <p><strong>Müşteri:</strong> {{ $reference->client_name ?? '-' }}</p>
                <p><strong>Proje Tipi:</strong> {{ $reference->project_type ?? '-' }}</p>
                <p><strong>Tamamlanma Tarihi:</strong> {{ $reference->completion_date ? $reference->completion_date->format('d.m.Y') : '-' }}</p>
                <p><strong>Durum:</strong> 
                    <span class="badge bg-{{ $reference->is_published ? 'success' : 'secondary' }}">
                        {{ $reference->is_published ? 'Yayında' : 'Taslak' }}
                    </span>
                </p>
                @if($reference->description)
                    <div class="mt-3">
                        <strong>Açıklama:</strong>
                        <p>{{ $reference->description }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Görsel</h5>
                @if($reference->image)
                    <img src="{{ asset($reference->image) }}" alt="{{ $reference->title }}" class="img-fluid rounded">
                @else
                    <p class="text-muted">Görsel yok</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
