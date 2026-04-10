@props([
    'label' => null,
    'icon' => null,
    'variant' => 'ghost', // ghost | primary
    'as' => 'button',
    'href' => null,
    'type' => 'button',
])

@php
    $isPrimary = $variant === 'primary';
@endphp

@if ($as === 'a')
    <a
        href="{{ $href }}"
        {{ $attributes->class([
            'inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-medium transition',
        ]) }}
        :class="theme === 'dark'
            ? '{{ $isPrimary ? 'aui-primary-bg shadow-sm' : 'border border-white/10 bg-white/5 text-slate-300 hover:border-white/20 hover:bg-white/10 hover:text-white' }}'
            : '{{ $isPrimary ? 'aui-primary-bg shadow-sm' : 'border border-slate-200 bg-white text-slate-700 shadow-sm hover:border-slate-300 hover:bg-slate-50' }}'"
    >
        @if ($icon)
            {!! $icon !!}
        @endif
        @if ($label)
            <span>{{ $label }}</span>
        @endif
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->class([
            'inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-medium transition',
        ]) }}
        :class="theme === 'dark'
            ? '{{ $isPrimary ? 'aui-primary-bg shadow-sm' : 'border border-white/10 bg-white/5 text-slate-300 hover:border-white/20 hover:bg-white/10 hover:text-white' }}'
            : '{{ $isPrimary ? 'aui-primary-bg shadow-sm' : 'border border-slate-200 bg-white text-slate-700 shadow-sm hover:border-slate-300 hover:bg-slate-50' }}'"
    >
        @if ($icon)
            {!! $icon !!}
        @endif
        @if ($label)
            <span>{{ $label }}</span>
        @endif
        {{ $slot }}
    </button>
@endif
