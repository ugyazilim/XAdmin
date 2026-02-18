<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use App\Models\News;
use App\Models\Project;
use App\Models\Reference;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Slider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $sliders = Slider::active()->ordered()->get();
        $categories = Category::where('status', 'active')->orderBy('sort_order')->limit(5)->get();
        $latestNews = News::published()->news()->ordered()->limit(3)->get();

        return view('frontend.pages.home', compact('sliders', 'categories', 'latestNews'));
    }

    public function about(): View
    {
        $page = \App\Models\Page::where('slug', 'hakkimizda')->where('is_published', true)->first();
        if (! $page) {
            abort(404);
        }

        return view('frontend.pages.about', compact('page'));
    }

    public function vision(): View
    {
        $page = \App\Models\Page::where('slug', 'vizyon')->where('is_published', true)->first();
        if (! $page) {
            abort(404);
        }

        return view('frontend.pages.page', compact('page'));
    }

    public function mission(): View
    {
        $page = \App\Models\Page::where('slug', 'misyon')->where('is_published', true)->first();
        if (! $page) {
            abort(404);
        }

        return view('frontend.pages.page', compact('page'));
    }

    public function projects(Request $request): View
    {
        // Projeler artık kategoriye bağlı değil - gerçek referans projeleri
        $query = Project::published()->ordered();

        $projects = $query->paginate(12);

        return view('frontend.pages.projects', compact('projects'));
    }

    public function showProject(string $slug): View
    {
        $project = Project::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // İlgili projeler
        $relatedProjects = Project::where('id', '!=', $project->id)
            ->published()
            ->ordered()
            ->limit(6)
            ->get();

        return view('frontend.pages.projects.show', compact('project', 'relatedProjects'));
    }

    public function references(): View
    {
        $references = Reference::published()->ordered()->get();

        return view('frontend.pages.references', compact('references'));
    }

    public function contact(): View
    {
        $googleMapsEmbed = Setting::where('key', 'google_maps_embed')->first()?->value;

        return view('frontend.pages.contact', compact('googleMapsEmbed'));
    }

    public function contactStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create($validated);

        return back()->with('success', 'Mesajınız başarıyla gönderildi. En kısa sürede size dönüş yapacağız.');
    }

    public function contactSubmit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string',
        ]);

        Contact::create([
            'name' => $validated['name'],
            'email' => null,
            'phone' => $validated['phone'],
            'subject' => 'İletişim Formu',
            'message' => $validated['message'],
        ]);

        return back()->with('success', 'Mesajınız başarıyla gönderildi. En kısa sürede size dönüş yapacağız.');
    }

    public function services(Request $request): View
    {
        $query = Service::with(['category', 'images'])->active()->ordered();

        // Seçili kategoriler (footer'daki gibi)
        $categorySlugs = [
            'aluminyum-vitrin',
            'otomatik-kepenk',
            'ic-oda-kapilari',
            'dusakabin-sistemleri',
            'pvc-kapi-ve-pencere-sistemleri',
        ];

        // Kategori filtresi
        if ($request->has('category') && $request->category) {
            $category = Category::where('slug', $request->category)
                ->where('status', 'active')
                ->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        $services = $query->get();
        $categories = Category::active()
            ->whereIn('slug', $categorySlugs)
            ->orderByRaw('FIELD(slug, "'.implode('","', $categorySlugs).'")')
            ->get();
        $selectedCategory = $request->category ? Category::where('slug', $request->category)->first() : null;

        return view('frontend.pages.services', compact('services', 'categories', 'selectedCategory'));
    }

    // Hizmet Sayfaları - Dinamik
    public function showService(string $slug): View
    {
        $service = Service::with('images')->where('slug', $slug)->where('is_active', true)->first();

        if (! $service) {
            // Slug'a göre bulunamazsa, eski route'lara yönlendir
            $slugMap = [
                'celik-kapi' => 'steel-doors',
                'celik-kapi-sistemleri' => 'steel-doors',
                'pvc-kapi' => 'pvc-doors',
                'pvc-kapi-sistemleri' => 'pvc-doors',
                'aluminyum-dusakabin' => 'shower-cabins',
                'mobilya' => 'furniture',
                'isi-yalitim' => 'insulation',
                'izocam' => 'isocam',
                'izocam-isleri' => 'isocam',
            ];

            if (isset($slugMap[$slug])) {
                return redirect()->route('services.'.$slugMap[$slug])->setStatusCode(301);
            }

            abort(404);
        }

        // Aynı kategoriden rastgele 3 hizmet çek (mevcut hizmet hariç)
        $relatedServices = Service::with(['images', 'category'])
            ->where('category_id', $service->category_id)
            ->where('id', '!=', $service->id)
            ->where('is_active', true)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('frontend.pages.services.show', compact('service', 'relatedServices'));
    }

    // Eski route'lar için backward compatibility - Dinamik hizmetlere yönlendir
    public function steelDoors(): RedirectResponse
    {
        $service = Service::with('images')->where('slug', 'celik-kapi-sistemleri')->where('is_active', true)->first();
        if (! $service) {
            $service = Service::with('images')->where('slug', 'celik-kapi')->where('is_active', true)->first();
        }
        if (! $service) {
            $service = Service::with('images')->where('slug', 'like', '%celik%')->where('is_active', true)->first();
        }
        if ($service) {
            return redirect()->route('services.show', $service->slug)->setStatusCode(301);
        }

        return redirect()->route('services')->setStatusCode(301);
    }

    public function pvcDoors(): RedirectResponse
    {
        $service = Service::with('images')->where('slug', 'pvc-kapi-sistemleri')->where('is_active', true)->first();
        if (! $service) {
            $service = Service::with('images')->where('slug', 'pvc-kapi')->where('is_active', true)->first();
        }
        if (! $service) {
            $service = Service::with('images')->where('slug', 'like', '%pvc%')->where('is_active', true)->first();
        }
        if ($service) {
            return redirect()->route('services.show', $service->slug)->setStatusCode(301);
        }

        return redirect()->route('services')->setStatusCode(301);
    }

    public function showerCabins(): RedirectResponse
    {
        $service = Service::with('images')->where('slug', 'aluminyum-dusakabin')->where('is_active', true)->first();
        if (! $service) {
            $service = Service::with('images')->where('slug', 'like', '%dusakabin%')->where('is_active', true)->first();
        }
        if ($service) {
            return redirect()->route('services.show', $service->slug)->setStatusCode(301);
        }

        return redirect()->route('services')->setStatusCode(301);
    }

    public function furniture(): RedirectResponse
    {
        $service = Service::with('images')->where('slug', 'mobilya')->where('is_active', true)->first();
        if (! $service) {
            $service = Service::with('images')->where('slug', 'like', '%mobilya%')->where('is_active', true)->first();
        }
        if ($service) {
            return redirect()->route('services.show', $service->slug)->setStatusCode(301);
        }

        return redirect()->route('services')->setStatusCode(301);
    }

    public function insulation(): RedirectResponse
    {
        $service = Service::with('images')->where('slug', 'isi-yalitim')->where('is_active', true)->first();
        if (! $service) {
            $service = Service::with('images')->where('slug', 'like', '%yalitim%')->where('is_active', true)->first();
        }
        if ($service) {
            return redirect()->route('services.show', $service->slug)->setStatusCode(301);
        }

        return redirect()->route('services')->setStatusCode(301);
    }

    public function isocam(): RedirectResponse
    {
        $service = Service::with('images')->where('slug', 'izocam-isleri')->where('is_active', true)->first();
        if (! $service) {
            $service = Service::with('images')->where('slug', 'izocam')->where('is_active', true)->first();
        }
        if (! $service) {
            $service = Service::with('images')->where('slug', 'like', '%izocam%')->where('is_active', true)->first();
        }
        if ($service) {
            return redirect()->route('services.show', $service->slug)->setStatusCode(301);
        }

        return redirect()->route('services')->setStatusCode(301);
    }

    public function catalog(): View
    {
        // Placeholder ürünler - İleride veritabanından gelecek
        // Unsplash'tan gerçekçi inşaat/yapı görselleri kullanılıyor
        $products = [
            [
                'id' => 1,
                'name' => 'Yüksek Kaliteli Çelik Profil',
                'image' => 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=1200&h=800&fit=crop',
                'description' => 'Endüstriyel ve yapı sektöründe kullanılan yüksek kaliteli çelik profillerimiz, uluslararası standartlarda üretilmektedir.',
                'features' => [
                    'ISO 9001 Kalite Sertifikalı',
                    'Paslanmaz Çelik Malzeme',
                    'Çeşitli Ölçülerde Mevcut',
                    'Hızlı Teslimat',
                    'Uygun Fiyat Garantisi',
                ],
            ],
            [
                'id' => 2,
                'name' => 'Premium Beton Karışımı',
                'image' => 'https://images.unsplash.com/photo-1504307651254-35680f096041?w=1200&h=800&fit=crop',
                'description' => 'Yüksek dayanıklılık ve performans sunan premium beton karışımlarımız, en zorlu projelerde güvenle kullanılabilir.',
                'features' => [
                    'Yüksek Dayanıklılık',
                    'Hızlı Kuruma Özelliği',
                    'Çevre Dostu Formül',
                    'Toplu Alım İndirimi',
                    'Teknik Destek Hizmeti',
                ],
            ],
            [
                'id' => 3,
                'name' => 'Endüstriyel Yalıtım Malzemesi',
                'image' => 'https://images.unsplash.com/photo-1504307651254-35680f096041?w=1200&h=800&fit=crop',
                'description' => 'A+ sınıfı yalıtım özelliği ile enerji tasarrufu sağlayan, yangına dayanıklı yalıtım çözümlerimiz.',
                'features' => [
                    'A+ Sınıfı Yalıtım',
                    'Yangına Dayanıklı',
                    'Uzun Ömürlü',
                    'Kolay Montaj',
                    'Enerji Tasarrufu Sağlar',
                ],
            ],
            [
                'id' => 4,
                'name' => 'Modern Alüminyum Cephe Sistemi',
                'image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1200&h=800&fit=crop',
                'description' => 'Modern mimari projeler için tasarlanmış, hava koşullarına dayanıklı alüminyum cephe sistemlerimiz.',
                'features' => [
                    'Modern Tasarım',
                    'Hava Koşullarına Dayanıklı',
                    'Bakım Gerektirmez',
                    'Özel Ölçü İmkanı',
                    'Profesyonel Montaj Hizmeti',
                ],
            ],
            [
                'id' => 5,
                'name' => 'Yüksek Performanslı Boya',
                'image' => 'https://images.unsplash.com/photo-1563453392212-326f5e854473?w=1200&h=800&fit=crop',
                'description' => 'UV ışınlarına ve suya dayanıklı, uzun ömürlü ve çevre dostu premium boya çözümlerimiz.',
                'features' => [
                    'UV Işınlarına Dayanıklı',
                    'Su Geçirmez Özellik',
                    'Geniş Renk Paleti',
                    'Çevre Dostu İçerik',
                    'Uzun Süreli Garanti',
                ],
            ],
            [
                'id' => 6,
                'name' => 'Premium Seramik Kaplama',
                'image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1200&h=800&fit=crop',
                'description' => 'İtalyan kalitesinde, kaymaz yüzey özelliği ile güvenli ve estetik seramik kaplama çözümlerimiz.',
                'features' => [
                    'İtalyan Kalitesi',
                    'Kaymaz Yüzey',
                    'Kolay Temizlenir',
                    'Çeşitli Desenler',
                    'Uzun Ömürlü',
                ],
            ],
        ];

        $companyName = Setting::get('site_name', 'OBA TİCARET | Yapı Malz. - Mobilya - PVC - Çelik Kapı');
        $companyAddress = Setting::get('company_address', Setting::get('address', 'Şehit Halis Şişman Mah. Kamil Kara Bul. No:240 Kadirli/Osmaniye, Osmaniye 80750'));
        $companyPhone = Setting::get('company_phone', Setting::get('contact_phone', '0532 641 53 16'));
        $companyEmail = Setting::get('contact_email', 'info@obaticaret.com');
        $companyDescription = Setting::get('company_description', Setting::get('description', '1996\'dan bu yana Kadirli/Osmaniye\'de çelik kapı, PVC kapı, alüminyum duşakabin, mobilya, ısı yalıtım ve izocam alanlarında kaliteli ürün ve hizmetler sunuyoruz.'));

        return view('frontend.pages.catalog', compact('products', 'companyName', 'companyAddress', 'companyPhone', 'companyEmail', 'companyDescription'));
    }

    public function news(): View
    {
        $news = News::published()->news()->ordered()->paginate(12);

        return view('frontend.pages.news.index', compact('news'));
    }

    public function showNews(string $slug): View
    {
        $newsItem = News::where('slug', $slug)->where('is_published', true)->firstOrFail();

        return view('frontend.pages.news.show', compact('newsItem'));
    }

    public function search(Request $request): View
    {
        $query = $request->get('q', '');

        $newsResults = collect();
        $serviceResults = collect();

        if (! empty($query)) {
            // Haberler/Blog araması
            $newsResults = News::published()
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', '%'.$query.'%')
                        ->orWhere('excerpt', 'like', '%'.$query.'%')
                        ->orWhere('content', 'like', '%'.$query.'%');
                })
                ->ordered()
                ->get();

            // Hizmetler araması
            $serviceResults = Service::active()
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', '%'.$query.'%')
                        ->orWhere('short_description', 'like', '%'.$query.'%')
                        ->orWhere('content', 'like', '%'.$query.'%');
                })
                ->ordered()
                ->get();
        }

        return view('frontend.pages.search', compact('query', 'newsResults', 'serviceResults'));
    }
}
