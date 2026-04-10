<?php

namespace ChrisKelemba\LaravelUiKit\Support;

use Illuminate\Support\Str;

class IconResolver
{
    public static function resolve(mixed $icon, ?string $label = null): ?string
    {
        if (! is_string($icon) || trim($icon) === '') {
            return static::resolveFromLabel($label);
        }

        $icon = trim($icon);

        if (Str::contains($icon, '<')) {
            return $icon;
        }

        $aliases = config('ui-kit.icons.aliases', []);
        $aliasKey = Str::of($icon)->trim()->lower()->slug('_')->value();

        if (isset($aliases[$aliasKey])) {
            return static::fontAwesomeTag($aliases[$aliasKey]);
        }

        if (Str::contains($icon, 'fa-')) {
            return static::fontAwesomeTag($icon);
        }

        return null;
    }

    protected static function resolveFromLabel(?string $label): ?string
    {
        if (! is_string($label) || trim($label) === '') {
            return null;
        }

        $aliases = config('ui-kit.icons.aliases', []);
        $labelKey = Str::of($label)->trim()->lower()->slug('_')->value();

        if (! isset($aliases[$labelKey])) {
            return null;
        }

        return static::fontAwesomeTag($aliases[$labelKey]);
    }

    protected static function fontAwesomeTag(string $classes): string
    {
        $classes = trim($classes);

        if ($classes === '') {
            return '';
        }

        return '<i class="' . e($classes) . '" aria-hidden="true"></i>';
    }
}
