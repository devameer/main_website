<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /** All settings as a plain key => value array (cached forever). */
    public static function allCached(): array
    {
        return Cache::rememberForever('settings.all', function () {
            return self::query()->pluck('value', 'key')->toArray();
        });
    }

    /** Get a single setting, with a fallback default. */
    public static function get(string $key, $default = null)
    {
        $all = static::allCached();

        return array_key_exists($key, $all) ? $all[$key] : $default;
    }

    /** Persist a setting and bust the cache. */
    public static function set(string $key, $value): void
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('settings.all');
    }
}
