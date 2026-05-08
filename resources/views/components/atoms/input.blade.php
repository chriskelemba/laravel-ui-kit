@props([
    'type' => 'text',
    'name' => null,
    'value' => null,
    'placeholder' => null,
])

<input
    type="{{ $type }}"
    name="{{ $name }}"
    value="{{ $value }}"
    placeholder="{{ $placeholder }}"
    data-aui-field
    {{ $attributes->class(['aui-focus w-full rounded-md border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2']) }}
    :class="theme === 'dark'
        ? 'border-white/10 bg-slate-900/70 text-slate-100 placeholder:text-slate-500'
        : 'border-slate-300 bg-white text-slate-900 placeholder:text-slate-400'"
/>
