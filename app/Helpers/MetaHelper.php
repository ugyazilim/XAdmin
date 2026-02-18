<?php

namespace App\Helpers;

use App\Models\Setting;

class MetaHelper
{
    /**
     * Get page title with site name
     */
    public static function title(?string $title = null): string
    {
        $siteName = Setting::where('key', 'site_name')->value('value') ?? 'OBA TİCARET';

        if ($title) {
            return "{$title} | {$siteName}";
        }

        return $siteName;
    }

    /**
     * Get meta description
     */
    public static function description(?string $description = null): string
    {
        if ($description) {
            return $description;
        }

        return Setting::where('key', 'site_description')->value('value')
            ?? '1996\'dan bu yana Çelik Kapı, PVC Kapı, Alüminyum Duşakabin, Mobilya, Isı Yalıtım ve İzocam alanlarında hizmet veriyoruz.';
    }

    /**
     * Get meta keywords
     */
    public static function keywords(?string $keywords = null): string
    {
        if ($keywords) {
            return $keywords;
        }

        return Setting::where('key', 'seo_keywords')->value('value')
            ?? 'Çelik Kapı, PVC Kapı, Alüminyum Duşakabin, Mobilya, Isı Yalıtım, İzocam, Oba Ticaret, Kadirli, Osmaniye';
    }

    /**
     * Get Open Graph image
     */
    public static function ogImage(?string $image = null): string
    {
        if ($image) {
            return asset($image);
        }

        return asset('assets/img/og-image.jpg');
    }

    /**
     * Get site URL
     */
    public static function siteUrl(): string
    {
        return config('app.url');
    }
}
