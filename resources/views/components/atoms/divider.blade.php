@props([
    'label' => null,
])

<div {{ $attributes->class(['flex items-center gap-3']) }}>
    <div class="h-px flex-1" :class="theme === 'dark' ? 'bg-white/10' : 'bg-slate-200'"></div>
    @if ($label)
        <span class="text-[10px] uppercase tracking-widest" :class="theme === 'dark' ? 'text-slate-500' : 'text-slate-400'">
            {{ $label }}
        </span>
    @endif
    <div class="h-px flex-1" :class="theme === 'dark' ? 'bg-white/10' : 'bg-slate-200'"></div>
</div>
