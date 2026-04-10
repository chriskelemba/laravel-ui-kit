@props([
    'text' => 'Tooltip',
])

<span x-data="{ open: false }" {{ $attributes->class(['relative inline-flex']) }}>
    <span @mouseenter="open = true" @mouseleave="open = false">
        {{ $slot }}
    </span>
    <span
        x-show="open"
        x-transition
        class="absolute left-1/2 top-full z-50 mt-2 -translate-x-1/2 whitespace-nowrap rounded-md px-2 py-1 text-xs"
        :class="theme === 'dark' ? 'bg-slate-800 text-slate-100' : 'bg-slate-900 text-white'"
    >
        {{ $text }}
    </span>
</span>
