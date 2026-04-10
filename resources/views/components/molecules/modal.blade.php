@props([
    'title' => null,
    'open' => false,
    'size' => 'md',
])

@php
    $sizes = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-lg',
        'lg' => 'max-w-2xl',
    ];
    $panelClass = $sizes[$size] ?? $sizes['md'];
@endphp

<div x-data="{ open: @js($open) }" {{ $attributes->class(['relative']) }}>
    @isset($trigger)
        <span @click="open = true">
            {{ $trigger }}
        </span>
    @endisset

    <template x-teleport="body">
        <div
            x-cloak
            x-show="open"
            class="fixed inset-0 z-40 flex items-center justify-center p-4"
            style="position: fixed; inset: 0; z-index: 40;"
            :class="theme === 'dark' ? 'bg-slate-950/70' : 'bg-slate-900/50'"
        >
            <div
                x-show="open"
                x-transition
                @click.away="open = false"
                class="w-full {{ $panelClass }} rounded-xl p-6 shadow-xl"
                :class="theme === 'dark' ? 'bg-slate-900 text-slate-100' : 'bg-white text-slate-900'"
            >
                <div class="flex items-start justify-between gap-4">
                    <div>
                        @if ($title)
                            <h2 class="text-lg font-semibold" :class="theme === 'dark' ? 'text-slate-100' : 'text-slate-900'">{{ $title }}</h2>
                        @endif
                    </div>
                    <x-ui-kit::atoms.button variant="ghost" @click="open = false">
                        Close
                    </x-ui-kit::atoms.button>
                </div>

                <div class="mt-4">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </template>
</div>
