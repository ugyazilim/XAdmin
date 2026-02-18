<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $news = [
            [
                'title' => 'Oba Ticaret, Akıllı Çelik Kapı Sistemlerinde Yeni Teknoloji Geliştirdi',
                'slug' => 'oba-ticaret-akilli-celik-kapi-sistemlerinde-yeni-teknoloji-gelistirdi',
                'excerpt' => 'Oba Ticaret, 2024 yılında başlattığı AR-GE çalışmaları sonucunda akıllı çelik kapı sistemlerinde devrim niteliğinde bir teknoloji geliştirdi. Yeni sistem, güvenlik ve enerji verimliliğini bir araya getiriyor.',
                'content' => '<p>Oba Ticaret, 1996\'dan bu yana sürdürdüğü kaliteli hizmet anlayışını teknolojik yeniliklerle birleştirerek inşaat sektöründe öncü olmaya devam ediyor. Son dönemde gerçekleştirdiği kapsamlı AR-GE çalışmaları neticesinde, akıllı çelik kapı sistemlerinde yeni bir teknoloji geliştirdi.</p>

<p>Bu yeni teknoloji, geleneksel çelik kapı sistemlerinin ötesine geçerek, dijital entegrasyon ve akıllı kontrol sistemleri sunuyor. Geliştirilen sistem, mobil uygulama üzerinden kontrol edilebilen, uzaktan erişim özellikli ve enerji verimliliği sağlayan bir yapıya sahip.</p>

<p>Oba Ticaret\'in AR-GE ekibi, Kadirli/Osmaniye\'deki merkezinde 18 aylık yoğun bir çalışma süreci sonunda bu teknolojiyi hayata geçirdi. Proje kapsamında, çelik kapı üretiminde kullanılan malzemelerin dayanıklılık testleri, akıllı sistem entegrasyonları ve enerji tüketim analizleri gerçekleştirildi.</p>

<p>Yeni sistemin en önemli özellikleri arasında, biyometrik erişim kontrolü, otomatik kilit mekanizması, yangın ve deprem sensörleri ile entegre çalışma kabiliyeti bulunuyor. Ayrıca, sistem güneş enerjisi ile çalışabilme özelliğine sahip, bu sayede enerji maliyetlerinde %40\'a varan tasarruf sağlanıyor.</p>

<p>Oba Ticaret Genel Müdürü, yaptığı açıklamada: "Bu teknoloji, sadece bir ürün geliştirme değil, aynı zamanda sektörde yeni bir standart oluşturma çalışmasıdır. Müşterilerimize en güvenli, en verimli ve en teknolojik çözümleri sunmak için sürekli araştırma ve geliştirme yapıyoruz" dedi.</p>

<p>Geliştirilen akıllı çelik kapı sistemi, önümüzdeki aylarda piyasaya sürülecek ve Oba Ticaret\'in tüm müşterilerine sunulacak. Şirket, bu teknoloji ile inşaat sektöründe sürdürülebilirlik ve dijitalleşme alanında öncü olmayı hedefliyor.</p>',
                'type' => 'news',
                'published_at' => now()->subDays(5),
                'sort_order' => 1,
                'is_published' => true,
                'meta_title' => 'Oba Ticaret Akıllı Çelik Kapı Sistemleri - AR-GE Çalışmaları',
                'meta_description' => 'Oba Ticaret, akıllı çelik kapı sistemlerinde yeni teknoloji geliştirdi. AR-GE çalışmaları sonucu ortaya çıkan sistem, güvenlik ve enerji verimliliğini bir araya getiriyor.',
            ],
            [
                'title' => 'Oba Ticaret, Sürdürülebilir Yapı Malzemeleri İçin Yeni Proje Başlattı',
                'slug' => 'oba-ticaret-surdurulebilir-yapi-malzemeleri-icin-yeni-proje-baslatti',
                'excerpt' => 'Çevre dostu yapı malzemeleri üretimi için kapsamlı bir AR-GE projesi başlatan Oba Ticaret, geri dönüştürülebilir malzemeler kullanarak sürdürülebilir inşaat çözümleri geliştiriyor.',
                'content' => '<p>Oba Ticaret, inşaat sektöründe sürdürülebilirlik konusunda önemli bir adım atarak, çevre dostu yapı malzemeleri üretimi için kapsamlı bir AR-GE projesi başlattı. Proje kapsamında, geri dönüştürülebilir malzemeler kullanılarak yeni nesil yapı malzemeleri geliştiriliyor.</p>

<p>Proje, Oba Ticaret\'in Kadirli/Osmaniye\'deki AR-GE merkezinde, üniversiteler ve araştırma kurumları ile işbirliği içinde yürütülüyor. İki yıllık bir süreçte tamamlanması planlanan proje, PVC kapı sistemleri, alüminyum duşakabin ve ısı yalıtım malzemelerinde çevre dostu alternatifler sunmayı hedefliyor.</p>

<p>Oba Ticaret\'in AR-GE ekibi, proje kapsamında gerçekleştirdiği çalışmalarda, endüstriyel atıklardan elde edilen malzemeleri yapı sektöründe kullanılabilir hale getirmek için yoğun testler yapıyor. Geliştirilen malzemeler, geleneksel malzemelere göre %30 daha az karbon ayak izi bırakıyor ve %50\'ye varan oranlarda geri dönüştürülebiliyor.</p>

<p>Proje koordinatörü, yaptığı açıklamada: "Sürdürülebilirlik, artık bir tercih değil, bir zorunluluk. Oba Ticaret olarak, gelecek nesillere daha yaşanabilir bir dünya bırakmak için çevre dostu çözümler geliştirmeye odaklanıyoruz. Bu proje, bu hedefimizin önemli bir parçası" dedi.</p>

<p>Geliştirilen sürdürülebilir yapı malzemeleri, öncelikle Oba Ticaret\'in kendi projelerinde test edilecek ve başarılı sonuçlar alındıktan sonra tüm müşterilere sunulacak. Şirket, bu proje ile inşaat sektöründe çevre bilincinin artırılmasına katkı sağlamayı hedefliyor.</p>

<p>Oba Ticaret, sürdürülebilirlik konusundaki çalışmalarını sadece ürün geliştirme ile sınırlı tutmuyor. Şirket, üretim süreçlerinde de çevre dostu uygulamalar benimsiyor ve enerji verimliliği sağlayan sistemler kullanıyor.</p>',
                'type' => 'news',
                'published_at' => now()->subDays(12),
                'sort_order' => 2,
                'is_published' => true,
                'meta_title' => 'Oba Ticaret Sürdürülebilir Yapı Malzemeleri AR-GE Projesi',
                'meta_description' => 'Oba Ticaret, çevre dostu yapı malzemeleri üretimi için kapsamlı AR-GE projesi başlattı. Geri dönüştürülebilir malzemeler ile sürdürülebilir inşaat çözümleri geliştiriliyor.',
            ],
            [
                'title' => 'Oba Ticaret, Isı Yalıtım Teknolojilerinde İnovasyon Çalışmalarına Devam Ediyor',
                'slug' => 'oba-ticaret-isi-yalitim-teknolojilerinde-inovasyon-calismalarina-devam-ediyor',
                'excerpt' => 'Oba Ticaret, ısı yalıtım sektöründe yeni nesil teknolojiler geliştirmek için AR-GE çalışmalarına hız verdi. Nano teknoloji kullanılarak geliştirilen yalıtım malzemeleri, enerji tasarrufunda yeni standartlar oluşturuyor.',
                'content' => '<p>Oba Ticaret, ısı yalıtım sektöründe öncü olma hedefiyle, nano teknoloji tabanlı yalıtım malzemeleri geliştirmek için kapsamlı AR-GE çalışmaları yürütüyor. Yapılan araştırmalar, geleneksel yalıtım malzemelerine göre %60 daha etkili sonuçlar veriyor.</p>

<p>Proje kapsamında, Oba Ticaret\'in AR-GE ekibi, nano partiküller kullanarak ultra ince ama son derece etkili yalıtım katmanları geliştirdi. Bu teknoloji, özellikle binalarda enerji tüketimini önemli ölçüde azaltarak, hem çevresel hem de ekonomik faydalar sağlıyor.</p>

<p>Geliştirilen nano yalıtım teknolojisi, sadece ısı kaybını önlemekle kalmıyor, aynı zamanda ses yalıtımı ve yangın güvenliği konularında da üstün performans gösteriyor. Malzeme, 5 mm kalınlığında uygulanmasına rağmen, geleneksel 10 cm kalınlığındaki yalıtım malzemeleri ile aynı performansı sağlıyor.</p>

<p>Oba Ticaret\'in AR-GE merkezinde gerçekleştirilen testler, yeni teknolojinin -30°C ile +50°C arasındaki sıcaklık değişimlerinde stabil kalarak, uzun yıllar boyunca performansını koruduğunu gösteriyor. Ayrıca, malzeme UV ışınlarına karşı da dayanıklı, bu sayede dış cephe uygulamalarında güvenle kullanılabiliyor.</p>

<p>Proje yöneticisi, konuyla ilgili yaptığı açıklamada: "Nano teknoloji, inşaat sektöründe devrim yaratacak potansiyele sahip. Oba Ticaret olarak, bu teknolojiyi ısı yalıtım alanına adapte ederek, müşterilerimize en verimli çözümleri sunmayı hedefliyoruz. Yaptığımız testler, bu teknolojinin geleceğin yalıtım çözümü olduğunu gösteriyor" dedi.</p>

<p>Oba Ticaret, nano yalıtım teknolojisini önümüzdeki dönemde ticari olarak piyasaya sürmeyi planlıyor. Şirket, bu teknoloji ile özellikle yeni yapılan binalarda ve renovasyon projelerinde önemli enerji tasarrufları sağlamayı hedefliyor.</p>

<p>AR-GE çalışmaları kapsamında, Oba Ticaret ayrıca İzocam işlerinde de yeni uygulama teknikleri geliştiriyor. Geliştirilen teknikler, montaj süresini %40 azaltırken, kalite standartlarını da yükseltiyor.</p>',
                'type' => 'news',
                'published_at' => now()->subDays(20),
                'sort_order' => 3,
                'is_published' => true,
                'meta_title' => 'Oba Ticaret Nano Teknoloji Isı Yalıtım AR-GE Çalışmaları',
                'meta_description' => 'Oba Ticaret, nano teknoloji tabanlı ısı yalıtım malzemeleri geliştiriyor. AR-GE çalışmaları sonucu geleneksel yalıtıma göre %60 daha etkili çözümler üretiliyor.',
            ],
            [
                'title' => 'Oba Ticaret, Alüminyum Duşakabin Üretiminde Dijital Dönüşüm Projesi Tamamlandı',
                'slug' => 'oba-ticaret-aluminyum-dusakabin-uretiminde-dijital-donusum-projesi-tamamlandi',
                'excerpt' => 'Oba Ticaret, alüminyum duşakabin üretim süreçlerini dijitalleştirerek, üretim verimliliğini %45 artırdı. AR-GE ekibi tarafından geliştirilen otomasyon sistemleri, kalite kontrol süreçlerini de optimize etti.',
                'content' => '<p>Oba Ticaret, alüminyum duşakabin üretiminde dijital dönüşüm projesini başarıyla tamamladı. Proje kapsamında, üretim hatları tam otomasyon sistemleri ile donatıldı ve kalite kontrol süreçleri dijital platformlara taşındı.</p>

<p>18 aylık bir AR-GE sürecinin sonunda hayata geçirilen dijital dönüşüm projesi, Oba Ticaret\'in Kadirli/Osmaniye\'deki üretim tesislerinde uygulanmaya başlandı. Proje ile birlikte, üretim süreçlerinde insan hatası riski minimize edilirken, üretim hızı ve kalitesi önemli ölçüde artırıldı.</p>

<p>Geliştirilen otomasyon sistemleri, alüminyum profil kesiminden başlayarak, montaj ve kalite kontrol aşamalarına kadar tüm süreçleri kapsıyor. Sistem, 3D modelleme teknolojisi kullanarak, müşteri ölçülerine göre otomatik olarak üretim planlaması yapıyor ve hata payını sıfıra indiriyor.</p>

<p>Oba Ticaret\'in AR-GE ekibi, proje kapsamında özel bir yazılım geliştirdi. Bu yazılım, müşteri ölçülerini alarak, en uygun malzeme kullanımını hesaplıyor ve atık oranını %25\'e düşürüyor. Ayrıca, yazılım üretim süreçlerini gerçek zamanlı olarak takip ediyor ve olası sorunları önceden tespit ediyor.</p>

<p>Proje koordinatörü, yaptığı açıklamada: "Dijital dönüşüm, sadece teknoloji yatırımı değil, aynı zamanda iş süreçlerinin tamamen yeniden düşünülmesi anlamına geliyor. Oba Ticaret olarak, bu dönüşümü başarıyla tamamlayarak, sektörde öncü bir konuma geldik. Müşterilerimize daha hızlı, daha kaliteli ve daha ekonomik çözümler sunabiliyoruz" dedi.</p>

<p>Dijital dönüşüm projesi kapsamında, Oba Ticaret ayrıca müşteri deneyimini de iyileştirdi. Geliştirilen online platform sayesinde, müşteriler ürünlerini 3D olarak görüntüleyebiliyor, özelleştirme yapabiliyor ve sipariş takibini gerçek zamanlı olarak yapabiliyor.</p>

<p>Proje sonuçları, üretim verimliliğinde %45 artış, kalite kontrol süreçlerinde %60 hızlanma ve müşteri memnuniyetinde %35 iyileşme sağladı. Oba Ticaret, bu başarılı projeyi diğer ürün gruplarına da uygulamayı planlıyor.</p>',
                'type' => 'news',
                'published_at' => now()->subDays(28),
                'sort_order' => 4,
                'is_published' => true,
                'meta_title' => 'Oba Ticaret Alüminyum Duşakabin Dijital Dönüşüm Projesi',
                'meta_description' => 'Oba Ticaret, alüminyum duşakabin üretiminde dijital dönüşüm projesini tamamladı. AR-GE çalışmaları ile üretim verimliliği %45 artırıldı.',
            ],
            [
                'title' => 'Oba Ticaret, Mobilya Sektöründe Özel Tasarım ve Üretim Teknolojileri Geliştirdi',
                'slug' => 'oba-ticaret-mobilya-sektorunde-ozel-tasarim-ve-uretim-teknolojileri-gelistirdi',
                'excerpt' => 'Oba Ticaret, mobilya sektöründe özel tasarım ve üretim için yeni teknolojiler geliştirdi. AR-GE ekibi, müşteri ihtiyaçlarına özel çözümler üretmek için gelişmiş CAD/CAM sistemleri ve CNC teknolojileri entegre etti.',
                'content' => '<p>Oba Ticaret, mobilya sektöründe özel tasarım ve üretim alanında önemli bir adım atarak, gelişmiş teknolojiler kullanarak müşteri ihtiyaçlarına özel çözümler üretmeye başladı. AR-GE ekibi, bu süreçte CAD/CAM sistemleri ve CNC teknolojilerini entegre ederek, özel tasarım mobilya üretiminde yeni standartlar oluşturdu.</p>

<p>Geliştirilen sistem, müşterilerin kendi tasarımlarını veya özel ihtiyaçlarını dijital ortamda görselleştirmelerine olanak tanıyor. AR-GE ekibi tarafından geliştirilen yazılım, müşteri tasarımlarını analiz ederek, üretilebilirlik kontrolü yapıyor ve en uygun üretim yöntemini öneriyor.</p>

<p>Oba Ticaret\'in Kadirli/Osmaniye\'deki üretim tesislerinde kurulan CNC tezgahları, gelişmiş yazılım kontrolü ile çalışıyor. Bu sistemler, ahşap, MDF, laminat ve diğer malzemeleri yüksek hassasiyetle işleyerek, müşteri tasarımlarını gerçeğe dönüştürüyor.</p>

<p>AR-GE çalışmaları kapsamında, Oba Ticaret ayrıca sürdürülebilir mobilya üretimi için yeni malzemeler test ediyor. Geri dönüştürülmüş ahşap ve çevre dostu yapıştırıcılar kullanılarak, hem kaliteli hem de çevreye duyarlı ürünler üretiliyor.</p>

<p>Proje yöneticisi, yaptığı açıklamada: "Mobilya sektöründe özel tasarım, artık lüks değil, bir ihtiyaç haline geldi. Oba Ticaret olarak, teknolojik altyapımızı güçlendirerek, müşterilerimize hayal ettikleri mobilyaları üretme imkanı sunuyoruz. AR-GE çalışmalarımız, bu alanda sürekli yenilik getirmemizi sağlıyor" dedi.</p>

<p>Geliştirilen teknolojiler sayesinde, Oba Ticaret artık karmaşık tasarımları bile kısa sürede ve yüksek kalitede üretebiliyor. Özel tasarım mobilya üretim süresi, geleneksel yöntemlere göre %50 azalırken, kalite standartları da önemli ölçüde yükseldi.</p>

<p>Oba Ticaret, mobilya sektöründeki AR-GE çalışmalarını sadece üretim teknolojileri ile sınırlı tutmuyor. Şirket, aynı zamanda ergonomi, estetik ve fonksiyonellik konularında da araştırmalar yürütüyor. Bu çalışmalar, müşterilere hem görsel olarak çekici hem de kullanım açısından pratik mobilya çözümleri sunmayı hedefliyor.</p>

<p>Şirket, özel tasarım mobilya hizmetini, mutfak dolaplarından yatak odası takımlarına, ofis mobilyalarından banyo dolaplarına kadar geniş bir yelpazede sunuyor. Her proje, müşteri ihtiyaçlarına özel olarak tasarlanıyor ve üretiliyor.</p>',
                'type' => 'news',
                'published_at' => now()->subDays(35),
                'sort_order' => 5,
                'is_published' => true,
                'meta_title' => 'Oba Ticaret Özel Tasarım Mobilya AR-GE Teknolojileri',
                'meta_description' => 'Oba Ticaret, mobilya sektöründe özel tasarım ve üretim için gelişmiş teknolojiler geliştirdi. CAD/CAM ve CNC sistemleri ile müşteri ihtiyaçlarına özel çözümler üretiliyor.',
            ],
            [
                'title' => 'Oba Ticaret, PVC Kapı Sistemlerinde Ses Yalıtım Teknolojisi Geliştirdi',
                'slug' => 'oba-ticaret-pvc-kapi-sistemlerinde-ses-yalitim-teknolojisi-gelistirdi',
                'excerpt' => 'Oba Ticaret, PVC kapı sistemlerinde ses yalıtım performansını artırmak için kapsamlı AR-GE çalışmaları yürüttü. Geliştirilen yeni teknoloji, ses geçirgenliğini %70 azaltarak, konforlu yaşam alanları oluşturuyor.',
                'content' => '<p>Oba Ticaret, PVC kapı sistemlerinde ses yalıtım performansını önemli ölçüde artıran yeni bir teknoloji geliştirdi. AR-GE ekibi, iki yıllık bir çalışma sürecinde, çeşitli malzeme kombinasyonları ve yapısal tasarımlar test ederek, optimum ses yalıtım çözümünü buldu.</p>

<p>Geliştirilen teknoloji, çok katmanlı yapı ve özel dolgu malzemeleri kullanarak, ses geçirgenliğini %70 oranında azaltıyor. Bu teknoloji, özellikle apartman dairelerinde, ofis binalarında ve otel gibi konaklama tesislerinde önemli bir konfor artışı sağlıyor.</p>

<p>Oba Ticaret\'in AR-GE merkezinde gerçekleştirilen testler, yeni teknolojinin hem düşük frekanslı (trafik, makine sesleri) hem de yüksek frekanslı (konuşma, müzik) sesleri etkili bir şekilde bloke ettiğini gösteriyor. Test sonuçları, geliştirilen sistemin uluslararası ses yalıtım standartlarını aştığını ortaya koyuyor.</p>

<p>Proje kapsamında, Oba Ticaret ayrıca PVC kapı çerçevelerinde de iyileştirmeler yaptı. Geliştirilen özel contalar ve çok katmanlı cam sistemleri, ses yalıtım performansını daha da artırıyor. Ayrıca, kapı kanatlarının iç yapısı, akustik özellikleri optimize edilmiş özel bölmeler ile güçlendirildi.</p>

<p>AR-GE ekibi lideri, yaptığı açıklamada: "Ses yalıtımı, modern yaşam alanlarında giderek daha önemli hale geliyor. Oba Ticaret olarak, PVC kapı sistemlerinde ses yalıtım teknolojisini geliştirerek, müşterilerimize daha konforlu yaşam alanları sunmayı hedefliyoruz. Yaptığımız AR-GE çalışmaları, bu hedefe ulaşmamızı sağladı" dedi.</p>

<p>Geliştirilen ses yalıtım teknolojisi, sadece performans açısından değil, aynı zamanda estetik açıdan da avantajlar sunuyor. Teknoloji, kapıların görsel tasarımını etkilemeden, ses yalıtım performansını artırıyor. Bu sayede, müşteriler hem estetik hem de fonksiyonel çözümler elde ediyor.</p>

<p>Oba Ticaret, yeni ses yalıtım teknolojisini tüm PVC kapı modellerinde uygulamaya başladı. Şirket, bu teknoloji ile özellikle şehir merkezlerinde ve gürültülü bölgelerde bulunan binalarda önemli bir konfor artışı sağlamayı hedefliyor.</p>

<p>AR-GE çalışmaları kapsamında, Oba Ticaret ayrıca ses yalıtım performansını ölçmek için özel test laboratuvarları kurdu. Bu laboratuvarlarda, gerçek yaşam koşulları simüle edilerek, ürünlerin ses yalıtım performansı detaylı olarak test ediliyor.</p>

<p>Şirket, ses yalıtım teknolojisindeki başarısını, diğer ürün gruplarına da uygulamayı planlıyor. Özellikle alüminyum duşakabin ve çelik kapı sistemlerinde de benzer teknolojilerin geliştirilmesi için çalışmalar sürdürülüyor.</p>',
                'type' => 'news',
                'published_at' => now()->subDays(42),
                'sort_order' => 6,
                'is_published' => true,
                'meta_title' => 'Oba Ticaret PVC Kapı Ses Yalıtım Teknolojisi AR-GE',
                'meta_description' => 'Oba Ticaret, PVC kapı sistemlerinde ses yalıtım performansını %70 artıran yeni teknoloji geliştirdi. AR-GE çalışmaları ile konforlu yaşam alanları oluşturuluyor.',
            ],
        ];

        foreach ($news as $item) {
            News::updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }
    }
}
