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

<div {{ $wrapperAttributes->class(['aui-form-field space-y-2']) }}>
    @if ($label)
        <label
            for="{{ $name }}"
            class="aui-form-label text-sm font-semibold tracking-[0.01em]"
            :class="theme === 'dark' ? 'text-slate-100' : 'text-slate-800'"
        >
            {{ $label }}
            @if ($isRequired)
                <span class="ml-1 aui-primary-text">*</span>
            @endif
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
        <p class="text-xs leading-5" :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'">{{ $hint }}</p>
    @endif
</div>
