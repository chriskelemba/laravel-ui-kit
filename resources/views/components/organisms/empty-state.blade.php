@props([
    'title' => 'Nothing here yet',
    'message' => 'Create something to get started.',
])

<div {{ $attributes->class(['rounded-2xl border px-6 py-8 text-center']) }}
    :class="theme === 'dark' ? 'border-white/10 bg-slate-900/60 text-slate-300' : 'border-slate-200 bg-white text-slate-600'">
    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl"
        :class="theme === 'dark' ? 'bg-white/5 text-slate-200' : 'bg-slate-100 text-slate-600'">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m-6-8h6M5 6h14a1 1 0 011 1v10a1 1 0 01-1 1H5a1 1 0 01-1-1V7a1 1 0 011-1z"/>
        </svg>
    </div>
    <h3 class="mt-4 text-sm font-semibold" :class="theme === 'dark' ? 'text-slate-100' : 'text-slate-900'">{{ $title }}</h3>
    <p class="mt-1 text-sm">{{ $message }}</p>
    <div class="mt-4">
        {{ $slot }}
    </div>
</div>
