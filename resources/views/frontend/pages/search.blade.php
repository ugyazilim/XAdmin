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
                    <h2>Arama Sonuçları</h2>
                    <ul>
                        <li><a href="{{ url('/') }}">Anasayfa</a><i class="fa-regular fa-angle-right"></i></li>
                        <li>Arama</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Area End -->

<!-- Search Results Area Start -->
<div class="blog-three__columns section-padding-three">
    <div class="container">
        @if(empty($query))
            <div class="row">
                <div class="col-12">
                    <div class="text-center py-5">
                        <h3 class="mb-20">Arama yapmak için bir kelime girin</h3>
                        <p class="text-muted">Lütfen arama kutusuna bir kelime veya ifade yazın.</p>
                    </div>
                </div>
            </div>
        @else
            <div class="row mb-30">
                <div class="col-12">
                    <h3 class="mb-10">"{{ $query }}" için arama sonuçları</h3>
                    <p class="text-muted">
                        <strong>{{ $newsResults->count() + $serviceResults->count() }}</strong> sonuç bulundu
                        @if($newsResults->count() > 0)
                            ({{ $newsResults->count() }} haber, 
                        @endif
                        @if($serviceResults->count() > 0)
                            {{ $serviceResults->count() }} hizmet)
                        @endif
                    </p>
                </div>
            </div>

            @if($newsResults->count() > 0)
            <div class="row mb-50">
                <div class="col-12">
                    <h4 class="mb-30"><i class="fal fa-newspaper me-2"></i>Haberler & Blog</h4>
                </div>
                @foreach($newsResults as $index => $newsItem)
                <div class="col-xl-4 col-lg-6 mb-30 wow fadeInUp" data-wow-delay="{{ ($index % 3) * 0.2 }}s">
                    <div class="blog__one-item">
                        @if($newsItem->featured_image_url)
                        <div class="blog__one-item-image">
                            <a href="{{ route('news.show', $newsItem->slug) }}">
                                <img src="{{ $newsItem->featured_image_url }}" alt="{{ $newsItem->title }}">
                            </a>
                        </div>
                        @endif
                        <div class="blog__one-item-content">
                            <h4><a href="{{ route('news.show', $newsItem->slug) }}">{{ $newsItem->title }}</a></h4>
                            @if($newsItem->excerpt)
                            <p class="mt-15 mb-15">{{ Str::limit($newsItem->excerpt, 100) }}</p>
                            @elseif($newsItem->content)
                            <p class="mt-15 mb-15">{{ Str::limit(strip_tags($newsItem->content), 100) }}</p>
                            @endif
                            <a class="more_btn" href="{{ route('news.show', $newsItem->slug) }}">Devamını Oku<i class="flaticon-right-up"></i></a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            @if($serviceResults->count() > 0)
            <div class="row">
                <div class="col-12">
                    <h4 class="mb-30"><i class="flaticon-cyber-security me-2"></i>Hizmetler</h4>
                </div>
                @foreach($serviceResults as $index => $service)
                <div class="col-lg-4 col-md-6 mb-30 wow fadeInUp" data-wow-delay="{{ ($index % 3) * 0.2 + 0.1 }}s">
                    <div class="services__one-item">
                        @if($service->icon)
                        <i class="{{ $service->icon }}"></i>
                        @else
                        <i class="flaticon-cyber-security"></i>
                        @endif
                        <h4><a href="{{ route('services.show', $service->slug) }}">{{ $service->title }}</a></h4>
                        <p>{{ $service->short_description ?? Str::limit(strip_tags($service->content), 100) }}</p>
                        <a class="more_btn" href="{{ route('services.show', $service->slug) }}">Detaylı Bilgi<i class="flaticon-right-up"></i></a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            @if($newsResults->count() == 0 && $serviceResults->count() == 0)
            <div class="row">
                <div class="col-12">
                    <div class="text-center py-5">
                        <h4 class="mb-20">Sonuç bulunamadı</h4>
                        <p class="text-muted mb-30">"{{ $query }}" için hiçbir sonuç bulunamadı. Lütfen farklı kelimeler deneyin.</p>
                        <a href="{{ route('news') }}" class="btn btn-primary me-2">Tüm Haberleri Gör</a>
                        <a href="{{ route('services') }}" class="btn btn-outline-primary">Tüm Hizmetleri Gör</a>
                    </div>
                </div>
            </div>
            @endif
        @endif
    </div>
</div>
<!-- Search Results Area End -->

@include('frontend.partials.footer')
