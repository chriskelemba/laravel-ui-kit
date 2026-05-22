@props([
    'label' => null,
    'icon' => null,
    'variant' => 'ghost', // ghost | primary
    'as' => 'button',
    'href' => null,
    'type' => 'button',
    'tooltip' => null,
    'iconOnly' => false,
])

@php
    $isPrimary = $variant === 'primary';
    $showTooltip = filled($tooltip);
    $contentClasses = $iconOnly
        ? 'inline-flex items-center justify-center rounded-full p-2.5 text-sm font-medium transition'
        : 'inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-medium transition';
@endphp

@if ($showTooltip)
    <x-ui-kit::molecules.tooltip :text="$tooltip">
@endif

    @if ($as === 'a')
        <a
            href="{{ $href }}"
            aria-label="{{ $tooltip ?? $label }}"
            {{ $attributes->class([$contentClasses]) }}
            :class="theme === 'dark'
                ? '{{ $isPrimary ? 'aui-primary-bg shadow-sm' : 'border border-white/10 bg-white/5 text-slate-300 hover:border-white/20 hover:bg-white/10 hover:text-white' }}'
                : '{{ $isPrimary ? 'aui-primary-bg shadow-sm' : 'border border-slate-200 bg-white text-slate-700 shadow-sm hover:border-slate-300 hover:bg-slate-50' }}'"
        >
            @if ($icon)
                <span class="inline-flex h-4 w-4 items-center justify-center">{!! $icon !!}</span>
            @endif
            @if ($label && ! $iconOnly)
                <span>{{ $label }}</span>
            @endif
            @if (! $iconOnly)
                {{ $slot }}
            @endif
        </a>
    @else
        <button
            type="{{ $type }}"
            aria-label="{{ $tooltip ?? $label }}"
            {{ $attributes->class([$contentClasses]) }}
            :class="theme === 'dark'
                ? '{{ $isPrimary ? 'aui-primary-bg shadow-sm' : 'border border-white/10 bg-white/5 text-slate-300 hover:border-white/20 hover:bg-white/10 hover:text-white' }}'
                : '{{ $isPrimary ? 'aui-primary-bg shadow-sm' : 'border border-slate-200 bg-white text-slate-700 shadow-sm hover:border-slate-300 hover:bg-slate-50' }}'"
        >
            @if ($icon)
                <span class="inline-flex h-4 w-4 items-center justify-center">{!! $icon !!}</span>
            @endif
            @if ($label && ! $iconOnly)
                <span>{{ $label }}</span>
            @endif
            @if (! $iconOnly)
                {{ $slot }}
            @endif
        </button>
    @endif

@if ($showTooltip)
    </x-ui-kit::molecules.tooltip>
@endif
