@props([
    'tabs' => [],
    'active' => null,
])

@php
    $active = $active ?? ($tabs[0]['id'] ?? null);
@endphp

<div x-data="{ active: @js($active) }" {{ $attributes->class(['space-y-4']) }}>
    <div class="flex flex-wrap gap-2">
        @foreach ($tabs as $tab)
            <button
                type="button"
                @click="active = '{{ $tab['id'] }}'"
                class="rounded-full px-4 py-1.5 text-xs font-semibold"
                :class="active === '{{ $tab['id'] }}'
                    ? (theme === 'dark' ? 'bg-white/10 text-white' : 'bg-slate-900 text-white')
                    : (theme === 'dark' ? 'text-slate-400 hover:bg-white/5' : 'text-slate-600 hover:bg-slate-100')"
            >
                {{ $tab['label'] ?? '' }}
            </button>
        @endforeach
    </div>
    <div>
        @foreach ($tabs as $tab)
            <div x-show="active === '{{ $tab['id'] }}'" x-transition>
                {!! $tab['content'] ?? '' !!}
            </div>
        @endforeach
    </div>
</div>
