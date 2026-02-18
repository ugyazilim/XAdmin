<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $companyName }} - Kurumsal Katalog</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            overflow: hidden;
            background: #0a0a0a;
        }

        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            color: #2c3e50;
            line-height: 1.6;
        }

        .flipbook-container {
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: radial-gradient(circle at center, #1a1a2e 0%, #0a0a0a 100%);
            perspective: 2500px;
            position: relative;
        }

        .book {
            width: 90vw;
            height: 90vh;
            max-width: 1400px;
            max-height: 900px;
            position: relative;
            transform-style: preserve-3d;
        }

        .page {
            width: 50%;
            height: 100%;
            position: absolute;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 0;
            backface-visibility: hidden;
            transform-origin: left center;
            transition: transform 1s cubic-bezier(0.645, 0.045, 0.355, 1);
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.4);
            overflow: hidden;
        }

        .page.left {
            left: 0;
        }

        .page.right {
            right: 0;
            transform-origin: right center;
        }

        .page.flipped {
            transform: rotateY(-180deg);
        }

        .page-content {
            width: 100%;
            height: 100%;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        /* Kapak Sayfası */
        .page.cover {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #7e8ba3 100%);
            color: white;
            text-align: center;
        }

        .page.cover::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }

        .page.cover h1 {
            font-size: 72px;
            font-weight: 300;
            margin-bottom: 30px;
            letter-spacing: 4px;
            text-transform: uppercase;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 1;
        }

        .page.cover .subtitle {
            font-size: 28px;
            opacity: 0.95;
            margin-bottom: 20px;
            font-weight: 300;
            letter-spacing: 2px;
            position: relative;
            z-index: 1;
        }

        .page.cover .subtitle-en {
            font-size: 22px;
            opacity: 0.85;
            margin-bottom: 60px;
            font-style: italic;
            position: relative;
            z-index: 1;
        }

        .page.cover .year {
            font-size: 20px;
            opacity: 0.8;
            margin-top: 60px;
            font-weight: 300;
            letter-spacing: 1px;
            position: relative;
            z-index: 1;
        }

        /* Hakkımızda Sayfası */
        .page.about {
            background: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%);
        }

        .page.about h2 {
            font-size: 48px;
            font-weight: 300;
            color: #1e3c72;
            margin-bottom: 40px;
            text-align: center;
            letter-spacing: 2px;
            position: relative;
            padding-bottom: 20px;
        }

        .page.about h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: linear-gradient(90deg, transparent, #667eea, transparent);
        }

        .page.about .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
            flex: 1;
        }

        .page.about .about-text {
            font-size: 18px;
            color: #444;
            line-height: 1.9;
            text-align: justify;
        }

        .page.about .about-text p {
            margin-bottom: 20px;
        }

        .page.about .about-image {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .page.about .about-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            z-index: 1;
        }

        .page.about .about-image img {
            width: 100%;
            height: auto;
            display: block;
            position: relative;
            z-index: 0;
        }

        /* Ürün Sayfaları */
        .page.product {
            background: white;
        }

        .page.product:nth-child(even) {
            background: linear-gradient(to right, #fafafa 0%, #ffffff 100%);
        }

        .product-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            height: 100%;
        }

        .product-info h2 {
            font-size: 44px;
            font-weight: 300;
            color: #1e3c72;
            margin-bottom: 30px;
            line-height: 1.3;
            letter-spacing: 1px;
            position: relative;
            padding-bottom: 15px;
        }

        .product-info h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 2px;
            background: linear-gradient(90deg, #667eea, transparent);
        }

        .product-info .product-description {
            font-size: 17px;
            color: #555;
            line-height: 1.9;
            margin-bottom: 40px;
            text-align: justify;
        }

        .product-features {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .product-features li {
            font-size: 16px;
            color: #34495e;
            margin-bottom: 16px;
            padding-left: 35px;
            position: relative;
            line-height: 1.8;
        }

        .product-features li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #667eea;
            font-weight: bold;
            font-size: 20px;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(102, 126, 234, 0.1);
            border-radius: 50%;
        }

        .product-image {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
            position: relative;
            transition: transform 0.3s ease;
        }

        .product-image:hover {
            transform: translateY(-5px);
        }

        .product-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            z-index: 1;
            pointer-events: none;
        }

        .product-image img {
            width: 100%;
            height: auto;
            display: block;
            position: relative;
            z-index: 0;
        }

        /* Footer Sayfası */
        .page.footer {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
        }

        .footer-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
            height: 100%;
        }

        .footer-contact h3 {
            font-size: 36px;
            font-weight: 300;
            margin-bottom: 40px;
            letter-spacing: 2px;
            position: relative;
            padding-bottom: 20px;
        }

        .footer-contact h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100px;
            height: 3px;
            background: rgba(255, 255, 255, 0.5);
        }

        .footer-contact p {
            font-size: 18px;
            line-height: 2;
            opacity: 0.95;
            margin-bottom: 12px;
        }

        .footer-contact strong {
            font-weight: 400;
            font-size: 20px;
        }

        .footer-contact a {
            color: white;
            text-decoration: none;
            transition: opacity 0.3s;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        .footer-contact a:hover {
            opacity: 0.8;
            border-bottom-color: white;
        }

        .footer-logo {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .footer-logo img {
            max-width: 350px;
            height: auto;
            opacity: 0.95;
            filter: brightness(1.1);
        }

        .footer-logo h2 {
            font-weight: 300;
            font-size: 56px;
            margin: 0;
            letter-spacing: 3px;
        }

        .footer-copyright {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            text-align: center;
            opacity: 0.7;
            font-size: 14px;
        }

        /* Page Numbers */
        .page-number {
            position: absolute;
            bottom: 25px;
            right: 40px;
            font-size: 14px;
            color: #999;
            font-weight: 300;
            font-family: 'Georgia', serif;
        }

        .page.footer .page-number,
        .page.cover .page-number {
            color: rgba(255, 255, 255, 0.6);
        }

        /* Navigation Controls */
        .nav-controls {
            position: fixed;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            display: flex;
            gap: 20px;
            background: rgba(0, 0, 0, 0.7);
            padding: 15px 30px;
            border-radius: 50px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .nav-btn {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background: white;
            color: #667eea;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .nav-btn:hover:not(:disabled) {
            background: #667eea;
            color: white;
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .nav-btn:active:not(:disabled) {
            transform: scale(0.95);
        }

        .nav-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .page-indicator {
            position: fixed;
            top: 30px;
            right: 30px;
            z-index: 1000;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 14px;
            backdrop-filter: blur(10px);
        }

        /* Responsive */
        @media (max-width: 1400px) {
            .book {
                width: 95vw;
                height: 95vh;
            }
        }

        @media (max-width: 1200px) {
            .page-content {
                padding: 50px 40px;
            }

            .page.cover h1 {
                font-size: 56px;
            }

            .product-content,
            .footer-content,
            .page.about .about-content {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .product-image {
                order: -1;
            }

            .product-info h2 {
                font-size: 36px;
            }
        }

        @media (max-width: 768px) {
            .page-content {
                padding: 40px 25px;
            }

            .page.cover h1 {
                font-size: 42px;
                letter-spacing: 2px;
            }

            .page.cover .subtitle {
                font-size: 20px;
            }

            .page.cover .subtitle-en {
                font-size: 16px;
            }

            .product-info h2,
            .page.about h2 {
                font-size: 32px;
            }

            .product-info .product-description,
            .page.about .about-text {
                font-size: 16px;
            }

            .nav-controls {
                bottom: 20px;
                padding: 12px 25px;
            }

            .nav-btn {
                width: 45px;
                height: 45px;
                font-size: 20px;
            }

            .page-indicator {
                top: 15px;
                right: 15px;
                padding: 8px 15px;
                font-size: 12px;
            }
        }

        @media (max-width: 576px) {
            .page.cover h1 {
                font-size: 32px;
            }

            .product-info h2 {
                font-size: 28px;
            }

            .nav-btn {
                width: 40px;
                height: 40px;
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="flipbook-container">
        <div class="page-indicator">
            <span id="currentPage">1</span> / <span id="totalPages">{{ count($products) + 3 }}</span>
        </div>
        
        <div class="book" id="book">
            @php
                $totalLogicalPages = count($products) + 3; // Kapak, Hakkımızda, Ürünler, Footer
                $pagePairs = [];
                
                // Sayfa çiftleri oluştur
                $pagePairs[] = ['type' => 'cover', 'data' => null, 'page' => 1];
                $pagePairs[] = ['type' => 'about', 'data' => null, 'page' => 2];
                foreach($products as $product) {
                    $pagePairs[] = ['type' => 'product', 'data' => $product, 'page' => count($pagePairs) + 1];
                }
                $pagePairs[] = ['type' => 'footer', 'data' => null, 'page' => count($pagePairs) + 1];
            @endphp

            @foreach($pagePairs as $index => $pair)
                @php
                    $leftPageNum = ($index * 2) + 1;
                    $rightPageNum = ($index * 2) + 2;
                    $isEven = $index % 2 == 0;
                @endphp

                <!-- Sol Sayfa -->
                <div class="page {{ $pair['type'] }} left" data-page="{{ $leftPageNum }}" style="z-index: {{ $totalLogicalPages * 2 - $leftPageNum + 1 }};">
                    <div class="page-content">
                        @if($pair['type'] === 'cover')
                            <h1>{{ $companyName }}</h1>
                            <p class="subtitle">Kurumsal Katalog</p>
                            <p class="subtitle-en">Corporate Catalog</p>
                            <p class="year">{{ date('Y') }}</p>
                        @elseif($pair['type'] === 'about')
                            <h2>Hakkımızda</h2>
                            <div class="about-content">
                                <div class="about-text">
                                    <p>{{ $companyDescription }}</p>
                                    <p style="margin-top: 20px;">Firmamız, müşteri memnuniyeti ve kalite odaklı hizmet anlayışı ile sektörde öncü konumdadır. Yılların verdiği deneyim ve uzman kadromuz ile en kaliteli ürünleri en uygun fiyatlarla sunmaktayız.</p>
                                    <p style="margin-top: 20px;">Vizyonumuz, sektörde lider konumda olmak ve müşterilerimize en iyi hizmeti sunmaktır. Misyonumuz ise, kaliteli ürünler ve profesyonel hizmet anlayışı ile müşteri memnuniyetini sağlamaktır.</p>
                                </div>
                                <div class="about-image">
                                    <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=800&h=600&fit=crop" alt="Hakkımızda" loading="lazy">
                                </div>
                            </div>
                        @elseif($pair['type'] === 'product')
                            <div class="product-content">
                                <div class="product-info">
                                    <h2>{{ $pair['data']['name'] }}</h2>
                                    <p class="product-description">{{ $pair['data']['description'] }}</p>
                                    <ul class="product-features">
                                        @foreach($pair['data']['features'] as $feature)
                                            <li>{{ $feature }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="product-image">
                                    <img src="{{ $pair['data']['image'] }}" alt="{{ $pair['data']['name'] }}" loading="lazy">
                                </div>
                            </div>
                        @elseif($pair['type'] === 'footer')
                            <div class="footer-content">
                                <div class="footer-contact">
                                    <h3>İletişim Bilgileri</h3>
                                    <p><strong>{{ $companyName }}</strong></p>
                                    <p>{{ $companyAddress }}</p>
                                    <p><a href="tel:{{ $companyPhone }}">{{ $companyPhone }}</a></p>
                                    <p><a href="mailto:{{ $companyEmail }}">{{ $companyEmail }}</a></p>
                                </div>
                                <div class="footer-logo">
                                    @if(file_exists(public_path('theme/assets/img/logo-3.png')))
                                        <img src="{{ asset('theme/assets/img/logo-3.png') }}" alt="{{ $companyName }}">
                                    @else
                                        <h2>{{ $companyName }}</h2>
                                    @endif
                                </div>
                            </div>
                            <div class="footer-copyright">
                                © {{ date('Y') }} {{ $companyName }}. Tüm hakları saklıdır.
                            </div>
                        @endif
                    </div>
                    <div class="page-number">{{ $pair['page'] }}</div>
                </div>

                <!-- Sağ Sayfa (Boş veya sonraki içerik) -->
                <div class="page right" data-page="{{ $rightPageNum }}" style="z-index: {{ $totalLogicalPages * 2 - $rightPageNum + 1 }}; background: {{ $isEven ? 'white' : 'linear-gradient(to right, #fafafa 0%, #ffffff 100%)' }};">
                    @if($index < count($pagePairs) - 1)
                        @php
                            $nextPair = $pagePairs[$index + 1];
                        @endphp
                        <div class="page-content">
                            @if($nextPair['type'] === 'cover')
                                <div style="text-align: center; padding: 60px; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white;">
                                    <h1 style="font-size: 72px; font-weight: 300; letter-spacing: 4px;">{{ $companyName }}</h1>
                                </div>
                            @elseif($nextPair['type'] === 'about')
                                <div style="padding: 60px; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%);">
                                    <h2 style="font-size: 48px; font-weight: 300; color: #1e3c72; text-align: center;">Hakkımızda</h2>
                                </div>
                            @elseif($nextPair['type'] === 'product')
                                <div style="padding: 60px; height: 100%; display: flex; align-items: center; justify-content: center;">
                                    <div class="product-content">
                                        <div class="product-info">
                                            <h2>{{ $nextPair['data']['name'] }}</h2>
                                            <p class="product-description">{{ $nextPair['data']['description'] }}</p>
                                            <ul class="product-features">
                                                @foreach($nextPair['data']['features'] as $feature)
                                                    <li>{{ $feature }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="product-image">
                                            <img src="{{ $nextPair['data']['image'] }}" alt="{{ $nextPair['data']['name'] }}" loading="lazy">
                                        </div>
                                    </div>
                                </div>
                            @elseif($nextPair['type'] === 'footer')
                                <div style="padding: 60px; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white;">
                                    <h3 style="font-size: 36px; font-weight: 300;">İletişim Bilgileri</h3>
                                </div>
                            @endif
                        </div>
                    @endif
                    <div class="page-number">{{ $rightPageNum }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Navigation Controls -->
    <div class="nav-controls">
        <button class="nav-btn" id="prevBtn" title="Önceki Sayfa">‹</button>
        <button class="nav-btn" id="nextBtn" title="Sonraki Sayfa">›</button>
    </div>

    <script>
        (function() {
            const book = document.getElementById('book');
            const pages = Array.from(book.querySelectorAll('.page'));
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const currentPageSpan = document.getElementById('currentPage');
            const totalPagesSpan = document.getElementById('totalPages');
            
            let currentSpread = 1; // Her spread = 2 sayfa (sol + sağ)
            const totalSpreads = {{ count($products) + 3 }};
            totalPagesSpan.textContent = totalSpreads;

            // Initialize
            function init() {
                pages.forEach(page => {
                    const pageNum = parseInt(page.dataset.page);
                    const spreadNum = Math.ceil(pageNum / 2);
                    
                    if (spreadNum > 1 && page.classList.contains('left')) {
                        page.classList.add('flipped');
                    }
                });
                updateNavigation();
            }

            function flipPage(direction) {
                if (direction === 'next' && currentSpread >= totalSpreads) return;
                if (direction === 'prev' && currentSpread <= 1) return;

                const targetSpread = direction === 'next' ? currentSpread + 1 : currentSpread - 1;
                
                pages.forEach(page => {
                    const pageNum = parseInt(page.dataset.page);
                    const spreadNum = Math.ceil(pageNum / 2);
                    
                    if (direction === 'next') {
                        if (spreadNum === currentSpread && page.classList.contains('left')) {
                            page.classList.add('flipped');
                        }
                    } else {
                        if (spreadNum === currentSpread - 1 && page.classList.contains('left')) {
                            page.classList.remove('flipped');
                        }
                    }
                });

                currentSpread = Math.max(1, Math.min(totalSpreads, targetSpread));
                updateNavigation();
            }

            function updateNavigation() {
                currentPageSpan.textContent = currentSpread;
                prevBtn.disabled = currentSpread <= 1;
                nextBtn.disabled = currentSpread >= totalSpreads;
            }

            // Event listeners
            prevBtn.addEventListener('click', () => flipPage('prev'));
            nextBtn.addEventListener('click', () => flipPage('next'));

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
                    e.preventDefault();
                    flipPage(e.key === 'ArrowRight' ? 'next' : 'prev');
                } else if (e.key === 'Home') {
                    e.preventDefault();
                    currentSpread = 1;
                    init();
                } else if (e.key === 'End') {
                    e.preventDefault();
                    currentSpread = totalSpreads;
                    pages.forEach(page => {
                        const pageNum = parseInt(page.dataset.page);
                        const spreadNum = Math.ceil(pageNum / 2);
                        if (spreadNum < totalSpreads && page.classList.contains('left')) {
                            page.classList.add('flipped');
                        }
                    });
                    updateNavigation();
                }
            });

            // Touch/swipe support
            let startX = 0;
            let startY = 0;

            book.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
                startY = e.touches[0].clientY;
            });

            book.addEventListener('touchend', (e) => {
                if (!startX || !startY) return;
                
                const endX = e.changedTouches[0].clientX;
                const endY = e.changedTouches[0].clientY;
                const diffX = startX - endX;
                const diffY = startY - endY;

                if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 50) {
                    flipPage(diffX > 0 ? 'next' : 'prev');
                }

                startX = 0;
                startY = 0;
            });

            // Click on page edges to flip
            pages.forEach(page => {
                if (page.classList.contains('left')) {
                    page.addEventListener('click', (e) => {
                        const rect = page.getBoundingClientRect();
                        if (e.clientX > rect.right - 100) {
                            flipPage('next');
                        }
                    });
                }
                if (page.classList.contains('right')) {
                    page.addEventListener('click', (e) => {
                        const rect = page.getBoundingClientRect();
                        if (e.clientX < rect.left + 100) {
                            flipPage('prev');
                        }
                    });
                }
            });

            // Initialize
            init();
        })();
    </script>
</body>
</html>
