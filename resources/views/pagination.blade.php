@if ($paginator->hasPages())
    @php
        $current = $paginator->currentPage();
        $last = $paginator->lastPage();
        $window = 1;
        $start = max(1, $current - $window);
        $end = min($last, $current + $window);
        $colors = config('ui-kit.pagination.colors', []);
        $style = collect([
            '--ui-kit-pagination-text' => $colors['text'] ?? '#475569',
            '--ui-kit-pagination-muted' => $colors['muted'] ?? '#94a3b8',
            '--ui-kit-pagination-border' => $colors['border'] ?? '#e2e8f0',
            '--ui-kit-pagination-background' => $colors['background'] ?? '#ffffff',
            '--ui-kit-pagination-hover-background' => $colors['hover_background'] ?? '#f8fafc',
            '--ui-kit-pagination-hover-border' => $colors['hover_border'] ?? '#cbd5e1',
            '--ui-kit-pagination-active-background' => $colors['active_background'] ?? '#0f172a',
            '--ui-kit-pagination-active-text' => $colors['active_text'] ?? '#ffffff',
            '--ui-kit-pagination-active-border' => $colors['active_border'] ?? ($colors['active_background'] ?? '#0f172a'),
        ])->map(fn ($value, $key) => $key . ': ' . $value)->implode('; ');
    @endphp

    <nav role="navigation" aria-label="Pagination" class="w-full" style="{{ $style }}">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <p class="text-xs text-[var(--ui-kit-pagination-text)]">
                {{ $current }}/{{ $last }}
            </p>

            <div class="flex items-center gap-1">
                @if ($paginator->onFirstPage())
                    <span
                        class="inline-flex items-center gap-1 rounded-lg border px-3 py-1.5 text-xs text-[var(--ui-kit-pagination-muted)]"
                        style="border-color: var(--ui-kit-pagination-border); background: var(--ui-kit-pagination-background);"
                        aria-disabled="true"
                    >
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span class="hidden sm:inline">Prev</span>
                    </span>
                @else
                    <a
                        href="{{ $paginator->previousPageUrl() }}"
                        rel="prev"
                        class="inline-flex items-center gap-1 rounded-lg border px-3 py-1.5 text-xs text-[var(--ui-kit-pagination-text)] transition"
                        style="border-color: var(--ui-kit-pagination-border); background: var(--ui-kit-pagination-background);"
                        onmouseover="this.style.background='var(--ui-kit-pagination-hover-background)'; this.style.borderColor='var(--ui-kit-pagination-hover-border)'"
                        onmouseout="this.style.background='var(--ui-kit-pagination-background)'; this.style.borderColor='var(--ui-kit-pagination-border)'"
                    >
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span class="hidden sm:inline">Prev</span>
                    </a>
                @endif

                @if ($last <= 5)
                    @for ($page = 1; $page <= $last; $page++)
                        @if ($page == $current)
                            <span
                                class="inline-flex items-center rounded-lg border px-3 py-1.5 text-xs font-semibold"
                                style="border-color: var(--ui-kit-pagination-active-border); background: var(--ui-kit-pagination-active-background); color: var(--ui-kit-pagination-active-text);"
                                aria-current="page"
                            >
                                {{ $page }}
                            </span>
                        @else
                            <a
                                href="{{ $paginator->url($page) }}"
                                class="hidden items-center rounded-lg border px-3 py-1.5 text-xs text-[var(--ui-kit-pagination-text)] transition sm:inline-flex"
                                style="border-color: var(--ui-kit-pagination-border); background: var(--ui-kit-pagination-background);"
                                onmouseover="this.style.background='var(--ui-kit-pagination-hover-background)'; this.style.borderColor='var(--ui-kit-pagination-hover-border)'"
                                onmouseout="this.style.background='var(--ui-kit-pagination-background)'; this.style.borderColor='var(--ui-kit-pagination-border)'"
                            >
                                {{ $page }}
                            </a>
                        @endif
                    @endfor
                @else
                    @if ($start > 1)
                        <a
                            href="{{ $paginator->url(1) }}"
                            class="hidden items-center rounded-lg border px-3 py-1.5 text-xs text-[var(--ui-kit-pagination-text)] transition sm:inline-flex"
                            style="border-color: var(--ui-kit-pagination-border); background: var(--ui-kit-pagination-background);"
                            onmouseover="this.style.background='var(--ui-kit-pagination-hover-background)'; this.style.borderColor='var(--ui-kit-pagination-hover-border)'"
                            onmouseout="this.style.background='var(--ui-kit-pagination-background)'; this.style.borderColor='var(--ui-kit-pagination-border)'"
                        >
                            1
                        </a>
                        @if ($start > 2)
                            <span class="hidden px-2 text-xs text-[var(--ui-kit-pagination-muted)] sm:inline">…</span>
                        @endif
                    @endif

                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $current)
                            <span
                                class="inline-flex items-center rounded-lg border px-3 py-1.5 text-xs font-semibold"
                                style="border-color: var(--ui-kit-pagination-active-border); background: var(--ui-kit-pagination-active-background); color: var(--ui-kit-pagination-active-text);"
                                aria-current="page"
                            >
                                {{ $page }}
                            </span>
                        @else
                            <a
                                href="{{ $paginator->url($page) }}"
                                class="hidden items-center rounded-lg border px-3 py-1.5 text-xs text-[var(--ui-kit-pagination-text)] transition sm:inline-flex"
                                style="border-color: var(--ui-kit-pagination-border); background: var(--ui-kit-pagination-background);"
                                onmouseover="this.style.background='var(--ui-kit-pagination-hover-background)'; this.style.borderColor='var(--ui-kit-pagination-hover-border)'"
                                onmouseout="this.style.background='var(--ui-kit-pagination-background)'; this.style.borderColor='var(--ui-kit-pagination-border)'"
                            >
                                {{ $page }}
                            </a>
                        @endif
                    @endfor

                    @if ($end < $last)
                        @if ($end < $last - 1)
                            <span class="hidden px-2 text-xs text-[var(--ui-kit-pagination-muted)] sm:inline">…</span>
                        @endif
                        <a
                            href="{{ $paginator->url($last) }}"
                            class="hidden items-center rounded-lg border px-3 py-1.5 text-xs text-[var(--ui-kit-pagination-text)] transition sm:inline-flex"
                            style="border-color: var(--ui-kit-pagination-border); background: var(--ui-kit-pagination-background);"
                            onmouseover="this.style.background='var(--ui-kit-pagination-hover-background)'; this.style.borderColor='var(--ui-kit-pagination-hover-border)'"
                            onmouseout="this.style.background='var(--ui-kit-pagination-background)'; this.style.borderColor='var(--ui-kit-pagination-border)'"
                        >
                            {{ $last }}
                        </a>
                    @endif
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a
                        href="{{ $paginator->nextPageUrl() }}"
                        rel="next"
                        class="inline-flex items-center gap-1 rounded-lg border px-3 py-1.5 text-xs text-[var(--ui-kit-pagination-text)] transition"
                        style="border-color: var(--ui-kit-pagination-border); background: var(--ui-kit-pagination-background);"
                        onmouseover="this.style.background='var(--ui-kit-pagination-hover-background)'; this.style.borderColor='var(--ui-kit-pagination-hover-border)'"
                        onmouseout="this.style.background='var(--ui-kit-pagination-background)'; this.style.borderColor='var(--ui-kit-pagination-border)'"
                    >
                        <span class="hidden sm:inline">Next</span>
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @else
                    <span
                        class="inline-flex items-center gap-1 rounded-lg border px-3 py-1.5 text-xs text-[var(--ui-kit-pagination-muted)]"
                        style="border-color: var(--ui-kit-pagination-border); background: var(--ui-kit-pagination-background);"
                        aria-disabled="true"
                    >
                        <span class="hidden sm:inline">Next</span>
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                @endif
            </div>
        </div>
    </nav>
@endif
