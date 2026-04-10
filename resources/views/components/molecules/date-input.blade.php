@props([
    'name' => null,
])

<input
    type="date"
    name="{{ $name }}"
    {{ $attributes->class(['aui-focus w-full rounded-md border px-3 py-2 text-sm focus:outline-none focus:ring-2']) }}
    :class="theme === 'dark'
        ? 'border-white/10 bg-slate-900/70 text-slate-100'
        : 'border-slate-300 bg-white text-slate-900'"
/>
