@props([
    'title' => null,
    'subtitle' => null,
    'points' => [],
    'height' => 180,
])

@php
    $safePoints = array_values(array_filter($points, fn ($p) => is_numeric($p)));
    $min = count($safePoints) ? min($safePoints) : 0;
    $max = count($safePoints) ? max($safePoints) : 1;
    $range = ($max - $min) ?: 1;
    $width = 320;
    $padding = 12;
    $count = max(1, count($safePoints));
    $step = ($width - ($padding * 2)) / max(1, $count - 1);
    $polyline = [];
    foreach ($safePoints as $index => $value) {
        $x = $padding + ($step * $index);
        $normalized = ($value - $min) / $range;
        $y = $height - ($padding + ($normalized * ($height - ($padding * 2))));
        $polyline[] = $x . ',' . $y;
    }
    $polylinePoints = implode(' ', $polyline);
@endphp

<div {{ $attributes->class(['rounded-2xl border p-4']) }} :class="theme === 'dark' ? 'border-white/10 bg-slate-900/70' : 'border-slate-200 bg-white'">
    <div class="flex items-center justify-between">
        <div>
            @if ($title)
                <p class="text-sm font-semibold" :class="theme === 'dark' ? 'text-slate-100' : 'text-slate-900'">{{ $title }}</p>
            @endif
            @if ($subtitle)
                <p class="text-xs" :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'">{{ $subtitle }}</p>
            @endif
        </div>
        <div class="text-xs" :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'">{{ $max }} max</div>
    </div>

    <div class="mt-4">
        <svg viewBox="0 0 {{ $width }} {{ $height }}" class="w-full">
            <defs>
                <linearGradient id="aui-line" x1="0" y1="0" x2="1" y2="0">
                    <stop offset="0%" stop-color="var(--aui-primary)" />
                    <stop offset="100%" stop-color="var(--aui-accent)" />
                </linearGradient>
            </defs>
            <polyline
                fill="none"
                stroke="url(#aui-line)"
                stroke-width="3"
                stroke-linecap="round"
                stroke-linejoin="round"
                points="{{ $polylinePoints }}"
            />
            <polygon
                points="{{ $polylinePoints }} {{ $width - $padding }},{{ $height - $padding }} {{ $padding }},{{ $height - $padding }}"
                fill="url(#aui-line)"
                opacity="0.12"
            />
        </svg>
    </div>
</div>
