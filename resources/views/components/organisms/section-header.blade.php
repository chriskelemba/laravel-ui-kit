@props([
    'title' => null,
    'subtitle' => null,
])

<div {{ $attributes->class(['flex flex-wrap items-center justify-between gap-3']) }}>
    <div>
        @if ($title)
            <h2 class="text-lg font-semibold" :class="theme === 'dark' ? 'text-slate-100' : 'text-slate-900'">{{ $title }}</h2>
        @endif
        @if ($subtitle)
            <p class="text-sm" :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'">{{ $subtitle }}</p>
        @endif
    </div>
    <div>
        {{ $actions ?? '' }}
    </div>
</div>
