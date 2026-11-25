<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = ['key','value','type'];

    /**
     * Whenever a setting is saved or deleted, forget the per-request copy so the
     * next read sees the change.
     */
    protected static function booted(): void
    {
        $forget = fn () => app()->forgetInstance('site.settings');

        static::saved($forget);
        static::deleted($forget);
    }

    /**
     * Every setting as key => value, loaded once per request instead of one
     * query for each get() call.
     */
    private static function cached(): array
    {
        return app()->make('site.settings');
    }

    public static function loadAll(): array
    {
        return static::query()->pluck('value', 'key')->all();
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $all = static::cached();

        return array_key_exists($key, $all) ? $all[$key] : $default;
    }

    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /**
     * A setting that holds a link or a file path, as a full URL.
     * Full URLs are returned as they are; anything else is treated as a path
     * on this site (e.g. "cv/muhammad-ahmed.pdf" or "/cv/muhammad-ahmed.pdf").
     */
    public static function url(string $key): ?string
    {
        $value = trim((string) static::get($key));

        if ($value === '') {
            return null;
        }

        return preg_match('#^https?://#i', $value) ? $value : url(ltrim($value, '/'));
    }

    /**
     * A setting written as one "value | label" pair per line, as [value, label] rows.
     * Lines without a "|" are ignored.
     */
    public static function pairs(string $key): array
    {
        $rows = [];

        foreach (preg_split('/\R/', (string) static::get($key)) as $line) {
            if (! str_contains($line, '|')) {
                continue;
            }

            [$value, $label] = array_map('trim', explode('|', $line, 2));

            if ($value !== '' && $label !== '') {
                $rows[] = [$value, $label];
            }
        }

        return $rows;
    }
}
