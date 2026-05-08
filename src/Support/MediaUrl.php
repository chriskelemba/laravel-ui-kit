<?php

namespace ChrisKelemba\LaravelUiKit\Support;

use Illuminate\Support\Facades\Storage;

class MediaUrl
{
    public static function resolve(mixed $value): mixed
    {
        if (! is_string($value) || trim($value) === '') {
            return $value;
        }

        if (preg_match('/^(https?:|data:|blob:|\/)/i', $value)) {
            return $value;
        }

        if (str_starts_with($value, 'storage://')) {
            $disk = config('ui-kit.media.default_disk', 'local');
            $path = substr($value, 10);

            if (! Storage::disk($disk)->exists($path)) {
                return null;
            }

            return route('ui-kit.assets.media', [
                'disk' => $disk,
                'path' => $path,
            ]);
        }

        if (str_starts_with($value, 'disk://')) {
            $segments = explode('/', substr($value, 7), 2);
            $disk = $segments[0] ?? config('ui-kit.media.default_disk', 'local');
            $path = $segments[1] ?? null;

            if ($path && Storage::disk($disk)->exists($path)) {
                return route('ui-kit.assets.media', [
                    'disk' => $disk,
                    'path' => $path,
                ]);
            }

            return null;
        }

        return $value;
    }
}
