@props([
    'title' => null,
])

<div x-data="{ open: false }" {{ $attributes->class(['relative inline-flex']) }}>
    <span @click="open = !open">
        {{ $trigger ?? $slot }}
    </span>
    <div
        x-show="open"
        x-transition
        @click.away="open = false"
        class="absolute right-0 z-50 mt-3 w-64 rounded-xl border p-4 shadow-xl"
        :class="theme === 'dark' ? 'border-white/10 bg-slate-900 text-slate-100' : 'border-slate-200 bg-white text-slate-900'"
    >
        @if ($title)
            <p class="text-sm font-semibold">{{ $title }}</p>
        @endif
        <div class="text-sm">
            {{ $content ?? '' }}
        </div>
    </div>
</div>
