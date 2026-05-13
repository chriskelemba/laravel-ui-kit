@props([
    'name' => 'option',
    'options' => [],
])

<div {{ $attributes->class(['space-y-2']) }}>
    @foreach ($options as $option)
        <label class="group flex items-start gap-3 rounded-2xl border px-3 py-3 text-sm transition" :class="theme === 'dark' ? 'border-white/10 bg-white/5 text-slate-200 hover:border-white/20' : 'border-slate-200 bg-white/85 text-slate-700 hover:border-slate-300 hover:bg-white'">
            <input type="radio" name="{{ $name }}" value="{{ $option['value'] ?? '' }}" data-aui-field class="mt-0.5 h-4 w-4 appearance-none rounded-full border-2 border-slate-400 bg-white shadow-none outline-none ring-0 transition checked:border-[color:var(--aui-primary)] checked:bg-[radial-gradient(circle,var(--aui-primary)_0_45%,white_50%_100%)] focus:outline-none focus:ring-0 focus:ring-offset-0" {{ !empty($option['checked']) ? 'checked' : '' }} />
            <span class="leading-5">{{ $option['label'] ?? '' }}</span>
        </label>
    @endforeach
</div>
