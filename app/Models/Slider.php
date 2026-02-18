<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'mobile_image',
        'video',
        'media_type',
        'link',
        'button_text',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Resim URL'si
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset($this->image);
        }

        return asset('upload/default_slider.webp');
    }

    /**
     * Mobil resim URL'si
     */
    public function getMobileImageUrlAttribute(): string
    {
        if ($this->mobile_image) {
            return asset($this->mobile_image);
        }

        return $this->image_url;
    }

    /**
     * Video URL'si
     */
    public function getVideoUrlAttribute(): ?string
    {
        if ($this->video) {
            return asset($this->video);
        }

        return null;
    }

    /**
     * Medya tipi kontrolü
     */
    public function isVideo(): bool
    {
        return $this->media_type === 'video';
    }

    public function isImage(): bool
    {
        return $this->media_type === 'image';
    }

    // Scope'lar
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
