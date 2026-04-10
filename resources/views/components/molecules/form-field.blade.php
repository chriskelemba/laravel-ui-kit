@props([
    'label' => null,
    'name' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'hint' => null,
    'required' => false,
])

@php
    $hasSlot = trim($slot) !== '';
    $isRequired = $required || $attributes->has('required');
    $wrapperAttributes = $attributes->only('class');
    $inputAttributes = $isRequired
        ? $attributes->except('class')->merge(['required' => true])
        : $attributes->except('class');
@endphp

<div {{ $wrapperAttributes->class(['space-y-1']) }}>
    @if ($label)
        <label
            for="{{ $name }}"
            class="text-sm font-medium"
            :class="theme === 'dark' ? 'text-slate-200' : 'text-slate-700'"
        >
            {{ $label }}
        </label>
    @endif

    @if ($hasSlot)
        {{ $slot }}
    @else
        <x-ui-kit::atoms.input
            :name="$name"
            :type="$type"
            :value="$value"
            :placeholder="$placeholder"
            id="{{ $name }}"
            {{ $inputAttributes }}
        />
    @endif

    @if ($hint)
        <p class="text-xs" :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'">{{ $hint }}</p>
    @endif
</div>
