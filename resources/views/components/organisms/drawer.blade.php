@props([
    'title' => null,
    'open' => false,
])

<div x-data="{ open: @js($open) }" {{ $attributes->class(['relative']) }}>
    @isset($trigger)
        <span @click="open = true">
            {{ $trigger }}
        </span>
    @endisset

    <template x-teleport="body">
        <div x-show="open" x-cloak class="fixed inset-0 z-40">
            <div class="absolute inset-0" @click="open = false"
                :class="theme === 'dark' ? 'bg-slate-950/70' : 'bg-slate-900/50'"></div>
            <div
                class="absolute right-0 top-0 h-full w-80 p-6 shadow-2xl"
                :class="theme === 'dark' ? 'bg-slate-900 text-slate-100' : 'bg-white text-slate-900'"
                x-transition
            >
                <div class="flex items-center justify-between">
                    @if ($title)
                        <h3 class="text-sm font-semibold">{{ $title }}</h3>
                    @endif
                    <button type="button" class="text-xs" @click="open = false">Close</button>
                </div>
                <div class="mt-4">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </template>
</div>
