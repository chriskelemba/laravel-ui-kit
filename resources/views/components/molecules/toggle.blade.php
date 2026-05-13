@props([
    'label' => null,
    'checked' => false,
    'name' => null,
    'value' => '1',
])

<label x-data="{ on: @js((bool) $checked) }" {{ $attributes->class(['inline-flex items-center gap-3']) }}>
    <input type="checkbox" name="{{ $name }}" value="{{ $value }}" data-aui-field class="sr-only" x-model="on" {{ $checked ? 'checked' : '' }} />
    <span
        class="relative inline-flex h-7 w-12 items-center rounded-full border transition"
        :class="on
            ? 'border-transparent bg-emerald-500'
            : (theme === 'dark' ? 'border-white/10 bg-white/10' : 'border-slate-200 bg-slate-200/80')"
    >
        <span class="inline-block h-5 w-5 rounded-full bg-white shadow-sm transition" :class="on ? 'translate-x-6' : 'translate-x-1'"></span>
    </span>
    @if ($label)
        <span class="text-sm font-medium" :class="theme === 'dark' ? 'text-slate-200' : 'text-slate-700'">{{ $label }}</span>
    @endif
</label>
