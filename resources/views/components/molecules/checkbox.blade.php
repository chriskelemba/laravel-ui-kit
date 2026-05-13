@props([
    'label' => null,
    'checked' => false,
    'name' => null,
    'value' => '1',
])

<label {{ $attributes->class(['group inline-flex items-start gap-3 rounded-2xl border px-3 py-3 text-sm transition']) }} :class="theme === 'dark' ? 'border-white/10 bg-white/5 text-slate-200 hover:border-white/20' : 'border-slate-200 bg-white/85 text-slate-700 hover:border-slate-300 hover:bg-white'">
    <input type="checkbox" name="{{ $name }}" value="{{ $value }}" data-aui-field class="mt-0.5 h-4 w-4 appearance-none rounded-[0.35rem] border-2 border-slate-400 bg-white bg-center bg-no-repeat shadow-none outline-none ring-0 transition checked:border-[color:var(--aui-primary)] checked:bg-[color:var(--aui-primary)] focus:outline-none focus:ring-0 focus:ring-offset-0" style="background-size: 0.7rem; background-image: none;" :style="$el.checked ? `background-size: 0.7rem; background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='none'%3E%3Cpath d='M3.5 8.5 6.5 11.5 12.5 4.5' stroke='white' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E&quot;);` : 'background-size: 0.7rem; background-image: none;'" {{ $checked ? 'checked' : '' }} />
    <span class="leading-5">{{ $label ?? $slot }}</span>
</label>
