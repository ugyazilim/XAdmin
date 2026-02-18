@extends('admin.layout')

@section('title', 'Kullanıcı Detayları')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1" style="font-weight: 700; color: #1f2937;">{{ $user->name }}</h2>
        <p class="text-muted mb-0">Kullanıcı detayları ve aktiviteleri</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-2"></i>Düzenle
        </a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Geri
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Kullanıcı Bilgileri</h5>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">İsim:</dt>
                    <dd class="col-sm-9">{{ $user->name }}</dd>

                    <dt class="col-sm-3">E-posta:</dt>
                    <dd class="col-sm-9">{{ $user->email }}</dd>

                    <dt class="col-sm-3">Telefon:</dt>
                    <dd class="col-sm-9">{{ $user->phone ?? '-' }}</dd>

                    <dt class="col-sm-3">Rol:</dt>
                    <dd class="col-sm-9">
                        <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }}">
                            {{ $user->role === 'admin' ? 'Admin' : 'Personel' }}
                        </span>
                    </dd>

                    <dt class="col-sm-3">Durum:</dt>
                    <dd class="col-sm-9">
                        <span class="badge bg-{{ $user->is_active ? 'success' : 'secondary' }}">
                            {{ $user->is_active ? 'Aktif' : 'Pasif' }}
                        </span>
                    </dd>

                    <dt class="col-sm-3">Üyelik Tarihi:</dt>
                    <dd class="col-sm-9">{{ $user->created_at->format('d M Y') }}</dd>
                </dl>
            </div>
        </div>

    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-gear me-2"></i>Hızlı İşlemler</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary">
                        <i class="bi bi-pencil me-2"></i>Kullanıcıyı Düzenle
                    </a>
                    @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Emin misiniz?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="bi bi-trash me-2"></i>Kullanıcıyı Sil
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
