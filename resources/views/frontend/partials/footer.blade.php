<div class="footer__four">
		<div class="container">
			<div class="row">
				<div class="col-xl-12">
					<div class="footer__four-area">
						<div class="row">
							<div class="col-lg-4 col-md-6 col-sm-12 mb-30">
								<div class="footer__four-widget mr-40">
									<a class="logo" href="{{ url('/') }}"><img src="{{ asset('assets/img/logo.png') }}" alt="Oba Ticaret Logo"></a>
									<p class="mt-20">OBA TİCARET | Yapı Malz. - Mobilya - PVC - Çelik Kapı. 1996'dan bu yana Kadirli/Osmaniye'de çelik kapı, PVC kapı sistemleri, alüminyum duşakabin, mobilya, ısı yalıtım ve izocam alanlarında kaliteli çözümler sunuyoruz. Müşteri memnuniyeti ve kalite odaklı hizmet anlayışımızla sektörde öncü konumdayız.</p>
								</div>
							</div>
							<div class="col-lg-2 col-md-3 col-sm-6 mb-30">
								<div class="footer__four-widget">
									<h4>Hızlı Bağlantılar</h4>
									<div class="footer-widget-menu">
										<ul>
											<li><a href="{{ url('/') }}">Anasayfa</a></li>
											<li><a href="{{ route('about') }}">Hakkımızda</a></li>
											<li><a href="{{ route('projects') }}">Projelerimiz</a></li>
											<li><a href="{{ route('references') }}">Referanslar</a></li>
											<li><a href="{{ route('news') }}">Haberler</a></li>
											<li><a href="{{ route('contact') }}">İletişim</a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-6 mb-30">
								<div class="footer__four-widget">
									<h4>Kategoriler</h4>
									<div class="footer-widget-menu">
										<ul>
											@if(isset($footerCategories) && $footerCategories->count() > 0)
												@foreach($footerCategories as $category)
												<li><a href="{{ route('services', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>
												@endforeach
											@else
												<li><a href="{{ route('services') }}">Hizmetlerimiz</a></li>
											@endif
										</ul>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-sm-12 mb-30">
								<div class="footer__four-widget address">
									<h4>İletişim Bilgileri</h4>
									<div class="footer__four-widget-address">
										<div class="footer-address-item mb-15">
											<i class="fal fa-map-marker-alt"></i>
											<span>Şehit Halis Şişman Mah. Kamil Kara Bul. No:240 Kadirli/Osmaniye, Osmaniye 80750</span>
										</div>
										<div class="footer-address-item mb-15">
											<div style="display: flex; flex-direction: column; gap: 8px;">
												<a href="tel:05305693623" style="display: flex; align-items: center; gap: 8px;">
													<i class="fal fa-phone" style="font-size: 14px;"></i>
													<span>0530 569 36 23</span>
												</a>
												<a href="tel:05326415316" style="display: flex; align-items: center; gap: 8px;">
													<i class="fal fa-phone" style="font-size: 14px;"></i>
													<span>0532 641 53 16</span>
												</a>
											</div>
										</div>
										<div class="footer-address-item mb-15">
											<i class="fal fa-envelope"></i>
											<a href="mailto:info@obaticaret.com">info@obaticaret.com</a>
										</div>
										<div class="footer-address-item">
											<i class="fal fa-clock"></i>
											<span>Pazartesi - Cumartesi: 08:00 - 18:00</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Footer Area End -->
	<!-- Copyright Area Start -->
	<div class="copyright__area four">
		<div class="container">
			<div class="row al-center">
				<div class="col-md-12">
					<div class="copyright__area-content t-center">
						<p>&copy; {{ date('Y') }} 2026 OBA TİCARET | ÇELİK KAPI - PVC - MOBİLYA - MUTFAK - İÇ ODA KAPILARI. Tüm hakları saklıdır.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Copyright Area End -->
	<!-- Scroll Btn Start -->
	<div class="scroll-up scroll-one">
		<svg class="scroll-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102"><path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" /> </svg>
	</div>
	<!-- Scroll Btn End -->
	<!-- WhatsApp Floating Button Start -->
	<a href="https://wa.me/905305693623?text=Merhaba,%20teklif%20almak%20istiyorum." target="_blank" rel="noopener noreferrer" class="whatsapp-float" id="whatsappFloat">
		<div class="whatsapp-float-icon">
			<i class="fab fa-whatsapp"></i>
		</div>
		<div class="whatsapp-float-text">
			<span>Teklif Al</span>
		</div>
	</a>
	<!-- WhatsApp Floating Button End -->
	<!-- WhatsApp Floating Button Styles -->
	<style>
		.whatsapp-float {
			position: fixed;
			right: 20px;
			bottom: 20px;
			z-index: 9999;
			display: flex;
			align-items: center;
			gap: 12px;
			background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
			color: white;
			padding: 12px 20px;
			border-radius: 50px;
			text-decoration: none;
			box-shadow: 0 8px 25px rgba(37, 211, 102, 0.4);
			transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
			animation: whatsappPulse 2s ease-in-out infinite;
		}

		.whatsapp-float:hover {
			transform: translateY(-5px) scale(1.05);
			box-shadow: 0 12px 35px rgba(37, 211, 102, 0.6);
			background: linear-gradient(135deg, #128C7E 0%, #25D366 100%);
			color: white;
		}

		.whatsapp-float-icon {
			width: 48px;
			height: 48px;
			display: flex;
			align-items: center;
			justify-content: center;
			background: rgba(255, 255, 255, 0.2);
			border-radius: 50%;
			font-size: 24px;
			animation: whatsappShake 1.5s ease-in-out infinite;
		}

		.whatsapp-float-text {
			font-weight: 600;
			font-size: 16px;
			letter-spacing: 0.5px;
			white-space: nowrap;
		}

		/* Titreşim Animasyonu */
		@keyframes whatsappShake {
			0%, 100% {
				transform: rotate(0deg);
			}
			10%, 30%, 50%, 70%, 90% {
				transform: rotate(-5deg);
			}
			20%, 40%, 60%, 80% {
				transform: rotate(5deg);
			}
		}

		/* Nabız Animasyonu */
		@keyframes whatsappPulse {
			0%, 100% {
				box-shadow: 0 8px 25px rgba(37, 211, 102, 0.4);
			}
			50% {
				box-shadow: 0 8px 35px rgba(37, 211, 102, 0.7), 0 0 0 10px rgba(37, 211, 102, 0.1);
			}
		}

		/* Tablet ve Mobil için Responsive */
		@media (max-width: 768px) {
			.whatsapp-float {
				right: 15px;
				bottom: 15px;
				padding: 10px 16px;
			}

			.whatsapp-float-icon {
				width: 42px;
				height: 42px;
				font-size: 22px;
			}

			.whatsapp-float-text {
				font-size: 14px;
			}
		}

		@media (max-width: 575px) {
			.whatsapp-float {
				right: 10px;
				bottom: 10px;
				padding: 8px 14px;
			}

			.whatsapp-float-icon {
				width: 38px;
				height: 38px;
				font-size: 20px;
			}

			.whatsapp-float-text {
				font-size: 13px;
			}
		}
	</style>
	<!-- Main JS -->
	<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
	<!-- Bootstrap JS -->
	<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
	<!-- Counter up -->
	<script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
	<!-- Popper JS -->
	<script src="{{ asset('assets/js/popper.min.js') }}"></script>
	<!-- Progressbar JS -->
	<script src="{{ asset('assets/js/progressbar.min.js') }}"></script>
	<!-- Magnific JS -->
	<script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
	<!-- Swiper JS -->
	<script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
	<!-- Waypoints JS -->
	<script src="{{ asset('assets/js/jquery.waypoints.min.js') }}"></script>
	<!-- Isotope JS -->
	<script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
	<!-- WOW Js -->
	<script src="{{ asset('assets/js/wow.min.js') }}"></script>
	<!-- Gsap Js -->
	<script src="{{ asset('assets/js/gsap.js') }}"></script>
	<!-- Scroll Trigger Js -->
	<script src="{{ asset('assets/js/scroll-trigger.js') }}"></script>
	<!-- Split Text Js -->
	<script src="{{ asset('assets/js/split-text.js') }}"></script>
	<!-- Custom JS -->
	<script src="{{ asset('assets/js/custom.js') }}"></script>
</body>

</html>
