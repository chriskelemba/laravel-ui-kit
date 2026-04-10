@props([
    'items' => [],
])

<div {{ $attributes->class(['space-y-3']) }}>
    @foreach ($items as $item)
        @php
            $title = $item['title'] ?? '';
            $meta = $item['meta'] ?? null;
            $priority = $item['priority'] ?? null; // high | medium | low
            $badgeClasses = [
                'high' => 'bg-red-500/10 text-red-400',
                'medium' => 'bg-amber-500/10 text-amber-400',
                'low' => 'bg-slate-500/10 text-slate-400',
            ];
            $badgeClassesLight = [
                'high' => 'bg-red-100 text-red-600',
                'medium' => 'bg-amber-100 text-amber-600',
                'low' => 'bg-slate-100 text-slate-600',
            ];
            $badge = $badgeClasses[$priority] ?? $badgeClasses['low'];
            $badgeLight = $badgeClassesLight[$priority] ?? $badgeClassesLight['low'];
        @endphp
            <label
            :class="theme === 'dark'
                ? 'group flex items-start gap-3 rounded-lg border border-white/5 bg-white/5 p-3 transition hover:border-white/10 hover:bg-white/10'
                : 'group flex items-start gap-3 rounded-lg border border-slate-200 bg-white p-3 transition hover:border-slate-300 hover:bg-slate-50'"
        >
            <input type="checkbox" class="mt-0.5 h-4 w-4 rounded border-slate-300 bg-white focus:ring-2 focus:ring-offset-0" style="accent-color: var(--aui-primary);">
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
            @if ($priority)
                <span
                    :class="theme === 'dark' ? '{{ $badge }}' : '{{ $badgeLight }}'"
                    class="rounded-full px-2 py-0.5 text-xs font-medium"
                >
                    {{ ucfirst($priority) }}
                </span>
            @endif
        </label>
    @endforeach
</div>
