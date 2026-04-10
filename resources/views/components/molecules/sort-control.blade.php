@props([
    'options' => [],
])

<div {{ $attributes->class(['flex items-center gap-2 text-xs']) }} :class="theme === 'dark' ? 'text-slate-300' : 'text-slate-600'">
    <span>Sort</span>
    <select class="rounded-md border px-2 py-1 text-xs"
        :class="theme === 'dark' ? 'border-white/10 bg-slate-900/70 text-slate-100' : 'border-slate-200 bg-white text-slate-700'">
        @foreach ($options as $option)
            <option value="{{ $option['value'] ?? '' }}">{{ $option['label'] ?? '' }}</option>
        @endforeach
    </select>
</div>
