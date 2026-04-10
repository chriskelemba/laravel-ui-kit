@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'as' => 'button',
    'href' => null,
])

@php
    $base = 'inline-flex items-center justify-center gap-2 rounded-full font-medium transition focus:outline-none focus:ring-2 focus:ring-slate-400';
    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-5 py-2.5 text-base',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $variant = $variant ?? 'primary';
@endphp

@if ($as === 'a')
    <a
        href="{{ $href }}"
        {{ $attributes->class([$base, $sizeClass]) }}
        :class="theme === 'dark'
            ? {
                'primary': 'aui-primary-bg',
                'secondary': 'border border-white/20 text-white hover:bg-white/10',
                'danger': 'aui-danger-bg',
                'ghost': 'text-slate-200 hover:bg-white/10'
            }[@js($variant)] || 'aui-primary-bg'
            : {
                'primary': 'aui-primary-bg',
                'secondary': 'border border-slate-300 bg-white text-slate-900 shadow-sm hover:bg-slate-50',
                'danger': 'aui-danger-bg',
                'ghost': 'text-slate-700 hover:bg-slate-100'
            }[@js($variant)] || 'aui-primary-bg'"
    >
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->class([$base, $sizeClass]) }}
        :class="theme === 'dark'
            ? {
                'primary': 'aui-primary-bg',
                'secondary': 'border border-white/20 text-white hover:bg-white/10',
                'danger': 'aui-danger-bg',
                'ghost': 'text-slate-200 hover:bg-white/10'
            }[@js($variant)] || 'aui-primary-bg'
            : {
                'primary': 'aui-primary-bg',
                'secondary': 'border border-slate-300 bg-white text-slate-900 shadow-sm hover:bg-slate-50',
                'danger': 'aui-danger-bg',
                'ghost': 'text-slate-700 hover:bg-slate-100'
            }[@js($variant)] || 'aui-primary-bg'"
    >
        {{ $slot }}
    </button>
@endif
