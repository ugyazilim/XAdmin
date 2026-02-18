<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        view()->composer('frontend.*', function (View $view) {
            static $siteSettings = null;
            if ($siteSettings === null) {
                $all = Setting::all()->pluck('value', 'key');
                $siteSettings = [
                    'company_name'        => $all->get('company_name', 'OBA TİCARET'),
                    'company_tagline'     => $all->get('company_tagline', 'Yapı Malz. - Mobilya - PVC - Çelik Kapı'),
                    'company_description' => $all->get('company_description', ''),
                    'site_name'           => $all->get('site_name', 'OBA TİCARET'),
                    'site_description'    => $all->get('site_description', ''),
                    'contact_phone'       => $all->get('contact_phone', ''),
                    'contact_phone2'      => $all->get('contact_phone2', ''),
                    'contact_email'       => $all->get('contact_email', ''),
                    'contact_address'     => $all->get('contact_address', ''),
                    'contact_city'        => $all->get('contact_city', ''),
                    'working_hours'       => $all->get('working_hours', 'Pazartesi - Cumartesi: 08:00 - 18:00'),
                    'whatsapp_number'     => $all->get('whatsapp_number', ''),
                    'google_maps_embed'   => $all->get('google_maps_embed', ''),
                    'social_facebook'     => $all->get('social_facebook', ''),
                    'social_instagram'    => $all->get('social_instagram', ''),
                    'social_twitter'      => $all->get('social_twitter', ''),
                    'social_youtube'      => $all->get('social_youtube', ''),
                    'seo_title'           => $all->get('seo_title', ''),
                    'seo_description'     => $all->get('seo_description', ''),
                    'seo_keywords'        => $all->get('seo_keywords', ''),
                    'founded_year'        => $all->get('founded_year', '1996'),
                    'site_logo'           => $all->get('site_logo', ''),
                    'about_video'         => $all->get('about_video', ''),
                ];
            }
            $view->with('site', (object) $siteSettings);
        });

        view()->composer('frontend.partials.header', function (View $view) {
            $view->with('headerCategories', Category::active()->ordered()->get());
        });

        view()->composer('frontend.partials.footer', function (View $view) {
            $view->with('footerCategories', Category::active()->ordered()->get());
        });
    }
}
