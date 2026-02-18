<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'category_tag' => 'Çelik Kapı',
                'title' => 'Villa Giriş Kapısı Projesi',
                'slug' => 'villa-giris-kapisi-projesi',
                'description' => 'Özel tasarım villa giriş kapısı projesi',
                'image' => 'assets/img/portfolio/portfolio-6.jpg',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 1,
            ],
            [
                'category_tag' => 'PVC Sistemler',
                'title' => 'Apartman Pencere Yenileme',
                'slug' => 'apartman-pencere-yenileme',
                'description' => 'Apartman pencere ve kapı sistemleri yenileme projesi',
                'image' => 'assets/img/portfolio/portfolio-2.jpg',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 2,
            ],
            [
                'category_tag' => 'Duşakabin',
                'title' => 'Modern Banyo Tasarımı',
                'slug' => 'modern-banyo-tasarimi',
                'description' => 'Modern alüminyum duşakabin ve banyo tasarımı',
                'image' => 'assets/img/portfolio/portfolio-4.jpg',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 3,
            ],
            [
                'category_tag' => 'Isı Yalıtım',
                'title' => 'Bina Dış Cephe Mantolama',
                'slug' => 'bina-dis-cephe-mantolama',
                'description' => 'Bina dış cephe ısı yalıtım ve mantolama projesi',
                'image' => 'assets/img/portfolio/portfolio-8.jpg',
                'is_featured' => true,
                'is_published' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(
                ['slug' => $project['slug']],
                $project
            );
        }
    }
}
