@props([
    'label' => null,
    'checked' => false,
])

<label x-data="{ on: @js((bool) $checked) }" {{ $attributes->class(['inline-flex items-center gap-3']) }}>
    <input type="checkbox" class="sr-only" x-model="on" />
    <span
        class="relative inline-flex h-6 w-11 items-center rounded-full transition"
        :class="on
            ? 'aui-primary-soft-bg'
            : (theme === 'dark' ? 'bg-white/10' : 'bg-slate-200')"
    >
        <span class="inline-block h-4 w-4 rounded-full bg-white transition" :class="on ? 'translate-x-6' : 'translate-x-1'"></span>
    </span>
    @if ($label)
        <span class="text-sm" :class="theme === 'dark' ? 'text-slate-300' : 'text-slate-600'">{{ $label }}</span>
    @endif
</label>
