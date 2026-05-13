@props([
    'name' => null,
])

<input
    type="date"
    name="{{ $name }}"
    data-aui-field
    {{ $attributes->class(['aui-form-input aui-focus w-full rounded-2xl border px-4 py-3 text-sm transition duration-200 focus:outline-none focus:ring-2']) }}
    :class="theme === 'dark'
        ? 'border-white/10 bg-slate-900/80 text-slate-100'
        : 'border-slate-200 bg-white/95 text-slate-900'"
/>
