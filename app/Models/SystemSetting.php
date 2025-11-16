<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SystemSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'description',
    ];

    /**
     * Obtener un valor de configuración
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember("system_setting_{$key}", 3600, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            
            if (!$setting) {
                return $default;
            }

            return self::castValue($setting->value, $setting->type);
        });
    }

    /**
     * Establecer un valor de configuración
     */
    public static function set(string $key, mixed $value): void
    {
        $setting = self::firstOrCreate(['key' => $key]);
        $setting->value = (string) $value;
        $setting->save();

        Cache::forget("system_setting_{$key}");
    }

    /**
     * Convertir el valor según el tipo
     */
    protected static function castValue(string $value, string $type): mixed
    {
        return match ($type) {
            'integer' => (int) $value,
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'json' => json_decode($value, true),
            default => $value,
        };
    }

    /**
     * Limpiar caché al actualizar
     */
    protected static function booted(): void
    {
        static::saved(function ($setting) {
            Cache::forget("system_setting_{$setting->key}");
        });

        static::deleted(function ($setting) {
            Cache::forget("system_setting_{$setting->key}");
        });
    }
}
