@props([
    'title' => null,
    'subtitle' => null,
    'segments' => [],
    'size' => 160,
])

@php
    $total = array_sum(array_map(fn ($seg) => $seg['value'] ?? 0, $segments));
    $total = $total ?: 1;
    $radius = ($size / 2) - 10;
    $circumference = 2 * M_PI * $radius;
    $offset = 0;
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

    <div class="mt-4 flex flex-wrap items-center gap-6">
        <svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 {{ $size }} {{ $size }}">
            <g transform="rotate(-90 {{ $size / 2 }} {{ $size / 2 }})">
                @foreach ($segments as $segment)
                    @php
                        $value = $segment['value'] ?? 0;
                        $color = $segment['color'] ?? '#60a5fa';
                        $dash = ($value / $total) * $circumference;
                    @endphp
                    <circle
                        cx="{{ $size / 2 }}"
                        cy="{{ $size / 2 }}"
                        r="{{ $radius }}"
                        fill="transparent"
                        stroke="{{ $color }}"
                        stroke-width="14"
                        stroke-dasharray="{{ $dash }} {{ $circumference - $dash }}"
                        stroke-dashoffset="-{{ $offset }}"
                        stroke-linecap="round"
                    />
                    @php $offset += $dash; @endphp
                @endforeach
            </g>
        </svg>
        <div class="space-y-2 text-xs">
            @foreach ($segments as $segment)
                <div class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full" style="background: {{ $segment['color'] ?? '#60a5fa' }}"></span>
                    <span :class="theme === 'dark' ? 'text-slate-300' : 'text-slate-600'">{{ $segment['label'] ?? 'Item' }}</span>
                    <span class="ml-auto" :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'">
                        {{ $segment['value'] ?? 0 }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>
</div>
