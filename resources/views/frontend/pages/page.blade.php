@include('frontend.partials.header')
<!-- Breadcrumb Area Start -->
<div class="breadcrumb__area" style="background-image: url('{{ asset('assets/img/page/breadcrumb.jpg') }}');">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="breadcrumb__area-content">
                    <h2>{{ $page->title }}</h2>
                    <ul>
                        <li><a href="{{ url('/') }}">Anasayfa</a><i class="fa-regular fa-angle-right"></i></li>
                        <li>{{ $page->title }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Area End -->

<!-- Page Content Area Start -->
<div class="page__content section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page__content-area">
                    @if($page->featured_image)
                    <div class="page__content-image mb-30">
                        <img src="{{ asset($page->featured_image) }}" alt="{{ $page->title }}" class="img-fluid w-100">
                    </div>
                    @endif
                    
                    <div class="page__content-text">
                        {!! $page->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Content Area End -->

@include('frontend.partials.footer')
