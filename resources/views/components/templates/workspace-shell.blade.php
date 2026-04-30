@props([
    'title' => null,
    'subtitle' => null,
    'headerLogoSrc' => null,
    'headerLogoAlt' => null,
    'activePrimarySection' => null,
    'activeSidebarItem' => null,
    'pageEyebrow' => null,
    'pageHeading' => null,
    'pageDescription' => null,
    'primaryRailItems' => [],
    'sidebarSections' => [],
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
    'profileEditHref' => null,
    'profileLogoutHref' => null,
    'profileEditRoute' => null,
    'profileLogoutRoute' => null,
])

@php
    $profile = \ChrisKelemba\LaravelUiKit\Support\ProfileResolver::resolve([
        'user' => $profileUser,
        'name' => $profileName,
        'email' => $profileEmail,
        'avatar_src' => $profileAvatarSrc,
        'edit_href' => $profileEditHref,
        'logout_href' => $profileLogoutHref,
        'edit_route' => $profileEditRoute,
        'logout_route' => $profileLogoutRoute,
    ]);

    $profileName = $profile['name'];
    $profileEmail = $profile['email'];
    $profileAvatarSrc = $profile['avatar_src'];
    $profileInitials = $profile['initials'];
    $profileEditHref = $profile['edit_href'];
    $profileLogoutHref = $profile['logout_href'];

    $currentSidebarSection = $sidebarSections[$activePrimarySection] ?? reset($sidebarSections) ?: [
        'compose' => null,
        'items' => [],
        'spaces_title' => null,
        'spaces' => [],
        'note_title' => null,
        'note_body' => null,
    ];

    $sidebarItems = array_map(function (array $item) use ($activeSidebarItem) {
        $item['active'] = ($item['key'] ?? null) === $activeSidebarItem;
        return $item;
    }, $currentSidebarSection['items'] ?? []);

    $listSection = array_merge([
        'eyebrow' => null,
        'title' => null,
        'badge' => null,
        'items' => [],
    ], $listSection);

    $rightPanelHeader = $rightPanelHeaders[$rightSidebarView] ?? [
        'eyebrow' => null,
        'title' => null,
        'description' => null,
    ];

    $rightPanel = $rightPanels[$rightSidebarView] ?? [
        'blocks' => [],
    ];

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
    class="workspace-shell"
    style="{{ $themeStyle }}"
    :title="$title"
    :subtitle="$subtitle"
    :show-sidebar="true"
    :sidebar-open="true"
    sidebar-mode="toggle"
    :active-primary-section="$activePrimarySection"
    :show-sidebar-toggle="true"
    :show-sidebar-toggle-desktop="true"
    :sidebar-collapsible="true"
    :sidebar-collapsed="false"
    sidebar-collapse-mode="hidden"
    sidebar-width="18rem"
    :right-sidebar-visible="$showRightSidebar"
    :right-sidebar-collapsible="$showRightSidebar"
    :right-sidebar-collapsed="$showRightSidebar ? false : true"
    right-sidebar-collapse-mode="hidden"
    right-sidebar-width="20rem"
    :active-right-primary-section="$showRightPrimaryRail ? $rightSidebarView : null"
    x-init="
        activePrimarySection = @js($activePrimarySection);
        if (window.innerWidth >= 1024) {
            sidebarCollapsed = false;
            sidebarOpen = true;
        }

        $watch('activePrimarySection', value => {
            if (value && window.innerWidth >= 1024) {
                sidebarCollapsed = false;
                sidebarOpen = true;
            }
        });
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
                    @isset($brand)
                        {{ $brand }}
                    @elseif ($headerLogoSrc)
                        <div class="flex h-10 items-center gap-3 overflow-visible">
                            <img
                                src="{{ $headerLogoSrc }}"
                                alt="{{ $headerLogoAlt ?: $title }}"
                                class="h-32 w-auto max-w-[18rem] origin-left scale-[1.9] object-contain"
                            >
                        </div>
                    @elseif ($title)
                        <p class="text-2xl font-semibold tracking-tight text-slate-900">{{ $title }}</p>
                    @endif
                </div>

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

                <div class="flex shrink-0 items-center justify-end">
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
                                <a href="{{ $profileEditHref }}" class="flex items-center justify-between rounded-2xl px-3 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50" role="menuitem">
                                    <span>Edit profile</span>
                                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                                <a href="{{ $profileLogoutHref }}" class="flex items-center justify-between rounded-2xl px-3 py-2.5 text-sm font-semibold text-rose-600 transition hover:bg-rose-50" role="menuitem">
                                    <span>Logout</span>
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12"/>
                                    </svg>
                                </a>
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
                            <button
                                type="button"
                                class="ws-compose flex min-w-0 flex-1 items-center gap-3 rounded-full px-4 py-3 text-left transition"
                            >
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-slate-800 shadow-sm">
                                    <i class="fa-solid fa-pen" aria-hidden="true"></i>
                                </span>
                                <span class="truncate text-base font-semibold tracking-tight">{{ $currentSidebarSection['compose'] }}</span>
                            </button>
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
                                    <a href="#" class="ws-hover-soft flex items-center gap-3 rounded-r-full rounded-l-2xl px-4 py-2 text-sm font-medium text-slate-700 transition">
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
                    </div>

                    <div class="flex min-h-0 flex-1 flex-col overflow-hidden">
                        <div class="min-h-0 flex-1 space-y-4 overflow-y-auto px-5 py-5">
                            @foreach ($rightPanel['blocks'] ?? [] as $block)
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
                                                    <p class="text-sm font-semibold text-slate-900">{{ $item['title'] }}</p>
                                                    <p class="mt-1 text-sm text-slate-600">{{ $item['description'] }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </article>
                                @elseif (($block['type'] ?? null) === 'detail')
                                    <article class="ws-panel-card rounded-3xl border p-5 shadow-sm">
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
                                @elseif (($block['type'] ?? null) === 'stat-list')
                                    <article class="ws-soft-card rounded-3xl border p-4">
                                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ $block['eyebrow'] }}</p>
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
                                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ $block['eyebrow'] }}</p>
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
        <section class="ws-card rounded-[32px] border p-6 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">{{ $pageEyebrow }}</p>
            <div class="mt-3 flex flex-wrap items-start justify-between gap-4">
                <div class="max-w-2xl">
                    <h1 class="text-3xl font-semibold tracking-tight text-slate-900">{{ $pageHeading }}</h1>
                    <p class="mt-3 text-sm leading-7 text-slate-600">{{ $pageDescription }}</p>
                </div>
            </div>
        </section>

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
                                <a
                                    href="{{ $item['href'] }}"
                                    @if (! empty($item['action_href']))
                                        @click.prevent="
                                            window.setTimeout(() => window.location.href = '{{ $item['action_href'] }}', 80);
                                        "
                                    @endif
                                    class="{{ !empty($item['selected']) ? 'ws-list-selected shadow-sm' : 'ws-soft-card hover:border-slate-300 hover:bg-white' }} block rounded-3xl border px-4 py-4 transition"
                                >
                                    <div class="flex items-center justify-between gap-4">
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-slate-900">{{ $item['title'] }}</p>
                                            <p class="mt-1 text-sm text-slate-600">{{ $item['subtitle'] }}</p>
                                            <p class="mt-2 text-xs font-medium uppercase tracking-[0.16em] text-slate-500">{{ $item['meta'] }}</p>
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
