@extends('admin.layout')

@section('title', 'Kontrol Paneli')

@section('content')
<div class="container-fluid">
<!-- KPI Cards - Primary Row -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="kpi-card-modern" style="background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="kpi-label">Toplam Proje</p>
                    <h2 class="kpi-value">{{ $kpis['total_projects'] }}</h2>
                    <small class="kpi-change text-white-50">
                        <i class="bi bi-briefcase"></i> Tüm projeler
                    </small>
                </div>
                <div class="kpi-icon">
                    <i class="bi bi-briefcase"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="kpi-card-modern" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="kpi-label">Yayında Proje</p>
                    <h2 class="kpi-value">{{ $kpis['published_projects'] }}</h2>
                    <small class="kpi-change text-white-50">
                        <i class="bi bi-check-circle"></i> Aktif projeler
                    </small>
                </div>
                <div class="kpi-icon">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="kpi-card-modern" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="kpi-label">Yeni Mesaj</p>
                    <h2 class="kpi-value">{{ $kpis['new_contacts'] }}</h2>
                    <small class="kpi-change text-white-50">
                        <i class="bi bi-envelope"></i> Okunmamış
                    </small>
                </div>
                <div class="kpi-icon">
                    <i class="bi bi-envelope"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="kpi-card-modern" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p class="kpi-label">Toplam Referans</p>
                    <h2 class="kpi-value">{{ $kpis['total_references'] }}</h2>
                    <small class="kpi-change text-white-50">
                        <i class="bi bi-star"></i> Referanslar
                    </small>
                </div>
                <div class="kpi-icon">
                    <i class="bi bi-star"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Secondary KPIs -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-light p-3 me-3">
                    <i class="bi bi-folder text-primary" style="font-size: 1.5rem;"></i>
                </div>
                <div>
                    <small class="text-muted">Kategoriler</small>
                    <h4 class="mb-0">{{ $kpis['total_categories'] }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-light p-3 me-3">
                    <i class="bi bi-briefcase text-success" style="font-size: 1.5rem;"></i>
                </div>
                <div>
                    <small class="text-muted">Öne Çıkan Proje</small>
                    <h4 class="mb-0">{{ $kpis['featured_projects'] }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-light p-3 me-3">
                    <i class="bi bi-newspaper text-warning" style="font-size: 1.5rem;"></i>
                </div>
                <div>
                    <small class="text-muted">Haber/Duyuru</small>
                    <h4 class="mb-0">{{ $kpis['total_news'] }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-light p-3 me-3">
                    <i class="bi bi-envelope text-info" style="font-size: 1.5rem;"></i>
                </div>
                <div>
                    <small class="text-muted">Toplam Mesaj</small>
                    <h4 class="mb-0">{{ $kpis['total_contacts'] }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Services & Applications Row -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-light p-3 me-3">
                    <i class="bi bi-briefcase text-primary" style="font-size: 1.5rem;"></i>
                </div>
                <div>
                    <small class="text-muted">Toplam Hizmet</small>
                    <h4 class="mb-0">{{ $kpis['total_services'] }}</h4>
                    <small class="text-success">{{ $kpis['active_services'] }} aktif</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-circle bg-light p-3 me-3">
                    <i class="bi bi-award text-success" style="font-size: 1.5rem;"></i>
                </div>
                <div>
                    <small class="text-muted">Öne Çıkan Proje</small>
                    <h4 class="mb-0">{{ $kpis['featured_projects'] }}</h4>
                    <small class="text-success">Aktif</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Son Projeler -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-briefcase me-2 text-primary"></i>Son Projeler
                </h5>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-sm btn-outline-primary">
                    Tümünü Gör <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Proje</th>
                                <th>Kategori</th>
                                <th>Konum</th>
                                <th>Durum</th>
                                <th>Tarih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentProjects as $project)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.projects.show', $project) }}" class="fw-bold text-decoration-none">
                                            {{ $project->title }}
                                        </a>
                                    </td>
                                    <td>{{ $project->category ? $project->category->name : '-' }}</td>
                                    <td>{{ $project->location ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $project->is_published ? 'success' : 'secondary' }}">
                                            {{ $project->is_published ? 'Yayında' : 'Taslak' }}
                                        </span>
                                    </td>
                                    <td class="text-muted small">{{ $project->created_at->format('d.m.Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                        <p class="mb-0 mt-2">Henüz proje yok</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Son İletişim Mesajları -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-envelope me-2 text-warning"></i>Son Mesajlar
                </h5>
            </div>
            <div class="card-body">
                @forelse($recentContacts as $contact)
                    <div class="d-flex align-items-start mb-3 {{ !$loop->last ? 'pb-3 border-bottom' : '' }}">
                        <div class="flex-grow-1">
                            <div class="fw-bold">{{ $contact->name }}</div>
                            <small class="text-muted">{{ Str::limit($contact->message, 50) }}</small>
                            <div class="mt-1">
                                <span class="badge bg-{{ $contact->status === 'new' ? 'warning' : 'info' }} badge-sm">
                                    {{ $contact->status === 'new' ? 'Yeni' : 'Okundu' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-envelope" style="font-size: 2rem;"></i>
                        <p class="mb-0 mt-2">Henüz mesaj yok</p>
                    </div>
                @endforelse
                <div class="mt-3">
                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-outline-primary w-100">
                        Tüm Mesajlar <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-2">
    <!-- Son Referanslar -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-star me-2 text-warning"></i>Son Referanslar
                </h5>
                <a href="{{ route('admin.references.index') }}" class="btn btn-sm btn-outline-primary">
                    Tümünü Gör <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body">
                @forelse($recentReferences as $reference)
                    <div class="d-flex align-items-center mb-3 {{ !$loop->last ? 'pb-3 border-bottom' : '' }}">
                        @if($reference->image)
                            <img src="{{ asset($reference->image) }}" 
                                 alt="{{ $reference->title }}" 
                                 class="rounded me-3"
                                 style="width: 60px; height: 60px; object-fit: cover;">
                        @endif
                        <div class="flex-grow-1">
                            <div class="fw-bold">{{ $reference->title }}</div>
                            <small class="text-muted">{{ $reference->client_name ?? '-' }}</small>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-star" style="font-size: 2rem;"></i>
                        <p class="mb-0 mt-2">Henüz referans yok</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Son Haberler/Duyurular -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-newspaper me-2 text-info"></i>Son Haberler/Duyurular
                </h5>
                <a href="{{ route('admin.news.index') }}" class="btn btn-sm btn-outline-primary">
                    Tümünü Gör <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body">
                @forelse($recentNews as $news)
                    <div class="mb-3 {{ !$loop->last ? 'pb-3 border-bottom' : '' }}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="fw-bold">{{ $news->title }}</div>
                                <small class="text-muted">{{ $news->excerpt ? Str::limit($news->excerpt, 60) : '-' }}</small>
                                <div class="mt-1">
                                    <span class="badge bg-{{ $news->type === 'news' ? 'primary' : 'warning' }} badge-sm">
                                        {{ $news->type === 'news' ? 'Haber' : 'Duyuru' }}
                                    </span>
                                    <span class="text-muted small ms-2">{{ $news->published_at ? $news->published_at->format('d.m.Y') : '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-newspaper" style="font-size: 2rem;"></i>
                        <p class="mb-0 mt-2">Henüz haber/duyuru yok</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
</div>

@endsection
