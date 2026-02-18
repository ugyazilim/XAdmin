<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'type',
        'published_at',
        'sort_order',
        'is_published',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'date',
            'sort_order' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        if ($this->featured_image && file_exists(public_path($this->featured_image))) {
            return asset($this->featured_image);
        }

        return null;
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeNews($query)
    {
        return $query->where('type', 'news');
    }

    public function scopeAnnouncements($query)
    {
        return $query->where('type', 'announcement');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('published_at', 'desc');
    }
}
