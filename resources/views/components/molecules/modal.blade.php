@props([
    'title' => null,
    'open' => false,
    'size' => 'md',
    'width' => null,
    'height' => null,
    'maxHeight' => '90vh',
    'closeOnEscape' => true,
    'closeOnBackdrop' => true,
    'showClose' => true,
    'id' => 'modal-' . \Illuminate\Support\Str::uuid(),
])

@php
    $sizes = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-lg',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
        'full' => 'max-w-[96vw]',
    ];
    $panelClass = $width ? '' : ($sizes[$size] ?? $sizes['md']);
    $titleId = $id . '-title';
    $descriptionId = $id . '-description';
    $panelStyle = collect([
        $width ? 'width: ' . $width : null,
        $height ? 'height: ' . $height : null,
        $maxHeight ? 'max-height: ' . $maxHeight : null,
    ])->filter()->implode('; ');
@endphp

<div
    x-data="{ open: @js($open) }"
    x-on:keydown.escape.window="@js($closeOnEscape) ? (open = false) : null"
    {{ $attributes->class(['relative']) }}
>
    @isset($trigger)
        <span @click="open = true">
            {{ $trigger }}
        </span>
    @endisset

    <template x-teleport="body">
        <div
            x-cloak
            x-show="open"
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
            role="presentation"
            aria-hidden="true"
            :class="theme === 'dark' ? 'bg-slate-950/70' : 'bg-slate-900/50'"
            @if($closeOnBackdrop)
                @click="open = false"
            @endif
        >
            <div
                x-show="open"
                x-transition.scale.95
                class="w-full {{ $panelClass }} overflow-y-auto rounded-2xl p-6 shadow-2xl"
                style="{{ $panelStyle }}"
                role="dialog"
                aria-modal="true"
                aria-labelledby="{{ $title ? $titleId : '' }}"
                aria-describedby="{{ $descriptionId }}"
                tabindex="-1"
                @click.stop
                :class="theme === 'dark' ? 'bg-slate-900 text-slate-100' : 'bg-white text-slate-900'"
            >
                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        @if ($title)
                            <h2 id="{{ $titleId }}" class="text-lg font-semibold" :class="theme === 'dark' ? 'text-slate-100' : 'text-slate-900'">{{ $title }}</h2>
                        @endif
                        @isset($subtitle)
                            <p class="mt-1 text-sm" :class="theme === 'dark' ? 'text-slate-300' : 'text-slate-600'">{{ $subtitle }}</p>
                        @endisset
                    </div>
                    @if($showClose)
                        <x-ui-kit::atoms.button variant="ghost" @click="open = false" aria-label="Close modal">
                            Close
                        </x-ui-kit::atoms.button>
                    @endif
                </div>

                <div id="{{ $descriptionId }}" class="mt-4">
                    @isset($body)
                        {{ $body }}
                    @else
                        {{ $slot }}
                    @endisset
                </div>

                @isset($footer)
                    <div class="mt-6 flex items-center justify-end gap-3 border-t pt-4" :class="theme === 'dark' ? 'border-slate-700' : 'border-slate-200'">
                        {{ $footer }}
                    </div>
                @endisset
            </div>
        </div>
    </template>
</div>
