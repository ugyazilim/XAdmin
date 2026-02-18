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
                    <h2>Projelerimiz</h2>
                    <ul>
                        <li><a href="{{ url('/') }}">Anasayfa</a><i class="fa-regular fa-angle-right"></i></li>
                        <li>Projelerimiz</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Area End -->

<!-- Gallery Area Start -->
<div class="gallery__area four__columns section-padding">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 mb-40 wow fadeInUp" data-wow-delay=".3s">
                <div class="text-center">
                    <p class="lead">Tamamladığımız referans projelerimizi inceleyebilirsiniz.</p>
                </div>
            </div>
        </div>
        
        <div class="row gallery__area-active">
            @forelse($projects as $index => $project)
                <div class="col-xl-4 col-md-6 mt-25 wow fadeInUp" 
                     data-wow-delay="{{ ($index % 3) * 0.2 + 0.4 }}s">
                    <div class="portfolio__four-item">
                        @if($project->image_url)
                            <a href="{{ route('projects.show', $project->slug) }}">
                                <i class="flaticon flaticon-right-up"></i>
                            </a>
                            <img src="{{ $project->image_url }}" alt="{{ $project->title }}">
                        @else
                            <a href="{{ route('projects.show', $project->slug) }}">
                                <i class="flaticon flaticon-right-up"></i>
                            </a>
                            <img src="{{ asset('assets/img/portfolio/portfolio-1.jpg') }}" alt="{{ $project->title }}">
                        @endif
                        <div class="portfolio__four-item-content">
                            @if($project->client_name)
                                <span>{{ $project->client_name }}</span>
                            @elseif($project->location)
                                <span>{{ $project->location }}</span>
                            @else
                                <span>Referans Proje</span>
                            @endif
                            <h5><a href="{{ route('projects.show', $project->slug) }}">{{ $project->title }}</a></h5>
                            @if($project->description)
                                <p class="mt-10">{{ Str::limit($project->description, 80) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <p class="text-muted">Henüz proje eklenmemiş.</p>
                    </div>
                </div>
            @endforelse
        </div>
        
        @if($projects->hasPages())
        <div class="row mt-25">
            <div class="col-xl-12">
                <div class="theme__pagination t-center">
                    {{ $projects->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<!-- Gallery Area End -->

@push('styles')
<style>
    .gallery-filter-btn {
        display: inline-block;
        padding: 10px 25px;
        margin: 0 5px 10px;
        background: transparent;
        border: 2px solid #e5e5e5;
        color: #666;
        text-decoration: none;
        border-radius: 5px;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .gallery-filter-btn:hover,
    .gallery-filter-btn.active {
        background: var(--theme-color, #667eea);
        border-color: var(--theme-color, #667eea);
        color: #fff;
    }
    
    .gallery__area-button {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
    }
</style>
@endpush

@push('scripts')
<script>
    // Isotope filtering (if using Isotope library)
    // If not using Isotope, the URL-based filtering will work
    document.addEventListener('DOMContentLoaded', function() {
        // Remove Isotope filtering if not needed, URL-based filtering is already working
        // This is just for visual feedback
        const filterButtons = document.querySelectorAll('.gallery-filter-btn');
        filterButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                // Remove active class from all buttons
                filterButtons.forEach(b => b.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');
            });
        });
    });
</script>
@endpush

@include('frontend.partials.footer')
