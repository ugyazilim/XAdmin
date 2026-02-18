@include('frontend.partials.header')
@php
    use Illuminate\Support\Str;
@endphp
	<!-- Header Area End -->
	<!-- Banner Area Start -->
    <div class="banner__two swiper slide_three">
        <div class="swiper-wrapper">
            @forelse($sliders as $slider)
            <div class="banner__two-area swiper-slide">	
                <div class="banner__two-area-image">
                    @if($slider->isVideo() && $slider->video)
                        <!-- Video Slider -->
                        <video autoplay muted loop playsinline style="width: 100%; height: 100%; object-fit: cover;">
                            <source src="{{ asset($slider->video) }}" type="video/{{ pathinfo($slider->video, PATHINFO_EXTENSION) === 'mp4' ? 'mp4' : (pathinfo($slider->video, PATHINFO_EXTENSION) === 'webm' ? 'webm' : 'ogg') }}">
                        </video>
                    @elseif($slider->isImage())
                        <!-- Image Slider -->
                        <picture>
                            @if($slider->mobile_image)
                                <source media="(max-width: 768px)" srcset="{{ asset($slider->mobile_image) }}">
                            @endif
                            <img src="{{ asset($slider->image) }}" alt="{{ $slider->title ?? 'Slider' }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </picture>
                    @endif
                </div>
                @if($slider->title || $slider->subtitle || $slider->button_text)
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-12">
                            <div class="banner__two-content">
                                @if($slider->title)
                                    <h2 class="banner__two-content-title">{{ $slider->title }}</h2>
                                @endif
                                @if($slider->subtitle)
                                    <p class="banner__two-content-subtitle">{{ $slider->subtitle }}</p>
                                @endif
                                @if($slider->button_text && $slider->link)
                                    <a href="{{ $slider->link }}" class="build_button">{{ $slider->button_text }}<i class="flaticon-right-up"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            @empty
            {{-- Fallback: Eğer slider yoksa eski statik video göster --}}
            <div class="banner__two-area swiper-slide">	
                <div class="banner__two-area-image">
                    <!-- Desktop Video -->
                    <video class="d-none d-md-block" autoplay muted loop playsinline style="width: 100%; height: 100%; object-fit: cover;">
                        <source src="{{ asset('assets/videos/yenisliderweb.mp4') }}" type="video/mp4">
                    </video>
                    <!-- Mobil Video -->
                    <video class="d-block d-md-none" autoplay muted loop playsinline style="width: 100%; height: 100%; object-fit: cover;">
                        <source src="{{ asset('assets/videos/yenislidermobil.mp4') }}" type="video/mp4">
                    </video>
                </div>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-12">
                            <div class="banner__two-content">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>

	<!-- Services Area End -->
    <!-- About Area Start -->
    <div class="about__two" style="padding-top: 50px;">
        <div class="container">
            <div class="row align-items-center">
                <!-- Sol Taraf - Yazı İçeriği (Web'de sol, Mobilde üst) -->
                <div class="col-lg-6 col-md-12 mb-30 order-lg-1 order-1">
                    <div class="about__two-left">
                        <h2 class="title_split_anim">{{ $site->company_name }}</h2>
                        <p class="wow fadeInUp" data-wow-delay=".4s" style="line-height: 1.8; margin-bottom: 30px;">{{ $site->company_description }}</p>
                        <div class="item_bounce mt-35">
                            <a class="build_button" href="{{ route('services') }}">Tüm Hizmetler<i class="flaticon-right-up"></i></a>                        
                        </div>
                    </div>
                </div>
                <!-- Sağ Taraf - Video (Web'de sağ, Mobilde alt) -->
                <div class="col-lg-6 col-md-12 mb-30 order-lg-2 order-2">
                    <div class="about__two-right wow fadeInRight" data-wow-delay=".4s">
                        <div class="about__two-right-image" style="position: relative; border-radius: 16px; overflow: hidden; box-shadow: 0 15px 50px rgba(0,0,0,0.2); background: #000; width: 100%; aspect-ratio: 16/9;">
                            <video 
                                id="aboutVideo"
                                autoplay 
                                muted 
                                loop 
                                playsinline 
                                disablePictureInPicture
                                preload="auto"
                                webkit-playsinline="true"
                                x5-playsinline="true"
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: block; border-radius: 16px; object-fit: cover; pointer-events: none; user-select: none;"
                                oncontextmenu="return false;">
                                @php $aboutVideoSrc = $site->about_video ? asset($site->about_video) : asset('assets/videos/home_video.mp4'); @endphp
                                <source src="{{ $aboutVideoSrc }}" type="video/mp4">
                                Tarayıcınız video oynatmayı desteklemiyor.
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Portfolio Area Start (Kategoriler) -->
    <div class="portfolio__one">
        <div class="container">
            <div class="row mt-60 wow fadeInUp" data-wow-delay=".5s">
                <div class="col-xl-12">
                    <div class="swiper portfolio_slide data_cursor" data-cursor-text="Drag">
                        <div class="swiper-wrapper">
                            @if(isset($categories) && $categories->count() > 0)
                                @foreach($categories as $category)
                                <div class="swiper-slide">
                                    <div class="portfolio__one-item">
                                        <img src="{{ $category->image_url ?? asset('assets/img/portfolio/portfolio-6.jpg') }}" alt="{{ $category->name }}">
                                        <div class="portfolio__one-item-content">
                                            <span>{{ $category->name }}</span>
                                            <h4><a href="{{ route('services', ['category' => $category->slug]) }}">{{ $category->name }}</a></h4>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Portfolio Area End -->

	<div class="blog__four section-padding-two">
		<div class="container">
			<div class="row mb-30">
				<div class="col-xl-12">
					<div class="blog__four-title t-center">
						<span class="subtitle wow fadeInLeft" data-wow-delay=".4s">Haberler & Blog</span>
						<h2 class="title_split_anim">Sektörel Haberler ve İpuçları</h2>
						<div class="mt-30">
							<a href="{{ route('news') }}" class="build_button">Tüm Haberleri Gör<i class="flaticon-right-up"></i></a>
						</div>
					</div>					
				</div>
			</div>
            <div class="row">
                @if(isset($latestNews) && $latestNews->count() > 0)
                    @foreach($latestNews as $index => $newsItem)
                    <div class="col-xl-4 col-md-6 mt-25 wow fadeInUp" data-wow-delay="{{ ($index * 0.3) + 0.4 }}s">
                        <div class="blog__four-item">
                            <div class="blog__four-item-image">
                                <a href="{{ route('news.show', $newsItem->slug) }}">
                                    @if($newsItem->featured_image_url)
                                        <img src="{{ $newsItem->featured_image_url }}" alt="{{ $newsItem->title }}">
                                    @else
                                        <img src="{{ asset('assets/img/blog/blog-' . ($index + 1) . '.jpg') }}" alt="{{ $newsItem->title }}">
                                    @endif
                                </a>
                            </div>
                            <div class="blog__four-item-content">
                                <h4><a href="{{ route('news.show', $newsItem->slug) }}">{{ $newsItem->title }}</a></h4>
                                @if($newsItem->excerpt)
                                    <p>{{ Str::limit($newsItem->excerpt, 100) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    {{-- Fallback: Eğer haber yoksa statik içerik göster --}}
                    <div class="col-xl-4 col-md-6 mt-25 wow fadeInUp" data-wow-delay=".4s">
                        <div class="blog__four-item">
                            <div class="blog__four-item-image">
                                <a href="{{ route('news') }}"><img src="{{ asset('assets/img/blog/blog-1.jpg') }}" alt="Çelik Kapı Seçimi"></a>
                            </div>
                            <div class="blog__four-item-content">
                                <h4><a href="{{ route('news') }}">Çelik Kapı Seçerken Dikkat Edilmesi Gerekenler</a></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 mt-25 wow fadeInUp" data-wow-delay=".7s">
                        <div class="blog__four-item">
                            <div class="blog__four-item-image">
                                <a href="{{ route('news') }}"><img src="{{ asset('assets/img/blog/blog-2.jpg') }}" alt="Isı Yalıtım"></a>
                            </div>
                            <div class="blog__four-item-content">
                                <h4><a href="{{ route('news') }}">Isı Yalıtımı ile Enerji Tasarrufu Nasıl Sağlanır?</a></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 mt-25 wow fadeInUp" data-wow-delay="1s">
                        <div class="blog__four-item">
                            <div class="blog__four-item-image">
                                <a href="{{ route('news') }}"><img src="{{ asset('assets/img/blog/blog-3.jpg') }}" alt="PVC Pencere"></a>
                            </div>
                            <div class="blog__four-item-content">
                                <h4><a href="{{ route('news') }}">PVC Pencere ve Kapıların Bakım Rehberi</a></h4>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
		</div>
	</div>

    <!-- Map Area Start -->
    <div class="map section-padding pt-0">
        <div class="container-fluid px-0">
            <div class="row">
                <div class="col-12">
                    <div class="map-area">
                        @if($site->google_maps_embed)
                            {!! $site->google_maps_embed !!}
                        @else
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3171.045988425255!2d36.0824718!3d37.3650887!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x152f2032184e30f7%3A0x6f4f2a95417d4438!2zT2JhIEh1cmRhY8SxbMSxaw!5e0!3m2!1str!2str!4v1769852147129!5m2!1str!2str" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="{{ $site->company_name }}" aria-label="{{ $site->company_name }}"></iframe>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Map Area End -->

    @include('frontend.partials.footer')

@push('styles')
<style>
    /* About Section - Clean Spacing, No Extra Padding */
    .about__two {
        padding: 0 !important;
        margin: 0 !important;
    }
    
    .about__two .container {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
    }
    
    .about__two-left {
        padding: 0 !important;
        margin: 0 !important;
    }
    
    /* Video Container - Perfect Rectangle on All Devices */
    .about__two-right-image {
        aspect-ratio: 16/9 !important;
        min-height: 0 !important;
    }
    
    /* Desktop - Enhanced Spacing (Yan Yana) */
    @media (min-width: 992px) {
        .about__two {
            padding-top: 60px !important;
            padding-bottom: 60px !important;
        }
        
        .about__two-right-image {
            box-shadow: 0 20px 60px rgba(0,0,0,0.25) !important;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .about__two-right-image:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 70px rgba(0,0,0,0.3) !important;
        }
    }
    
    /* Tablet */
    @media (min-width: 768px) and (max-width: 991px) {
        .about__two {
            padding-top: 40px !important;
            padding-bottom: 40px !important;
        }
        
        .about__two-right-image {
            margin-top: 20px;
        }
    }
    
    /* Mobile - Perfect Rectangle (Alt Alta) - Minimal Spacing */
    @media (max-width: 767px) {
        .about__two {
            padding-top: 20px !important;
            padding-bottom: 30px !important;
        }
        
        .about__two .container {
            padding-left: 15px !important;
            padding-right: 15px !important;
        }
        
        .about__two-left {
            margin-bottom: 20px !important;
            padding: 0 !important;
        }
        
        .about__two-right-image {
            aspect-ratio: 16/9 !important;
            width: 100% !important;
            margin-top: 0 !important;
            border-radius: 12px !important;
        }
        
        .about__two-right-image video {
            border-radius: 12px !important;
        }
    }
    
    /* Extra Small Devices */
    @media (max-width: 575px) {
        .about__two {
            padding-top: 15px !important;
            padding-bottom: 25px !important;
        }
        
        .about__two-left {
            margin-bottom: 15px !important;
        }
        
        .about__two-right-image {
            margin-top: 0 !important;
        }
    }

</style>
@endpush

@push('scripts')
<script>
    (function() {
        function initVideo() {
            const video = document.getElementById('aboutVideo');
            if (!video) {
                console.log('Video elementi bulunamadı');
                return;
            }

            console.log('Video elementi bulundu:', video);
            console.log('Video src:', video.querySelector('source')?.src || video.src);

            // Video yükleme durumunu kontrol et
            function checkVideoReady() {
                if (video.readyState >= 2) { // HAVE_CURRENT_DATA
                    playVideo();
                } else {
                    console.log('Video henüz hazır değil, readyState:', video.readyState);
                }
            }

            function playVideo() {
                const playPromise = video.play();
                if (playPromise !== undefined) {
                    playPromise
                        .then(function() {
                            console.log('Video başarıyla oynatıldı');
                        })
                        .catch(function(error) {
                            console.error('Video oynatma hatası:', error);
                            // Kullanıcı etkileşimi gerekiyorsa, video yüklendikten sonra tekrar dene
                            setTimeout(function() {
                                video.play().catch(function(e) {
                                    console.error('Video oynatma tekrar deneme hatası:', e);
                                });
                            }, 2000);
                        });
                }
            }

            // Video yükleme event'leri
            video.addEventListener('loadstart', function() {
                console.log('Video yükleme başladı');
            });

            video.addEventListener('loadedmetadata', function() {
                console.log('Video metadata yüklendi');
                checkVideoReady();
            });

            video.addEventListener('loadeddata', function() {
                console.log('Video data yüklendi');
                checkVideoReady();
            });

            video.addEventListener('canplay', function() {
                console.log('Video oynatılabilir');
                playVideo();
            });

            video.addEventListener('canplaythrough', function() {
                console.log('Video kesintisiz oynatılabilir');
                playVideo();
            });

            // Video hata kontrolü
            video.addEventListener('error', function(e) {
                console.error('Video yükleme hatası:', e);
                console.error('Video error code:', video.error?.code);
                console.error('Video error message:', video.error?.message);
            });

            // Video duraklatıldığında tekrar başlat
            video.addEventListener('pause', function() {
                if (!video.ended && !document.hidden) {
                    console.log('Video duraklatıldı, tekrar başlatılıyor...');
                    setTimeout(function() {
                        playVideo();
                    }, 100);
                }
            });

            // Video bittiğinde tekrar başlat
            video.addEventListener('ended', function() {
                console.log('Video bitti, tekrar başlatılıyor...');
                video.currentTime = 0;
                playVideo();
            });

            // Sayfa görünürlük kontrolü
            document.addEventListener('visibilitychange', function() {
                if (!document.hidden && video.paused && !video.ended) {
                    console.log('Sayfa görünür oldu, video oynatılıyor...');
                    playVideo();
                }
            });

            // Video yüklemesini zorla başlat
            video.load();

            // İlk yüklemede oynatmayı dene - farklı zamanlarda
            setTimeout(function() {
                if (video.readyState >= 2) {
                    playVideo();
                } else {
                    checkVideoReady();
                }
            }, 500);

            setTimeout(function() {
                if (video.paused) {
                    playVideo();
                }
            }, 1500);

            setTimeout(function() {
                if (video.paused) {
                    playVideo();
                }
            }, 3000);
        }

        // DOM yüklendiğinde çalıştır
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(initVideo, 100);
            });
        } else {
            setTimeout(initVideo, 100);
        }

        // Window yüklendiğinde de kontrol et
        window.addEventListener('load', function() {
            setTimeout(initVideo, 500);
        });

        // Intersection Observer ile video görünür olduğunda oynat
        if ('IntersectionObserver' in window) {
            setTimeout(function() {
                const observer = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            const video = document.getElementById('aboutVideo');
                            if (video && video.paused) {
                                video.play().catch(function(e) {
                                    console.error('IntersectionObserver video oynatma hatası:', e);
                                });
                            }
                        }
                    });
                }, { threshold: 0.5 });

                const video = document.getElementById('aboutVideo');
                if (video) {
                    observer.observe(video);
                }
            }, 1000);
        }
    })();
</script>
@endpush
