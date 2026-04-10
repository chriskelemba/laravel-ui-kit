@props([
    'label' => 'Upload file',
])

<label {{ $attributes->class(['flex w-full cursor-pointer flex-col items-center justify-center rounded-xl border border-dashed px-4 py-6 text-sm']) }}
    :class="theme === 'dark' ? 'border-white/10 text-slate-300 hover:border-white/20' : 'border-slate-200 text-slate-600 hover:border-slate-300'">
    <input type="file" class="hidden" />
    <span class="font-semibold">{{ $label }}</span>
    <span class="text-xs" :class="theme === 'dark' ? 'text-slate-500' : 'text-slate-400'">Drag and drop or click to browse</span>
</label>
