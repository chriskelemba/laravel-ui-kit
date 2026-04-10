@props([
    'variant' => 'primary',
])

@php
    $variant = $variant ?? 'primary';
@endphp

<span
    {{ $attributes->class(['inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold']) }}
    :class="theme === 'dark'
        ? {
            'primary': 'aui-primary-soft-bg aui-primary-text',
            'secondary': 'bg-slate-500/15 text-slate-300',
            'success': 'aui-status-success',
            'danger': 'aui-status-danger',
            'warning': 'aui-status-warning'
        }[@js($variant)] || 'aui-primary-soft-bg aui-primary-text'
        : {
            'primary': 'aui-primary-soft-bg aui-primary-text',
            'secondary': 'bg-slate-100 text-slate-600',
            'success': 'aui-status-success',
            'danger': 'aui-status-danger',
            'warning': 'aui-status-warning'
        }[@js($variant)] || 'aui-primary-soft-bg aui-primary-text'"
>
    {{ $slot }}
</span>
