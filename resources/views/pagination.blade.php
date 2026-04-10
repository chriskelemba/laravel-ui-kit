@if ($paginator->hasPages())
    @php
        $current = $paginator->currentPage();
        $last = $paginator->lastPage();
        $window = 1;
        $start = max(1, $current - $window);
        $end = min($last, $current + $window);
    @endphp

    <nav role="navigation" aria-label="Pagination" class="w-full">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <p class="text-xs" :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'">
                {{ $current }}/{{ $last }}
            </p>

            <div class="flex items-center gap-1">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span
                        class="inline-flex items-center gap-1 rounded-lg border px-3 py-1.5 text-xs"
                        :class="theme === 'dark' ? 'border-white/10 text-slate-500' : 'border-slate-200 text-slate-400'"
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
                        class="inline-flex items-center gap-1 rounded-lg border px-3 py-1.5 text-xs transition"
                        :class="theme === 'dark'
                            ? 'border-white/10 text-slate-200 hover:border-white/20 hover:bg-white/5'
                            : 'border-slate-200 text-slate-600 hover:border-slate-300 hover:bg-slate-50'"
                    >
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span class="hidden sm:inline">Prev</span>
                    </a>
                @endif

                {{-- Page Links (compact) --}}
                @if ($last <= 5)
                    @for ($page = 1; $page <= $last; $page++)
                        @if ($page == $current)
                            <span
                                class="inline-flex items-center rounded-lg px-3 py-1.5 text-xs font-semibold"
                                :class="theme === 'dark'
                                    ? 'bg-white/10 text-white'
                                    : 'bg-slate-900 text-white'"
                                aria-current="page"
                            >
                                {{ $page }}
                            </span>
                        @else
                            <a
                                href="{{ $paginator->url($page) }}"
                                class="hidden items-center rounded-lg border px-3 py-1.5 text-xs transition sm:inline-flex"
                                :class="theme === 'dark'
                                    ? 'border-white/10 text-slate-300 hover:border-white/20 hover:bg-white/5'
                                    : 'border-slate-200 text-slate-600 hover:border-slate-300 hover:bg-slate-50'"
                            >
                                {{ $page }}
                            </a>
                        @endif
                    @endfor
                @else
                    @if ($start > 1)
                        <a
                            href="{{ $paginator->url(1) }}"
                            class="hidden items-center rounded-lg border px-3 py-1.5 text-xs transition sm:inline-flex"
                            :class="theme === 'dark'
                                ? 'border-white/10 text-slate-300 hover:border-white/20 hover:bg-white/5'
                                : 'border-slate-200 text-slate-600 hover:border-slate-300 hover:bg-slate-50'"
                        >
                            1
                        </a>
                        @if ($start > 2)
                            <span class="hidden px-2 text-xs sm:inline" :class="theme === 'dark' ? 'text-slate-500' : 'text-slate-400'">…</span>
                        @endif
                    @endif

                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $current)
                            <span
                                class="inline-flex items-center rounded-lg px-3 py-1.5 text-xs font-semibold"
                                :class="theme === 'dark'
                                    ? 'bg-white/10 text-white'
                                    : 'bg-slate-900 text-white'"
                                aria-current="page"
                            >
                                {{ $page }}
                            </span>
                        @else
                            <a
                                href="{{ $paginator->url($page) }}"
                                class="hidden items-center rounded-lg border px-3 py-1.5 text-xs transition sm:inline-flex"
                                :class="theme === 'dark'
                                    ? 'border-white/10 text-slate-300 hover:border-white/20 hover:bg-white/5'
                                    : 'border-slate-200 text-slate-600 hover:border-slate-300 hover:bg-slate-50'"
                            >
                                {{ $page }}
                            </a>
                        @endif
                    @endfor

                    @if ($end < $last)
                        @if ($end < $last - 1)
                            <span class="hidden px-2 text-xs sm:inline" :class="theme === 'dark' ? 'text-slate-500' : 'text-slate-400'">…</span>
                        @endif
                        <a
                            href="{{ $paginator->url($last) }}"
                            class="hidden items-center rounded-lg border px-3 py-1.5 text-xs transition sm:inline-flex"
                            :class="theme === 'dark'
                                ? 'border-white/10 text-slate-300 hover:border-white/20 hover:bg-white/5'
                                : 'border-slate-200 text-slate-600 hover:border-slate-300 hover:bg-slate-50'"
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
                        class="inline-flex items-center gap-1 rounded-lg border px-3 py-1.5 text-xs transition"
                        :class="theme === 'dark'
                            ? 'border-white/10 text-slate-200 hover:border-white/20 hover:bg-white/5'
                            : 'border-slate-200 text-slate-600 hover:border-slate-300 hover:bg-slate-50'"
                    >
                        <span class="hidden sm:inline">Next</span>
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @else
                    <span
                        class="inline-flex items-center gap-1 rounded-lg border px-3 py-1.5 text-xs"
                        :class="theme === 'dark' ? 'border-white/10 text-slate-500' : 'border-slate-200 text-slate-400'"
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
