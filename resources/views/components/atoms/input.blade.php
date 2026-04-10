@props([
    'type' => 'text',
    'name' => null,
    'value' => null,
    'placeholder' => null,
])

@php
    $isRequired = $attributes->has('required');
@endphp

<input
    type="{{ $type }}"
    name="{{ $name }}"
    value="{{ $value }}"
    placeholder="{{ $placeholder }}"
    {{ $attributes->class(['aui-focus w-full rounded-md border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2']) }}
    :class="theme === 'dark'
        ? (@js($isRequired)
            ? 'border-rose-500/60 bg-slate-900/70 text-slate-100 placeholder:text-slate-500 focus:border-rose-400/70 focus:ring-rose-500/30'
            : 'border-white/10 bg-slate-900/70 text-slate-100 placeholder:text-slate-500')
        : (@js($isRequired)
            ? 'border-rose-500/60 bg-white text-slate-900 placeholder:text-slate-400 focus:border-rose-500 focus:ring-rose-200'
            : 'border-slate-300 bg-white text-slate-900 placeholder:text-slate-400')"
/>
