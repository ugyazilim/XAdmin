@include('frontend.partials.header')
    <!-- Breadcrumb Area Start -->
    <div class="breadcrumb__area" style="background-image: url('{{ asset('assets/img/page/breadcrumb.jpg') }}');">
		<div class="container">
			<div class="row">
				<div class="col-xl-12">
					<div class="breadcrumb__area-content">
						<h2>İletişim</h2>
						<ul>
							<li><a href="{{ url('/') }}">Anasayfa</a><i class="fa-regular fa-angle-right"></i></li>
							<li>İletişim</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>       
    <!-- Breadcrumb Area End -->
    <!-- Contact Area Start -->
    <div class="contact__area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 lg-mb-25">
                    <div class="contact__area-left mr-40 xl-mr-0">
                        <div class="title">
                            <span class="subtitle wow fadeInLeft" data-wow-delay=".4s">Bize Ulaşın</span>
                            <h2 class="title_split_anim mb-25">İletişime Geçin</h2>
                            <p class="wow fadeInUp" data-wow-delay=".4s">Sorularınız, talepleriniz veya projeleriniz için bizimle iletişime geçebilirsiniz. Size en kısa sürede dönüş yapacağız.</p>
                        </div>
                        <div class="contact__area-left-contact wow fadeInUp" data-wow-delay=".7s">
                            @if($site->contact_phone)
                            <div class="contact__area-left-contact-item">
                                <div class="contact__area-left-contact-item-content">
                                    <span>Telefon:</span>
                                    <h6 style="display: flex; flex-direction: column; gap: 10px; margin-top: 5px;">
                                        <a href="tel:{{ preg_replace('/\s+/', '', $site->contact_phone) }}" style="display: flex; align-items: center; gap: 10px;">
                                            <i class="flaticon-phone" style="font-size: 16px;"></i>
                                            <span>{{ $site->contact_phone }}</span>
                                        </a>
                                        @if($site->contact_phone2)
                                        <a href="tel:{{ preg_replace('/\s+/', '', $site->contact_phone2) }}" style="display: flex; align-items: center; gap: 10px;">
                                            <i class="flaticon-phone" style="font-size: 16px;"></i>
                                            <span>{{ $site->contact_phone2 }}</span>
                                        </a>
                                        @endif
                                    </h6>
                                </div>
                            </div>
                            @endif
                            @if($site->contact_email)
                            <div class="contact__area-left-contact-item">
                                <div class="contact__area-left-contact-item-icon">
                                    <i class="flaticon-email-3"></i>
                                </div>
                                <div class="contact__area-left-contact-item-content">
                                    <span>E-posta:</span>
                                    <h6><a href="mailto:{{ $site->contact_email }}">{{ $site->contact_email }}</a></h6>
                                </div>
                            </div>
                            @endif
                            @if($site->contact_address)
                            <div class="contact__area-left-contact-item">
                                <div class="contact__area-left-contact-item-icon">
                                    <i class="flaticon-location-1"></i>
                                </div>
                                <div class="contact__area-left-contact-item-content">
                                    <span>Adres:</span>
                                    <h6><a href="https://www.google.com/maps?q={{ urlencode($site->contact_address) }}" target="_blank">{{ $site->contact_address }}</a></h6>
                                </div>
                            </div>
                            @endif
                            @if($site->working_hours)
                            <div class="contact__area-left-contact-item">
                                <div class="contact__area-left-contact-item-icon">
                                    <i class="flaticon-calendar"></i>
                                </div>
                                <div class="contact__area-left-contact-item-content">
                                    <span>Çalışma Saatleri:</span>
                                    <h6>{{ $site->working_hours }}</h6>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 wow fadeInRight" data-wow-delay=".4s">
                    <div class="contact__area-form">
                        <h4>Mesaj Gönderin</h4>
                        <form action="{{ route('contact.submit') }}" method="POST">
                            @csrf
							<div class="row">
								<div class="col-md-12 mb-25">
									<div class="contact__form-area-item">
										<input type="text" name="name" placeholder="Adınız Soyadınız" required>
									</div>
								</div>
								<div class="col-md-12 mb-25">
									<div class="contact__form-area-item">
										<input type="tel" name="phone" placeholder="Telefon Numaranız" required>
									</div>
								</div>
								<div class="col-md-12 mb-25">
									<div class="contact__form-area-item">
										<textarea name="message" placeholder="Mesajınız" rows="5" required></textarea>
									</div>
								</div>
								<div class="col-md-12">
									<div class="contact__form-area-item">
										<button class="build_button" type="submit">Mesaj Gönder <i class="flaticon-right-up"></i></button>
									</div>
								</div>
							</div>
						</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact Area End -->
    <!-- Map Area Start -->
    <div class="map section-padding pt-0">
        <div class="container-fluid px-0">
            <div class="row">
                <div class="col-12">
                    <div class="map-area">
                        @if($site->google_maps_embed)
                            {!! $site->google_maps_embed !!}
                        @else
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3171.045988425255!2d36.0824718!3d37.3650887!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x152f2032184e30f7%3A0x6f4f2a95417d4438!2zT2JhIEh1cmRhY8SxbMSxaw!5e0!3m2!1str!2str!4v1769852147129!5m2!1str!2str" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="{{ $site->company_name }}" aria-label="{{ $site->company_name }}"></iframe>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Map Area End -->
    
    
    @include('frontend.partials.footer')
