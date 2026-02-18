<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $site->company_name }} - Kurumsal Katalog</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100%; overflow: hidden; background: #0a0a0a; }
        body { font-family: 'Georgia', 'Times New Roman', serif; color: #2c3e50; line-height: 1.6; }

        .flipbook-container {
            width: 100vw; height: 100vh; display: flex; justify-content: center; align-items: center;
            background: radial-gradient(circle at center, #1a1a2e 0%, #0a0a0a 100%);
            perspective: 2500px; position: relative;
        }
        .book { width: 90vw; height: 90vh; max-width: 1400px; max-height: 900px; position: relative; transform-style: preserve-3d; }

        .page {
            width: 50%; height: 100%; position: absolute; background: white;
            display: flex; flex-direction: column; justify-content: center; padding: 0;
            backface-visibility: hidden; transform-origin: left center;
            transition: transform 1s cubic-bezier(0.645, 0.045, 0.355, 1);
            box-shadow: 0 5px 25px rgba(0,0,0,0.4); overflow: hidden;
        }
        .page.left { left: 0; }
        .page.right { right: 0; transform-origin: right center; }
        .page.flipped { transform: rotateY(-180deg); }
        .page-content { width: 100%; height: 100%; padding: 60px; display: flex; flex-direction: column; justify-content: center; position: relative; }

        .page.cover {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #7e8ba3 100%);
            color: white; text-align: center;
        }
        .page.cover::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }
        .page.cover h1 { font-size: 72px; font-weight: 300; margin-bottom: 30px; letter-spacing: 4px; text-transform: uppercase; text-shadow: 2px 2px 4px rgba(0,0,0,0.3); position: relative; z-index: 1; }
        .page.cover .subtitle { font-size: 28px; opacity: 0.95; margin-bottom: 20px; font-weight: 300; letter-spacing: 2px; position: relative; z-index: 1; }
        .page.cover .subtitle-en { font-size: 22px; opacity: 0.85; margin-bottom: 60px; font-style: italic; position: relative; z-index: 1; }
        .page.cover .year { font-size: 20px; opacity: 0.8; margin-top: 60px; font-weight: 300; letter-spacing: 1px; position: relative; z-index: 1; }

        .page.about { background: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%); }
        .page.about h2 { font-size: 48px; font-weight: 300; color: #1e3c72; margin-bottom: 40px; text-align: center; letter-spacing: 2px; position: relative; padding-bottom: 20px; }
        .page.about h2::after { content: ''; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 100px; height: 3px; background: linear-gradient(90deg, transparent, #667eea, transparent); }
        .page.about .about-text { font-size: 18px; color: #444; line-height: 1.9; text-align: justify; }
        .page.about .about-text p { margin-bottom: 20px; }

        .page.product { background: white; }
        .page.product:nth-child(even) { background: linear-gradient(to right, #fafafa 0%, #ffffff 100%); }
        .product-content { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; height: 100%; }
        .product-info h2 { font-size: 44px; font-weight: 300; color: #1e3c72; margin-bottom: 30px; line-height: 1.3; letter-spacing: 1px; position: relative; padding-bottom: 15px; }
        .product-info h2::after { content: ''; position: absolute; bottom: 0; left: 0; width: 80px; height: 2px; background: linear-gradient(90deg, #667eea, transparent); }
        .product-info .product-description { font-size: 17px; color: #555; line-height: 1.9; margin-bottom: 40px; text-align: justify; }
        .product-info .product-category { display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 6px 16px; border-radius: 20px; font-size: 13px; margin-bottom: 20px; font-family: sans-serif; }
        .product-image { border-radius: 12px; overflow: hidden; box-shadow: 0 15px 50px rgba(0,0,0,0.2); position: relative; transition: transform 0.3s ease; }
        .product-image:hover { transform: translateY(-5px); }
        .product-image img { width: 100%; height: auto; display: block; }

        .page.footer { background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; }
        .footer-content { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; height: 100%; }
        .footer-contact h3 { font-size: 36px; font-weight: 300; margin-bottom: 40px; letter-spacing: 2px; position: relative; padding-bottom: 20px; }
        .footer-contact h3::after { content: ''; position: absolute; bottom: 0; left: 0; width: 100px; height: 3px; background: rgba(255,255,255,0.5); }
        .footer-contact p { font-size: 18px; line-height: 2; opacity: 0.95; margin-bottom: 12px; }
        .footer-contact strong { font-weight: 400; font-size: 20px; }
        .footer-contact a { color: white; text-decoration: none; border-bottom: 1px solid rgba(255,255,255,0.3); }
        .footer-contact a:hover { opacity: 0.8; border-bottom-color: white; }
        .footer-logo { display: flex; justify-content: center; align-items: center; }
        .footer-logo h2 { font-weight: 300; font-size: 56px; margin: 0; letter-spacing: 3px; }
        .footer-copyright { margin-top: 40px; padding-top: 30px; border-top: 1px solid rgba(255,255,255,0.2); text-align: center; opacity: 0.7; font-size: 14px; }

        .page-number { position: absolute; bottom: 25px; right: 40px; font-size: 14px; color: #999; font-weight: 300; }
        .page.footer .page-number, .page.cover .page-number { color: rgba(255,255,255,0.6); }

        .nav-controls { position: fixed; bottom: 40px; left: 50%; transform: translateX(-50%); z-index: 1000; display: flex; gap: 20px; background: rgba(0,0,0,0.7); padding: 15px 30px; border-radius: 50px; backdrop-filter: blur(10px); box-shadow: 0 8px 32px rgba(0,0,0,0.3); }
        .nav-btn { width: 55px; height: 55px; border-radius: 50%; background: white; color: #667eea; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: bold; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
        .nav-btn:hover:not(:disabled) { background: #667eea; color: white; transform: scale(1.1); }
        .nav-btn:disabled { opacity: 0.4; cursor: not-allowed; }

        .page-indicator { position: fixed; top: 30px; right: 30px; z-index: 1000; background: rgba(0,0,0,0.7); color: white; padding: 10px 20px; border-radius: 25px; font-size: 14px; backdrop-filter: blur(10px); }
        .back-link { position: fixed; top: 30px; left: 30px; z-index: 1000; background: rgba(0,0,0,0.7); color: white; padding: 10px 20px; border-radius: 25px; font-size: 14px; backdrop-filter: blur(10px); text-decoration: none; display: flex; align-items: center; gap: 8px; }
        .back-link:hover { background: rgba(0,0,0,0.9); color: white; }

        @media (max-width: 1200px) {
            .page-content { padding: 50px 40px; }
            .page.cover h1 { font-size: 56px; }
            .product-content, .footer-content { grid-template-columns: 1fr; gap: 40px; }
            .product-image { order: -1; }
            .product-info h2 { font-size: 36px; }
        }
        @media (max-width: 768px) {
            .page-content { padding: 40px 25px; }
            .page.cover h1 { font-size: 42px; letter-spacing: 2px; }
            .page.cover .subtitle { font-size: 20px; }
            .product-info h2, .page.about h2 { font-size: 32px; }
            .nav-controls { bottom: 20px; padding: 12px 25px; }
            .nav-btn { width: 45px; height: 45px; font-size: 20px; }
            .page-indicator, .back-link { top: 15px; padding: 8px 15px; font-size: 12px; }
            .back-link { left: 15px; }
        }
        @media (max-width: 576px) {
            .page.cover h1 { font-size: 32px; }
            .product-info h2 { font-size: 28px; }
        }
    </style>
</head>
<body>
    <div class="flipbook-container">
        <a href="{{ url('/') }}" class="back-link">&#8592; Siteye Dön</a>
        <div class="page-indicator">
            <span id="currentPage">1</span> / <span id="totalPages">{{ $services->count() + 3 }}</span>
        </div>

        <div class="book" id="book">
            @php
                $allPages = collect();
                $allPages->push(['type' => 'cover']);
                $allPages->push(['type' => 'about']);
                foreach($services as $service) {
                    $allPages->push(['type' => 'product', 'data' => $service]);
                }
                $allPages->push(['type' => 'footer']);
            @endphp

            @foreach($allPages as $index => $pair)
                @php
                    $leftPageNum = ($index * 2) + 1;
                    $rightPageNum = ($index * 2) + 2;
                @endphp

                <div class="page {{ $pair['type'] }} left" data-page="{{ $leftPageNum }}" style="z-index: {{ $allPages->count() * 2 - $leftPageNum + 1 }};">
                    <div class="page-content">
                        @if($pair['type'] === 'cover')
                            <h1>{{ $site->company_name }}</h1>
                            <p class="subtitle">Kurumsal Katalog</p>
                            <p class="subtitle-en">Corporate Catalog</p>
                            <p class="year">{{ date('Y') }}</p>
                        @elseif($pair['type'] === 'about')
                            <h2>Hakkımızda</h2>
                            <div class="about-text">
                                <p>{{ $site->company_description }}</p>
                            </div>
                        @elseif($pair['type'] === 'product')
                            <div class="product-content">
                                <div class="product-info">
                                    @if($pair['data']->category)
                                        <span class="product-category">{{ $pair['data']->category->name }}</span>
                                    @endif
                                    <h2>{{ $pair['data']->title }}</h2>
                                    <p class="product-description">{{ $pair['data']->short_description ?: Str::limit(strip_tags($pair['data']->content), 300) }}</p>
                                </div>
                                <div class="product-image">
                                    @if($pair['data']->image_url)
                                        <img src="{{ asset($pair['data']->image_url) }}" alt="{{ $pair['data']->title }}" loading="lazy">
                                    @elseif($pair['data']->images->count() > 0)
                                        <img src="{{ asset($pair['data']->images->first()->image_url) }}" alt="{{ $pair['data']->title }}" loading="lazy">
                                    @endif
                                </div>
                            </div>
                        @elseif($pair['type'] === 'footer')
                            <div class="footer-content">
                                <div class="footer-contact">
                                    <h3>İletişim Bilgileri</h3>
                                    <p><strong>{{ $site->company_name }}</strong></p>
                                    @if($site->contact_address)<p>{{ $site->contact_address }}</p>@endif
                                    @if($site->contact_phone)<p><a href="tel:{{ preg_replace('/\s+/', '', $site->contact_phone) }}">{{ $site->contact_phone }}</a></p>@endif
                                    @if($site->contact_email)<p><a href="mailto:{{ $site->contact_email }}">{{ $site->contact_email }}</a></p>@endif
                                </div>
                                <div class="footer-logo">
                                    <h2>{{ $site->company_name }}</h2>
                                </div>
                            </div>
                            <div class="footer-copyright">&copy; {{ date('Y') }} {{ $site->company_name }}. Tüm hakları saklıdır.</div>
                        @endif
                    </div>
                    <div class="page-number">{{ $index + 1 }}</div>
                </div>

                <div class="page right" data-page="{{ $rightPageNum }}" style="z-index: {{ $allPages->count() * 2 - $rightPageNum + 1 }}; background: {{ $index % 2 == 0 ? 'white' : 'linear-gradient(to right, #fafafa 0%, #ffffff 100%)' }};">
                    @if($index < $allPages->count() - 1)
                        @php $nextPair = $allPages[$index + 1]; @endphp
                        <div class="page-content">
                            @if($nextPair['type'] === 'about')
                                <div style="height: 100%; display: flex; align-items: center; justify-content: center;">
                                    <h2 style="font-size: 48px; font-weight: 300; color: #1e3c72; text-align: center;">Hakkımızda</h2>
                                </div>
                            @elseif($nextPair['type'] === 'product')
                                <div style="height: 100%; display: flex; align-items: center; justify-content: center;">
                                    <div class="product-content">
                                        <div class="product-info">
                                            @if($nextPair['data']->category)
                                                <span class="product-category">{{ $nextPair['data']->category->name }}</span>
                                            @endif
                                            <h2>{{ $nextPair['data']->title }}</h2>
                                            <p class="product-description">{{ $nextPair['data']->short_description ?: Str::limit(strip_tags($nextPair['data']->content), 300) }}</p>
                                        </div>
                                        <div class="product-image">
                                            @if($nextPair['data']->image_url)
                                                <img src="{{ asset($nextPair['data']->image_url) }}" alt="{{ $nextPair['data']->title }}" loading="lazy">
                                            @elseif($nextPair['data']->images->count() > 0)
                                                <img src="{{ asset($nextPair['data']->images->first()->image_url) }}" alt="{{ $nextPair['data']->title }}" loading="lazy">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @elseif($nextPair['type'] === 'footer')
                                <div style="height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white;">
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

    <div class="nav-controls">
        <button class="nav-btn" id="prevBtn" title="Önceki Sayfa">&#8249;</button>
        <button class="nav-btn" id="nextBtn" title="Sonraki Sayfa">&#8250;</button>
    </div>

    <script>
        (function() {
            const book = document.getElementById('book');
            const pages = Array.from(book.querySelectorAll('.page'));
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const currentPageSpan = document.getElementById('currentPage');
            const totalPagesSpan = document.getElementById('totalPages');

            let currentSpread = 1;
            const totalSpreads = {{ $services->count() + 3 }};
            totalPagesSpan.textContent = totalSpreads;

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
                        if (spreadNum === currentSpread && page.classList.contains('left')) page.classList.add('flipped');
                    } else {
                        if (spreadNum === currentSpread - 1 && page.classList.contains('left')) page.classList.remove('flipped');
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

            prevBtn.addEventListener('click', () => flipPage('prev'));
            nextBtn.addEventListener('click', () => flipPage('next'));
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') { e.preventDefault(); flipPage('prev'); }
                if (e.key === 'ArrowRight') { e.preventDefault(); flipPage('next'); }
            });

            let startX = 0;
            book.addEventListener('touchstart', (e) => { startX = e.touches[0].clientX; });
            book.addEventListener('touchend', (e) => {
                if (!startX) return;
                const diffX = startX - e.changedTouches[0].clientX;
                if (Math.abs(diffX) > 50) flipPage(diffX > 0 ? 'next' : 'prev');
                startX = 0;
            });

            init();
        })();
    </script>
</body>
</html>
