<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Genel Ayarlar
            ['key' => 'site_name', 'value' => 'OBA TİCARET | Yapı Malz. - Mobilya - PVC - Çelik Kapı', 'type' => 'string', 'group' => 'general', 'description' => 'Site adı'],
            ['key' => 'company_name', 'value' => 'OBA TİCARET', 'type' => 'string', 'group' => 'general', 'description' => 'Firma adı'],
            ['key' => 'company_tagline', 'value' => 'Yapı Malz. - Mobilya - PVC - Çelik Kapı', 'type' => 'string', 'group' => 'general', 'description' => 'Firma sloganı'],
            ['key' => 'founded_year', 'value' => '1996', 'type' => 'string', 'group' => 'general', 'description' => 'Kuruluş yılı'],
            ['key' => 'company_description', 'value' => '1996\'dan bu yana Kadirli/Osmaniye\'de çelik kapı, PVC kapı, alüminyum duşakabin, mobilya, ısı yalıtım ve izocam alanlarında kaliteli ürün ve hizmetler sunuyoruz.', 'type' => 'string', 'group' => 'general', 'description' => 'Firma açıklaması'],
            ['key' => 'site_description', 'value' => '1996\'dan bu yana Çelik Kapı, PVC Kapı, Alüminyum Duşakabin, Mobilya, Isı Yalıtım ve İzocam alanlarında hizmet veriyoruz.', 'type' => 'string', 'group' => 'general', 'description' => 'Site açıklaması'],
            ['key' => 'site_logo', 'value' => 'assets/img/logo.png', 'type' => 'string', 'group' => 'general', 'description' => 'Site logosu'],
            ['key' => 'site_favicon', 'value' => 'favicon.ico', 'type' => 'string', 'group' => 'general', 'description' => 'Favicon'],

            // İletişim Bilgileri
            ['key' => 'contact_phone', 'value' => '0532 641 53 16', 'type' => 'string', 'group' => 'contact', 'description' => 'İletişim telefonu'],
            ['key' => 'contact_email', 'value' => 'info@obaticaret.com', 'type' => 'string', 'group' => 'contact', 'description' => 'İletişim e-postası'],
            ['key' => 'contact_address', 'value' => 'Şehit Halis Şişman Mah. Kamil Kara Bul. No:240 Kadirli/Osmaniye, Osmaniye 80750', 'type' => 'string', 'group' => 'contact', 'description' => 'Adres'],
            ['key' => 'contact_city', 'value' => 'Kadirli / Osmaniye', 'type' => 'string', 'group' => 'contact', 'description' => 'Şehir/İl'],
            ['key' => 'contact_district', 'value' => 'Kadirli', 'type' => 'string', 'group' => 'contact', 'description' => 'İlçe'],
            ['key' => 'contact_province', 'value' => 'Osmaniye', 'type' => 'string', 'group' => 'contact', 'description' => 'İl'],
            ['key' => 'contact_postal_code', 'value' => '80750', 'type' => 'string', 'group' => 'contact', 'description' => 'Posta kodu'],
            ['key' => 'whatsapp_number', 'value' => '905326415316', 'type' => 'string', 'group' => 'contact', 'description' => 'WhatsApp numarası'],

            // Sosyal Medya
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/obaticaret', 'type' => 'string', 'group' => 'social', 'description' => 'Instagram'],
            ['key' => 'social_facebook', 'value' => 'https://facebook.com/obaticaret', 'type' => 'string', 'group' => 'social', 'description' => 'Facebook'],
            ['key' => 'social_twitter', 'value' => '', 'type' => 'string', 'group' => 'social', 'description' => 'Twitter/X'],
            ['key' => 'social_youtube', 'value' => '', 'type' => 'string', 'group' => 'social', 'description' => 'YouTube'],

            // SEO Ayarları
            ['key' => 'seo_title', 'value' => 'OBA TİCARET | Yapı Malz. - Mobilya - PVC - Çelik Kapı | Kadirli/Osmaniye', 'type' => 'string', 'group' => 'seo', 'description' => 'SEO başlık'],
            ['key' => 'seo_description', 'value' => '1996\'dan bu yana Kadirli/Osmaniye\'de çelik kapı, PVC kapı, alüminyum duşakabin, mobilya, ısı yalıtım ve izocam alanlarında kaliteli ürün ve hizmetler sunuyoruz.', 'type' => 'string', 'group' => 'seo', 'description' => 'SEO açıklama'],
            ['key' => 'seo_keywords', 'value' => 'Çelik Kapı, PVC Kapı, Alüminyum Duşakabin, Mobilya, Isı Yalıtım, İzocam, Oba Ticaret, Kadirli, Osmaniye, Yapı Malzemeleri', 'type' => 'string', 'group' => 'seo', 'description' => 'SEO anahtar kelimeler'],
            ['key' => 'google_analytics', 'value' => '', 'type' => 'string', 'group' => 'seo', 'description' => 'Google Analytics ID'],

            // Frontend Alias Ayarları (Uyumluluk için)
            ['key' => 'address', 'value' => 'Şehit Halis Şişman Mah. Kamil Kara Bul. No:240 Kadirli/Osmaniye, Osmaniye 80750', 'type' => 'string', 'group' => 'contact', 'description' => 'Adres (alias)'],
            ['key' => 'phone', 'value' => '0532 641 53 16', 'type' => 'string', 'group' => 'contact', 'description' => 'Telefon (alias)'],
            ['key' => 'email', 'value' => 'info@obaticaret.com', 'type' => 'string', 'group' => 'contact', 'description' => 'E-posta (alias)'],
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/obaticaret', 'type' => 'string', 'group' => 'social', 'description' => 'Facebook URL (alias)'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/obaticaret', 'type' => 'string', 'group' => 'social', 'description' => 'Instagram URL (alias)'],
            ['key' => 'twitter_url', 'value' => '', 'type' => 'string', 'group' => 'social', 'description' => 'Twitter URL (alias)'],
            ['key' => 'google_maps_embed', 'value' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3171.045988425255!2d36.0824718!3d37.3650887!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x152f2032184e30f7%3A0x6f4f2a95417d4438!2zT2JhIEh1cmRhY8SxbMSxaw!5e0!3m2!1str!2str!4v1769852147129!5m2!1str!2str" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Oba Ticaret - Kadirli, Osmaniye" aria-label="Oba Ticaret - Kadirli, Osmaniye"></iframe>', 'type' => 'string', 'group' => 'contact', 'description' => 'Google Maps Embed kodu'],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
