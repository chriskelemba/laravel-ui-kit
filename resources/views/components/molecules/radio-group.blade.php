@props([
    'name' => 'option',
    'options' => [],
])

<div {{ $attributes->class(['space-y-2']) }}>
    @foreach ($options as $option)
        <label class="flex items-center gap-2 text-sm" :class="theme === 'dark' ? 'text-slate-300' : 'text-slate-600'">
            <input type="radio" name="{{ $name }}" value="{{ $option['value'] ?? '' }}" class="h-4 w-4 border-slate-300" style="accent-color: var(--aui-primary);" {{ !empty($option['checked']) ? 'checked' : '' }} />
            <span>{{ $option['label'] ?? '' }}</span>
        </label>
    @endforeach
</div>
