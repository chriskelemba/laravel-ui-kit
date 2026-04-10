@props([
    'steps' => [],
    'active' => 1,
])

@php
    $active = (int) $active;
@endphp

<div {{ $attributes->class(['flex items-center gap-4']) }}>
    @foreach ($steps as $index => $step)
        @php $stepIndex = $index + 1; @endphp
        <div class="flex items-center gap-2">
            <span
                class="flex h-7 w-7 items-center justify-center rounded-full text-xs font-semibold"
                :class="{{ $stepIndex }} <= {{ $active }}
                    ? 'aui-primary-soft-bg aui-primary-text'
                    : (theme === 'dark' ? 'bg-white/10 text-slate-400' : 'bg-slate-100 text-slate-500')"
            >
                {{ $stepIndex }}
            </span>
            <span class="text-xs" :class="theme === 'dark' ? 'text-slate-300' : 'text-slate-600'">
                {{ $step['label'] ?? '' }}
            </span>
        </div>
        @if ($index < count($steps) - 1)
            <div class="h-px w-6" :class="theme === 'dark' ? 'bg-white/10' : 'bg-slate-200'"></div>
        @endif
    @endforeach
</div>
