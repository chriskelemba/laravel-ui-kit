@props([
    'options' => [],
    'name' => null,
])

<select
    name="{{ $name }}"
    data-aui-field
    {{ $attributes->class(['aui-form-input aui-form-select aui-focus w-full appearance-none rounded-2xl border px-4 py-3 pr-11 text-sm transition duration-200 focus:outline-none focus:ring-2']) }}
    style="-webkit-appearance: none; -moz-appearance: none; appearance: none;"
    :class="theme === 'dark'
        ? 'border-white/10 bg-slate-900/80 text-slate-100'
        : 'border-slate-200 bg-white/95 text-slate-900'"
>
    @foreach ($options as $option)
        <option value="{{ $option['value'] ?? '' }}" {{ !empty($option['selected']) ? 'selected' : '' }}>
            {{ $option['label'] ?? '' }}
        </option>
    @endforeach
</select>
