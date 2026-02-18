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
                    <h2>Haberler & Blog</h2>
                    <ul>
                        <li><a href="{{ url('/') }}">Anasayfa</a><i class="fa-regular fa-angle-right"></i></li>
                        <li>Haberler</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Area End -->

<!-- Blog Area Start -->
<div class="blog-three__columns section-padding-three">
    <div class="container">
        <div class="row">
            @forelse($news as $index => $newsItem)
            <div class="col-xl-4 col-lg-6 wow fadeInUp" data-wow-delay="{{ ($index % 3) * 0.3 + 0.4 }}s">
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
                        @endif
                        <a class="more_btn" href="{{ route('news.show', $newsItem->slug) }}">Devamını Oku<i class="flaticon-right-up"></i></a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <p class="text-muted">Henüz haber eklenmemiş.</p>
                </div>
            </div>
            @endforelse
        </div>
        
        @if($news->hasPages())
        <div class="row mt-25">
            <div class="col-xl-12">
                <div class="theme__pagination t-center">
                    {{ $news->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<!-- Blog Area End -->

@include('frontend.partials.footer')
