@include('frontend.partials.header')
    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb__area" style="background-image: url('{{ asset('assets/img/page/breadcrumb.jpg') }}');">
		<div class="container">
			<div class="row">
				<div class="col-xl-12">
					<div class="breadcrumb__area-content">
						<h2>Referanslar</h2>
						<ul>
							<li><a href="{{ url('/') }}">Anasayfa</a><i class="fa-regular fa-angle-right"></i></li>
							<li>Referanslar</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>       
    <!-- Breadcrumb Area End -->
    
    <!-- Portfolio Area Start (Referanslar) -->
    <div class="three__columns section-padding-three">
        <div class="container">
            <div class="row mb-40">
                <div class="col-xl-12">
                    <div class="section-title t-center">
                        <span class="subtitle wow fadeInLeft" data-wow-delay=".4s">Referanslarımız</span>
                        <h2 class="title_split_anim">Tamamladığımız Projeler</h2>
                    </div>
                </div>
            </div>
            
            <div class="row">
                @forelse($references as $index => $reference)
                <div class="col-lg-4 col-md-6 mt-25 wow fadeInUp" data-wow-delay="{{ ($index % 3) * 0.3 + 0.4 }}s">
					<div class="portfolio__three-item">
						<img src="{{ $reference->image_url ?? asset('assets/img/portfolio/portfolio-3.jpg') }}" alt="{{ $reference->title }}">
						<div class="portfolio__three-item-content">
							@if($reference->project_type)
							<span>{{ $reference->project_type }}</span>
							@endif
							<h4>{{ $reference->title }}</h4>
							@if($reference->client_name)
							<p class="mt-2 mb-0"><small>{{ $reference->client_name }}</small></p>
							@endif
						</div>
					</div>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <p class="text-muted">Henüz referans eklenmemiş.</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Portfolio Area End -->
    @include('frontend.partials.footer')
