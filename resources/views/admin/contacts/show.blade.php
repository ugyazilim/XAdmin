@extends('admin.layout')

@section('title', 'İletişim Mesajı')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">İletişim Mesajı</h2>
        <p class="text-muted mb-0">{{ $contact->subject ?? 'Konu yok' }}</p>
    </div>
    <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Mesajlara Dön
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Mesaj Detayları</h5>
                <p><strong>Ad Soyad:</strong> {{ $contact->name }}</p>
                <p><strong>E-posta:</strong> <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>
                @if($contact->phone)
                    <p><strong>Telefon:</strong> <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a></p>
                @endif
                @if($contact->subject)
                    <p><strong>Konu:</strong> {{ $contact->subject }}</p>
                @endif
                <p><strong>Durum:</strong> 
                    <span class="badge bg-{{ $contact->status === 'new' ? 'warning' : ($contact->status === 'read' ? 'info' : ($contact->status === 'replied' ? 'success' : 'secondary')) }}">
                        @if($contact->status === 'new')
                            Yeni
                        @elseif($contact->status === 'read')
                            Okundu
                        @elseif($contact->status === 'replied')
                            Yanıtlandı
                        @else
                            Arşivlendi
                        @endif
                    </span>
                </p>
                <p><strong>Tarih:</strong> {{ $contact->created_at->format('d.m.Y H:i') }}</p>
                <div class="mt-3">
                    <strong>Mesaj:</strong>
                    <div class="bg-light p-3 rounded mt-2">
                        {{ $contact->message }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Mesaj Yönetimi</h5>
                <form action="{{ route('admin.contacts.update', $contact) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Durum</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="new" {{ old('status', $contact->status) === 'new' ? 'selected' : '' }}>Yeni</option>
                            <option value="read" {{ old('status', $contact->status) === 'read' ? 'selected' : '' }}>Okundu</option>
                            <option value="replied" {{ old('status', $contact->status) === 'replied' ? 'selected' : '' }}>Yanıtlandı</option>
                            <option value="archived" {{ old('status', $contact->status) === 'archived' ? 'selected' : '' }}>Arşivlendi</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Notlar</label>
                        <textarea class="form-control @error('admin_notes') is-invalid @enderror" 
                                  id="admin_notes" name="admin_notes" rows="5">{{ old('admin_notes', $contact->admin_notes) }}</textarea>
                        @error('admin_notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-circle me-2"></i>Güncelle
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
