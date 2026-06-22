<?php

namespace ChrisKelemba\LaravelUiKit\Support;

class ThemePalette
{
    public static function fromColor(?string $hex): ?array
    {
        $normalized = self::normalizeHex($hex);

        if ($normalized === null) {
            return null;
        }

        [$r, $g, $b] = self::hexToRgb($normalized);
        [$headerR, $headerG, $headerB] = self::mixRgbWithWhite($r, $g, $b, 0.78);
        [$accentSoftStrongR, $accentSoftStrongG, $accentSoftStrongB] = self::mixRgbWithWhite($r, $g, $b, 0.56);

        return [
            'canvas' => self::mixWithWhite($r, $g, $b, 0.78),
            'header' => self::rgba($headerR, $headerG, $headerB, 0.96),
            'surface' => self::mixWithWhite($r, $g, $b, 0.88),
            'surface_soft' => self::mixWithWhite($r, $g, $b, 0.74),
            'surface_strong' => self::mixWithWhite($r, $g, $b, 0.58),
            'border' => self::rgba($r, $g, $b, 0.22),
            'accent' => $normalized,
            'accent_soft' => self::mixWithWhite($r, $g, $b, 0.80),
            'accent_soft_strong' => self::rgba($accentSoftStrongR, $accentSoftStrongG, $accentSoftStrongB, 0.82),
            'accent_text' => self::mixWithBlack($r, $g, $b, 0.18),
            'accent_contrast' => '#ffffff',
            'dark_button' => self::mixWithBlack($r, $g, $b, 0.34),
            'dark_button_hover' => self::mixWithBlack($r, $g, $b, 0.44),
            'feature_start' => self::mixWithBlack($r, $g, $b, 0.18),
            'feature_end' => $normalized,
        ];
    }

    public static function normalizeHex(?string $hex): ?string
    {
        $value = strtoupper(trim((string) $hex));

        if ($value === '') {
            return null;
        }

        if (! str_starts_with($value, '#')) {
            $value = '#'.$value;
        }

        if (preg_match('/^#([A-F0-9]{3})$/', $value, $matches) === 1) {
            $chars = str_split($matches[1]);

            return '#'.$chars[0].$chars[0].$chars[1].$chars[1].$chars[2].$chars[2];
        }

        return preg_match('/^#([A-F0-9]{6})$/', $value) === 1 ? $value : null;
    }

    private static function hexToRgb(string $hex): array
    {
        return [
            hexdec(substr($hex, 1, 2)),
            hexdec(substr($hex, 3, 2)),
            hexdec(substr($hex, 5, 2)),
        ];
    }

    private static function mixWithWhite(int $r, int $g, int $b, float $whiteWeight): string
    {
        return self::rgbToHex(...self::mixRgbWithWhite($r, $g, $b, $whiteWeight));
    }

    private static function mixRgbWithWhite(int $r, int $g, int $b, float $whiteWeight): array
    {
        $weight = max(0, min(1, $whiteWeight));

        return [
            (int) round(($r * (1 - $weight)) + (255 * $weight)),
            (int) round(($g * (1 - $weight)) + (255 * $weight)),
            (int) round(($b * (1 - $weight)) + (255 * $weight)),
        ];
    }

    private static function mixWithBlack(int $r, int $g, int $b, float $blackWeight): string
    {
        $weight = max(0, min(1, $blackWeight));

        return self::rgbToHex(
            (int) round($r * (1 - $weight)),
            (int) round($g * (1 - $weight)),
            (int) round($b * (1 - $weight)),
        );
    }

    private static function rgbToHex(int $r, int $g, int $b): string
    {
        return sprintf('#%02X%02X%02X', $r, $g, $b);
    }

    private static function rgba(int $r, int $g, int $b, float $alpha): string
    {
        return sprintf('rgba(%d, %d, %d, %.2f)', $r, $g, $b, $alpha);
    }
}
