@props([
    'title' => null,
    'month' => null,
    'year' => null,
    'events' => [],
])

@php
    $today = now();
    $month = $month ?? $today->month;
    $year = $year ?? $today->year;
    $first = \Illuminate\Support\Carbon::create($year, $month, 1)->startOfMonth();
    $startDay = $first->dayOfWeekIso; // 1=Mon
    $daysInMonth = $first->daysInMonth;
    $cells = [];
    for ($i = 1; $i < $startDay; $i++) {
        $cells[] = null;
    }
    for ($day = 1; $day <= $daysInMonth; $day++) {
        $cells[] = $day;
    }
    while (count($cells) % 7 !== 0) {
        $cells[] = null;
    }
    $eventDays = collect($events)->mapWithKeys(fn ($event) => [($event['day'] ?? 0) => $event])->all();
@endphp

<div {{ $attributes->class(['rounded-2xl border p-4']) }} :class="theme === 'dark' ? 'border-white/10 bg-slate-900/70' : 'border-slate-200 bg-white'">
    <div class="flex items-center justify-between">
        <div>
            @if ($title)
                <p class="text-sm font-semibold" :class="theme === 'dark' ? 'text-slate-100' : 'text-slate-900'">{{ $title }}</p>
            @endif
            <p class="text-xs" :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'">
                {{ $first->format('F Y') }}
            </p>
        </div>
        <div class="text-xs" :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'">Mon - Sun</div>
    </div>

    <div class="mt-4 grid grid-cols-7 gap-2 text-xs">
        @foreach (['M','T','W','T','F','S','S'] as $label)
            <div class="text-center font-semibold" :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'">{{ $label }}</div>
        @endforeach

        @foreach ($cells as $day)
            @php
                $event = $day ? ($eventDays[$day] ?? null) : null;
                $isToday = $day && $day === $today->day && $month === $today->month && $year === $today->year;
            @endphp
            <div
                class="h-10 rounded-lg p-2 text-right"
                :class="theme === 'dark'
                    ? '{{ $day ? 'bg-white/5 text-slate-200' : 'text-slate-600' }}'
                    : '{{ $day ? 'bg-slate-50 text-slate-700' : 'text-slate-400' }}'"
            >
                @if ($day)
                    <div class="flex items-center justify-between">
                        <span class="text-[10px]" :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'">
                            {{ $day }}
                        </span>
                        @if ($isToday)
                            <span class="h-2 w-2 rounded-full" style="background-color: var(--aui-primary);"></span>
                        @endif
                    </div>
                    @if ($event)
                        <div class="mt-1 truncate text-[10px]" style="color: {{ $event['color'] ?? 'var(--aui-primary)' }}">
                            {{ $event['label'] ?? '' }}
                        </div>
                    @endif
                @endif
            </div>
        @endforeach
    </div>
</div>
