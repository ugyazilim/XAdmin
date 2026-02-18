@include('frontend.partials.header')
@php
    use Illuminate\Support\Str;
@endphp
    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb__area" style="background-image: url('{{ asset('assets/img/page/breadcrumb.jpg') }}');">
		<div class="container">
			<div class="row">
				<div class="col-xl-12">
					<div class="breadcrumb__area-content">
						<h2>{{ $service->title }}</h2>
						<ul>
							<li><a href="{{ url('/') }}">Anasayfa</a><i class="fa-regular fa-angle-right"></i></li>
							<li><a href="{{ route('services') }}">Hizmetlerimiz</a><i class="fa-regular fa-angle-right"></i></li>
							<li>{{ $service->title }}</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>       
    <!-- Breadcrumb Area End -->
    <!-- Services Details Area Start -->
    <div class="services__details section-padding">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 order-lg-1 order-2">
                    <div class="services__details-area text-center text-lg-start">
                        <h3 class="mb-20">{{ $service->title }}</h3>
                        @if($service->short_description)
                        <p class="mb-20 lead">{{ $service->short_description }}</p>
                        @endif
                        @if($service->content)
                        <div class="mb-25">
                            {!! $service->content !!}
                        </div>
                        @endif
                        <!-- Teklif Al Butonu -->
                        <div class="mt-30 mb-4 mb-lg-0">
                            <a href="https://wa.me/905305693623?text=Merhaba,%20{{ urlencode($service->title) }}%20hakkında%20teklif%20almak%20istiyorum." target="_blank" rel="noopener noreferrer" class="build_button teklif-al-btn">
                                <i class="fab fa-whatsapp me-2"></i>Teklif Al<i class="flaticon-right-up ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 order-lg-2 order-1">
                    <div class="services__details-image mt-4 mt-lg-0 pt-lg-4">
                        @if($service->images->count() > 0)
                        <!-- Swiper Slider -->
                        <div class="swiper service-images-swiper mb-30">
                            <div class="swiper-wrapper">
                                @foreach($service->images as $image)
                                <div class="swiper-slide">
                                    <img src="{{ asset($image->image) }}" alt="{{ $image->alt_text ?? $service->title }}" class="img-fluid w-100">
                                </div>
                                @endforeach
                            </div>
                            @if($service->images->count() > 1)
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                            @endif
                        </div>
                        @elseif($service->featured_image)
                        <img src="{{ asset($service->featured_image) }}" alt="{{ $service->title }}" class="img-fluid w-100">
                        @else
                        <img src="{{ asset('assets/img/portfolio/portfolio-1.jpg') }}" alt="{{ $service->title }}" class="img-fluid w-100">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Services Details Area End -->

    <!-- Diğer Modeller Area Start -->
    @if(isset($relatedServices) && $relatedServices->count() > 0)
    <div class="three__columns section-padding-three">
        <div class="container">
            <div class="row mb-30">
                <div class="col-xl-12">
                    <div class="t-center">
                        <span class="subtitle wow fadeInLeft" data-wow-delay=".4s">Diğer Modeller</span>
                        <h2 class="title_split_anim">Aynı Kategoriden Hizmetlerimiz</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($relatedServices as $index => $relatedService)
                <div class="col-lg-4 col-md-6 mt-25 wow fadeInUp" data-wow-delay="{{ ($index % 3) * 0.3 + 0.3 }}s">
                    <div class="portfolio__three-item">
                        @if($relatedService->featured_image)
                            <img src="{{ asset($relatedService->featured_image) }}" alt="{{ $relatedService->title }}">
                        @elseif($relatedService->images->count() > 0 && $relatedService->images->first())
                            <img src="{{ asset($relatedService->images->first()->image) }}" alt="{{ $relatedService->title }}">
                        @else
                            <img src="{{ asset('assets/img/portfolio/portfolio-' . (($index % 4) + 1) . '.jpg') }}" alt="{{ $relatedService->title }}">
                        @endif
                        <div class="portfolio__three-item-content">
                            <a href="{{ route('services.show', $relatedService->slug) }}"><i class="flaticon flaticon-right-up"></i></a>
                            <span>{{ $relatedService->category->name ?? 'Hizmet' }}</span>
                            <h4><a href="{{ route('services.show', $relatedService->slug) }}">{{ $relatedService->title }}</a></h4>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    <!-- Diğer Modeller Area End -->
    
    @if($service->images->count() > 1)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const swiper = new Swiper('.service-images-swiper', {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: {{ $service->images->count() > 2 ? 'true' : 'false' }},
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        });
    </script>
    @endif

@push('styles')
<style>
    /* Teklif Al Butonu Stilleri */
    .teklif-al-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
        color: white !important;
        padding: 14px 30px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 16px;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 6px 20px rgba(37, 211, 102, 0.3);
        border: none;
        position: relative;
        overflow: hidden;
    }

    .teklif-al-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(37, 211, 102, 0.5);
        background: linear-gradient(135deg, #128C7E 0%, #25D366 100%);
        color: white !important;
    }

    .teklif-al-btn i.fab.fa-whatsapp {
        font-size: 20px;
        margin-right: 8px;
    }

    .teklif-al-btn i.flaticon-right-up {
        margin-left: 8px;
        font-size: 14px;
    }

    /* Mobil için responsive */
    @media (max-width: 768px) {
        .teklif-al-btn {
            width: 100%;
            padding: 12px 25px;
            font-size: 15px;
            margin-top: 20px;
        }

        .services__details-area {
            text-align: center !important;
        }
    }

    @media (max-width: 575px) {
        .teklif-al-btn {
            padding: 11px 20px;
            font-size: 14px;
        }
    }

</style>
@endpush
    
@include('frontend.partials.footer')
