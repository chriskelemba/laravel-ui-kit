@props([
    'items' => [],
])

<div {{ $attributes->class(['space-y-4']) }}>
    @foreach ($items as $item)
        <div class="flex gap-3">
            <div class="mt-1 h-2.5 w-2.5 rounded-full" style="background: {{ $item['color'] ?? '#60a5fa' }}"></div>
            <div>
                <p class="text-sm font-medium" :class="theme === 'dark' ? 'text-slate-200' : 'text-slate-800'">{{ $item['title'] ?? '' }}</p>
                <p class="text-xs" :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'">{{ $item['meta'] ?? '' }}</p>
            </div>
        </div>
    @endforeach
</div>
