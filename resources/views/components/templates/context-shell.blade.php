@props([
    'title' => null,
    'subtitle' => null,
    'section' => null,
    'subnav' => null,
    'searchQuery' => null,
    'searchAction' => null,
    'searchPlaceholder' => 'Search',
    'brandLogo' => null,
    'brandName' => null,
    'brandSubtitle' => null,
    'statusLabel' => null,
    'primaryActionLabel' => null,
    'navigation' => [],
    'navigationBadges' => [],
    'helperRailItems' => [],
    'helperPanels' => [],
    'theme' => [
        'primary' => '#2f6a9d',
        'primary_hover' => '#25577f',
        'primary_soft' => 'rgba(47, 106, 157, 0.16)',
        'primary_softer' => 'rgba(47, 106, 157, 0.08)',
        'primary_contrast' => '#ffffff',
        'accent' => '#e5232a',
        'accent_soft' => 'rgba(229, 35, 42, 0.14)',
        'danger' => '#e5232a',
        'danger_soft' => 'rgba(229, 35, 42, 0.14)',
    ],
    'activeHelperPanel' => null,
])

@php
    $searchAction = $searchAction ?? url()->current();
    $section = $section ?? ($navigation[0]['key'] ?? null);

    if ($subnav === null) {
        foreach ($navigation as $navItem) {
            if (($navItem['key'] ?? null) === $section) {
                $subnav = $navItem['items'][0]['key'] ?? null;
                break;
            }
        }
    }

    $primaryRailItems = collect($navigation)->map(fn (array $item) => [
        'key' => $item['key'] ?? null,
        'label' => $item['label'] ?? '',
        'href' => $item['href'] ?? '#',
        'active' => ($item['key'] ?? null) === $section,
        'icon' => $item['icon'] ?? null,
    ])->filter(fn (array $item) => filled($item['key']))->values()->all();

    $secondaryItems = collect($navigation)->mapWithKeys(function (array $item) use ($section, $subnav, $navigationBadges) {
        $items = collect($item['items'] ?? [])->map(function (array $child) use ($item, $section, $subnav, $navigationBadges) {
            $badgeKey = $child['badge_key'] ?? null;

            return [
                'label' => $child['label'] ?? '',
                'href' => $child['href'] ?? '#',
                'badge' => $badgeKey ? ($navigationBadges[$badgeKey] ?? null) : ($child['badge'] ?? null),
                'active' => ($item['key'] ?? null) === $section && ($child['key'] ?? null) === $subnav,
            ];
        })->values()->all();

        return [($item['key'] ?? '') => $items];
    })->filter(fn (array $items, string $key) => filled($key))->all();

    $helperPanels = collect($helperPanels)->mapWithKeys(function (array $panel, $key) {
        $panelKey = is_string($key) ? $key : ($panel['key'] ?? null);

        return filled($panelKey) ? [$panelKey => $panel] : [];
    })->all();

    $activeHelperPanel = $activeHelperPanel ?? array_key_first($helperPanels);

    $helperRailItems = ! empty($helperRailItems)
        ? $helperRailItems
        : collect($helperPanels)->map(fn (array $panel, string $key) => [
            'key' => $key,
            'label' => $panel['rail_label'] ?? $panel['title'] ?? ucfirst($key),
            'href' => '#',
            'icon' => $panel['icon'] ?? null,
            'toggles_sidebar' => true,
        ])->values()->all();

    $helperRailItems = collect($helperRailItems)->map(fn (array $item) => array_merge($item, [
        'active' => ($item['key'] ?? null) === $activeHelperPanel,
    ]))->values()->all();

    $themeStyle = collect([
        '--aui-primary' => $theme['primary'] ?? '#2f6a9d',
        '--aui-primary-hover' => $theme['primary_hover'] ?? '#25577f',
        '--aui-primary-soft' => $theme['primary_soft'] ?? 'rgba(47, 106, 157, 0.16)',
        '--aui-primary-softer' => $theme['primary_softer'] ?? 'rgba(47, 106, 157, 0.08)',
        '--aui-primary-contrast' => $theme['primary_contrast'] ?? '#ffffff',
        '--aui-accent' => $theme['accent'] ?? '#e5232a',
        '--aui-accent-soft' => $theme['accent_soft'] ?? 'rgba(229, 35, 42, 0.14)',
        '--aui-danger' => $theme['danger'] ?? '#e5232a',
        '--aui-danger-soft' => $theme['danger_soft'] ?? 'rgba(229, 35, 42, 0.14)',
    ])->map(fn (string $value, string $key) => $key . ': ' . $value)->implode('; ');
@endphp

@php
    $branding = config('ui-kit.branding', []);
    $brandLogo = $brandLogo ?? ($branding['logo'] ?? null);
    $brandName = $brandName ?? ($branding['name'] ?? config('app.name'));
    $brandSubtitle = $brandSubtitle ?? ($branding['subtitle'] ?? null);
@endphp

<div {{ $attributes->class(['aui-context-shell']) }} style="{{ $themeStyle }}">
    <style>
        .aui-context-shell > div > div > header {
            border-bottom-color: transparent !important;
            background: rgba(255, 255, 255, 0.98) !important;
        }

        .aui-context-shell .aui-sidebar {
            border-color: transparent !important;
        }

        .aui-context-shell nav[class*='border-r'],
        .aui-context-shell nav[class*='border-l'] {
            border-color: transparent !important;
        }

        html[data-aui-theme="dark"] .aui-context-shell > div > div > header {
            background: rgba(18, 24, 38, 0.98) !important;
        }

        html[data-aui-theme="dark"] .aui-context-shell > div {
            background: #0f1726 !important;
        }

        html[data-aui-theme="dark"] .aui-context-shell .aui-main {
            background: #11192a !important;
        }

        html[data-aui-theme="dark"] .aui-context-shell .aui-sidebar,
        html[data-aui-theme="dark"] .aui-context-shell nav[class*='bg-slate-950'],
        html[data-aui-theme="dark"] .aui-context-shell nav[class*='bg-slate-900'] {
            background: #121a2b !important;
        }

        html[data-aui-theme="dark"] .aui-context-shell section[class*='rounded-3xl'],
        html[data-aui-theme="dark"] .aui-context-shell div[class*='rounded-3xl'][class*='border'],
        html[data-aui-theme="dark"] .aui-context-shell div[class*='rounded-2xl'][class*='border'] {
            border-color: rgba(148, 163, 184, 0.14) !important;
        }

        html[data-aui-theme="dark"] .aui-context-shell section[class*='rounded-3xl'] {
            background: #151f31 !important;
        }

        html[data-aui-theme="dark"] .aui-context-shell table,
        html[data-aui-theme="dark"] .aui-context-shell div[class*='bg-slate-900/70'],
        html[data-aui-theme="dark"] .aui-context-shell div[class*='bg-slate-900/85'],
        html[data-aui-theme="dark"] .aui-context-shell div[class*='bg-slate-900/80'] {
            background: #182235 !important;
        }

        html[data-aui-theme="dark"] .aui-context-shell thead[class*='bg-slate-900/90'] {
            background: #1d2940 !important;
        }

        html[data-aui-theme="dark"] .aui-context-shell tbody[class*='divide-white/10'] {
            border-color: rgba(148, 163, 184, 0.12) !important;
        }

        html[data-aui-theme="dark"] .aui-context-shell tbody[class*='divide-white/10'] tr {
            border-color: rgba(148, 163, 184, 0.12) !important;
        }

        html[data-aui-theme="dark"] .aui-context-shell form[class*='rounded-xl'],
        html[data-aui-theme="dark"] .aui-context-shell div[class*='rounded-xl'][class*='bg-slate-900/70'] {
            background: #172133 !important;
            border-color: rgba(148, 163, 184, 0.16) !important;
        }

        html[data-aui-theme="dark"] .aui-context-shell button[class*='bg-white/5'] {
            background: #1b263a !important;
            border-color: rgba(148, 163, 184, 0.14) !important;
        }

        html[data-aui-theme="dark"] .aui-context-shell .aui-primary-soft-bg {
            background-color: rgba(47, 106, 157, 0.22) !important;
        }
    </style>

    <x-ui-kit::templates.app-shell
        :title="$title"
        :subtitle="$subtitle"
        sidebar-collapse-mode="hidden"
        :active-primary-section="$section"
        right-sidebar-collapse-mode="hidden"
        :active-right-primary-section="$activeHelperPanel"
        :right-sidebar-collapsed="true"
    >
        @if (! empty($primaryRailItems))
            <x-slot:primaryRail>
                <x-ui-kit::organisms.primary-rail :items="$primaryRailItems" />
            </x-slot:primaryRail>
        @endif

        @if (! empty($secondaryItems))
            <x-slot:sidebar>
                @foreach ($secondaryItems as $secondaryKey => $items)
                    <div x-show="activePrimarySection === '{{ $secondaryKey }}'" x-cloak>
                        <x-ui-kit::organisms.sidebar :items="$items" />
                    </div>
                @endforeach
            </x-slot:sidebar>
        @endif

        @if (! empty($helperPanels))
            <x-slot:rightSidebar>
                @foreach ($helperPanels as $panelKey => $panel)
                    <div x-show="activeRightPrimarySection === '{{ $panelKey }}'" x-cloak>
                        <x-ui-kit::organisms.sidebar
                            side="right"
                            variant="panel"
                            :eyebrow="$panel['eyebrow'] ?? null"
                            :title="$panel['title'] ?? null"
                            :subtitle="$panel['subtitle'] ?? null"
                        >
                            <x-slot:actions>
                                <button
                                    type="button"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-full transition"
                                    :class="theme === 'dark' ? 'text-slate-300 hover:bg-white/10' : 'text-slate-600 hover:bg-slate-100'"
                                    @click="rightSidebarCollapsed = true; hoverRightPrimarySection = null"
                                    aria-label="Close helper panel"
                                >
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </x-slot:actions>

                            <div class="space-y-4">
                                @foreach ($panel['blocks'] ?? [] as $block)
                                    @if (($block['type'] ?? null) === 'timeline')
                                        @php
                                            $items = $block['items'] ?? [];
                                            $highlightFirst = (bool) ($block['highlight_first'] ?? false);
                                            $featured = $highlightFirst ? ($items[0] ?? null) : null;
                                            $rest = $highlightFirst ? array_slice($items, 1) : $items;
                                        @endphp
                                        <div class="rounded-3xl border p-4" :class="theme === 'dark' ? 'border-white/10 bg-white/5' : 'border-slate-200 bg-slate-50/80'">
                                            @if (! empty($block['title']))
                                                <p class="text-xs font-semibold uppercase tracking-[0.2em]" :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'">{{ $block['title'] }}</p>
                                            @endif
                                            <div class="mt-4 space-y-4">
                                                @if ($featured)
                                                    <div class="rounded-2xl px-4 py-3" style="background-color: color-mix(in srgb, var(--aui-primary) 16%, transparent);">
                                                        <p class="text-sm font-semibold" :class="theme === 'dark' ? 'text-white' : 'text-slate-900'">{{ $featured['title'] ?? '' }}</p>
                                                        @if (! empty($featured['meta']))
                                                            <p class="mt-1 text-xs" :class="theme === 'dark' ? 'text-slate-300' : 'text-slate-600'">{{ $featured['meta'] }}</p>
                                                        @endif
                                                    </div>
                                                @endif
                                                <div class="space-y-3">
                                                    @foreach ($rest as $item)
                                                        <div class="flex gap-3">
                                                            <span class="mt-1 h-2.5 w-2.5 rounded-full {{
                                                                ($item['tone'] ?? null) === 'green'
                                                                    ? 'bg-emerald-500'
                                                                    : (($item['tone'] ?? null) === 'amber' ? 'bg-amber-500' : 'bg-sky-500')
                                                            }}"></span>
                                                            <div>
                                                                <p class="text-sm font-medium" :class="theme === 'dark' ? 'text-slate-100' : 'text-slate-800'">{{ $item['title'] ?? '' }}</p>
                                                                @if (! empty($item['meta']))
                                                                    <p class="text-xs" :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'">{{ $item['meta'] }}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @elseif (($block['type'] ?? null) === 'stat-grid')
                                        <div class="grid gap-3 sm:grid-cols-2">
                                            @foreach ($block['items'] ?? [] as $item)
                                                <div class="rounded-2xl border p-4" :class="theme === 'dark' ? 'border-white/10 bg-white/5' : 'border-slate-200 bg-slate-50/80'">
                                                    <p class="text-xs uppercase tracking-[0.2em]" :class="theme === 'dark' ? 'text-slate-500' : 'text-slate-400'">{{ $item['label'] ?? '' }}</p>
                                                    <p class="mt-2 text-lg font-semibold" :class="theme === 'dark' ? 'text-white' : 'text-slate-900'">{{ $item['value'] ?? '' }}</p>
                                                    @if (! empty($item['meta']))
                                                        <p class="mt-1 text-sm" :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'">{{ $item['meta'] }}</p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @elseif (($block['type'] ?? null) === 'key-value')
                                        <div class="rounded-3xl border p-4" :class="theme === 'dark' ? 'border-white/10 bg-white/5' : 'border-slate-200 bg-white'">
                                            @if (! empty($block['title']))
                                                <p class="text-sm font-semibold" :class="theme === 'dark' ? 'text-slate-100' : 'text-slate-800'">{{ $block['title'] }}</p>
                                            @endif
                                            <dl class="mt-4 space-y-3 text-sm">
                                                @foreach ($block['items'] ?? [] as $item)
                                                    <div class="flex items-center justify-between gap-4">
                                                        <dt :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'">{{ $item['label'] ?? '' }}</dt>
                                                        <dd class="font-medium {{ $item['value_class'] ?? '' }}" :class="theme === 'dark' ? 'text-slate-100' : 'text-slate-800'">{{ $item['value'] ?? '' }}</dd>
                                                    </div>
                                                @endforeach
                                            </dl>
                                        </div>
                                    @elseif (($block['type'] ?? null) === 'preferences')
                                        <div class="rounded-3xl border p-4" :class="theme === 'dark' ? 'border-white/10 bg-white/5' : 'border-slate-200 bg-white'">
                                            @if (! empty($block['title']))
                                                <p class="text-sm font-semibold" :class="theme === 'dark' ? 'text-slate-100' : 'text-slate-800'">{{ $block['title'] }}</p>
                                            @endif
                                            <div class="mt-4 space-y-4">
                                                @foreach ($block['items'] ?? [] as $item)
                                                    <label class="flex items-start justify-between gap-4">
                                                        <div>
                                                            <p class="text-sm font-medium" :class="theme === 'dark' ? 'text-slate-100' : 'text-slate-800'">{{ $item['label'] ?? '' }}</p>
                                                            @if (! empty($item['description']))
                                                                <p class="text-xs" :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'">{{ $item['description'] }}</p>
                                                            @endif
                                                        </div>
                                                        <span
                                                            class="mt-0.5 inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $item['badge_class'] ?? '' }}"
                                                            :class="theme === 'dark' ? 'text-white' : 'text-slate-900'"
                                                        >{{ $item['badge'] ?? '' }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @elseif (($block['type'] ?? null) === 'button' && ! empty($block['label']))
                                        <button
                                            type="button"
                                            class="inline-flex w-full items-center justify-center rounded-2xl px-4 py-3 text-sm font-semibold text-white transition"
                                            style="background-color: {{ $block['background'] ?? 'var(--aui-primary)' }};"
                                        >
                                            {{ $block['label'] }}
                                        </button>
                                    @endif
                                @endforeach
                            </div>
                        </x-ui-kit::organisms.sidebar>
                    </div>
                @endforeach
            </x-slot:rightSidebar>

            <x-slot:rightPrimaryRail>
                <x-ui-kit::organisms.primary-rail side="right" :items="$helperRailItems" />
            </x-slot:rightPrimaryRail>
        @endif

        <x-slot:header>
            <div class="flex min-h-[var(--aui-header-height)] w-full items-center gap-4 px-6 py-4 lg:px-8">
                <div class="flex items-center gap-3">
                    <button
                        type="button"
                        @click="sidebarOpen = !sidebarOpen"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-full text-slate-600 transition hover:bg-slate-100 lg:hidden"
                        :class="theme === 'dark' ? 'text-slate-300 hover:bg-white/10' : 'text-slate-600 hover:bg-slate-100'"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16"/>
                        </svg>
                    </button>
                    <button
                        type="button"
                        @click="sidebarCollapsed = !sidebarCollapsed"
                        class="hidden h-10 w-10 items-center justify-center rounded-full text-slate-600 transition hover:bg-slate-100 lg:inline-flex"
                        :class="theme === 'dark' ? 'text-slate-300 hover:bg-white/10' : 'text-slate-600 hover:bg-slate-100'"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16"/>
                        </svg>
                    </button>

                    @if ($brandLogo || $brandName || $brandSubtitle)
                        <div class="flex min-w-0 items-center gap-3">
                            @if ($brandLogo)
                                <img src="{{ $brandLogo }}" alt="{{ $brandName ?? 'Brand' }}" class="h-8 w-auto shrink-0 object-contain">
                            @endif
                            <div class="min-w-0">
                                @if ($brandName)
                                    <p class="truncate text-base font-semibold" :class="theme === 'dark' ? 'text-slate-100' : 'text-slate-800'">
                                        {{ $brandName }}
                                    </p>
                                @endif
                                @if ($brandSubtitle)
                                    <p class="truncate text-xs" :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'">
                                        {{ $brandSubtitle }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="hidden md:block md:w-[30rem] md:pl-4">
                        <x-ui-kit::molecules.search-bar
                            :placeholder="$searchPlaceholder"
                            :action="$searchAction"
                            name="q"
                            :value="$searchQuery"
                        />
                    </div>
                </div>

                <div class="ml-auto flex items-center gap-2">
                    @if ($statusLabel)
                        <div
                            class="hidden items-center gap-2 rounded-full border px-3 py-2 text-sm shadow-sm sm:inline-flex"
                            :class="theme === 'dark' ? 'border-white/10 bg-white/5 text-slate-200' : 'border-slate-200 bg-white text-slate-700'"
                        >
                            <span class="h-2.5 w-2.5 rounded-full" style="background-color: var(--aui-accent);"></span>
                            <span>{{ $statusLabel }}</span>
                        </div>
                    @endif

                    @if ($primaryActionLabel)
                        <x-ui-kit::atoms.action-button variant="primary" :label="$primaryActionLabel" />
                    @endif

                </div>
            </div>
        </x-slot:header>

        <div class="space-y-8">
            {{ $slot }}
        </div>

        @if (! empty($helperPanels))
            <div class="pointer-events-none fixed bottom-5 right-5 z-50 hidden lg:block">
                <button
                    type="button"
                    class="pointer-events-auto inline-flex h-11 w-11 items-center justify-center rounded-full border shadow-lg transition"
                    :class="theme === 'dark'
                        ? 'border-white/10 bg-slate-900/95 text-slate-200 hover:bg-slate-800'
                        : 'border-slate-200 bg-white text-slate-700 hover:bg-slate-50'"
                    @click="
                        if (rightSidebarVisible) {
                            rightSidebarVisible = false;
                        } else {
                            rightSidebarVisible = true;
                            if (!activeRightPrimarySection) activeRightPrimarySection = '{{ $activeHelperPanel }}';
                        }
                    "
                    :aria-label="rightSidebarVisible ? 'Collapse helper panel' : 'Expand helper panel'"
                    title="Toggle helper panel"
                >
                    <svg
                        class="h-5 w-5 transition-transform duration-200"
                        :class="rightSidebarVisible ? '' : 'rotate-180'"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        @endif
    </x-ui-kit::templates.app-shell>
</div>
