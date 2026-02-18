<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class UpdateActiveCampaign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:update-active-to-instagram';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aktif kampanyayı İnstagram Takipçi olarak günceller';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Aktif kampanya aranıyor...');
        
        $activeCampaign = Campaign::where('is_active', true)->first();
        
        if (!$activeCampaign) {
            $this->error('Aktif kampanya bulunamadı!');
            return Command::FAILURE;
        }
        
        $this->info("Mevcut kampanya: {$activeCampaign->name} (ID: {$activeCampaign->id})");
        
        $newName = 'İnstagram Takipçi';
        $newSlug = Str::slug($newName);
        
        // Slug'un benzersiz olmasını sağla
        $slug = $newSlug;
        $counter = 1;
        while (Campaign::where('slug', $slug)->where('id', '!=', $activeCampaign->id)->exists()) {
            $slug = $newSlug . '-' . $counter;
            $counter++;
        }
        
        $activeCampaign->update([
            'name' => $newName,
            'slug' => $slug,
        ]);
        
        $this->info("✓ Kampanya başarıyla güncellendi: {$newName}");
        $this->info("  Slug: {$slug}");
        
        return Command::SUCCESS;
    }
}
