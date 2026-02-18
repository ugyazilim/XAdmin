@include('frontend.partials.header')

<!-- Breadcrumb Area Start -->
<div class="breadcrumb__area" style="background-image: url('{{ asset('assets/img/page/breadcrumb.jpg') }}');">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="breadcrumb__area-content">
                    <h2>Hakkımızda</h2>
                    <ul>
                        <li><a href="{{ url('/') }}">Anasayfa</a><i class="fa-regular fa-angle-right"></i></li>
                        <li>Hakkımızda</li>
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
                    @if($page->featured_image)
                    <div class="text-center mb-30">
                        <img src="{{ asset($page->featured_image) }}" alt="{{ $page->title }}" class="img-fluid">
                    </div>
                    @endif
                    
                    <h3 class="mt-25 mb-20">{{ $page->title }}</h3>
                    
                    @if($page->content)
                    <div class="blog__details-area-content">
                        {!! $page->content !!}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Blog Details Area End -->

@include('frontend.partials.footer')
