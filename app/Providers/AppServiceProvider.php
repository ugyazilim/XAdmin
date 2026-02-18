<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Header'a kategorileri ekle (hizmetler dropdown'ı için)
        view()->composer('frontend.partials.header', function (View $view) {
            $categories = Category::active()->ordered()->get();
            $view->with('headerCategories', $categories);
        });

        // Footer'a kategorileri ekle (belirli kategoriler)
        view()->composer('frontend.partials.footer', function (View $view) {
            $categorySlugs = [
                'aluminyum-vitrin',
                'otomatik-kepenk',
                'ic-oda-kapilari',
                'dusakabin-sistemleri',
                'pvc-kapi-ve-pencere-sistemleri',
            ];
            $categories = Category::active()
                ->whereIn('slug', $categorySlugs)
                ->orderByRaw('FIELD(slug, "'.implode('","', $categorySlugs).'")')
                ->get();
            $view->with('footerCategories', $categories);
        });
    }
}
