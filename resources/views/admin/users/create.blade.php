@extends('admin.layout')

@section('title', 'Yeni Kullanıcı Oluştur')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1" style="font-weight: 700; color: #1f2937;">Yeni Kullanıcı Oluştur</h2>
        <p class="text-muted mb-0">Yeni bir sistem kullanıcısı ekleyin</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Geri
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-person-plus me-2"></i>Kullanıcı Bilgileri</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="form-label fw-semibold">İsim <span class="text-danger">*</span></label>
                <div class="input-group-icon">
                    <span class="input-group-text">
                        <i class="bi bi-person"></i>
                    </span>
                    <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" required>
                </div>
                @error('name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="form-label fw-semibold">E-posta <span class="text-danger">*</span></label>
                <div class="input-group-icon">
                    <span class="input-group-text">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}" required>
                </div>
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="form-label fw-semibold">Şifre <span class="text-danger">*</span></label>
                <div class="input-group-icon">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password" name="password" required minlength="8">
                </div>
                <small class="text-muted">Minimum 8 karakter</small>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label fw-semibold">Şifre Tekrar <span class="text-danger">*</span></label>
                <div class="input-group-icon">
                    <span class="input-group-text">
                        <i class="bi bi-lock-fill"></i>
                    </span>
                    <input type="password" class="form-control" 
                           id="password_confirmation" name="password_confirmation" required>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">İptal</a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Kullanıcı Oluştur
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
