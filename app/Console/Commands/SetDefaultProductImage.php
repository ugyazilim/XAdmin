<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SetDefaultProductImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:set-default-image';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tüm ürünlere varsayılan fotoğrafı ekle (upload/default_product.webp)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Ürün fotoğrafları güncelleniyor...');

        $defaultImagePath = 'upload/default_product.webp';
        $fullPath = public_path($defaultImagePath);
        
        if (!File::exists($fullPath)) {
            $this->error("Varsayılan fotoğraf bulunamadı: {$fullPath}");
            $this->info("Lütfen önce 'public/upload/default_product.webp' dosyasını oluşturun.");
            return Command::FAILURE;
        }

        $products = Product::all();
        $bar = $this->output->createProgressBar($products->count());
        $bar->start();

        $successCount = 0;

        foreach ($products as $product) {
            $product->update(['image_url' => $defaultImagePath]);
            $successCount++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        
        $this->info("Tamamlandı!");
        $this->info("Başarılı: {$successCount} ürün güncellendi.");

        return Command::SUCCESS;
    }
}
