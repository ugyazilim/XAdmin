<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Hakkımızda',
                'slug' => 'hakkimizda',
                'content' => '<p>OBA TİCARET | Yapı Malz. - Mobilya - PVC - Çelik Kapı olarak 1996\'dan bu yana Kadirli/Osmaniye\'de çelik kapı, PVC kapı, alüminyum duşakabin, mobilya, ısı yalıtım ve izocam alanlarında kaliteli ürün ve hizmetler sunuyoruz.</p><p>Şehit Halis Şişman Mah. Kamil Kara Bul. No:240 Kadirli/Osmaniye, Osmaniye 80750 adresinde hizmet vermekteyiz. Uzman ekibimiz ve geniş ürün yelpazemizle evinizi ve iş yerinizi güvenli, konforlu ve estetik hale getiriyoruz.</p>',
                'template' => 'default',
                'meta_title' => 'Hakkımızda - OBA TİCARET',
                'meta_description' => 'OBA TİCARET hakkında bilgiler. 1996\'dan bu yana Kadirli/Osmaniye\'de yapı malzemeleri, mobilya, PVC ve çelik kapı alanlarında hizmet veriyoruz.',
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Vizyon',
                'slug' => 'vizyon',
                'content' => '<p>OBA TİCARET olarak vizyonumuz, sektörde öncü ve güvenilir bir marka olmak, müşterilerimize en kaliteli ürün ve hizmetleri sunarak onların memnuniyetini en üst seviyede tutmaktır.</p><p>Teknolojik gelişmeleri takip ederek, sürekli kendimizi geliştiriyor ve müşterilerimize en iyi çözümleri sunuyoruz. Sektördeki lider konumumuzu koruyarak, gelecek nesillere daha iyi bir hizmet anlayışı bırakmayı hedefliyoruz.</p>',
                'template' => 'default',
                'meta_title' => 'Vizyon - OBA TİCARET',
                'meta_description' => 'OBA TİCARET\'in vizyonu ve gelecek hedefleri hakkında bilgiler.',
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Misyon',
                'slug' => 'misyon',
                'content' => '<p>OBA TİCARET olarak misyonumuz, müşterilerimize kaliteli, güvenilir ve uygun fiyatlı ürün ve hizmetler sunmaktır. Müşteri memnuniyetini ön planda tutarak, onların ihtiyaçlarına en uygun çözümleri üretmek temel prensibimizdir.</p><p>Uzman ekibimiz ve deneyimli kadromuzla, her projede mükemmelliği hedefliyoruz. Müşterilerimizin güvenini kazanmak ve bu güveni sürdürmek için sürekli çalışıyor, sektördeki en iyi uygulamaları takip ediyoruz.</p>',
                'template' => 'default',
                'meta_title' => 'Misyon - OBA TİCARET',
                'meta_description' => 'OBA TİCARET\'in misyonu ve değerleri hakkında bilgiler.',
                'is_published' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($pages as $page) {
            Page::firstOrCreate(
                ['slug' => $page['slug']],
                $page
            );
        }

        // Gereksiz sayfaları sil
        $pagesToDelete = [
            'kariyer',
            'iletisim',
            'gizlilik-politikasi',
            'kvkk-aydinlatma-metni',
            'kullanim-kosullari',
        ];

        Page::whereIn('slug', $pagesToDelete)->delete();
    }
}
