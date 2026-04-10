@props([
    'headers' => [],
    'rows' => [],
    'empty' => 'No records found.',
    'rowView' => null,
])

@php
    $hasSlot = trim($slot) !== '';
@endphp

<div
    {{ $attributes->class(['overflow-hidden rounded-3xl border']) }}
    :class="theme === 'dark' ? 'border-white/10 bg-slate-900/70' : 'border-slate-200 bg-white shadow-sm'"
>
    <table class="w-full text-left text-sm">
        <thead
            class="text-xs tracking-wide"
            :class="theme === 'dark' ? 'bg-slate-900/90 text-slate-400' : 'bg-slate-50/80 text-slate-500'"
        >
            <tr>
                @foreach ($headers as $header)
                    <th class="px-4 py-3 font-semibold">{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody :class="theme === 'dark' ? 'divide-y divide-white/10' : 'divide-y divide-slate-200'">
            @if ($hasSlot)
                {{ $slot }}
            @elseif ($rowView)
                @forelse ($rows as $item)
                    @include($rowView, ['item' => $item])
                @empty
                    <tr>
                        <td
                            colspan="{{ max(1, count($headers)) }}"
                            class="px-4 py-6 text-center"
                            :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'"
                        >
                            {{ $empty }}
                        </td>
                    </tr>
                @endforelse
            @else
                @forelse ($rows as $row)
                    <tr :class="theme === 'dark' ? 'hover:bg-white/5' : 'hover:bg-slate-50/80'">
                        @foreach ($row as $cell)
                            <td class="px-4 py-3" :class="theme === 'dark' ? 'text-slate-200' : 'text-slate-700'">
                                @if ($cell instanceof \Illuminate\Contracts\Support\Htmlable)
                                    {!! $cell->toHtml() !!}
                                @else
                                    {{ $cell }}
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td
                            colspan="{{ max(1, count($headers)) }}"
                            class="px-4 py-6 text-center"
                            :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'"
                        >
                            {{ $empty }}
                        </td>
                    </tr>
                @endforelse
            @endif
        </tbody>
    </table>
</div>
