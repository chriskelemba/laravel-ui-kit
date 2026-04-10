@props([
    'current' => 1,
    'total' => 1,
])

@php
    $current = max(1, (int) $current);
    $total = max(1, (int) $total);
@endphp

<div {{ $attributes->class(['flex items-center gap-2 text-xs']) }}>
    <button type="button" class="rounded-md px-2 py-1"
        :class="theme === 'dark' ? 'border border-white/10 text-slate-300' : 'border border-slate-200 text-slate-600'">
        Prev
    </button>
    <span :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'">Page {{ $current }} of {{ $total }}</span>
    <button type="button" class="rounded-md px-2 py-1"
        :class="theme === 'dark' ? 'border border-white/10 text-slate-300' : 'border border-slate-200 text-slate-600'">
        Next
    </button>
</div>
