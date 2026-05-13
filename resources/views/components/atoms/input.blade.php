@props([
    'type' => 'text',
    'name' => null,
    'value' => null,
    'placeholder' => null,
    'readonly' => false,
    'disabled' => false,
])

<input
    type="{{ $type }}"
    name="{{ $name }}"
    value="{{ $value }}"
    placeholder="{{ $placeholder }}"
    @readonly($readonly)
    @disabled($disabled)
    data-aui-field
    {{ $attributes->class(['aui-form-input aui-focus w-full rounded-2xl border px-4 py-3 text-sm shadow-sm transition duration-200 focus:outline-none focus:ring-2']) }}
    :class="theme === 'dark'
        ? 'border-white/10 bg-slate-900/80 text-slate-100 placeholder:text-slate-500'
        : 'border-slate-200 bg-white/95 text-slate-900 placeholder:text-slate-400'"
/>
