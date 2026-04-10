@props([
    'items' => [],
])

<nav {{ $attributes->class(['flex items-center gap-2 text-xs']) }}>
    @foreach ($items as $index => $item)
        <a
            href="{{ $item['href'] ?? '#' }}"
            class="transition"
            :class="theme === 'dark' ? 'text-slate-400 hover:text-slate-200' : 'text-slate-500 hover:text-slate-700'"
        >
            {{ $item['label'] ?? '' }}
        </a>
        @if ($index < count($items) - 1)
            <span :class="theme === 'dark' ? 'text-slate-600' : 'text-slate-400'">/</span>
        @endif
    @endforeach
</nav>
