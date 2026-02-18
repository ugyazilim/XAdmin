<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'client_name',
        'project_type',
        'completion_date',
        'sort_order',
        'is_featured',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'completion_date' => 'date',
            'sort_order' => 'integer',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function getImageUrlAttribute(): ?string
    {
        if ($this->image && file_exists(public_path($this->image))) {
            return asset($this->image);
        }

        return null;
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
