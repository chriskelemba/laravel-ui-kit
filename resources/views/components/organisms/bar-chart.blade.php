@props([
    'title' => null,
    'subtitle' => null,
    'items' => [],
    'height' => 160,
])

@php
    $values = array_map(fn ($item) => $item['value'] ?? 0, $items);
    $max = count($values) ? max($values) : 1;
    $max = $max ?: 1;
@endphp

<div {{ $attributes->class(['rounded-2xl border p-4']) }} :class="theme === 'dark' ? 'border-white/10 bg-slate-900/70' : 'border-slate-200 bg-white'">
    <div>
        @if ($title)
            <p class="text-sm font-semibold" :class="theme === 'dark' ? 'text-slate-100' : 'text-slate-900'">{{ $title }}</p>
        @endif
        @if ($subtitle)
            <p class="text-xs" :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'">{{ $subtitle }}</p>
        @endif
    </div>

    <div
        class="mt-4 grid gap-3"
        style="align-items: end; height: {{ (int) $height }}px; grid-template-columns: repeat({{ max(1, count($items)) }}, minmax(0, 1fr));"
    >
        @foreach ($items as $item)
            @php
                $value = $item['value'] ?? 0;
                $label = $item['label'] ?? '';
                $pct = ($value / $max) * 100;
            @endphp
            <div class="flex flex-col items-center gap-2">
                <div class="aui-chart-gradient w-full rounded-lg" style="height: {{ $pct }}%; min-height: 18px;"></div>
                <span class="text-[10px] uppercase tracking-wide" :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'">{{ $label }}</span>
            </div>
        @endforeach
    </div>
</div>
