@props([
    'title' => null,
    'description' => null,
    'showHeader' => true,
])

<section {{ $attributes->class(['space-y-6']) }}>
    @if ($showHeader)
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                @if ($title)
                    <h1 class="text-2xl font-semibold" :class="theme === 'dark' ? 'text-white' : 'text-slate-900'">
                        {{ $title }}
                    </h1>
                @endif
                @if ($description)
                    <p class="mt-1 text-sm" :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'">
                        {{ $description }}
                    </p>
                @endif
            </div>
            @isset($actions)
                <div class="flex items-center gap-2">
                    {{ $actions }}
                </div>
            @endisset
        </div>
    @endif

    @isset($toolbar)
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            {{ $toolbar }}
        </div>
    @endisset

    {{ $slot }}
</section>
