<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            // Hizmetler
            [
                'question' => 'Hangi hizmetleri sunuyorsunuz?',
                'answer' => 'Çelik Kapı, PVC Kapı, Alüminyum Duşakabin, Mobilya, Isı Yalıtım ve İzocam alanlarında hizmet veriyoruz. Detaylı bilgi için hizmetlerimiz sayfasını ziyaret edebilirsiniz.',
                'category' => 'hizmetler',
                'sort_order' => 1,
            ],
            [
                'question' => 'Özel ölçü üretim yapıyor musunuz?',
                'answer' => 'Evet, tüm ürünlerimizde özel ölçü üretim hizmeti sunuyoruz. Ücretsiz keşif için bizi arayabilirsiniz.',
                'category' => 'hizmetler',
                'sort_order' => 2,
            ],
            [
                'question' => 'Montaj hizmeti veriyor musunuz?',
                'answer' => 'Evet, tüm ürünlerimiz için profesyonel montaj hizmeti sunuyoruz. Montaj ekibimiz deneyimli ve sertifikalıdır.',
                'category' => 'hizmetler',
                'sort_order' => 3,
            ],

            // Ürünler
            [
                'question' => 'Garanti süreniz ne kadar?',
                'answer' => 'Tüm ürünlerimizde 2 yıl garanti süremiz bulunmaktadır. Garanti kapsamı ürün tipine göre değişiklik gösterebilir.',
                'category' => 'ürünler',
                'sort_order' => 1,
            ],
            [
                'question' => 'Hangi markaları kullanıyorsunuz?',
                'answer' => 'Sektörün önde gelen markaları ile çalışıyoruz. Kalite ve güvenilirlik önceliğimizdir.',
                'category' => 'ürünler',
                'sort_order' => 2,
            ],

            // Genel
            [
                'question' => 'Çalışma saatleriniz nedir?',
                'answer' => 'Hafta içi 08:00-18:00, Cumartesi 08:00-14:00 saatleri arasında hizmet vermekteyiz. Pazar günü kapalıyız.',
                'category' => 'genel',
                'sort_order' => 1,
            ],
            [
                'question' => 'Ücretsiz keşif hizmeti var mı?',
                'answer' => 'Evet, tüm hizmetlerimiz için ücretsiz keşif hizmeti sunuyoruz. Randevu almak için bizi arayabilirsiniz.',
                'category' => 'genel',
                'sort_order' => 2,
            ],
            [
                'question' => 'Hangi bölgelere hizmet veriyorsunuz?',
                'answer' => 'Kadirli ve Osmaniye çevresinde hizmet veriyoruz. Detaylı bilgi için bizi arayabilirsiniz.',
                'category' => 'genel',
                'sort_order' => 3,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }
    }
}
