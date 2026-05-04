@props([
    'items' => [],
    'panelWidthClass' => 'w-48',
])

<div x-data="{ open: false }" {{ $attributes->class(['relative inline-flex']) }}>
    <span @click="open = !open">
        {{ $trigger ?? $slot }}
    </span>
    <div
        x-show="open"
        x-transition
        @click.away="open = false"
        @class([
            'absolute right-0 z-50 mt-3 overflow-hidden rounded-xl border shadow-xl',
            $panelWidthClass,
        ])
        :class="theme === 'dark' ? 'border-white/10 bg-slate-900 text-slate-100' : 'border-slate-200 bg-white text-slate-900'"
    >
        @foreach ($items as $item)
            <a
                href="{{ $item['href'] ?? '#' }}"
                class="block px-4 py-2 text-sm transition"
                :class="theme === 'dark' ? 'hover:bg-white/5' : 'hover:bg-slate-50'"
            >
                {{ $item['label'] ?? '' }}
            </a>
        @endforeach
    </div>
</div>
