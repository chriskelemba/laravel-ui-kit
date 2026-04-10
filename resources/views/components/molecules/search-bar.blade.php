@props([
    'placeholder' => 'Search...',
    'name' => null,
    'value' => null,
    'action' => null,
    'method' => 'GET',
])

@if ($action)
    <form action="{{ $action }}" method="{{ strtoupper($method) === 'GET' ? 'GET' : 'POST' }}" {{ $attributes->class(['flex items-center gap-2 rounded-xl border px-3 py-2']) }}
        :class="theme === 'dark' ? 'border-white/10 bg-slate-900/70' : 'border-slate-200 bg-slate-100/80 shadow-sm'">
        @if (strtoupper($method) !== 'GET')
            @csrf
        @endif
        <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
        </svg>
        <input
            type="text"
            name="{{ $name ?? 'q' }}"
            value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            class="w-full bg-transparent text-sm focus:outline-none"
            :class="theme === 'dark' ? 'text-slate-100 placeholder:text-slate-500' : 'text-slate-700 placeholder:text-slate-400'"
        />
    </form>
@else
    <div {{ $attributes->class(['flex items-center gap-2 rounded-xl border px-3 py-2']) }}
        :class="theme === 'dark' ? 'border-white/10 bg-slate-900/70' : 'border-slate-200 bg-slate-100/80 shadow-sm'">
        <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
        </svg>
        <input
            type="text"
            @if ($name) name="{{ $name }}" @endif
            @if (! is_null($value)) value="{{ $value }}" @endif
            placeholder="{{ $placeholder }}"
            class="w-full bg-transparent text-sm focus:outline-none"
            :class="theme === 'dark' ? 'text-slate-100 placeholder:text-slate-500' : 'text-slate-700 placeholder:text-slate-400'"
        />
    </div>
@endif
