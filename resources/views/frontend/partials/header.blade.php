
<!DOCTYPE html>
<html lang="tr">

<head>
	<!-- Meta Başlangıcı -->
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta name="description" content="{{ $site->seo_description ?: $site->company_name.' | '.$site->company_tagline }}"/>
	<meta name="keywords" content="{{ $site->seo_keywords ?: '' }}"/>
	<meta name="author" content="{{ $site->company_name }}">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ $site->seo_title ?: $site->company_name.' | '.$site->company_tagline.' | '.$site->contact_city }}</title>
	<!-- Favicons -->
	<link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ asset('assets/css/fontawesome.css') }}">
	<!-- Flaticon -->
	<link rel="stylesheet" href="{{ asset('assets/font/flaticon_flexitype.css') }}">	
	<!-- Animate CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
	<!-- Swiper -->
	<link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
	<!-- Magnific -->
	<link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
	<!-- Özel CSS -->
	<link rel="stylesheet" href="{{ asset('assets/sass/style.css') }}"> 
	@stack('styles')
	<style>
		.header__area-menubar-left-logo a img {
			max-width: 282px !important;
			position: relative;
			z-index: 9999;
		}
		
		.switch__tab-icon {
			display: none !important;
		}
		
		@media (max-width: 768px) {
			.header__four {
				background: #ffffff !important;
			}
			
			.header__four .menu__bar i,
			.header__four .header__area-menubar-right-search-icon i {
				color: #000000 !important;
			}
			
			.menu__bar-popup.show {
				background: #ffffff !important;
			}
			
			.menu__bar-popup.show * {
				color: #000000 !important;
			}
			
			.menu__bar-popup-top .logo img {
				max-width: none !important;
			}
			
			.header__area-menubar-right-sidebar-popup {
				background: #ffffff !important;
			}
			
			.header__area-menubar-right-sidebar-popup * {
				color: #000000 !important;
			}
			
			.header__area-menubar-right-sidebar-popup .logo img {
				max-width: none !important;
			}
			
			.header__area-menubar-right-sidebar-popup i {
				color: #000000 !important;
			}
		}
		
		@media (min-width: 769px) {
			.banner__two .banner__two-area.swiper-slide {
				padding-bottom: 544px !important;
				padding-top: 70px !important;
			}
		}
	</style>
</head>

<body>
	<!-- Yükleyici Başlangıç -->
	<div class="theme-loader">
		<div class="spinner">
			<div class="spinner-bounce one"></div>
			<div class="spinner-bounce two"></div>
			<div class="spinner-bounce three"></div>
		</div>
	</div>
	<!-- Yükleyici Bitiş -->
	<!-- Karanlık/Parlak Mod Başlangıç -->
	<div class="switch__tab">
		<div class="switch__tab-icon">
		  <div class="switch__tab-open"><i class="fa-sharp fa-light fa-gear"></i></div>
		  <div class="switch__tab-close"><i class="fal fa-times"></i></div>
		</div>	
		<div class="switch__tab-area">	
			<div class="switch__tab-area-item">
				<h5>Mod</h5>
				<div class="switch__tab-area-item-button type-dark-mode">
					<button class="active" data-mode="light">Açık</button>
					<button data-mode="dark-mode">Koyu</button>
				</div>
			</div>
			<div class="switch__tab-area-item">
				<h5>Özel İmleç</h5>
				<div class="switch__tab-area-item-buttons" id="cursor_style">
					<button data-cursor="1">Evet</button>
					<button data-cursor="2" class="active">Hayır</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Karanlık/Parlak Mod Bitiş -->
	<!-- Arama Kutusu Başlangıç -->
	<div class="header__area-menubar-right-search-box">
		<form action="{{ route('search') }}" method="GET">
			<input type="search" name="q" placeholder="Blog veya hizmet ara..." value="{{ request('q') }}">
			<button type="submit"><i class="fal fa-search"></i></button>
		</form> 
		<span class="header__area-menubar-right-search-box-icon"><i class="fal fa-times"></i></span>
	</div>
	<!-- Arama Kutusu Bitiş -->
	<!-- Hamburger Menü Başlangıç -->
	<div class="header__area-menubar-right-sidebar-popup">
		<div class="sidebar-close-btn"><i class="fal fa-times"></i></div>
		<div class="header__area-menubar-right-sidebar-popup-logo">
			<a href="{{ url('/') }}"> <img src="{{ $site->site_logo ? asset($site->site_logo) : asset('assets/img/logo.png') }}" alt="{{ $site->company_name }}" style="height: 50px; width: auto;"></a>
		</div>
		<p>{{ $site->company_description }}</p>
		<div class="header__area-menubar-right-sidebar-popup-contact">
			<h4 class="mb-30">İletişim</h4>
			@if($site->contact_phone)
			<div class="header__area-menubar-right-sidebar-popup-contact-item">
				<div class="header__area-menubar-right-sidebar-popup-contact-item-content">
					<span>Telefon:</span>
					<h6 style="display: flex; flex-direction: column; gap: 8px; margin-top: 5px;">
						<a href="tel:{{ preg_replace('/\s+/', '', $site->contact_phone) }}" style="display: flex; align-items: center; gap: 8px;">
							<i class="flaticon-phone" style="font-size: 14px;"></i>
							<span>{{ $site->contact_phone }}</span>
						</a>
						@if($site->contact_phone2)
						<a href="tel:{{ preg_replace('/\s+/', '', $site->contact_phone2) }}" style="display: flex; align-items: center; gap: 8px;">
							<i class="flaticon-phone" style="font-size: 14px;"></i>
							<span>{{ $site->contact_phone2 }}</span>
						</a>
						@endif
					</h6>
				</div>
			</div>
			@endif
			@if($site->contact_email)
			<div class="header__area-menubar-right-sidebar-popup-contact-item">
				<div class="header__area-menubar-right-sidebar-popup-contact-item-icon">
					<i class="flaticon-email-3"></i>
				</div>
				<div class="header__area-menubar-right-sidebar-popup-contact-item-content">
					<span>E-posta:</span>
					<h6><a href="mailto:{{ $site->contact_email }}">{{ $site->contact_email }}</a></h6>
				</div>
			</div>
			@endif
			@if($site->contact_address)
			<div class="header__area-menubar-right-sidebar-popup-contact-item">
				<div class="header__area-menubar-right-sidebar-popup-contact-item-icon">
					<i class="flaticon-location-1"></i>
				</div>
				<div class="header__area-menubar-right-sidebar-popup-contact-item-content">
					<span>Adres:</span>
					<h6><a href="https://www.google.com/maps?q={{ urlencode($site->contact_address) }}" target="_blank" rel="noopener noreferrer">{{ $site->contact_address }}</a></h6>
				</div>
			</div>
			@endif
		</div>
		<div class="header__area-menubar-right-sidebar-popup-social">
			<ul>
				@if($site->whatsapp_number)<li><a href="https://wa.me/{{ $site->whatsapp_number }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-whatsapp"></i></a></li>@endif
				@if($site->social_facebook)<li><a href="{{ $site->social_facebook }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook-f"></i></a></li>@endif
				@if($site->social_instagram)<li><a href="{{ $site->social_instagram }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a></li>@endif
				@if($site->social_twitter)<li><a href="{{ $site->social_twitter }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-twitter"></i></a></li>@endif
				@if($site->social_youtube)<li><a href="{{ $site->social_youtube }}" target="_blank" rel="noopener noreferrer"><i class="fab fa-youtube"></i></a></li>@endif
			</ul>							
		</div>
	</div>
	<div class="sidebar-overlay"></div>
	<!-- Hamburger Menü Bitiş -->
	<!-- Mobil Menü Başlangıç -->
	<div class="menu__bar-popup">
		<div class="menu__bar-popup-top">
			<div class="logo"><a href="{{ url('/') }}"><img src="{{ $site->site_logo ? asset($site->site_logo) : asset('assets/img/logo.png') }}" alt="{{ $site->company_name }}" style="height: 50px; width: auto;"></a></div>			
			<div class="close"><i class="fal fa-times"></i></div>
		</div>
		<div class="vertical-menu">
			<div class="vertical_menu">
				<!-- Menü burada otomatik olarak Javascript ile gelecek / Header ile aynı menü -->
			</div>
		</div>
	</div>
	<div class="menu__bar-popup-overlay"></div>
	<!-- Mobil Menü Bitiş -->
	<!-- Header Alanı Başlangıç -->
	<div class="header__four">
		<div class="custom_container">
			<div class="header__area-menubar">
				<div class="header__area-menubar-left one">
					<div class="header__area-menubar-left-logo">
                        <a href="{{ url('/') }}"><img src="{{ $site->site_logo ? asset($site->site_logo) : asset('assets/img/logo.png') }}" alt="{{ $site->company_name }}" style="height: 50px; width: auto;"></a>
                    </div>
				</div>
				<div class="header__area-menubar-center">
					<div class="header__area-menubar-center-menu">
                        <ul id="mobilemenu">
                            <li><a href="{{ url('/') }}">Anasayfa</a></li>
							<li class="menu-item-has-children"><a href="{{ route('services') }}">Hizmetlerimiz</a>
								<ul class="sub-menu">
									@if(isset($headerCategories) && $headerCategories->count() > 0)
										@foreach($headerCategories as $category)
										<li><a href="{{ route('services', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>
										@endforeach
									@else
										{{-- Fallback: Eski statik menü --}}
										<li><a href="{{ route('services') }}">Tüm Hizmetler</a></li>
									@endif
								</ul>
							</li>
							<li class="menu-item-has-children"><a href="{{ route('about') }}">Kurumsal</a>
								<ul class="sub-menu">
									<li><a href="{{ route('about') }}">Hakkımızda</a></li>
									<li><a href="{{ route('vision') }}">Vizyon</a></li>
									<li><a href="{{ route('mission') }}">Misyon</a></li>
								</ul>
							</li>
							<li><a href="{{ route('projects') }}">Projelerimiz</a></li>
							<li><a href="{{ route('references') }}">Referanslar</a></li>
							<li><a href="{{ route('news') }}">Haberler</a></li>
                            <li><a href="{{ route('contact') }}">İletişim</a></li>
						</ul>
					</div>
				</div>
				<div class="header__area-menubar-right">
					<div class="header__area-menubar-right-search">
						<div class="search">	
							<span class="header__area-menubar-right-search-icon open"><i class="fal fa-search"></i></span>
						</div>
					</div>
					<div class="header__area-menubar-right-btn one">
						<div class="item_bounce">
                            <a class="build_button" href="{{ route('contact') }}">Teklif Al <i class="flaticon-right-up"></i></a>
                        </div>
					</div>
					<div class="header__area-menubar-right-sidebar">
						<div class="header__area-menubar-right-sidebar-icon">
							<i class="flaticon-menu-6"></i>
						</div>
					</div>
					<div class="header__area-menubar-right-responsive-menu menu__bar">
						<i class="flaticon-menu-3"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
