@props([
    'items' => [],
])

<div {{ $attributes->class(['space-y-3']) }}>
    @foreach ($items as $item)
        @php
            $title = $item['title'] ?? '';
            $meta = $item['meta'] ?? null;
            $icon = $item['icon'] ?? null;
            $tone = $item['tone'] ?? 'blue';
            $toneMap = [
                'green' => 'aui-status-success',
                'blue' => 'aui-primary-soft-bg aui-primary-text',
                'purple' => 'aui-primary-gradient-soft aui-primary-text',
                'amber' => 'aui-status-warning',
                'rose' => 'aui-status-danger',
                'slate' => 'bg-slate-500/10 text-slate-500',
            ];
            $toneClass = $toneMap[$tone] ?? $toneMap['blue'];
        @endphp
        <div
            :class="theme === 'dark'
                ? 'group flex items-start gap-3 rounded-lg border border-white/5 bg-white/5 p-3 transition hover:border-white/10 hover:bg-white/10'
                : 'group flex items-start gap-3 rounded-lg border border-slate-200 bg-white p-3 transition hover:border-slate-300 hover:bg-slate-50'"
        >
            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg {{ $toneClass }}">
                @if ($icon)
                    {!! $icon !!}
                @endif
            </div>
            <div class="flex-1">
                <p :class="theme === 'dark' ? 'text-sm font-medium text-slate-200' : 'text-sm font-medium text-slate-900'">
                    {{ $title }}
                </p>
                @if ($meta)
                    <p :class="theme === 'dark' ? 'mt-0.5 text-xs text-slate-400' : 'mt-0.5 text-xs text-slate-500'">
                        {{ $meta }}
                    </p>
                @endif
            </div>
        </div>
    @endforeach
</div>
