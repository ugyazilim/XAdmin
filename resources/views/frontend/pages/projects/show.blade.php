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
                    <h2>{{ $project->title }}</h2>
                    <ul>
                        <li><a href="{{ url('/') }}">Anasayfa</a><i class="fa-regular fa-angle-right"></i></li>
                        <li><a href="{{ route('projects') }}">Projelerimiz</a><i class="fa-regular fa-angle-right"></i></li>
                        <li>{{ Str::limit($project->title, 30) }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Area End -->

<!-- Project Details Area Start -->
<div class="blog__details section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="blog__details-area">
                    @if($project->image_url)
                    <div class="text-center mb-30">
                        <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="img-fluid">
                    </div>
                    @endif
                    
                    <h3 class="mt-25 mb-20">{{ $project->title }}</h3>
                    
                    @if($project->client_name)
                    <p class="mb-20">
                        <strong>Müşteri:</strong> {{ $project->client_name }}
                    </p>
                    @endif
                    
                    @if($project->location)
                    <p class="mb-20">
                        <strong>Konum:</strong> {{ $project->location }}
                    </p>
                    @endif
                    
                    @if($project->project_date)
                    <p class="mb-20">
                        <strong>Proje Tarihi:</strong> {{ $project->project_date?->format('d.m.Y') ?? $project->project_date }}
                    </p>
                    @endif
                    
                    @if($project->description)
                    <p class="mb-20 lead">{{ $project->description }}</p>
                    @endif
                    
                    @if($project->content)
                    <div class="blog__details-area-content">
                        {!! $project->content !!}
                    </div>
                    @endif
                    
                    @if($project->gallery && count($project->gallery) > 0)
                    <div class="mt-40">
                        <h4 class="mb-30">Galeri</h4>
                        <div class="row">
                            @foreach($project->gallery as $image)
                            <div class="col-md-4 mb-20">
                                <img src="{{ asset($image) }}" alt="{{ $project->title }}" class="img-fluid">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    @if($project->location || $project->client_name || $project->project_date)
                    <div class="mt-40">
                        <h4 class="mb-30">Proje Bilgileri</h4>
                        <div class="row">
                            @if($project->location)
                            <div class="col-md-4 mb-20">
                                <p><strong>Konum:</strong> {{ $project->location }}</p>
                            </div>
                            @endif
                            @if($project->client_name)
                            <div class="col-md-4 mb-20">
                                <p><strong>Müşteri:</strong> {{ $project->client_name }}</p>
                            </div>
                            @endif
                            @if($project->project_date)
                            <div class="col-md-4 mb-20">
                                <p><strong>Proje Tarihi:</strong> {{ $project->project_date?->format('d.m.Y') ?? $project->project_date }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        @if($relatedProjects->count() > 0)
        <div class="row mt-60">
            <div class="col-xl-12">
                <div class="blog__four-title t-center mb-40">
                    <span class="subtitle wow fadeInLeft" data-wow-delay=".4s">İlgili Projeler</span>
                    <h2 class="title_split_anim">Benzer Projeler</h2>
                </div>
            </div>
            @foreach($relatedProjects as $index => $relatedProject)
            <div class="col-xl-4 col-md-6 mt-25 wow fadeInUp" data-wow-delay="{{ ($index * 0.3) + 0.4 }}s">
                <div class="portfolio__four-item">
                    @if($relatedProject->image_url)
                        <a href="{{ route('projects.show', $relatedProject->slug) }}">
                            <i class="flaticon flaticon-right-up"></i>
                        </a>
                        <img src="{{ $relatedProject->image_url }}" alt="{{ $relatedProject->title }}">
                    @else
                        <a href="{{ route('projects.show', $relatedProject->slug) }}">
                            <i class="flaticon flaticon-right-up"></i>
                        </a>
                        <img src="{{ asset('assets/img/portfolio/portfolio-1.jpg') }}" alt="{{ $relatedProject->title }}">
                    @endif
                    <div class="portfolio__four-item-content">
                        @if($relatedProject->client_name)
                            <span>{{ $relatedProject->client_name }}</span>
                        @elseif($relatedProject->location)
                            <span>{{ $relatedProject->location }}</span>
                        @else
                            <span>Referans Proje</span>
                        @endif
                        <h5><a href="{{ route('projects.show', $relatedProject->slug) }}">{{ $relatedProject->title }}</a></h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
<!-- Project Details Area End -->

@include('frontend.partials.footer')
