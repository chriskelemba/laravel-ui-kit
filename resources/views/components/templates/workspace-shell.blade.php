@props([
    'title' => null,
    'subtitle' => null,
    'headerLogoSrc' => null,
    'headerLogoAlt' => null,
    'showHeaderBranding' => true,
    'showHeaderDropdown' => false,
    'headerDropdownLabel' => 'Select',
    'headerDropdownCurrent' => null,
    'headerDropdownLogoSrc' => null,
    'headerDropdownLogoAlt' => null,
    'headerDropdownLogoFallback' => null,
    'headerDropdownItems' => [],
    'headerCenterLogoSrc' => null,
    'headerCenterLogoAlt' => null,
    'showHeaderCenterLogo' => false,
    'activePrimarySection' => null,
    'activeSidebarItem' => null,
    'pageEyebrow' => null,
    'pageHeading' => null,
    'pageDescription' => null,
    'primaryRailItems' => [],
    'sidebarSections' => [],
    'sidebarWidth' => '18rem',
    'sidebarCollapsed' => false,
    'sidebarHoverExpandable' => true,
    'spotlightCards' => [],
    'listSection' => [],
    'asideBlocks' => [],
    'rightSidebarView' => null,
    'rightPrimaryRailItems' => [],
    'rightPanelHeaders' => [],
    'rightPanels' => [],
    'rightFooterActions' => [],
    'forceRightSidebarOpen' => false,
    'themeColors' => [],
    'showRightSidebar' => true,
    'showRightPrimaryRail' => true,
    'showHeaderSearch' => true,
    'searchPlaceholder' => 'Search...',
    'profileName' => null,
    'profileEmail' => null,
    'profileAvatarSrc' => null,
    'profileUser' => null,
    'profileMenuItems' => [],
    'profileEditHref' => null,
    'profileLogoutHref' => null,
    'profileEditRoute' => null,
    'profileLogoutRoute' => null,
])

@php
    $workspaceShellStyle = trim(implode('; ', array_filter([
        $themeStyle,
        $attributes->get('style'),
    ])), " \t\n\r\0\x0B;");

    $currentRouteName = request()->route()?->getName();
    $currentUrl = url()->current();

    $resolveNavigationMatch = function (array $item) use ($currentRouteName, $currentUrl): bool {
        if (filled($currentRouteName) && filled($item['route'] ?? null) && $item['route'] === $currentRouteName) {
            return true;
        }

        if (! filled($item['href'] ?? null)) {
            return false;
        }

        return url($item['href']) === $currentUrl;
    };

    $profile = \ChrisKelemba\LaravelUiKit\Support\ProfileResolver::resolve([
        'user' => $profileUser,
        'name' => $profileName,
        'email' => $profileEmail,
        'avatar_src' => $profileAvatarSrc,
        'menu_items' => $profileMenuItems,
        'edit_href' => $profileEditHref,
        'logout_href' => $profileLogoutHref,
        'edit_route' => $profileEditRoute,
        'logout_route' => $profileLogoutRoute,
    ]);

    $profileName = $profile['name'];
    $profileEmail = $profile['email'];
    $profileAvatarSrc = \ChrisKelemba\LaravelUiKit\Support\MediaUrl::resolve($profile['avatar_src']);
    $profileInitials = $profile['initials'];
    $profileEditHref = $profile['edit_href'];
    $profileLogoutHref = $profile['logout_href'];
    $profileMenuItems = $profile['menu_items'];

    $resolvedActivePrimarySection = $activePrimarySection;

    if (! filled($resolvedActivePrimarySection)) {
        foreach ($sidebarSections as $sectionKey => $section) {
            foreach ($section['items'] ?? [] as $item) {
                if ($resolveNavigationMatch($item)) {
                    $resolvedActivePrimarySection = $sectionKey;
                    break 2;
                }
            }
        }
    }

    if (! filled($resolvedActivePrimarySection)) {
        foreach ($primaryRailItems as $item) {
            if ($resolveNavigationMatch($item)) {
                $resolvedActivePrimarySection = $item['key'] ?? null;
                break;
            }
        }
    }

    $currentSidebarSection = $sidebarSections[$resolvedActivePrimarySection] ?? reset($sidebarSections) ?: [
        'compose' => null,
        'items' => [],
        'spaces_title' => null,
        'spaces' => [],
        'note_title' => null,
        'note_body' => null,
    ];

    $primaryRailItems = array_map(function (array $item) use ($resolvedActivePrimarySection, $activePrimarySection, $resolveNavigationMatch) {
        $matchesExplicitKey = ($item['key'] ?? null) === $activePrimarySection;
        $matchesResolvedKey = ($item['key'] ?? null) === $resolvedActivePrimarySection;

        $item['active'] = $matchesExplicitKey || (! filled($activePrimarySection) && ($matchesResolvedKey || $resolveNavigationMatch($item)));

        return $item;
    }, $primaryRailItems);

    $sidebarItems = array_map(function (array $item) use ($activeSidebarItem, $currentRouteName, $currentUrl) {
        $matchesExplicitKey = ($item['key'] ?? null) === $activeSidebarItem;
        $matchesRouteName = filled($currentRouteName) && (($item['route'] ?? null) === $currentRouteName);
        $matchesHref = filled($item['href'] ?? null) && url($item['href']) === $currentUrl;

        $item['active'] = $matchesExplicitKey || (! filled($activeSidebarItem) && ($matchesRouteName || $matchesHref));

        return $item;
    }, $currentSidebarSection['items'] ?? []);

    $listSection = array_merge([
        'eyebrow' => null,
        'title' => null,
        'badge' => null,
        'items' => [],
    ], $listSection);

    $normalizedListItems = array_values(array_map(function (array $item) use ($rightSidebarView) {
        $item['panel_key'] = $item['panel_key'] ?? $rightSidebarView;

        return $item;
    }, $listSection['items']));

    $listSection['items'] = $normalizedListItems;

    $rightPanelHeader = $rightPanelHeaders[$rightSidebarView] ?? [
        'eyebrow' => null,
        'title' => null,
        'description' => null,
    ];

    $rightPanel = $rightPanels[$rightSidebarView] ?? [
        'blocks' => [],
    ];

    $hasCustomRightSidebarContent = isset($rightSidebarContent) && trim((string) $rightSidebarContent) !== '';
    $hasRenderableRightSidebar = $showRightSidebar && ($hasCustomRightSidebarContent || ! empty($rightPanels));

    $branding = config('ui-kit.branding', []);
    $headerLogoSrc = \ChrisKelemba\LaravelUiKit\Support\BrandingResolver::resolveLogo($headerLogoSrc ?? ($branding['logo'] ?? null));
    $headerLogoAlt = $headerLogoAlt ?: ($title ?: ($branding['name'] ?? config('app.name', 'Brand')));
    $headerCenterLogoSrc = \ChrisKelemba\LaravelUiKit\Support\BrandingResolver::resolveLogo($headerCenterLogoSrc ?? ($branding['center_logo'] ?? null));
    $headerCenterLogoAlt = $headerCenterLogoAlt ?: ($title ?: ($branding['name'] ?? config('app.name', 'Brand')));

    $themeColors = array_merge([
        'canvas' => '#f6f8fc',
        'header' => 'rgba(246, 248, 252, 0.95)',
        'surface' => '#ffffff',
        'surface_soft' => '#f8fafc',
        'surface_strong' => '#eff6ff',
        'border' => 'rgba(148, 163, 184, 0.28)',
        'text' => '#0f172a',
        'muted' => '#475569',
        'muted_strong' => '#94a3b8',
        'accent' => '#0ea5e9',
        'accent_soft' => '#e0f2fe',
        'accent_soft_strong' => 'rgba(186, 230, 253, 0.8)',
        'accent_text' => '#0369a1',
        'accent_contrast' => '#ffffff',
        'success_soft' => '#d1fae5',
        'success_text' => '#047857',
        'dark_button' => '#0f172a',
        'dark_button_hover' => '#1e293b',
        'feature_start' => '#0f172a',
        'feature_end' => '#1e293b',
    ], $themeColors);

    $themeStyle = collect($themeColors)->map(fn ($value, $key) => '--ws-' . str_replace('_', '-', $key) . ': ' . $value)->implode('; ');
@endphp

@push('head')
    <style>
        .workspace-shell {
            color: var(--ws-text);
            background: var(--ws-canvas) !important;
        }

        .workspace-shell .ws-header {
            background: var(--ws-header);
            border-color: var(--ws-border);
        }

        .workspace-shell .ws-toggle-active {
            background: var(--ws-dark-button);
            color: var(--ws-accent-contrast);
        }

        .workspace-shell .ws-toggle-active:hover {
            background: var(--ws-dark-button-hover);
        }

        .workspace-shell .ws-toggle-idle:hover,
        .workspace-shell .ws-hover-soft:hover {
            background: var(--ws-surface-soft);
        }

        .workspace-shell .ws-compose {
            background: var(--ws-accent-soft);
            color: var(--ws-text);
            box-shadow: inset 0 0 0 1px var(--ws-accent-soft-strong);
        }

        .workspace-shell .ws-compose:hover {
            background: var(--ws-accent-soft-strong);
        }

        .workspace-shell .ws-card,
        .workspace-shell .ws-panel-card {
            background: var(--ws-surface);
            border-color: var(--ws-border);
        }

        .workspace-shell .ws-soft-card {
            background: var(--ws-surface-soft);
            border-color: var(--ws-border);
        }

        .workspace-shell .ws-badge-soft,
        .workspace-shell .ws-chip {
            background: var(--ws-accent-soft);
            color: var(--ws-accent-text);
        }

        .workspace-shell .ws-badge-success {
            background: var(--ws-success-soft);
            color: var(--ws-success-text);
        }

        .workspace-shell .ws-nav-active,
        .workspace-shell .ws-list-selected {
            background: var(--ws-accent-soft);
        }

        .workspace-shell .ws-list-selected {
            border-color: var(--ws-accent-soft-strong);
        }

        .workspace-shell .ws-feature {
            background: linear-gradient(135deg, var(--ws-feature-start), var(--ws-feature-end));
        }

        .workspace-shell .ws-primary-action {
            background: var(--ws-dark-button);
            color: var(--ws-accent-contrast);
        }

        .workspace-shell .ws-primary-action:hover {
            background: var(--ws-dark-button-hover);
        }

        @media (min-width: 1024px) {
            .workspace-shell {
                height: 100vh;
                overflow: hidden;
            }

            .workspace-shell > .flex.min-h-screen {
                height: 100vh;
                min-height: 100vh;
                overflow: hidden;
            }

            .workspace-shell .aui-shell-body {
                flex: 1 1 auto;
                min-height: 0;
                overflow: hidden;
            }

            .workspace-shell .aui-main {
                height: calc(100vh - var(--aui-header-height));
                overflow-y: auto;
                overscroll-behavior: contain;
            }

            .workspace-shell .aui-shell-body > [x-ref="sidebarRegion"] {
                position: sticky;
                top: var(--aui-header-height);
                height: calc(100vh - var(--aui-header-height));
                align-self: flex-start;
                overflow: hidden;
            }

            .workspace-shell .aui-shell-body > [x-ref="sidebarRegion"] nav:first-child {
                height: 100%;
            }

            .workspace-shell .aui-shell-body > [x-ref="rightSidebarRegion"] {
                position: sticky;
                top: var(--aui-header-height);
                height: calc(100vh - var(--aui-header-height));
                align-self: flex-start;
                overflow: hidden;
            }

            .workspace-shell .aui-shell-body > [x-ref="rightSidebarRegion"] > aside {
                height: 100%;
            }
        }
    </style>
@endpush

    <x-ui-kit::templates.app-shell
    {{ $attributes->except('style')->class(['workspace-shell']) }}
    @if ($workspaceShellStyle !== '')
        style="{{ $workspaceShellStyle }}"
    @endif
    :title="$title"
    :subtitle="$subtitle"
    :show-sidebar="true"
    :sidebar-open="true"
    sidebar-mode="toggle"
    :active-primary-section="$resolvedActivePrimarySection"
    :show-sidebar-toggle="true"
    :show-sidebar-toggle-desktop="true"
    :sidebar-collapsible="true"
    :sidebar-collapsed="$sidebarCollapsed"
    :sidebar-hover-expandable="$sidebarHoverExpandable"
    sidebar-collapse-mode="hidden"
    :sidebar-width="$sidebarWidth"
    :right-sidebar-visible="$showRightSidebar && $forceRightSidebarOpen"
    :right-sidebar-collapsible="$showRightSidebar"
    :right-sidebar-collapsed="$showRightSidebar ? false : true"
    right-sidebar-collapse-mode="hidden"
    right-sidebar-width="20rem"
    :active-right-primary-section="$forceRightSidebarOpen ? $rightSidebarView : null"
    x-init="
        activePrimarySection = @js($resolvedActivePrimarySection);
        rightSidebarVisible = @js($showRightSidebar && $forceRightSidebarOpen);
        rightSidebarCollapsed = @js($showRightSidebar && ! $forceRightSidebarOpen);
        activeRightPrimarySection = @js($forceRightSidebarOpen ? $rightSidebarView : null);

        if (window.innerWidth >= 1024) {
            sidebarCollapsed = @js($sidebarCollapsed);
            sidebarOpen = @js(! $sidebarCollapsed);
        }
    "
>
    <x-slot:header>
        <div class="ws-header grid min-h-[var(--aui-header-height)] grid-cols-[5rem_minmax(0,1fr)] border-b backdrop-blur-xl">
            <div class="flex items-center justify-center">
                <button
                    type="button"
                    @click="
                        const nextCollapsed = !sidebarCollapsed;
                        if (sidebarCollapsible) sidebarCollapsed = nextCollapsed;
                        if (!sidebarStatic) sidebarOpen = !nextCollapsed;
                    "
                    class="inline-flex h-11 w-11 items-center justify-center rounded-2xl transition"
                    :class="sidebarCollapsed
                        ? 'ws-toggle-idle text-slate-500 hover:text-slate-900'
                        : 'ws-toggle-active text-white shadow-sm'"
                    aria-label="Toggle sidebar"
                >
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16"/>
                    </svg>
                </button>
            </div>

            <div class="relative flex min-w-0 items-center justify-between gap-4 px-6 py-4 lg:px-8">
                <div class="flex min-w-0 flex-1 items-center gap-6 overflow-visible">
                    @if ($showHeaderBranding)
                        @isset($brand)
                            {{ $brand }}
                        @elseif ($headerLogoSrc || $title || $subtitle)
                            <div class="flex min-w-0 items-center gap-4 overflow-visible">
                                @if ($headerLogoSrc)
                                    <img
                                        src="{{ $headerLogoSrc }}"
                                        alt="{{ $headerLogoAlt }}"
                                        class="h-14 w-auto max-w-[8rem] object-contain"
                                    >
                                @endif
                                <div class="min-w-0">
                                    @if ($title)
                                        <p class="truncate text-3xl font-black tracking-tight text-slate-900">{{ $title }}</p>
                                    @endif
                                    @if ($subtitle)
                                        <p class="truncate text-sm font-medium uppercase tracking-[0.24em] text-slate-500">{{ $subtitle }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endif

                    @if ($showHeaderDropdown && filled($headerDropdownItems))
                        <x-ui-kit::molecules.dropdown :items="$headerDropdownItems" panel-width-class="w-64" class="shrink-0">
                            <x-slot:trigger>
                                <button
                                    type="button"
                                    class="ws-card inline-flex min-h-[3.25rem] min-w-[16rem] items-center justify-between gap-3 rounded-full border px-3 py-2 text-left text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50"
                                >
                                    <span class="flex min-w-0 items-center gap-3">
                                        @if ($headerDropdownLogoSrc)
                                            <img
                                                src="{{ $headerDropdownLogoSrc }}"
                                                alt="{{ $headerDropdownLogoAlt ?: ($headerDropdownCurrent ?: $headerDropdownLabel) }}"
                                                class="h-10 w-10 rounded-full object-cover"
                                            >
                                        @else
                                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-sm font-bold text-slate-700">
                                                {{ $headerDropdownLogoFallback ?: 'S' }}
                                            </span>
                                        @endif

                                        <span class="min-w-0">
                                            <span class="block truncate text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500">{{ $headerDropdownLabel }}</span>
                                            <span class="block truncate text-sm font-semibold text-slate-900">{{ $headerDropdownCurrent ?: $headerDropdownLabel }}</span>
                                        </span>
                                    </span>
                                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                                    </svg>
                                </button>
                            </x-slot:trigger>
                        </x-ui-kit::molecules.dropdown>
                    @endif
                </div>

                @if ($showHeaderCenterLogo && ($headerCenterLogoSrc || isset($centerBrand)))
                    <div class="pointer-events-none absolute inset-y-0 left-1/2 hidden -translate-x-1/2 items-center justify-center sm:flex">
                        @isset($centerBrand)
                            <div class="pointer-events-auto">
                                {{ $centerBrand }}
                            </div>
                        @elseif ($headerCenterLogoSrc)
                            <img
                                src="{{ $headerCenterLogoSrc }}"
                                alt="{{ $headerCenterLogoAlt }}"
                                class="pointer-events-auto h-12 w-auto max-w-[8rem] object-contain lg:h-14 lg:max-w-[10rem]"
                            >
                        @endif
                    </div>
                @endif

                @if ($showHeaderSearch)
                    <label class="group hidden min-w-0 flex-[0_1_32rem] justify-center sm:flex">
                        <span class="sr-only">Search</span>
                        <span class="ws-card flex h-10 w-full max-w-lg items-center gap-3 rounded-full border px-4 shadow-sm transition group-focus-within:border-sky-300 group-focus-within:ring-2 group-focus-within:ring-sky-100">
                            <svg class="h-4 w-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"/>
                            </svg>
                            <input
                                type="search"
                                placeholder="{{ $searchPlaceholder }}"
                                class="min-w-0 flex-1 border-0 bg-transparent text-sm text-slate-700 outline-none placeholder:text-slate-400 focus:border-0 focus:outline-none focus:ring-0 focus-visible:outline-none"
                            >
                        </span>
                    </label>
                @endif

                <div class="flex shrink-0 items-center justify-end gap-3">
                    @isset($actions)
                        <div class="flex shrink-0 items-center gap-3">
                            {{ $actions }}
                        </div>
                    @endisset

                    <div class="relative shrink-0" x-data="{ profileOpen: false }" @keydown.escape.window="profileOpen = false">
                        <button
                            type="button"
                            class="ws-card flex h-11 w-11 items-center justify-center overflow-hidden rounded-full border text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50"
                            @click="profileOpen = !profileOpen"
                            :aria-expanded="profileOpen.toString()"
                            aria-haspopup="menu"
                            aria-label="Open profile menu"
                        >
                            @if ($profileAvatarSrc)
                                <img src="{{ $profileAvatarSrc }}" alt="{{ $profileName }}" class="h-full w-full object-cover">
                            @else
                                <span class="uppercase">{{ $profileInitials }}</span>
                            @endif
                        </button>

                        <div
                            x-cloak
                            x-show="profileOpen"
                            x-transition.opacity.duration.150ms
                            @click.outside="profileOpen = false"
                            class="ws-card absolute right-0 top-14 z-50 w-72 overflow-hidden rounded-3xl border p-3 shadow-xl"
                            role="menu"
                        >
                            <div class="flex items-center gap-3 rounded-2xl px-3 py-3">
                                <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-full bg-slate-100 text-sm font-semibold uppercase text-slate-700">
                                    @if ($profileAvatarSrc)
                                        <img src="{{ $profileAvatarSrc }}" alt="{{ $profileName }}" class="h-full w-full object-cover">
                                    @else
                                        {{ $profileInitials }}
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-slate-900">{{ $profileName }}</p>
                                    <p class="truncate text-xs text-slate-500">{{ $profileEmail }}</p>
                                </div>
                            </div>

                            <div class="mt-2 space-y-1 border-t border-slate-200/80 pt-2">
                                @foreach ($profileMenuItems as $item)
                                    @php
                                        $isDangerItem = ($item['tone'] ?? 'default') === 'danger';
                                    @endphp
                                    <a
                                        href="{{ $item['href'] }}"
                                        class="flex items-center justify-between rounded-2xl px-3 py-2.5 text-sm font-semibold transition {{ $isDangerItem ? 'text-rose-600 hover:bg-rose-50' : 'text-slate-700 hover:bg-slate-50' }}"
                                        role="menuitem"
                                    >
                                        <span class="flex items-center gap-3">
                                            @if (! empty($item['icon']))
                                                <i class="{{ $item['icon'] }} w-4 text-center {{ $isDangerItem ? 'text-rose-500' : 'text-slate-400' }}" aria-hidden="true"></i>
                                            @endif
                                            <span>{{ $item['label'] }}</span>
                                        </span>
                                        <svg class="h-4 w-4 {{ $isDangerItem ? 'text-rose-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot:header>

    <x-slot:primaryRail>
        <x-ui-kit::organisms.primary-rail :items="$primaryRailItems" class="border-r-0 [border-color:transparent!important] -mr-px" />
    </x-slot:primaryRail>

    <x-slot:sidebar>
        <div class="flex h-full overflow-hidden px-3 py-4">
            <div class="flex h-full min-h-0 w-full flex-col overflow-hidden">
                @if (! empty($currentSidebarSection['compose']))
                    <div class="shrink-0 px-2 pb-3" x-show="!sidebarCollapsed || sidebarHoverExpanded" x-transition.opacity.duration.150ms>
                        <div class="flex items-center gap-2">
                            @if (! empty($currentSidebarSection['compose_href']))
                                <a
                                    href="{{ $currentSidebarSection['compose_href'] }}"
                                    class="ws-compose flex min-w-0 flex-1 items-center gap-3 rounded-full px-4 py-3 text-left transition"
                                >
                                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-slate-800 shadow-sm">
                                        <i class="fa-solid fa-pen" aria-hidden="true"></i>
                                    </span>
                                    <span class="truncate text-base font-semibold tracking-tight">{{ $currentSidebarSection['compose'] }}</span>
                                </a>
                            @else
                                <button
                                    type="button"
                                    class="ws-compose flex min-w-0 flex-1 items-center gap-3 rounded-full px-4 py-3 text-left transition"
                                >
                                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-slate-800 shadow-sm">
                                        <i class="fa-solid fa-pen" aria-hidden="true"></i>
                                    </span>
                                    <span class="truncate text-base font-semibold tracking-tight">{{ $currentSidebarSection['compose'] }}</span>
                                </button>
                            @endif
                        </div>
                    </div>
                @endif

                <nav class="flex-1 space-y-1 overflow-hidden">
                    @foreach ($sidebarItems as $item)
                        <a
                            href="{{ $item['href'] }}"
                            class="{{ ($item['active'] ?? false) ? 'ws-nav-active text-slate-900 rounded-full' : 'text-slate-700 ws-hover-soft hover:rounded-full rounded-r-full rounded-l-2xl' }} group flex items-center gap-3 px-4 py-2.5 text-sm font-medium transition"
                        >
                            <span class="inline-flex h-5 w-5 items-center justify-center text-base text-slate-700">
                                {!! \ChrisKelemba\LaravelUiKit\Support\IconResolver::resolve($item['icon'] ?? null, $item['label'] ?? null) !!}
                            </span>

                            <span class="flex-1 truncate" x-show="!sidebarCollapsed || sidebarHoverExpanded" x-transition.opacity.duration.150ms>
                                {{ $item['label'] }}
                            </span>

                            @if (! empty($item['badge']))
                                <span
                                    class="{{ ($item['active'] ?? false) ? 'bg-white text-slate-700' : 'ws-soft-card text-slate-600' }} rounded-full px-2.5 py-1 text-[11px] font-semibold"
                                    x-show="!sidebarCollapsed || sidebarHoverExpanded"
                                    x-transition.opacity.duration.150ms
                                >
                                    {{ $item['badge'] }}
                                </span>
                            @endif
                        </a>
                    @endforeach
                </nav>

                @if (! empty($currentSidebarSection['spaces']) || ! empty($currentSidebarSection['note_body']))
                    <div class="mt-4 shrink-0 space-y-4 px-2" x-show="!sidebarCollapsed || sidebarHoverExpanded" x-transition.opacity.duration.150ms>
                        @if (! empty($currentSidebarSection['spaces']))
                            <p class="px-3 text-xs font-semibold uppercase tracking-[0.22em] text-slate-400">{{ $currentSidebarSection['spaces_title'] }}</p>
                            <div class="space-y-1.5">
                                @foreach ($currentSidebarSection['spaces'] as $space)
                                    <a href="{{ $space['href'] ?? '#' }}" class="ws-hover-soft flex items-center gap-3 rounded-r-full rounded-l-2xl px-4 py-2 text-sm font-medium text-slate-700 transition">
                                        <i class="{{ $space['icon'] }} w-5 text-center text-slate-500" aria-hidden="true"></i>
                                        <span class="flex-1">{{ $space['label'] }}</span>
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        @if (! empty($currentSidebarSection['note_body']))
                            <div class="ws-soft-card hidden rounded-[24px] border p-4 2xl:block">
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">{{ $currentSidebarSection['note_title'] }}</p>
                                <p class="mt-2 text-sm leading-5 text-slate-600">{{ $currentSidebarSection['note_body'] }}</p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </x-slot:sidebar>

    @if ($showRightSidebar)
        <x-slot:rightSidebar>
            <section class="flex h-full min-h-0 overflow-hidden">
                <div
                    class="min-h-0 flex-1 flex-col"
                    :class="rightSidebarCollapsed && !rightSidebarHoverExpanded ? 'hidden' : 'flex'"
                >
                    @if ($hasCustomRightSidebarContent)
                        <div class="flex min-h-0 flex-1 flex-col overflow-hidden" x-cloak>
                            <div class="relative shrink-0 border-b border-slate-200/80 px-5 py-4">
                                <button
                                    type="button"
                                    class="ws-panel-card ws-hover-soft absolute right-4 top-4 z-10 inline-flex h-10 w-10 items-center justify-center rounded-full border text-slate-500 shadow-sm transition hover:text-slate-900"
                                    @click="
                                        rightSidebarCollapsed = true;
                                        rightSidebarVisible = true;
                                    "
                                    aria-label="Collapse right sidebar"
                                    title="Collapse right sidebar"
                                >
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>

                                @isset($rightSidebarHeader)
                                    <div class="min-w-0 pr-14">
                                        {{ $rightSidebarHeader }}
                                    </div>
                                @else
                                    <div class="min-w-0 pr-14">
                                        @if (! empty($rightPanelHeader['eyebrow']))
                                            <p class="text-[11px] font-bold uppercase tracking-[0.3em] text-slate-400">{{ $rightPanelHeader['eyebrow'] }}</p>
                                        @endif
                                        @if (! empty($rightPanelHeader['title']))
                                            <p class="mt-2 truncate text-base font-semibold text-slate-800">{{ $rightPanelHeader['title'] }}</p>
                                        @endif
                                        @if (! empty($rightPanelHeader['description']))
                                            <p class="mt-1 text-sm leading-6 text-slate-500">{{ $rightPanelHeader['description'] }}</p>
                                        @endif
                                    </div>
                                @endisset
                            </div>

                            <div class="min-h-0 flex-1 overflow-y-auto px-5 py-5">
                                {{ $rightSidebarContent }}
                            </div>
                        </div>
                    @else
                        @foreach ($rightPanels as $panelKey => $panel)
                            @php
                                $panelHeader = $rightPanelHeaders[$panelKey] ?? $rightPanelHeader;
                            @endphp
                            <div
                                class="flex min-h-0 flex-1 flex-col overflow-hidden"
                                x-show="activeRightPrimarySection === @js($panelKey)"
                                x-cloak
                            >
                                <div class="relative shrink-0 border-b border-slate-200/80 px-5 py-4">
                                    <button
                                        type="button"
                                        class="ws-panel-card ws-hover-soft absolute right-4 top-4 z-10 inline-flex h-10 w-10 items-center justify-center rounded-full border text-slate-500 shadow-sm transition hover:text-slate-900"
                                        @click="
                                            rightSidebarCollapsed = true;
                                            rightSidebarVisible = true;
                                        "
                                        aria-label="Collapse right sidebar"
                                        title="Collapse right sidebar"
                                    >
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>

                                    <div class="min-w-0 pr-14">
                                        @if (! empty($panelHeader['eyebrow']))
                                            <p class="text-[11px] font-bold uppercase tracking-[0.3em] text-slate-400">{{ $panelHeader['eyebrow'] }}</p>
                                        @endif
                                        @if (! empty($panelHeader['title']))
                                            <p class="mt-2 truncate text-base font-semibold text-slate-800">{{ $panelHeader['title'] }}</p>
                                        @endif
                                        @if (! empty($panelHeader['description']))
                                            <p class="mt-1 text-sm leading-6 text-slate-500">{{ $panelHeader['description'] }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex min-h-0 flex-1 flex-col overflow-hidden">
                                    <div class="min-h-0 flex-1 space-y-4 overflow-y-auto px-5 py-5">
                                        @foreach ($panel['blocks'] ?? [] as $block)
                                        @if (($block['type'] ?? null) === 'calendar')
                                            <article class="ws-panel-card rounded-3xl border p-4 shadow-sm">
                                                <div class="flex items-center justify-between">
                                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ $block['eyebrow'] }}</p>
                                                    @if (! empty($block['badge']))
                                                        <span class="ws-soft-card rounded-full px-2.5 py-1 text-[11px] font-semibold text-slate-600">{{ $block['badge'] }}</span>
                                                    @endif
                                                </div>
                                                <div class="ws-soft-card mt-4 rounded-3xl p-4">
                                                    <div class="flex items-center justify-between text-sm font-semibold text-slate-900">
                                                        <span>{{ $block['month'] }}</span>
                                                        <span class="text-slate-400">{{ $block['view_label'] }}</span>
                                                    </div>
                                                    <div class="mt-4 grid grid-cols-7 gap-2 text-center text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">
                                                        @foreach ($block['weekdays'] ?? [] as $weekday)
                                                            <span>{{ $weekday }}</span>
                                                        @endforeach
                                                    </div>
                                                    <div class="mt-3 grid grid-cols-7 gap-2 text-center text-sm text-slate-600">
                                                        @foreach ($block['days'] ?? [] as $day)
                                                            <span class="rounded-2xl py-2 {{ !empty($day['active']) ? 'ws-badge-soft font-semibold' : '' }}">{{ $day['label'] }}</span>
                                                        @endforeach
                                                    </div>
                                                    <div class="mt-4 space-y-3">
                                                        @foreach ($block['events'] ?? [] as $event)
                                                            <div class="ws-panel-card rounded-2xl px-3 py-3 ring-1 ring-slate-200/70">
                                                                <p class="text-sm font-semibold text-slate-900">{{ $event['title'] }}</p>
                                                                <p class="mt-1 text-sm text-slate-600">{{ $event['description'] }}</p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </article>
                                        @elseif (($block['type'] ?? null) === 'stacked-cards')
                                            <article class="ws-panel-card rounded-3xl border p-4 shadow-sm">
                                                <div class="flex items-center justify-between">
                                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ $block['eyebrow'] }}</p>
                                                    @if (! empty($block['badge']))
                                                        <span class="ws-soft-card rounded-full px-2.5 py-1 text-[11px] font-semibold text-slate-600">{{ $block['badge'] }}</span>
                                                    @endif
                                                </div>
                                                <div class="mt-4 space-y-3">
                                                    @foreach ($block['items'] ?? [] as $item)
                                                        <div class="ws-soft-card rounded-2xl border px-4 py-4">
                                                            @if (! empty($item['image_src']))
                                                                <img
                                                                    src="{{ \ChrisKelemba\LaravelUiKit\Support\MediaUrl::resolve($item['image_src']) }}"
                                                                    alt="{{ $item['title'] ?? 'Image' }}"
                                                                    class="mb-3 h-28 w-full rounded-2xl object-cover"
                                                                >
                                                            @endif
                                                            <p class="text-sm font-semibold text-slate-900">{{ $item['title'] }}</p>
                                                            <p class="mt-1 text-sm text-slate-600">{{ $item['description'] }}</p>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </article>
                                        @elseif (($block['type'] ?? null) === 'detail')
                                            @php
                                                $isEmptyDetailState = ($block['empty_state'] ?? false)
                                                    || (
                                                        empty($block['image_src'])
                                                        && empty($block['title'])
                                                        && empty($block['subtitle'])
                                                        && empty($block['badge'])
                                                        && ! empty($block['description'])
                                                    );
                                            @endphp
                                            @if ($isEmptyDetailState)
                                                <article class="flex min-h-[26rem] items-center justify-center rounded-3xl px-8 py-12 text-center">
                                                    <div class="max-w-xs">
                                                        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full border border-slate-200 bg-slate-50 text-slate-400">
                                                            <svg class="h-9 w-9" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 6v6l4 2m4-2a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z"/>
                                                            </svg>
                                                        </div>
                                                        <p class="mt-6 text-base font-medium text-slate-500">{{ $block['description'] }}</p>
                                                    </div>
                                                </article>
                                            @else
                                                <article class="ws-panel-card rounded-3xl border p-5 shadow-sm">
                                                    @if (! empty($block['image_src']))
                                                        <img
                                                            src="{{ \ChrisKelemba\LaravelUiKit\Support\MediaUrl::resolve($block['image_src']) }}"
                                                            alt="{{ $block['title'] ?? 'Detail image' }}"
                                                            class="mb-4 h-40 w-full rounded-3xl object-cover"
                                                        >
                                                    @endif
                                                    <div class="flex items-start justify-between gap-3">
                                                        <div class="min-w-0">
                                                            <p class="text-lg font-semibold tracking-tight text-slate-900">{{ $block['title'] }}</p>
                                                            @if (! empty($block['subtitle']))
                                                                <p class="mt-1 text-sm text-slate-600">{{ $block['subtitle'] }}</p>
                                                            @endif
                                                        </div>
                                                        @if (! empty($block['badge']))
                                                            <span class="rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $block['badge_class'] ?? 'bg-slate-100 text-slate-700' }}">{{ $block['badge'] }}</span>
                                                        @endif
                                                    </div>

                                                    @if (! empty($block['description']))
                                                        <p class="mt-4 text-sm leading-6 text-slate-600">{{ $block['description'] }}</p>
                                                    @endif
                                                </article>
                                            @endif
                                        @elseif (($block['type'] ?? null) === 'stat-list')
                                            <article class="ws-soft-card rounded-3xl border p-4">
                                                @if (! empty($block['eyebrow']))
                                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ $block['eyebrow'] }}</p>
                                                @endif
                                                <div class="mt-4 space-y-2.5">
                                                    @foreach ($block['items'] ?? [] as $item)
                                                        <div class="ws-panel-card flex items-center justify-between gap-3 rounded-2xl px-3 py-2.5 shadow-sm ring-1 ring-slate-200/70">
                                                            <span class="text-sm text-slate-600">{{ $item['label'] }}</span>
                                                            <span class="text-right text-sm font-semibold text-slate-900">{{ $item['value'] }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </article>
                                        @elseif (($block['type'] ?? null) === 'key-value')
                                            <article class="ws-panel-card rounded-3xl border p-4 shadow-sm">
                                                @if (! empty($block['eyebrow']))
                                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ $block['eyebrow'] }}</p>
                                                @endif
                                                @if (! empty($block['title']))
                                                    <p class="{{ ! empty($block['eyebrow']) ? 'mt-2' : '' }} text-base font-semibold text-slate-900">{{ $block['title'] }}</p>
                                                @endif
                                                <div class="mt-4 space-y-3">
                                                    @foreach ($block['items'] ?? [] as $item)
                                                        @if (! empty($item['stacked']))
                                                            <div class="ws-soft-card rounded-2xl px-3 py-3">
                                                                <p class="text-sm text-slate-600">{{ $item['label'] }}</p>
                                                                <p class="mt-1 text-sm font-semibold text-slate-900">{{ $item['value'] }}</p>
                                                            </div>
                                                        @else
                                                            <div class="ws-soft-card flex items-center justify-between rounded-2xl px-3 py-3">
                                                                <span class="text-sm text-slate-600">{{ $item['label'] }}</span>
                                                                <span class="text-sm font-semibold text-slate-900">{{ $item['value'] }}</span>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </article>
                                        @elseif (($block['type'] ?? null) === 'upload-form')
                                            <article class="ws-panel-card rounded-3xl border p-4 shadow-sm">
                                                @if (! empty($block['eyebrow']))
                                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ $block['eyebrow'] }}</p>
                                                @endif
                                                @if (! empty($block['title']))
                                                    <p class="{{ ! empty($block['eyebrow']) ? 'mt-2' : '' }} text-base font-semibold text-slate-900">{{ $block['title'] }}</p>
                                                @endif
                                                @if (! empty($block['description']))
                                                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ $block['description'] }}</p>
                                                @endif

                                                <form
                                                    action="{{ $block['action'] ?? '#' }}"
                                                    method="{{ in_array(strtoupper($block['method'] ?? 'POST'), ['GET', 'POST']) ? strtoupper($block['method'] ?? 'POST') : 'POST' }}"
                                                    enctype="multipart/form-data"
                                                    class="mt-4 space-y-4"
                                                >
                                                    @csrf
                                                    @if (! in_array(strtoupper($block['method'] ?? 'POST'), ['GET', 'POST']))
                                                        @method($block['method'])
                                                    @endif

                                                    @foreach (($block['hidden_fields'] ?? []) as $hiddenField => $hiddenValue)
                                                        <input type="hidden" name="{{ $hiddenField }}" value="{{ $hiddenValue }}">
                                                    @endforeach

                                                    <label class="block">
                                                        <span class="mb-2 block text-sm font-medium text-slate-700">{{ $block['label'] ?? 'Upload file' }}</span>
                                                        <input
                                                            type="file"
                                                            name="{{ $block['input_name'] ?? 'file' }}"
                                                            @if (! empty($block['accept'])) accept="{{ $block['accept'] }}" @endif
                                                            class="block w-full rounded-2xl border border-slate-200 bg-white px-3 py-3 text-sm text-slate-700 file:mr-3 file:rounded-xl file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-slate-700"
                                                        >
                                                    </label>

                                                    <button type="submit" class="ws-primary-action w-full rounded-2xl px-4 py-3 text-sm font-semibold transition">
                                                        {{ $block['submit_label'] ?? 'Upload' }}
                                                    </button>
                                                </form>
                                            </article>
                                        @endif
                                        @endforeach
                                    </div>

                                    @if (! empty($rightFooterActions))
                                        <div class="shrink-0 space-y-3 px-5 pb-5 pt-4">
                                            @foreach ($rightFooterActions as $action)
                                                <button
                                                    type="button"
                                                    class="{{ ($action['variant'] ?? 'secondary') === 'primary'
                                                        ? 'ws-primary-action w-full rounded-2xl px-4 py-3 text-sm font-semibold transition'
                                                        : 'ws-soft-card ws-hover-soft w-full rounded-2xl border px-4 py-3 text-sm font-semibold text-slate-700 transition' }}"
                                                >
                                                    {{ $action['label'] }}
                                                </button>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </section>
        </x-slot:rightSidebar>
    @endif

    @if ($showRightPrimaryRail)
        <x-slot:rightPrimaryRail>
            <x-ui-kit::organisms.primary-rail
                side="right"
                :items="$rightPrimaryRailItems"
                class="border-l-0 [border-color:transparent!important] -ml-px"
            />
        </x-slot:rightPrimaryRail>
    @endif

    <div class="space-y-6">
        @if (filled($pageEyebrow) || filled($pageHeading) || filled($pageDescription))
            <section class="ws-card rounded-[32px] border p-6 shadow-sm">
                @if (filled($pageEyebrow))
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">{{ $pageEyebrow }}</p>
                @endif

                <div class="{{ filled($pageEyebrow) ? 'mt-3' : '' }} flex flex-wrap items-start justify-between gap-4">
                    <div class="max-w-2xl">
                        @if (filled($pageHeading))
                            <h1 class="text-3xl font-semibold tracking-tight text-slate-900">{{ $pageHeading }}</h1>
                        @endif

                        @if (filled($pageDescription))
                            <p class="{{ filled($pageHeading) ? 'mt-3' : '' }} text-sm leading-7 text-slate-600">{{ $pageDescription }}</p>
                        @endif
                    </div>
                </div>
            </section>
        @endif

        @if ($spotlightCards !== [])
            <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                @foreach ($spotlightCards as $card)
                    <article class="ws-card rounded-[28px] border p-5 shadow-sm">
                        <p class="text-sm font-medium text-slate-500">{{ $card['label'] }}</p>
                        <p class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">{{ $card['value'] }}</p>
                        <p class="mt-2 text-sm text-slate-600">{{ $card['meta'] }}</p>
                    </article>
                @endforeach
            </section>
        @endif

        @if (trim($slot) !== '')
            {{ $slot }}
        @endif

        @isset($floating)
            <div class="pointer-events-none fixed bottom-6 right-6 z-50">
                <div class="pointer-events-auto">
                    {{ $floating }}
                </div>
            </div>
        @endisset

        @if (! empty($listSection['items']) || ! empty($asideBlocks) || ! empty($listSection['title']))
            <section class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
                @if (! empty($listSection['title']) || ! empty($listSection['items']))
                    <article class="ws-card rounded-[32px] border p-6 shadow-sm">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">{{ $listSection['eyebrow'] }}</p>
                                <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-900">{{ $listSection['title'] }}</h2>
                            </div>
                            @if (! empty($listSection['badge']))
                                <span class="ws-badge-success rounded-full px-3 py-1 text-xs font-semibold">{{ $listSection['badge'] }}</span>
                            @endif
                        </div>

                        <div class="mt-6 space-y-3">
                            @foreach ($listSection['items'] as $item)
                                @php
                                    $listItemBaseClass = ! empty($item['selected'])
                                        ? 'ws-list-selected shadow-sm'
                                        : 'ws-soft-card hover:border-slate-400 hover:bg-slate-100';
                                    $listItemPanelKey = $item['panel_key'] ?? null;
                                    $listItemActionHref = $item['action_href'] ?? null;
                                    $listItemAlpineClass = $listItemPanelKey
                                        ? "(activeRightPrimarySection === " . \Illuminate\Support\Js::from($listItemPanelKey) . ") ? 'ws-list-selected shadow-sm' : 'ws-soft-card hover:border-slate-400 hover:bg-slate-100'"
                                        : null;
                                @endphp
                                <a
                                    href="{{ $item['href'] }}"
                                    @if ($listItemPanelKey)
                                        @click.prevent="
                                            activeRightPrimarySection = @js($listItemPanelKey);
                                            rightSidebarVisible = true;
                                            rightSidebarCollapsed = false;
                                        "
                                    @elseif ($listItemActionHref)
                                        @click.prevent="window.setTimeout(() => window.location.href = '{{ $listItemActionHref }}', 80);"
                                    @endif
                                    class="{{ $listItemBaseClass }} block cursor-pointer rounded-3xl border px-4 py-4 transition"
                                    @if ($listItemAlpineClass)
                                        :class="{{ $listItemAlpineClass }}"
                                    @endif
                                >
                                    <div class="flex items-center justify-between gap-4">
                                        <div class="flex min-w-0 items-center gap-4">
                                            @if (! empty($item['image_src']))
                                                <img
                                                    src="{{ \ChrisKelemba\LaravelUiKit\Support\MediaUrl::resolve($item['image_src']) }}"
                                                    alt="{{ $item['title'] ?? 'Item image' }}"
                                                    class="h-16 w-16 shrink-0 rounded-2xl object-cover"
                                                >
                                            @endif
                                            <div class="min-w-0">
                                                <p class="text-sm font-semibold text-slate-900">{{ $item['title'] }}</p>
                                                <p class="mt-1 text-sm text-slate-600">{{ $item['subtitle'] }}</p>
                                                <p class="mt-2 text-xs font-medium uppercase tracking-[0.16em] text-slate-500">{{ $item['meta'] }}</p>
                                            </div>
                                        </div>
                                        <div class="shrink-0 text-right">
                                            <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-500">{{ $item['status_label'] ?? 'Status' }}</p>
                                            <p class="mt-1 text-sm font-medium text-slate-800">{{ $item['status'] }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </article>
                @endif

                @if (! empty($asideBlocks))
                    <div class="space-y-6">
                        @foreach ($asideBlocks as $block)
                            @if (($block['type'] ?? null) === 'badge-list')
                                <article class="ws-card rounded-[32px] border p-6 shadow-sm">
                                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">{{ $block['eyebrow'] }}</p>
                                    <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-900">{{ $block['title'] }}</h2>
                                    <div class="mt-6 space-y-3">
                                        @foreach ($block['items'] ?? [] as $item)
                                            <div class="flex items-center justify-between rounded-3xl border border-slate-200/80 px-4 py-4">
                                                <div>
                                                    <p class="text-sm font-semibold text-slate-900">{{ $item['title'] }}</p>
                                                    <p class="mt-1 text-sm text-slate-600">{{ $item['subtitle'] }}</p>
                                                </div>
                                                <span class="ws-badge-soft rounded-full px-3 py-1 text-xs font-semibold">{{ $item['badge'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </article>
                            @elseif (($block['type'] ?? null) === 'feature')
                                <article class="ws-feature rounded-[32px] border border-slate-200/80 p-6 text-white shadow-sm">
                                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-300">{{ $block['eyebrow'] }}</p>
                                    <h2 class="mt-2 text-2xl font-semibold tracking-tight">{{ $block['title'] }}</h2>
                                    <p class="mt-3 text-sm leading-6 text-slate-300">{{ $block['description'] }}</p>
                                </article>
                            @elseif (($block['type'] ?? null) === 'simple-cards')
                                <article class="ws-card rounded-[32px] border p-6 shadow-sm">
                                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">{{ $block['eyebrow'] }}</p>
                                    <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-900">{{ $block['title'] }}</h2>
                                    <div class="mt-6 space-y-3">
                                        @foreach ($block['items'] ?? [] as $item)
                                            <div class="rounded-3xl border border-slate-200/80 px-4 py-4">
                                                <p class="text-sm font-semibold text-slate-900">{{ $item['title'] }}</p>
                                                <p class="mt-1 text-sm text-slate-600">{{ $item['subtitle'] }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </article>
                            @endif
                        @endforeach
                    </div>
                @endif
            </section>
        @endif
    </div>
</x-ui-kit::templates.app-shell>
