@props([
    'title' => null,
    'subtitle' => null,
    'showSidebar' => true,
    'sidebarOpen' => true,
    'sidebarMode' => 'toggle', // toggle | static
    'sidebarCollapsible' => true,
    'sidebarCollapsed' => false,
    'sidebarCollapseMode' => 'compact', // compact | hidden
    'sidebarWidth' => '15rem',
    'activePrimarySection' => null,
    'rightSidebarCollapsible' => true,
    'rightSidebarCollapsed' => false,
    'rightSidebarCollapseMode' => 'compact', // compact | hidden
    'rightSidebarVisible' => true,
    'rightSidebarWidth' => '24rem',
    'activeRightPrimarySection' => null,
    'showSidebarToggle' => true,
    'showSidebarToggleDesktop' => false,
])

@php
    $hasRightSidebar = isset($rightSidebar);
    $hasRightPrimaryRail = isset($rightPrimaryRail);
    $rightRailWidth = '5rem';
    $rightExpandedWidth = $hasRightSidebar && $hasRightPrimaryRail ? null : ($hasRightSidebar ? null : 'w-[5rem]');
    $rightCompactWidth = $hasRightSidebar && $hasRightPrimaryRail ? null : ($hasRightSidebar ? 'w-0' : 'w-[5rem]');
    $rightHiddenWidth = $hasRightPrimaryRail ? null : 'w-0';
    $rightExpandedWidthStyle = $hasRightSidebar && $hasRightPrimaryRail ? 'calc(' . $rightSidebarWidth . ' + ' . $rightRailWidth . ')' : null;
    $rightCompactWidthStyle = $hasRightSidebar && $hasRightPrimaryRail ? $rightRailWidth : ($hasRightSidebar ? '0px' : null);
    $rightHiddenWidthStyle = $hasRightPrimaryRail ? $rightRailWidth : '0px';
@endphp

<div
    x-cloak
    x-ref="shell"
    x-data="{
        sidebarStatic: @js($sidebarMode === 'static'),
        sidebarOpen: @js($sidebarMode === 'static' ? true : $sidebarOpen),
        sidebarCollapsible: @js($sidebarCollapsible),
        sidebarCollapseMode: @js($sidebarCollapseMode),
        sidebarCollapsed: false,
        sidebarHoverExpanded: false,
        activePrimarySection: @js($activePrimarySection),
        hoverPrimarySection: null,
        sidebarPointerX: null,
        sidebarPointerY: null,
        rightSidebarCollapsible: @js($rightSidebarCollapsible),
        rightSidebarCollapseMode: @js($rightSidebarCollapseMode),
        rightSidebarCollapsed: false,
        rightSidebarVisible: @js($rightSidebarVisible),
        rightSidebarHoverExpanded: false,
        activeRightPrimarySection: @js($activeRightPrimarySection),
        hoverRightPrimarySection: null,
        rightSidebarPointerX: null,
        rightSidebarPointerY: null,
        theme: 'light',
    }"
    x-init="
        const storedSidebarOpen = localStorage.getItem('aui-sidebar-open');
        if (!sidebarStatic && storedSidebarOpen !== null) {
            sidebarOpen = JSON.parse(storedSidebarOpen);
        }

        const storedRightSidebarVisible = localStorage.getItem('aui-right-sidebar-visible');
        if (storedRightSidebarVisible !== null) {
            rightSidebarVisible = JSON.parse(storedRightSidebarVisible);
        }

        sidebarCollapsed = sidebarCollapsible
            ? JSON.parse(localStorage.getItem('aui-sidebar-collapsed') ?? @js($sidebarCollapsed ? 'true' : 'false'))
            : false;

        rightSidebarCollapsed = rightSidebarCollapsible
            ? JSON.parse(localStorage.getItem('aui-right-sidebar-collapsed') ?? @js($rightSidebarCollapsed ? 'true' : 'false'))
            : false;

        $watch('sidebarCollapsed', value => {
            if (sidebarCollapsible) {
                localStorage.setItem('aui-sidebar-collapsed', JSON.stringify(value));
            }
            if (sidebarCollapseMode === 'hidden' && value) {
                sidebarHoverExpanded = false;
                if (!sidebarStatic) {
                    sidebarOpen = false;
                }
            }
        });

        $watch('sidebarOpen', value => {
            if (!sidebarStatic) {
                localStorage.setItem('aui-sidebar-open', JSON.stringify(value));
            }
        });

        $watch('rightSidebarCollapsed', value => {
            if (rightSidebarCollapsible) {
                localStorage.setItem('aui-right-sidebar-collapsed', JSON.stringify(value));
            }
            if (rightSidebarCollapseMode === 'hidden' && value) {
                rightSidebarHoverExpanded = false;
            }
        });

        $watch('rightSidebarVisible', value => {
            localStorage.setItem('aui-right-sidebar-visible', JSON.stringify(value));
            if (value && rightSidebarCollapsible && rightSidebarCollapseMode === 'hidden') {
                rightSidebarCollapsed = false;
            }
        });

        sidebarHoverExpanded = sessionStorage.getItem('aui-sidebar-hover-expanded') === 'true';
        rightSidebarHoverExpanded = sessionStorage.getItem('aui-right-sidebar-hover-expanded') === 'true';

        $watch('sidebarHoverExpanded', value => {
            sessionStorage.setItem('aui-sidebar-hover-expanded', value ? 'true' : 'false');
        });

        $watch('rightSidebarHoverExpanded', value => {
            sessionStorage.setItem('aui-right-sidebar-hover-expanded', value ? 'true' : 'false');
        });

        window.addEventListener('mousemove', event => {
            sidebarPointerX = event.clientX;
            sidebarPointerY = event.clientY;
            rightSidebarPointerX = event.clientX;
            rightSidebarPointerY = event.clientY;

            const hoverRegion = $refs.sidebarRegion || $refs.sidebar;
            const rightHoverRegion = $refs.rightSidebarRegion || $refs.rightSidebar;

            if (!sidebarHoverExpanded || !hoverRegion) {
            } else {
                const rect = hoverRegion.getBoundingClientRect();
                const insideX = event.clientX >= rect.left && event.clientX <= rect.right;
                const insideY = event.clientY >= rect.top && event.clientY <= rect.bottom;

                if (!(insideX && insideY)) {
                    sidebarHoverExpanded = false;
                }
            }

            if (!rightSidebarHoverExpanded || !rightHoverRegion) {
            } else {
                const rect = rightHoverRegion.getBoundingClientRect();
                const insideX = event.clientX >= rect.left && event.clientX <= rect.right;
                const insideY = event.clientY >= rect.top && event.clientY <= rect.bottom;

                if (!(insideX && insideY)) {
                    rightSidebarHoverExpanded = false;
                }
            }
        });

        $nextTick(() => {
            const hoverRegion = $refs.sidebarRegion || $refs.sidebar;
            const rightHoverRegion = $refs.rightSidebarRegion || $refs.rightSidebar;

            if (sidebarHoverExpanded && hoverRegion && sidebarPointerX !== null && sidebarPointerY !== null) {
                const rect = hoverRegion.getBoundingClientRect();
                const insideX = sidebarPointerX >= rect.left && sidebarPointerX <= rect.right;
                const insideY = sidebarPointerY >= rect.top && sidebarPointerY <= rect.bottom;

                if (!(insideX && insideY)) {
                    sidebarHoverExpanded = false;
                }
            }

            if (rightSidebarHoverExpanded && rightHoverRegion && rightSidebarPointerX !== null && rightSidebarPointerY !== null) {
                const rect = rightHoverRegion.getBoundingClientRect();
                const insideX = rightSidebarPointerX >= rect.left && rightSidebarPointerX <= rect.right;
                const insideY = rightSidebarPointerY >= rect.top && rightSidebarPointerY <= rect.bottom;

                if (!(insideX && insideY)) {
                    rightSidebarHoverExpanded = false;
                }
            }
        });
    "
    {{ $attributes->class(['min-h-screen']) }}
    :class="theme === 'dark'
        ? 'bg-slate-950 text-slate-100'
        : 'bg-[#f6f8fc] text-slate-900'"
>
    @if ($showSidebar)
        <div class="flex min-h-screen flex-col">
            <header
                :class="theme === 'dark'
                    ? 'sticky top-0 z-30 border-b border-white/5 bg-slate-900/80 backdrop-blur-xl'
                    : 'sticky top-0 z-30 border-b border-slate-200/80 bg-[#f6f8fc]/95 backdrop-blur-xl'"
            >
                @isset($header)
                    {{ $header }}
                @else
                    <div class="flex min-h-[var(--aui-header-height)] w-full items-center justify-between gap-4 px-6 py-4 lg:px-8">
                        <div class="flex items-center gap-4">
                            @if ($showSidebarToggle)
                                @php
                                    $toggleBase = 'group inline-flex h-10 w-10 items-center justify-center rounded-full border transition';
                                    $toggleDark = 'border-white/10 bg-white/5 text-slate-300 hover:border-white/20 hover:bg-white/10 hover:text-white';
                                    $toggleLight = 'border-slate-200 bg-white text-slate-600 shadow-sm hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900';
                                @endphp
                                <button
                                    type="button"
                                    @click="sidebarOpen = !sidebarOpen"
                                    x-show="!sidebarStatic"
                                    class="lg:hidden"
                                    :class="theme === 'dark'
                                        ? '{{ $toggleBase . ' ' . $toggleDark }}'
                                        : '{{ $toggleBase . ' ' . $toggleLight }}'"
                                >
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16"/>
                                    </svg>
                                </button>
                            @endif
                            @if ($showSidebarToggleDesktop || $showSidebarToggle)
                                <button
                                    type="button"
                                    @click="
                                        const nextCollapsed = !sidebarCollapsed;
                                        if (sidebarCollapsible) sidebarCollapsed = nextCollapsed;
                                        if (!sidebarStatic) sidebarOpen = !nextCollapsed;
                                    "
                                    x-show="sidebarCollapsible"
                                    class="hidden lg:inline-flex lg:h-10 lg:w-10 lg:items-center lg:justify-center lg:rounded-full lg:border lg:transition"
                                    :class="theme === 'dark'
                                        ? 'lg:border-white/10 lg:bg-white/5 lg:text-slate-300 lg:hover:bg-white/10'
                                        : 'lg:border-slate-200 lg:bg-white lg:text-slate-600 lg:shadow-sm lg:hover:bg-slate-50'"
                                    :aria-label="sidebarCollapsed ? 'Expand sidebar' : 'Collapse sidebar'"
                                >
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16"/>
                                    </svg>
                                </button>
                            @endif
                            @isset($brand)
                                <div class="flex items-center gap-3">
                                    {{ $brand }}
                                </div>
                            @else
                                <div>
                                    @if ($title)
                                        <h1 :class="theme === 'dark' ? 'text-xl font-semibold tracking-tight text-white' : 'text-xl font-semibold tracking-tight text-slate-900'">
                                            {{ $title }}
                                        </h1>
                                    @endif
                                    @if ($subtitle)
                                        <p :class="theme === 'dark' ? 'mt-0.5 text-sm text-slate-400' : 'mt-0.5 text-sm text-slate-500'">
                                            {{ $subtitle }}
                                        </p>
                                    @endif
                                </div>
                            @endisset
                        </div>
                        <div class="flex items-center gap-2">
                            @isset($actions)
                                {{ $actions }}
                            @endisset
                        </div>
                    </div>
                @endisset
            </header>

            <div class="aui-shell-body flex">
                <div
                    class="aui-overlay fixed inset-x-0 bottom-0 z-20 backdrop-blur-sm opacity-0 pointer-events-none transition lg:hidden"
                    style="top: var(--aui-header-height);"
                    :class="(sidebarOpen && !sidebarStatic)
                        ? 'opacity-100 pointer-events-auto ' + (theme === 'dark' ? 'bg-black/70' : 'bg-slate-900/40')
                        : 'opacity-0 pointer-events-none'"
                    @click="sidebarOpen = false"
                ></div>

                <div
                    x-ref="sidebarRegion"
                    class="flex shrink-0"
                    @mouseenter="if (window.innerWidth >= 1024 && sidebarCollapsible && sidebarCollapsed) sidebarHoverExpanded = true"
                    @mouseleave="sidebarHoverExpanded = false; hoverPrimarySection = null"
                >
                    @isset($primaryRail)
                        {{ $primaryRail }}
                    @endisset

                    <aside
                        x-ref="sidebar"
                        class="aui-sidebar fixed bottom-0 left-0 z-30 overflow-hidden border-r backdrop-blur-xl transition-[width,transform,opacity] duration-200 lg:sticky"
                        style="top: var(--aui-header-height); height: calc(100vh - var(--aui-header-height));"
                        :style="((sidebarOpen || sidebarStatic || (sidebarCollapsed && sidebarHoverExpanded)) && !(sidebarCollapsed && !sidebarHoverExpanded && sidebarCollapseMode === 'hidden'))
                            ? 'width: {{ $sidebarWidth }};'
                            : ''"
                        :class="(sidebarOpen || sidebarStatic || (sidebarCollapsed && sidebarHoverExpanded))
                            ? 'translate-x-0 opacity-100 pointer-events-auto '
                                + ((sidebarCollapsed && !sidebarHoverExpanded)
                                    ? (sidebarCollapseMode === 'hidden'
                                        ? 'lg:w-0 lg:opacity-100 lg:pointer-events-none lg:border-transparent '
                                        : 'lg:w-16 ')
                                    : '')
                                + (theme === 'dark' ? 'border-white/5 bg-slate-900/95' : 'border-slate-200/80 bg-white/95')
                            : 'w-60 -translate-x-full opacity-0 pointer-events-none lg:w-0 lg:translate-x-0 lg:opacity-0 lg:pointer-events-none lg:border-transparent '
                                + (theme === 'dark' ? 'border-white/5 bg-slate-900/95' : 'border-slate-200/80 bg-white/95')"
                    >
                        <div class="flex h-full flex-col">
                            @isset($sidebar)
                                {{ $sidebar }}
                            @endisset
                        </div>
                    </aside>
                </div>

                <main class="aui-main min-w-0 flex-1 px-6 py-8 lg:px-8">
                    <div class="w-full">
                        {{ $slot }}
                    </div>
                </main>

                @if (isset($rightPrimaryRail) || isset($rightSidebar))
                    <div
                        x-ref="rightSidebarRegion"
                        class="hidden shrink-0 overflow-hidden transition-[width,opacity] duration-200 lg:flex"
                        @mouseleave="rightSidebarHoverExpanded = false; hoverRightPrimarySection = null"
                        :style="!rightSidebarVisible
                            ? 'width: 0px;'
                            : (((rightSidebarCollapsed && !rightSidebarHoverExpanded)
                                ? (rightSidebarCollapseMode === 'hidden'
                                    ? 'width: {{ $rightHiddenWidthStyle }};'
                                    : 'width: {{ $rightCompactWidthStyle ?? '4rem' }};')
                                : (({{ $hasRightSidebar ? 'true' : 'false' }} && !{{ $hasRightPrimaryRail ? 'true' : 'false' }})
                                    ? 'width: {{ $rightSidebarWidth }};'
                                    : 'width: {{ $rightExpandedWidthStyle ?? $rightRailWidth }};')))"
                        :class="!rightSidebarVisible
                            ? 'opacity-0 pointer-events-none'
                            : (((rightSidebarCollapsed && !rightSidebarHoverExpanded)
                                ? (rightSidebarCollapseMode === 'hidden'
                                    ? '{{ $rightHiddenWidth ?? '' }} opacity-100'
                                    : '{{ $rightCompactWidth ?? '' }} opacity-100')
                                : '{{ $rightExpandedWidth ?? '' }} opacity-100'))"
                    >
                        @isset($rightSidebar)
                            <aside
                                x-ref="rightSidebar"
                                class="aui-sidebar overflow-hidden border-l backdrop-blur-xl transition-[width,opacity] duration-200"
                                :style="((!rightSidebarCollapsed || rightSidebarHoverExpanded) && {{ $hasRightSidebar ? 'true' : 'false' }})
                                    ? 'width: {{ $rightSidebarWidth }};'
                                    : ''"
                                :class="(((rightSidebarCollapsed && !rightSidebarHoverExpanded))
                                    ? (rightSidebarCollapseMode === 'hidden'
                                        ? 'w-0 opacity-100 pointer-events-none border-transparent '
                                        : '{{ $hasRightPrimaryRail ? 'w-0 opacity-100 pointer-events-none border-transparent ' : 'w-0 opacity-100 pointer-events-none border-transparent ' }}')
                                    : '')
                                    + (theme === 'dark' ? 'border-white/5 bg-slate-900/95' : 'border-slate-200/80 bg-white/95')"
                            >
                                <div class="flex h-full flex-col">
                                    {{ $rightSidebar }}
                                </div>
                            </aside>
                        @endisset

                        @isset($rightPrimaryRail)
                            {{ $rightPrimaryRail }}
                        @endisset
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="flex min-h-screen flex-col">
            <header
                :class="theme === 'dark'
                    ? 'sticky top-0 z-20 border-b border-white/5 bg-slate-900/80 backdrop-blur-xl'
                    : 'sticky top-0 z-20 border-b border-slate-200/80 bg-[#f6f8fc]/95 backdrop-blur-xl'"
            >
                @isset($header)
                    {{ $header }}
                @else
                    <div class="flex w-full items-center justify-between gap-4 px-6 py-4 lg:px-8">
                        <div>
                            @if ($title)
                                <h1 :class="theme === 'dark' ? 'text-xl font-semibold tracking-tight text-white' : 'text-xl font-semibold tracking-tight text-slate-900'">
                                    {{ $title }}
                                </h1>
                            @endif
                            @if ($subtitle)
                                <p :class="theme === 'dark' ? 'mt-0.5 text-sm text-slate-400' : 'mt-0.5 text-sm text-slate-500'">
                                    {{ $subtitle }}
                                </p>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            @isset($actions)
                                {{ $actions }}
                            @endisset
                        </div>
                    </div>
                @endisset
            </header>
            <main class="aui-main flex-1 px-6 py-8 lg:px-8">
                <div class="w-full">
                    {{ $slot }}
                </div>
            </main>
        </div>
    @endif
</div>
