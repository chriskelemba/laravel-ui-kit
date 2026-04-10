@props([
    'label' => null,
    'value' => null,
    'description' => null,
    'trend' => null, // 'up', 'down', or null
    'trendValue' => null,
    'icon' => null,
])

<div
    {{ $attributes->class([]) }}
    :class="theme === 'dark'
        ? 'group relative overflow-hidden rounded-3xl border border-white/10 bg-slate-900/85 p-5 transition hover:border-white/20'
        : 'group relative overflow-hidden rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-slate-300 hover:shadow-md'"
>
    <div class="relative">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                @if ($label)
                    <p :class="theme === 'dark' ? 'text-sm font-medium text-slate-400' : 'text-sm font-medium text-slate-500'">
                        {{ $label }}
                    </p>
                @endif

                @if ($value)
                    <p :class="theme === 'dark' ? 'mt-3 text-4xl font-semibold tracking-tight text-white' : 'mt-3 text-4xl font-semibold tracking-tight text-slate-900'">
                        {{ $value }}
                    </p>
                @endif
                
                @if ($description || $trend)
                    <div class="mt-2 flex items-center gap-2">
                        @if ($trend && $trendValue)
                            <span
                                :class="theme === 'dark'
                                    ? 'inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-medium ' + (@js($trend) === 'up' ? 'aui-status-success' : 'aui-status-danger')
                                    : 'inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-xs font-medium ' + (@js($trend) === 'up' ? 'aui-status-success' : 'aui-status-danger')"
                            >
                                @if ($trend === 'up')
                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                    </svg>
                                @else
                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                    </svg>
                                @endif
                                {{ $trendValue }}
                            </span>
                        @endif
                        
                        @if ($description)
                            <p :class="theme === 'dark' ? 'text-sm text-slate-400' : 'text-sm text-slate-500'">
                                {{ $description }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
            
            @if ($icon)
                <div
                    :class="theme === 'dark'
                        ? 'flex h-11 w-11 items-center justify-center rounded-2xl aui-primary-soft-bg aui-primary-text'
                        : 'flex h-11 w-11 items-center justify-center rounded-2xl aui-primary-soft-bg aui-primary-text'"
                >
                    {!! $icon !!}
                </div>
            @endif
        </div>
        
        {{ $slot }}
    </div>
</div>
