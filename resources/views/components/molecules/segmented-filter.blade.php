@props([
    'items' => [],
    'title' => null,
    'description' => null,
    'resetUrl' => null,
])

<div {{ $attributes->class(['space-y-4']) }}>
    @if ($title || $description)
        <div class="flex flex-wrap items-start justify-between gap-3">
            <div>
                @if ($title)
                    <p class="text-sm font-semibold text-slate-900" :class="theme === 'dark' ? 'text-slate-100' : 'text-slate-900'">{{ $title }}</p>
                @endif
                @if ($description)
                    <p class="mt-1 text-sm text-slate-600" :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-600'">{{ $description }}</p>
                @endif
            </div>

            @if ($resetUrl)
                <a
                    href="{{ $resetUrl }}"
                    class="inline-flex items-center rounded-full px-3 py-1.5 text-sm font-medium transition"
                    :class="theme === 'dark' ? 'text-slate-300 hover:bg-white/5' : 'text-slate-500 hover:bg-slate-100'"
                >
                    Reset
                </a>
            @endif
        </div>
    @endif

    <div
        class="inline-flex flex-wrap items-center gap-2 rounded-[28px] border p-2 shadow-sm"
        :class="theme === 'dark' ? 'border-white/10 bg-slate-950/60' : 'border-slate-200 bg-slate-100/90'"
    >
        @foreach ($items as $item)
            @php
                $active = (bool) ($item['active'] ?? false);
                $href = $item['href'] ?? '#';
            @endphp

            <a
                href="{{ $href }}"
                class="inline-flex items-center gap-2 rounded-full border px-6 py-3 text-sm font-semibold transition"
                :class="{{ $active ? 'true' : 'false' }}
                    ? 'border-[color:var(--aui-accent,#2563eb)] bg-white text-[color:var(--aui-accent,#2563eb)] shadow-sm'
                    : (theme === 'dark'
                        ? 'border-transparent bg-transparent text-slate-300 hover:bg-white/5'
                        : 'border-transparent bg-transparent text-slate-800 hover:bg-white')"
            >
                <span>{{ $item['label'] ?? '' }}</span>
                @if (isset($item['count']))
                    <span
                        class="inline-flex h-6 min-w-6 items-center justify-center rounded-full px-2 text-xs font-bold"
                        :class="{{ $active ? 'true' : 'false' }}
                            ? 'bg-[color:var(--aui-accent-soft,#dbeafe)] text-[color:var(--aui-accent,#2563eb)]'
                            : (theme === 'dark' ? 'bg-white/10 text-slate-300' : 'bg-slate-200 text-slate-600')"
                    >
                        {{ $item['count'] }}
                    </span>
                @endif
            </a>
        @endforeach
    </div>

    @if (trim((string) $slot) !== '')
        <div>{{ $slot }}</div>
    @endif
</div>
