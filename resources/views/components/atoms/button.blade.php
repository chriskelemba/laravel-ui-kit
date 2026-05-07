@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'as' => 'button',
    'href' => null,
    'loadingLabel' => 'Loading...',
])

@php
    $base = 'inline-flex cursor-pointer items-center justify-center gap-2 rounded-full font-medium transition focus:outline-none focus:ring-2 focus:ring-slate-400 disabled:cursor-not-allowed disabled:opacity-70';
    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-5 py-2.5 text-base',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $variant = $variant ?? 'primary';
    $showLoader = $as !== 'a' && strtolower((string) $type) === 'submit';
@endphp

@if ($as === 'a')
    <a
        href="{{ $href }}"
        data-aui-page-link="true"
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
        x-data="{ loading: false }"
        @click="
            if (@js($showLoader)) {
                loading = true;
                $el.disabled = true;
            }
            window.dispatchEvent(new CustomEvent('aui:page-loading'));
        "
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
        @if ($showLoader)
            <svg x-show="loading" x-cloak class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-opacity="0.25" stroke-width="3"></circle>
                <path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="3" stroke-linecap="round"></path>
            </svg>
            <span x-show="!loading">{{ $slot }}</span>
            <span x-show="loading" x-cloak>{{ $loadingLabel }}</span>
        @else
            {{ $slot }}
        @endif
    </button>
@endif
