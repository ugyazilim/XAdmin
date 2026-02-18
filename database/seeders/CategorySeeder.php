<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Header'daki hizmetler kategori olarak eklendi
        $categories = [
            [
                'name' => 'Çelik Kapı Sistemleri',
                'slug' => 'celik-kapi-sistemleri',
                'description' => 'Güvenlik ve dayanıklılık için çelik kapı sistemleri',
                'status' => 'active',
                'sort_order' => 1,
            ],
            [
                'name' => 'PVC Kapı Sistemleri',
                'slug' => 'pvc-kapi-sistemleri',
                'description' => 'Modern ve estetik PVC kapı sistemleri',
                'status' => 'active',
                'sort_order' => 2,
            ],
            [
                'name' => 'Alüminyum Duşakabin',
                'slug' => 'aluminyum-dusakabin',
                'description' => 'Özel ölçü alüminyum duşakabin sistemleri',
                'status' => 'active',
                'sort_order' => 3,
            ],
            [
                'name' => 'Mobilya',
                'slug' => 'mobilya',
                'description' => 'Özel tasarım ve üretim mobilya çözümleri',
                'status' => 'active',
                'sort_order' => 4,
            ],
            [
                'name' => 'Isı Yalıtım',
                'slug' => 'isi-yalitim',
                'description' => 'Enerji verimliliği için ısı yalıtım çözümleri',
                'status' => 'active',
                'sort_order' => 5,
            ],
            [
                'name' => 'İzocam İşleri',
                'slug' => 'izocam-isleri',
                'description' => 'Profesyonel İzocam uygulama ve montaj hizmetleri',
                'status' => 'active',
                'sort_order' => 6,
            ],
            [
                'name' => 'Alüminyum vitrin',
                'slug' => 'aluminyum-vitrin',
                'description' => 'Alüminyum vitrin sistemleri',
                'status' => 'active',
                'sort_order' => 7,
            ],
            [
                'name' => 'Otomatik kepenk',
                'slug' => 'otomatik-kepenk',
                'description' => 'Otomatik kepenk sistemleri',
                'status' => 'active',
                'sort_order' => 8,
            ],
            [
                'name' => 'İç oda kapıları',
                'slug' => 'ic-oda-kapilari',
                'description' => 'İç oda kapıları',
                'status' => 'active',
                'sort_order' => 9,
            ],
            [
                'name' => 'Duşakabin sistemleri',
                'slug' => 'dusakabin-sistemleri',
                'description' => 'Duşakabin sistemleri',
                'status' => 'active',
                'sort_order' => 10,
            ],
            [
                'name' => 'PVC kapı ve pencere sistemleri',
                'slug' => 'pvc-kapi-ve-pencere-sistemleri',
                'description' => 'PVC kapı ve pencere sistemleri',
                'status' => 'active',
                'sort_order' => 11,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
