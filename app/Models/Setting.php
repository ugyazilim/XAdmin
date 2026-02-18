<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description',
    ];

    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();

        if (! $setting) {
            return $default;
        }

        return match ($setting->type) {
            'boolean' => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
            'number' => is_numeric($setting->value) ? (str_contains($setting->value, '.') ? (float) $setting->value : (int) $setting->value) : $default,
            'json' => json_decode($setting->value, true) ?? $default,
            default => $setting->value ?? $default,
        };
    }

    public static function set(string $key, mixed $value, string $type = 'string', string $group = 'general'): void
    {
        $setting = static::firstOrNew(['key' => $key]);
        $setting->value = $type === 'json' ? json_encode($value) : (string) $value;
        $setting->type = $type;
        $setting->group = $group;
        $setting->save();
    }

    /**
     * Instance metod olarak getValue (backward compatibility)
     */
    public function getValue(): mixed
    {
        return static::get($this->key);
    }
}
