<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    public function run(): void
    {
        $sliders = [
            [
                'title' => 'OBA TİCARET | Yapı Malz. - Mobilya - PVC - Çelik Kapı',
                'subtitle' => '1996\'dan bu yana Kadirli/Osmaniye\'de kaliteli hizmet',
                'image' => 'assets/img/slider/slider-1.jpg',
                'link' => '/hizmetlerimiz',
                'button_text' => 'Hizmetlerimizi Keşfedin',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Çelik Kapı ve PVC Sistemler',
                'subtitle' => 'Güvenlik ve konfor için en kaliteli çözümler',
                'image' => 'assets/img/slider/slider-2.jpg',
                'link' => '/hizmetlerimiz/celik-kapi',
                'button_text' => 'Detaylı Bilgi',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Alüminyum Duşakabin ve Mobilya',
                'subtitle' => 'Modern tasarımlar, özel ölçü üretim',
                'image' => 'assets/img/slider/slider-3.jpg',
                'link' => '/hizmetlerimiz',
                'button_text' => 'Hizmetlerimiz',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::updateOrCreate(
                ['title' => $slider['title']],
                $slider
            );
        }
    }
}
