<?php

namespace ChrisKelemba\LaravelUiKit\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class ProfileResolver
{
    /**
     * @param  array<string, mixed>  $overrides
     * @return array{name: string, email: string|null, initials: string, avatar_src: string|null, edit_href: string, logout_href: string}
     */
    public static function resolve(array $overrides = []): array
    {
        $config = config('ui-kit.workspace.profile', []);
        $user = $overrides['user'] ?? self::currentUser();
        $fallback = Arr::get($config, 'fallback', []);

        $name = self::firstFilled([
            $overrides['name'] ?? null,
            self::valueFrom($user, Arr::get($config, 'fields.name', [])),
            Arr::get($fallback, 'name'),
            'Default User',
        ]);

        $email = self::firstFilled([
            $overrides['email'] ?? null,
            self::valueFrom($user, Arr::get($config, 'fields.email', [])),
            Arr::get($fallback, 'email'),
        ]);

        $avatarSrc = self::firstFilled([
            $overrides['avatar_src'] ?? null,
            self::valueFrom($user, Arr::get($config, 'fields.avatar_src', [])),
        ]);

        return [
            'name' => $name,
            'email' => $email,
            'initials' => self::initials($name),
            'avatar_src' => $avatarSrc,
            'edit_href' => self::href($overrides, $config, 'edit', '#'),
            'logout_href' => self::href($overrides, $config, 'logout', '#'),
        ];
    }

    protected static function currentUser(): mixed
    {
        if (! function_exists('auth')) {
            return null;
        }

        try {
            return auth()->user();
        } catch (\Throwable) {
            return null;
        }
    }

    /**
     * @param  array<int, string>|string|null  $fields
     */
    protected static function valueFrom(mixed $source, array|string|null $fields): mixed
    {
        if ($source === null) {
            return null;
        }

        foreach (Arr::wrap($fields) as $field) {
            $value = data_get($source, $field);

            if (filled($value)) {
                return $value;
            }
        }

        return null;
    }

    /**
     * @param  array<int, mixed>  $values
     */
    protected static function firstFilled(array $values): ?string
    {
        foreach ($values as $value) {
            if (filled($value)) {
                return (string) $value;
            }
        }

        return null;
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @param  array<string, mixed>  $config
     */
    protected static function href(array $overrides, array $config, string $key, string $default): string
    {
        $overrideKey = $key . '_href';
        $routeKey = $key . '_route';

        if (filled($overrides[$overrideKey] ?? null)) {
            return (string) $overrides[$overrideKey];
        }

        if (filled(Arr::get($config, "routes.{$key}.href"))) {
            return (string) Arr::get($config, "routes.{$key}.href");
        }

        $routeName = $overrides[$routeKey] ?? Arr::get($config, "routes.{$key}.name");

        if (filled($routeName) && Route::has($routeName)) {
            return route($routeName, Arr::get($config, "routes.{$key}.parameters", []));
        }

        return $default;
    }

    protected static function initials(?string $name): string
    {
        $name = trim((string) $name);

        if ($name === '') {
            return 'U';
        }

        $parts = preg_split('/\s+/', $name) ?: [];
        $initials = collect($parts)
            ->filter()
            ->map(fn (string $part) => Str::substr($part, 0, 1))
            ->take(1)
            ->implode('');

        return Str::upper($initials ?: 'U');
    }
}
