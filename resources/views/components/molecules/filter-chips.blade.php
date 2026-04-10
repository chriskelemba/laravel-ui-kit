@props([
    'items' => [],
])

<div {{ $attributes->class(['flex flex-wrap gap-2']) }}>
    @foreach ($items as $item)
        @php $active = $item['active'] ?? false; @endphp
        <button type="button" class="rounded-full px-3 py-1 text-xs font-semibold"
            :class="{{ $active ? 'true' : 'false' }}
                ? 'aui-primary-soft-bg aui-primary-text'
                : (theme === 'dark' ? 'bg-white/5 text-slate-300' : 'bg-slate-100 text-slate-600')"
        >
            {{ $item['label'] ?? '' }}
        </button>
    @endforeach
</div>
