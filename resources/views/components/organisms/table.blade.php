@props([
    'headers' => [],
    'rows' => [],
    'empty' => 'No records found.',
    'rowView' => null,
    'responsive' => true,
    'minWidth' => '64rem',
    'selectable' => false,
    'sortable' => false,
    'actions' => false,
])

@php
    $resolveIcon = function ($icon, ?string $label = null): ?string {
        if ($icon instanceof \Illuminate\Contracts\Support\Htmlable) {
            return $icon->toHtml();
        }

        return \ChrisKelemba\LaravelUiKit\Support\IconResolver::resolve(
            is_string($icon) ? $icon : null,
            $label,
        );
    };
    $hasSlot = trim($slot) !== '';
    $tableStyle = filled($minWidth)
        ? 'min-width: min(100%, ' . $minWidth . ');'
        : null;
    $normalizedHeaders = collect($headers)->map(function ($header) {
        if (is_array($header)) {
            return [
                'label' => $header['label'] ?? $header['title'] ?? '',
                'align' => $header['align'] ?? 'left',
                'width' => $header['width'] ?? null,
                'class' => $header['class'] ?? null,
                'sortable' => (bool) ($header['sortable'] ?? false),
            ];
        }

        return [
            'label' => $header,
            'align' => 'left',
            'width' => null,
            'class' => null,
            'sortable' => false,
        ];
    });
    $headerCount = max(1, $normalizedHeaders->count());
    $headerAlignments = $normalizedHeaders->pluck('align')->values()->all();
    $usesStructuredRows = ! $hasSlot
        && ! $rowView
        && collect($rows)->every(fn ($row) => is_array($row));

    $renderCell = function ($cell) {
        if ($cell instanceof \Illuminate\Contracts\Support\Htmlable) {
            return $cell->toHtml();
        }

        return e($cell);
    };

    $renderInlineValue = function ($value) {
        if ($value instanceof \Illuminate\Contracts\Support\Htmlable) {
            return $value->toHtml();
        }

        return (string) $value;
    };

    $normalizedRows = $usesStructuredRows
        ? collect($rows)->map(function ($row) use ($renderCell, $renderInlineValue, $resolveIcon) {
            $cells = is_array($row) && array_key_exists('cells', $row) ? ($row['cells'] ?? []) : $row;
            $actions = is_array($row) ? ($row['actions'] ?? []) : [];

            return [
                'id' => $row['id'] ?? null,
                'cells' => collect($cells)->map(function ($cell) use ($renderCell) {
                    $cellData = is_array($cell) && array_key_exists('value', $cell)
                        ? $cell
                        : ['value' => $cell];

                    $value = $cellData['value'] ?? null;

                    return [
                        'html' => $renderCell($value),
                        'sort' => (string) ($cellData['sort'] ?? strip_tags($renderCell($value))),
                        'align' => $cellData['align'] ?? null,
                        'class' => $cellData['class'] ?? null,
                    ];
                })->values()->all(),
                'actions' => collect($actions)->map(function ($action) use ($renderInlineValue, $resolveIcon) {
                    $label = $action['label'] ?? null;
                    $resolvedIcon = $resolveIcon($action['icon'] ?? null, $label);

                    return [
                        'as' => $action['as'] ?? (isset($action['href']) ? 'a' : 'button'),
                        'href' => $action['href'] ?? null,
                        'type' => $action['type'] ?? 'button',
                        'variant' => $action['variant'] ?? 'ghost',
                        'label' => $label,
                        'slot' => $renderInlineValue($action['slot'] ?? ''),
                        'icon' => $resolvedIcon,
                        'tooltip' => $action['tooltip'] ?? ($resolvedIcon ? ($label ?? null) : null),
                        'iconOnly' => (bool) ($action['icon_only'] ?? false),
                    ];
                })->values()->all(),
            ];
        })->values()
        : collect();
    $resolvedActions = (bool) $actions;
    $resolvedSortable = (bool) $sortable;
    $resolvedSelectable = (bool) $selectable;
    $columnCount = $headerCount
        + ($resolvedSelectable ? 1 : 0)
        + ($resolvedActions ? 1 : 0);
@endphp

<div
    {{ $attributes->class(['overflow-visible rounded-3xl border']) }}
    :class="theme === 'dark' ? 'border-white/10 bg-slate-900/70' : 'border-slate-200 bg-white shadow-sm'"
>
    <div
        @class(['overflow-x-auto overscroll-x-contain' => $responsive])
        @if ($usesStructuredRows)
            x-data="{
                rows: @js($normalizedRows->all()),
                headerAlignments: @js($headerAlignments),
                selectable: @js($resolvedSelectable),
                actionsEnabled: @js($resolvedActions),
                sortIndex: null,
                sortDirection: 'asc',
                selectedRows: [],
                get visibleIds() {
                    return this.rows
                        .map((row, index) => row.id ?? `row-${index}`)
                        .filter((value) => value !== null);
                },
                isSelected(value) {
                    return this.selectedRows.includes(value);
                },
                toggleRow(value) {
                    if (this.isSelected(value)) {
                        this.selectedRows = this.selectedRows.filter((item) => item !== value);
                        return;
                    }

                    this.selectedRows = [...this.selectedRows, value];
                },
                toggleAll() {
                    if (this.selectedRows.length === this.visibleIds.length) {
                        this.selectedRows = [];
                        return;
                    }

                    this.selectedRows = [...this.visibleIds];
                },
                sortBy(index) {
                    this.sortDirection = this.sortIndex === index && this.sortDirection === 'asc' ? 'desc' : 'asc';
                    this.sortIndex = index;
                    this.rows = [...this.rows].sort((a, b) => {
                        const left = (a.cells[index]?.sort ?? '').toString().toLowerCase();
                        const right = (b.cells[index]?.sort ?? '').toString().toLowerCase();
                        const compare = left.localeCompare(right, undefined, { numeric: true, sensitivity: 'base' });

                        return this.sortDirection === 'asc' ? compare : -compare;
                    });
                }
            }"
        @endif
    >
        <table class="w-full text-left text-sm" @if ($tableStyle) style="{{ $tableStyle }}" @endif>
            <thead
                class="text-xs tracking-wide"
                :class="theme === 'dark' ? 'bg-slate-900/90 text-slate-400' : 'bg-slate-50/80 text-slate-500'"
            >
                <tr>
                    @if ($resolvedSelectable)
                        <th class="w-14 px-4 py-3 font-semibold text-center">
                            <div class="flex justify-center">
                                <input
                                    type="checkbox"
                                    class="h-4 w-4 appearance-none rounded-[0.35rem] border-2 border-slate-400 bg-white bg-center bg-no-repeat shadow-none outline-none ring-0 transition checked:border-[color:var(--aui-primary)] checked:bg-[color:var(--aui-primary)] focus:outline-none focus:ring-0 focus:ring-offset-0"
                                    style="background-size: 0.7rem; background-image: none;"
                                    :checked="visibleIds.length > 0 && selectedRows.length === visibleIds.length"
                                    :style="visibleIds.length > 0 && selectedRows.length === visibleIds.length ? `background-size: 0.7rem; background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='none'%3E%3Cpath d='M3.5 8.5 6.5 11.5 12.5 4.5' stroke='white' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E&quot;);` : 'background-size: 0.7rem; background-image: none;'"
                                    @click="toggleAll()"
                                >
                            </div>
                        </th>
                    @endif

                    @foreach ($normalizedHeaders as $header)
                        <th
                            class="whitespace-nowrap px-4 py-3 font-semibold {{ $header['class'] }}"
                            @if ($header['width']) style="width: {{ $header['width'] }}" @endif
                            @if (($header['align'] ?? 'left') === 'right') align="right" @endif
                        >
                            <div class="@class([
                                'flex items-center gap-2',
                                'justify-end text-right' => ($header['align'] ?? 'left') === 'right',
                                'justify-center text-center' => ($header['align'] ?? 'left') === 'center',
                            ])">
                                @if ($resolvedSortable && $header['sortable'] && $usesStructuredRows)
                                    <button
                                        type="button"
                                        class="inline-flex items-center gap-2 transition hover:text-slate-900"
                                        @click="sortBy({{ $loop->index }})"
                                    >
                                        <span>{{ $header['label'] }}</span>
                                        <span class="inline-flex flex-col leading-none">
                                            <span
                                                class="text-[9px]"
                                                :class="sortIndex === {{ $loop->index }} && sortDirection === 'asc'
                                                    ? 'text-[color:var(--aui-accent,#2563eb)]'
                                                    : 'opacity-50'"
                                            >▲</span>
                                            <span
                                                class="text-[9px] -mt-0.5"
                                                :class="sortIndex === {{ $loop->index }} && sortDirection === 'desc'
                                                    ? 'text-[color:var(--aui-accent,#2563eb)]'
                                                    : 'opacity-50'"
                                            >▼</span>
                                        </span>
                                    </button>
                                @else
                                    {{ $header['label'] }}
                                @endif
                            </div>
                        </th>
                    @endforeach

                    @if ($resolvedActions)
                        <th class="whitespace-nowrap px-4 py-3 font-semibold text-center">
                            <div class="flex items-center justify-center gap-2">Actions</div>
                        </th>
                    @endif
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
                                colspan="{{ $columnCount }}"
                                class="px-4 py-6 text-center"
                                :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'"
                            >
                                {{ $empty }}
                            </td>
                        </tr>
                    @endforelse
                @elseif ($usesStructuredRows)
                    <template x-if="rows.length === 0">
                        <tr>
                            <td
                                colspan="{{ $columnCount }}"
                                class="px-4 py-6 text-center"
                                :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'"
                            >
                                {{ $empty }}
                            </td>
                        </tr>
                    </template>

                    <template x-for="(row, rowIndex) in rows" :key="rowIndex">
                        <tr :class="theme === 'dark' ? 'hover:bg-white/5' : 'hover:bg-slate-50/80'">
                            <template x-if="selectable">
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center">
                                        <input
                                            type="checkbox"
                                            class="h-4 w-4 appearance-none rounded-[0.35rem] border-2 border-slate-400 bg-white bg-center bg-no-repeat shadow-none outline-none ring-0 transition checked:border-[color:var(--aui-primary)] checked:bg-[color:var(--aui-primary)] focus:outline-none focus:ring-0 focus:ring-offset-0"
                                            style="background-size: 0.7rem; background-image: none;"
                                            :checked="isSelected(row.id ?? `row-${rowIndex}`)"
                                            :style="isSelected(row.id ?? `row-${rowIndex}`) ? `background-size: 0.7rem; background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='none'%3E%3Cpath d='M3.5 8.5 6.5 11.5 12.5 4.5' stroke='white' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E&quot;);` : 'background-size: 0.7rem; background-image: none;'"
                                            @click="toggleRow(row.id ?? `row-${rowIndex}`)"
                                        >
                                    </div>
                                </td>
                            </template>

                            <template x-for="(cell, cellIndex) in row.cells" :key="`${rowIndex}-${cellIndex}`">
                                <td
                                    class="whitespace-nowrap px-4 py-3"
                                    :class="[theme === 'dark' ? 'text-slate-200' : 'text-slate-700', cell.class ?? '']"
                                >
                                    <div
                                        class="flex items-center gap-2"
                                        :class="{
                                            'justify-end text-right': (cell.align ?? headerAlignments[cellIndex] ?? 'left') === 'right',
                                            'justify-center text-center': (cell.align ?? headerAlignments[cellIndex] ?? 'left') === 'center',
                                        }"
                                        x-html="cell.html"
                                    ></div>
                                </td>
                            </template>

                            <template x-if="actionsEnabled">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2 whitespace-nowrap">
                                        <template x-for="(action, actionIndex) in row.actions" :key="`${rowIndex}-action-${actionIndex}`">
                                            <span
                                                x-data="{
                                                    open: false,
                                                    tooltipStyle: '',
                                                    positionTooltip() {
                                                        if (!action.tooltip) return;
                                                        const rect = this.$refs.trigger.getBoundingClientRect();
                                                        const tooltip = this.$refs.tooltip;

                                                        if (!tooltip) return;

                                                        const tooltipRect = tooltip.getBoundingClientRect();
                                                        const tooltipHeight = tooltipRect.height || 32;
                                                        const tooltipWidth = tooltipRect.width || 96;
                                                        const spaceBelow = window.innerHeight - rect.bottom;
                                                        const showAbove = spaceBelow < tooltipHeight + 12;
                                                        const top = showAbove ? rect.top - 8 - tooltipHeight : rect.bottom + 8;
                                                        const idealLeft = rect.left + (rect.width / 2) - (tooltipWidth / 2);
                                                        const minLeft = 8;
                                                        const maxLeft = window.innerWidth - tooltipWidth - 8;
                                                        const left = Math.min(Math.max(idealLeft, minLeft), Math.max(minLeft, maxLeft));

                                                        this.tooltipStyle = `position: fixed; left: ${left}px; top: ${Math.max(8, top)}px;`;
                                                    },
                                                    showTooltip() {
                                                        if (!action.tooltip) return;
                                                        this.open = true;
                                                        this.$nextTick(() => this.positionTooltip());
                                                    },
                                                    hideTooltip() {
                                                        this.open = false;
                                                    }
                                                }"
                                                class="relative inline-flex"
                                            >
                                                <a
                                                    x-show="action.as === 'a'"
                                                    :href="action.href"
                                                    x-ref="trigger"
                                                    :aria-label="action.tooltip || action.label"
                                                    class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-medium transition"
                                                    :class="[
                                                        theme === 'dark'
                                                            ? (action.variant === 'primary'
                                                                ? 'aui-primary-bg shadow-sm'
                                                                : 'border border-white/10 bg-white/5 text-slate-300 hover:border-white/20 hover:bg-white/10 hover:text-white')
                                                            : (action.variant === 'primary'
                                                                ? 'aui-primary-bg shadow-sm'
                                                                : 'border border-slate-200 bg-white text-slate-700 shadow-sm hover:border-slate-300 hover:bg-slate-50'),
                                                        action.iconOnly ? 'justify-center rounded-full p-2.5' : ''
                                                    ]"
                                                    @mouseenter="showTooltip()"
                                                    @mouseleave="hideTooltip()"
                                                    @focus="showTooltip()"
                                                    @blur="hideTooltip()"
                                                >
                                                    <span x-show="action.icon" class="inline-flex h-4 w-4 items-center justify-center" x-html="action.icon"></span>
                                                    <span x-show="action.label && !action.iconOnly" x-text="action.label"></span>
                                                    <span x-show="action.slot && !action.iconOnly" x-text="action.slot"></span>
                                                </a>

                                                <template x-teleport="body">
                                                    <span
                                                        x-show="open && action.tooltip"
                                                        x-transition
                                                        x-cloak
                                                        x-ref="tooltip"
                                                        class="z-[999] whitespace-nowrap rounded-md px-2 py-1 text-xs pointer-events-none"
                                                        :class="theme === 'dark' ? 'bg-slate-800 text-slate-100' : 'bg-slate-900 text-white'"
                                                        :style="tooltipStyle"
                                                        x-text="action.tooltip"
                                                    ></span>
                                                </template>
                                            </span>
                                        </template>
                                    </div>
                                </td>
                            </template>
                        </tr>
                    </template>
                @else
                    @forelse ($rows as $row)
                        <tr :class="theme === 'dark' ? 'hover:bg-white/5' : 'hover:bg-slate-50/80'">
                            @php
                                $cells = is_array($row) && array_key_exists('cells', $row) ? ($row['cells'] ?? []) : $row;
                                $rowActions = is_array($row) ? ($row['actions'] ?? []) : [];
                            @endphp

                            @if ($resolvedSelectable)
                                <td class="px-4 py-3 text-center">
                                    <input
                                        type="checkbox"
                                        class="h-4 w-4 appearance-none rounded-[0.35rem] border-2 border-slate-400 bg-white bg-center bg-no-repeat shadow-none outline-none ring-0 transition checked:border-[color:var(--aui-primary)] checked:bg-[color:var(--aui-primary)] focus:outline-none focus:ring-0 focus:ring-offset-0"
                                        style="background-size: 0.7rem; background-image: none;"
                                    >
                                </td>
                            @endif

                            @foreach ($cells as $index => $cell)
                                @php
                                    $cellData = is_array($cell) && array_key_exists('value', $cell)
                                        ? $cell
                                        : ['value' => $cell];
                                    $align = $cellData['align'] ?? ($normalizedHeaders[$index]['align'] ?? 'left');
                                    $cellClass = $cellData['class'] ?? null;
                                @endphp

                                <td
                                    class="whitespace-nowrap px-4 py-3 {{ $cellClass }}"
                                    :class="theme === 'dark' ? 'text-slate-200' : 'text-slate-700'"
                                >
                                    <div class="@class([
                                        'flex items-center gap-2',
                                        'justify-end text-right' => $align === 'right',
                                        'justify-center text-center' => $align === 'center',
                                    ])">
                                        {!! $renderCell($cellData['value'] ?? null) !!}
                                    </div>
                                </td>
                            @endforeach

                            @if ($resolvedActions && $rowActions !== [])
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2 whitespace-nowrap">
                                        @foreach ($rowActions as $action)
                                            @php
                                                $actionLabel = $action['label'] ?? null;
                                                $actionIcon = $resolveIcon($action['icon'] ?? null, $actionLabel);
                                            @endphp
                                            <x-ui-kit::atoms.action-button
                                                :as="$action['as'] ?? (isset($action['href']) ? 'a' : 'button')"
                                                :href="$action['href'] ?? null"
                                                :type="$action['type'] ?? 'button'"
                                                :variant="$action['variant'] ?? 'ghost'"
                                                :label="$actionLabel"
                                                :icon="$actionIcon"
                                                :tooltip="$action['tooltip'] ?? ($actionIcon ? ($actionLabel ?? null) : null)"
                                                :icon-only="(bool) ($action['icon_only'] ?? false)"
                                            >
                                                {{ $action['slot'] ?? '' }}
                                            </x-ui-kit::atoms.action-button>
                                        @endforeach
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="{{ $columnCount }}"
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
</div>
