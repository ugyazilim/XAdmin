<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Log extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'action',
        'model',
        'model_id',
        'old_data',
        'new_data',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'old_data' => 'array',
            'new_data' => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Aksiyon metni
     */
    public function getActionTextAttribute(): string
    {
        return match ($this->action) {
            'create' => 'Oluşturuldu',
            'update' => 'Güncellendi',
            'delete' => 'Silindi',
            'login' => 'Giriş Yaptı',
            'logout' => 'Çıkış Yaptı',
            'status_change' => 'Durum Değişti',
            default => $this->action,
        };
    }

    /**
     * Log kaydet
     */
    public static function record(
        string $action,
        ?string $model = null,
        ?int $modelId = null,
        ?array $oldData = null,
        ?array $newData = null,
        ?int $userId = null
    ): self {
        return self::create([
            'user_id' => $userId ?? auth()->id(),
            'action' => $action,
            'model' => $model,
            'model_id' => $modelId,
            'old_data' => $oldData,
            'new_data' => $newData,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
        ]);
    }

    // Scope'lar
    public function scopeForModel($query, string $model, ?int $modelId = null)
    {
        $query->where('model', $model);

        if ($modelId) {
            $query->where('model_id', $modelId);
        }

        return $query;
    }

    public function scopeByAction($query, string $action)
    {
        return $query->where('action', $action);
    }

    public function scopeRecent($query)
    {
        return $query->orderByDesc('created_at');
    }
}
