@props([
    'action' => null,
    'method' => 'GET',
    'filters' => [],
    'submitLabel' => 'Apply filters',
    'resetUrl' => null,
    'title' => null,
    'description' => null,
])

@php
    $formMethod = strtoupper($method);
@endphp

<form
    action="{{ $action }}"
    method="{{ $formMethod === 'GET' ? 'GET' : 'POST' }}"
    {{ $attributes->class(['rounded-[28px] border p-5 shadow-sm']) }}
    :class="theme === 'dark' ? 'border-white/10 bg-slate-950/60' : 'border-slate-200 bg-white/95'"
>
    @if ($formMethod !== 'GET')
        @csrf
    @endif

    <div class="flex flex-wrap items-start justify-between gap-4">
        <div class="min-w-0">
            @if ($title)
                <p class="text-sm font-semibold text-slate-900" :class="theme === 'dark' ? 'text-slate-100' : 'text-slate-900'">{{ $title }}</p>
            @endif
            @if ($description)
                <p class="mt-1 text-sm text-slate-600" :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-600'">{{ $description }}</p>
            @endif
        </div>

        <div class="flex flex-wrap items-center gap-2">
            @if ($resetUrl)
                <a
                    href="{{ $resetUrl }}"
                    class="inline-flex items-center justify-center rounded-full border px-4 py-2 text-sm font-medium transition"
                    :class="theme === 'dark' ? 'border-white/15 text-slate-200 hover:bg-white/5' : 'border-slate-300 text-slate-700 hover:bg-slate-50'"
                >
                    Reset
                </a>
            @endif

            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-full px-4 py-2 text-sm font-semibold transition aui-primary-bg"
            >
                {{ $submitLabel }}
            </button>
        </div>
    </div>

    <div class="mt-5 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        @foreach ($filters as $filter)
            @php
                $type = $filter['type'] ?? 'text';
                $label = $filter['label'] ?? null;
                $name = $filter['name'] ?? null;
            @endphp

            <div class="space-y-2">
                @if ($label)
                    <label @if ($name) for="{{ $name }}" @endif class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500" :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'">
                        {{ $label }}
                    </label>
                @endif

                @if ($type === 'select')
                    <x-ui-kit::molecules.select
                        :name="$name"
                        :options="$filter['options'] ?? []"
                        :id="$filter['id'] ?? $name"
                    />
                @elseif ($type === 'search')
                    <x-ui-kit::molecules.search-bar
                        :name="$name"
                        :value="$filter['value'] ?? null"
                        :placeholder="$filter['placeholder'] ?? 'Search...'"
                    />
                @else
                    <x-ui-kit::atoms.input
                        :id="$filter['id'] ?? $name"
                        :name="$name"
                        :type="$type"
                        :value="$filter['value'] ?? null"
                        :placeholder="$filter['placeholder'] ?? null"
                    />
                @endif
            </div>
        @endforeach
    </div>
</form>
