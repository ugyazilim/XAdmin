<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;

class CleanFakeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:fake-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Eski fake ürünleri ve kategorileri temizle';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Eski fake veriler temizleniyor...');

        // Eski fake kategoriler
        $oldCategorySlugs = ['burgers', 'sides', 'drinks', 'desserts'];
        $oldCategories = Category::whereIn('slug', $oldCategorySlugs)->get();
        
        if ($oldCategories->count() > 0) {
            // Önce bu kategorilere ait ürünleri sil
            foreach ($oldCategories as $category) {
                Product::where('category_id', $category->id)->delete();
            }
            // Sonra kategorileri sil
            $deletedCategories = Category::whereIn('slug', $oldCategorySlugs)->delete();
            $this->info("{$deletedCategories} eski kategori silindi.");
        }

        // Eski fake ürünler (isim bazlı)
        $oldProductNames = ['Classic Burger', 'Cheese Burger', 'French Fries', 'Cola'];
        $deletedProducts = Product::whereIn('name', $oldProductNames)->delete();
        
        if ($deletedProducts > 0) {
            $this->info("{$deletedProducts} eski ürün silindi.");
        }

        // Eski kategoriye ait kalan ürünleri kontrol et
        $orphanedProducts = Product::whereDoesntHave('category')->count();
        if ($orphanedProducts > 0) {
            Product::whereDoesntHave('category')->delete();
            $this->info("{$orphanedProducts} yetim ürün silindi.");
        }

        $this->info('Temizleme tamamlandı!');
        $this->info('Toplam ürün: ' . Product::count());
        $this->info('Toplam kategori: ' . Category::count());

        return Command::SUCCESS;
    }
}
