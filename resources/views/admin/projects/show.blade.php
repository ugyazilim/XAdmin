@extends('admin.layout')

@section('title', $project->title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">{{ $project->title }}</h2>
        <p class="text-muted mb-0">Proje Detayları</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-2"></i>Düzenle
        </a>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Projelere Dön
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Proje Bilgileri</h5>
                <p><strong>Kategori:</strong> {{ $project->category ? $project->category->name : '-' }}</p>
                <p><strong>Konum:</strong> {{ $project->location ?? '-' }}</p>
                <p><strong>Müşteri:</strong> {{ $project->client_name ?? '-' }}</p>
                <p><strong>Proje Tarihi:</strong> {{ $project->project_date ? $project->project_date->format('d.m.Y') : '-' }}</p>
                <p><strong>Durum:</strong> 
                    <span class="badge bg-{{ $project->is_published ? 'success' : 'secondary' }}">
                        {{ $project->is_published ? 'Yayında' : 'Taslak' }}
                    </span>
                </p>
                @if($project->description)
                    <p><strong>Açıklama:</strong> {{ $project->description }}</p>
                @endif
                @if($project->content)
                    <div class="mt-3">
                        <strong>İçerik:</strong>
                        <div>{!! $project->content !!}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Görsel</h5>
                @if($project->image)
                    <img src="{{ asset($project->image) }}" alt="{{ $project->title }}" class="img-fluid rounded">
                @else
                    <p class="text-muted">Görsel yok</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
