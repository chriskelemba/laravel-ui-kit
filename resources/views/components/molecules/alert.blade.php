@props([
    'title' => null,
    'variant' => 'info',
])

@php
    $variant = $variant ?? 'info';
@endphp

<div
    {{ $attributes->class(['rounded-xl border px-4 py-3']) }}
    :class="theme === 'dark'
        ? {
            'info': 'aui-alert-info',
            'success': 'aui-alert-success',
            'warning': 'aui-alert-warning',
            'danger': 'aui-alert-danger'
        }[@js($variant)] || 'aui-alert-info'
        : {
            'info': 'aui-alert-info',
            'success': 'aui-alert-success',
            'warning': 'aui-alert-warning',
            'danger': 'aui-alert-danger'
        }[@js($variant)] || 'aui-alert-info'"
>
    @if ($title)
        <p class="text-sm font-semibold">{{ $title }}</p>
    @endif
    <div class="text-sm">
        {{ $slot }}
    </div>
</div>
