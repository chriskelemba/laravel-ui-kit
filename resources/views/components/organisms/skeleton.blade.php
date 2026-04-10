@props([
    'lines' => 3,
])

<div {{ $attributes->class(['space-y-3']) }}>
    @for ($i = 0; $i < $lines; $i++)
        <div class="h-3 w-full animate-pulse rounded"
            :class="theme === 'dark' ? 'bg-white/10' : 'bg-slate-200'"></div>
    @endfor
</div>
