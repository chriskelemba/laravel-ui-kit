@props([
    'title' => null,
    'message' => null,
    'variant' => 'info',
    'timeout' => 3000,
])

@php
    $variant = $variant ?? 'info';
@endphp

<div
    {{ $attributes->class(['rounded-2xl border px-6 py-5 text-base shadow-2xl']) }}
    :class="theme === 'dark'
        ? {
            'info': 'border-slate-700 bg-slate-900 text-slate-100',
            'success': 'border-transparent bg-slate-900 text-slate-100',
            'warning': 'border-transparent bg-slate-900 text-slate-100',
            'danger': 'border-transparent bg-slate-900 text-slate-100'
        }[@js($variant)] || 'border-slate-700 bg-slate-900 text-slate-100'
        : {
            'info': 'border-slate-200 bg-white text-slate-900',
            'success': 'border-transparent bg-white text-slate-900',
            'warning': 'border-transparent bg-white text-slate-900',
            'danger': 'border-transparent bg-white text-slate-900'
        }[@js($variant)] || 'border-slate-200 bg-white text-slate-900'"
    style="@if ($variant === 'success') border-color: var(--aui-success-soft); @elseif ($variant === 'warning') border-color: var(--aui-warning-soft); @elseif ($variant === 'danger') border-color: var(--aui-danger-soft); @elseif ($variant === 'info') border-color: var(--aui-primary-soft); @endif"
>
    @if ($title)
        <p class="text-sm font-semibold">{{ $title }}</p>
    @endif
    <p class="text-sm">{{ $message ?? $slot }}</p>
</div>
