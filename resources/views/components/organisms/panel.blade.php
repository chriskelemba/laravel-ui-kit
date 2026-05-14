@props([
    'title' => null,
])

<section
    {{ $attributes->class([]) }}
    :class="theme === 'dark'
        ? 'group relative overflow-visible rounded-3xl border border-white/10 bg-slate-900/80 p-6 backdrop-blur-sm transition hover:border-white/20'
        : 'group relative overflow-visible rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:border-slate-300'"
>
    <div class="relative">
        @if ($title || isset($actions))
            <header class="mb-5 flex items-center justify-between gap-4">
                @if ($title)
                    <div class="flex min-w-0 items-center gap-3">
                        <div class="h-2.5 w-2.5 shrink-0 rounded-full" style="background-color: var(--aui-primary);"></div>
                        <h2 class="min-w-0 truncate" :class="theme === 'dark' ? 'text-sm font-semibold text-slate-200' : 'text-sm font-semibold text-slate-700'">
                            {{ $title }}
                        </h2>
                    </div>
                @else
                    <div></div>
                @endif

                @isset($actions)
                    <div class="shrink-0">
                        {{ $actions }}
                    </div>
                @endisset
            </header>
        @endif
        <div class="space-y-3">
            {{ $slot }}
        </div>
    </div>
</section>
