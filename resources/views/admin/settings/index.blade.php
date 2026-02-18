@extends('admin.layout')

@section('title', 'Ayarlar')

@section('content')
<div class="mb-4">
    <h4 class="mb-1">Sistem Ayarları</h4>
    <p class="text-muted mb-0">Firma bilgileri ve sistem ayarlarını yönetin</p>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row">
    <!-- Genel Ayarlar -->
    <div class="col-lg-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-building me-2"></i>Firma Bilgileri</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update-group', 'general') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Firma Adı <span class="text-danger">*</span></label>
                            <input type="text" name="settings[company_name]" class="form-control" 
                                   value="{{ $settings['general']?->firstWhere('key', 'company_name')?->value ?? '' }}" required>
                            <div class="form-text">Örn: OBA TİCARET</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Firma Sloganı</label>
                            <input type="text" name="settings[company_tagline]" class="form-control" 
                                   value="{{ $settings['general']?->firstWhere('key', 'company_tagline')?->value ?? '' }}">
                            <div class="form-text">Örn: Yapı Malz. - Mobilya - PVC - Çelik Kapı</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Site Adı</label>
                            <input type="text" name="settings[site_name]" class="form-control" 
                                   value="{{ $settings['general']?->firstWhere('key', 'site_name')?->value ?? '' }}">
                            <div class="form-text">Tam site başlığı (SEO için)</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kuruluş Yılı</label>
                            <input type="text" name="settings[founded_year]" class="form-control" 
                                   value="{{ $settings['general']?->firstWhere('key', 'founded_year')?->value ?? '' }}">
                            <div class="form-text">Örn: 1996</div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Firma Açıklaması</label>
                            <textarea name="settings[company_description]" class="form-control" rows="3">{{ $settings['general']?->firstWhere('key', 'company_description')?->value ?? '' }}</textarea>
                            <div class="form-text">Firmanız hakkında kısa açıklama</div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Site Açıklaması</label>
                            <textarea name="settings[site_description]" class="form-control" rows="2">{{ $settings['general']?->firstWhere('key', 'site_description')?->value ?? '' }}</textarea>
                        </div>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input type="checkbox" name="settings[maintenance_mode]" class="form-check-input" id="maintenance_mode" value="1"
                               {{ ($settings['general']?->firstWhere('key', 'maintenance_mode')?->value ?? '0') === '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="maintenance_mode">Bakım Modu</label>
                        <div class="form-text">Site geçici olarak kapatılır</div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-2"></i>Kaydet
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Medya Ayarları -->
    <div class="col-lg-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-image me-2"></i>Medya / Görsel Ayarları</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update-group', 'media') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Site Logosu</label>
                            @php $currentLogo = $settings['media']?->firstWhere('key', 'site_logo')?->value; @endphp
                            @if($currentLogo)
                                <div class="mb-2">
                                    <img src="{{ asset($currentLogo) }}" alt="Logo" style="max-height: 60px;">
                                </div>
                            @endif
                            <input type="file" name="site_logo" class="form-control" accept="image/*">
                            <div class="form-text">PNG, SVG veya JPG. Header ve footer'da kullanılır.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Hakkımızda Videosu</label>
                            @php $currentVideo = $settings['media']?->firstWhere('key', 'about_video')?->value; @endphp
                            @if($currentVideo)
                                <div class="mb-2">
                                    <span class="badge bg-success"><i class="bi bi-camera-video me-1"></i>Video yüklü</span>
                                    <small class="text-muted ms-2">{{ $currentVideo }}</small>
                                </div>
                            @endif
                            <input type="file" name="about_video" class="form-control" accept="video/mp4,video/webm,video/ogg">
                            <div class="form-text">Ana sayfa hakkımızda bölümündeki video (MP4, max 30MB)</div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-2"></i>Kaydet
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- İletişim Bilgileri -->
    <div class="col-lg-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-telephone me-2"></i>İletişim Bilgileri</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update-group', 'contact') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Telefon <span class="text-danger">*</span></label>
                            <input type="text" name="settings[contact_phone]" class="form-control" 
                                   value="{{ $settings['contact']?->firstWhere('key', 'contact_phone')?->value ?? '' }}" required>
                            <div class="form-text">Örn: 0532 641 53 16</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Telefon 2</label>
                            <input type="text" name="settings[contact_phone2]" class="form-control" 
                                   value="{{ $settings['contact']?->firstWhere('key', 'contact_phone2')?->value ?? '' }}">
                            <div class="form-text">İkinci telefon numarası (opsiyonel)</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">WhatsApp Numarası</label>
                            <input type="text" name="settings[whatsapp_number]" class="form-control" 
                                   value="{{ $settings['contact']?->firstWhere('key', 'whatsapp_number')?->value ?? '' }}">
                            <div class="form-text">Ülke kodu ile (905326415316)</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Çalışma Saatleri</label>
                            <input type="text" name="settings[working_hours]" class="form-control" 
                                   value="{{ $settings['contact']?->firstWhere('key', 'working_hours')?->value ?? '' }}">
                            <div class="form-text">Örn: Pazartesi - Cumartesi: 08:00 - 18:00</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">E-posta <span class="text-danger">*</span></label>
                            <input type="email" name="settings[contact_email]" class="form-control" 
                                   value="{{ $settings['contact']?->firstWhere('key', 'contact_email')?->value ?? '' }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Şehir/İl</label>
                            <input type="text" name="settings[contact_city]" class="form-control" 
                                   value="{{ $settings['contact']?->firstWhere('key', 'contact_city')?->value ?? '' }}">
                            <div class="form-text">Örn: Kadirli / Osmaniye</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">İlçe</label>
                            <input type="text" name="settings[contact_district]" class="form-control" 
                                   value="{{ $settings['contact']?->firstWhere('key', 'contact_district')?->value ?? '' }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">İl</label>
                            <input type="text" name="settings[contact_province]" class="form-control" 
                                   value="{{ $settings['contact']?->firstWhere('key', 'contact_province')?->value ?? '' }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Posta Kodu</label>
                            <input type="text" name="settings[contact_postal_code]" class="form-control" 
                                   value="{{ $settings['contact']?->firstWhere('key', 'contact_postal_code')?->value ?? '' }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Tam Adres <span class="text-danger">*</span></label>
                            <textarea name="settings[contact_address]" class="form-control" rows="2" required>{{ $settings['contact']?->firstWhere('key', 'contact_address')?->value ?? '' }}</textarea>
                            <div class="form-text">Örn: Şehit Halis Şişman Mah. Kamil Kara Bul. No:240 Kadirli/Osmaniye, Osmaniye 80750</div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Google Maps Embed Kodu</label>
                            <textarea name="settings[google_maps_embed]" class="form-control" rows="3">{{ $settings['contact']?->firstWhere('key', 'google_maps_embed')?->value ?? '' }}</textarea>
                            <div class="form-text">Google Maps'ten iframe kodu yapıştırın</div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-2"></i>Kaydet
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Sosyal Medya -->
    <div class="col-lg-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-share me-2"></i>Sosyal Medya</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update-group', 'social') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Facebook URL</label>
                            <input type="url" name="settings[social_facebook]" class="form-control" 
                                   value="{{ $settings['social']?->firstWhere('key', 'social_facebook')?->value ?? '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Instagram URL</label>
                            <input type="url" name="settings[social_instagram]" class="form-control" 
                                   value="{{ $settings['social']?->firstWhere('key', 'social_instagram')?->value ?? '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Twitter/X URL</label>
                            <input type="url" name="settings[social_twitter]" class="form-control" 
                                   value="{{ $settings['social']?->firstWhere('key', 'social_twitter')?->value ?? '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">YouTube URL</label>
                            <input type="url" name="settings[social_youtube]" class="form-control" 
                                   value="{{ $settings['social']?->firstWhere('key', 'social_youtube')?->value ?? '' }}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-2"></i>Kaydet
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- SEO Ayarları -->
    <div class="col-lg-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-search me-2"></i>SEO Ayarları</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update-group', 'seo') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">SEO Başlık</label>
                            <input type="text" name="settings[seo_title]" class="form-control" 
                                   value="{{ $settings['seo']?->firstWhere('key', 'seo_title')?->value ?? '' }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">SEO Açıklama</label>
                            <textarea name="settings[seo_description]" class="form-control" rows="3">{{ $settings['seo']?->firstWhere('key', 'seo_description')?->value ?? '' }}</textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">SEO Anahtar Kelimeler</label>
                            <input type="text" name="settings[seo_keywords]" class="form-control" 
                                   value="{{ $settings['seo']?->firstWhere('key', 'seo_keywords')?->value ?? '' }}">
                            <div class="form-text">Virgülle ayrılmış anahtar kelimeler</div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Google Analytics ID</label>
                            <input type="text" name="settings[google_analytics]" class="form-control" 
                                   value="{{ $settings['seo']?->firstWhere('key', 'google_analytics')?->value ?? '' }}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-2"></i>Kaydet
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
