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
						<h2>Hizmetlerimiz</h2>
						<ul>
							<li><a href="{{ url('/') }}">Anasayfa</a><i class="fa-regular fa-angle-right"></i></li>
							<li>Hizmetlerimiz</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>       
    <!-- Breadcrumb Area End -->
    <!-- Services Area Start -->
    <div class="three__columns section-padding-three">
        <div class="container">
            <div class="row">
                @forelse($services as $index => $service)
                <div class="col-lg-4 col-md-6 mt-25 wow fadeInUp" data-wow-delay="{{ ($index % 3) * 0.3 + 0.3 }}s">
                    <div class="portfolio__three-item">
                        @if($service->featured_image_url)
                            <img src="{{ $service->featured_image_url }}" alt="{{ $service->title }}">
                        @elseif($service->images->count() > 0 && $service->images->first())
                            <img src="{{ asset($service->images->first()->image) }}" alt="{{ $service->title }}">
                        @else
                            <img src="{{ asset('assets/img/portfolio/portfolio-1.jpg') }}" alt="{{ $service->title }}">
                        @endif
                        <div class="portfolio__three-item-content">
                            <a href="{{ route('services.show', $service->slug) }}"><i class="flaticon flaticon-right-up"></i></a>
                            <span>{{ $service->category->name ?? 'Hizmet' }}</span>
                            <h4><a href="{{ route('services.show', $service->slug) }}">{{ $service->title }}</a></h4>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <p class="text-muted">Henüz hizmet eklenmemiş.</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Services Area End -->
    

@include('frontend.partials.footer')
