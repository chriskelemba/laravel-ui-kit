@props([
    'variant' => 'default',
])

@php
    $variant = $variant ?? 'default';
@endphp

<span
    {{ $attributes->class(['inline-flex items-center gap-1 rounded-lg border px-2.5 py-1 text-xs']) }}
    :class="theme === 'dark'
        ? {
            'default': 'border-white/10 text-slate-300',
            'accent': 'aui-primary-border aui-primary-text',
            'muted': 'border-white/5 text-slate-400'
        }[@js($variant)] || 'border-white/10 text-slate-300'
        : {
            'default': 'border-slate-200 text-slate-600',
            'accent': 'aui-primary-border aui-primary-text',
            'muted': 'border-slate-100 text-slate-500'
        }[@js($variant)] || 'border-slate-200 text-slate-600'"
>
    {{ $slot }}
</span>
