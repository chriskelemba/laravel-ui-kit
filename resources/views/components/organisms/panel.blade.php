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
        @if ($title)
            <header class="mb-5 flex items-center gap-3">
                <div class="h-2.5 w-2.5 rounded-full" style="background-color: var(--aui-primary);"></div>
                <h2 :class="theme === 'dark' ? 'text-sm font-semibold text-slate-200' : 'text-sm font-semibold text-slate-700'">
                    {{ $title }}
                </h2>
            </header>
        @endif
        <div class="space-y-3">
            {{ $slot }}
        </div>
    </div>
</section>
