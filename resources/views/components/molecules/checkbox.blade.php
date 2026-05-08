@props([
    'label' => null,
    'checked' => false,
    'name' => null,
    'value' => '1',
])

<label {{ $attributes->class(['inline-flex items-center gap-2 text-sm']) }} :class="theme === 'dark' ? 'text-slate-300' : 'text-slate-600'">
    <input type="checkbox" name="{{ $name }}" value="{{ $value }}" class="h-4 w-4 rounded border-slate-300 focus:ring-2" style="accent-color: var(--aui-primary);" {{ $checked ? 'checked' : '' }} />
    <span>{{ $label ?? $slot }}</span>
</label>
