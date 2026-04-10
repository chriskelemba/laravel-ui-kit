@props([
    'value' => 40,
])

@php
    $value = max(0, min(100, (int) $value));
@endphp

<div {{ $attributes->class(['space-y-2']) }}>
    <div class="h-2 w-full overflow-hidden rounded-full"
        :class="theme === 'dark' ? 'bg-white/10' : 'bg-slate-200'">
        <div class="aui-primary-gradient h-full rounded-full" style="width: {{ $value }}%"></div>
    </div>
    <p class="text-xs" :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'">{{ $value }}% complete</p>
</div>
