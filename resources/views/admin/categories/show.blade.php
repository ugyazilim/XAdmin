@extends('admin.layout')

@section('title', 'Kategori Detayları')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1" style="font-weight: 700; color: #1f2937;">{{ $category->name }}</h2>
        <p class="text-muted mb-0">Kategori detayları ve bilgileri</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-2"></i>Düzenle
        </a>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Geri
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Kategori Bilgileri</h5>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">İsim:</dt>
                    <dd class="col-sm-9">{{ $category->name }}</dd>

                    <dt class="col-sm-3">Slug:</dt>
                    <dd class="col-sm-9"><code>{{ $category->slug }}</code></dd>

                    <dt class="col-sm-3">Durum:</dt>
                    <dd class="col-sm-9">
                        <span class="badge bg-{{ $category->status === 'active' ? 'success' : 'secondary' }}">
                            {{ $category->status === 'active' ? 'Aktif' : 'Pasif' }}
                        </span>
                    </dd>

                    @if($category->parent)
                        <dt class="col-sm-3">Üst Kategori:</dt>
                        <dd class="col-sm-9">
                            <a href="{{ route('admin.categories.show', $category->parent) }}" class="text-decoration-none">
                                {{ $category->parent->name }}
                            </a>
                        </dd>
                    @endif

                    <dt class="col-sm-3">Sıralama:</dt>
                    <dd class="col-sm-9">{{ $category->sort_order }}</dd>

                    @if($category->description)
                        <dt class="col-sm-3">Açıklama:</dt>
                        <dd class="col-sm-9">{{ $category->description }}</dd>
                    @endif
                </dl>
            </div>
        </div>

        @if($category->children->count() > 0)
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-folder me-2"></i>Alt Kategoriler</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($category->children as $child)
                            <a href="{{ route('admin.categories.show', $child) }}" class="list-group-item list-group-item-action">
                                {{ $child->name }}
                                <span class="badge bg-{{ $child->status === 'active' ? 'success' : 'secondary' }} float-end">
                                    {{ $child->status === 'active' ? 'Aktif' : 'Pasif' }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-folder me-2"></i>Projeler ({{ $category->projects->count() }})</h5>
                <a href="{{ route('admin.projects.create') }}?category_id={{ $category->id }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>Proje Ekle
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Proje</th>
                                <th>Lokasyon</th>
                                <th>Tarih</th>
                                <th>Durum</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($category->projects as $project)
                                <tr>
                                    <td>{{ $project->title }}</td>
                                    <td>{{ $project->location ?? '-' }}</td>
                                    <td>{{ $project->project_date ? $project->project_date->format('d.m.Y') : '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $project->is_published ? 'success' : 'secondary' }}">
                                            {{ $project->is_published ? 'Yayında' : 'Taslak' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Bu kategoride proje yok</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-image me-2"></i>Kapak Resmi</h5>
            </div>
            <div class="card-body text-center">
                @php
                    $coverUrl = null;
                    if (class_exists(\Spatie\MediaLibrary\MediaCollections\Models\Media::class)) {
                        $coverUrl = $category->getFirstMediaUrl('cover');
                    }
                @endphp
                @if($coverUrl)
                    <img src="{{ $coverUrl }}" alt="Kapak" class="img-fluid rounded">
                @else
                    <div class="text-muted py-5">
                        <i class="bi bi-image" style="font-size: 3rem;"></i>
                        <p class="mt-2 mb-0">Kapak resmi yok</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-gear me-2"></i>Hızlı İşlemler</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-outline-primary">
                        <i class="bi bi-pencil me-2"></i>Kategoriyi Düzenle
                    </a>
                    <a href="{{ route('admin.projects.create') }}?category_id={{ $category->id }}" class="btn btn-outline-success">
                        <i class="bi bi-plus-circle me-2"></i>Proje Ekle
                    </a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Emin misiniz? Bu kategori içindeki tüm projeler de silinecektir.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-trash me-2"></i>Kategoriyi Sil
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
