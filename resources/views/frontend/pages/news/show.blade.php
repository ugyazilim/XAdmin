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
                    <h2>{{ $newsItem->title }}</h2>
                    <ul>
                        <li><a href="{{ url('/') }}">Anasayfa</a><i class="fa-regular fa-angle-right"></i></li>
                        <li><a href="{{ route('news') }}">Haberler</a><i class="fa-regular fa-angle-right"></i></li>
                        <li>{{ Str::limit($newsItem->title, 30) }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Area End -->

<!-- Blog Details Area Start -->
<div class="blog__details section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="blog__details-area">
                    @if($newsItem->featured_image_url)
                    <div class="text-center mb-30">
                        <img src="{{ $newsItem->featured_image_url }}" alt="{{ $newsItem->title }}" class="img-fluid">
                    </div>
                    @endif
                    
                    <h3 class="mt-25 mb-20">{{ $newsItem->title }}</h3>
                    
                    @if($newsItem->excerpt)
                    <p class="mb-20 lead">{{ $newsItem->excerpt }}</p>
                    @endif
                    
                    @if($newsItem->content)
                    <div class="blog__details-area-content">
                        {!! $newsItem->content !!}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Blog Details Area End -->

@include('frontend.partials.footer')
