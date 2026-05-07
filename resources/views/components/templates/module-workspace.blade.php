@props([
    'title' => null,
    'subtitle' => null,
    'section' => null,
    'subnav' => null,
    'pageEyebrow' => null,
    'pageHeading' => null,
    'pageDescription' => null,
    'navigation' => [],
    'navigationBadges' => [],
    'sidebarWidth' => '17rem',
    'sidebarCollapsed' => false,
    'sidebarHoverExpandable' => true,
    'spotlightCards' => [],
    'listSection' => [],
    'asideBlocks' => [],
    'showRightSidebar' => true,
    'rightSidebarView' => 'details',
    'rightPanelHeaders' => [],
    'rightPanels' => [],
    'rightFooterActions' => [],
    'showRightPrimaryRail' => false,
    'rightPrimaryRailItems' => [],
    'themeColors' => [],
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
    $navigation = collect($navigation);

    $resolvedSection = $section;
    $resolvedSubnav = $subnav;
    $currentRouteName = request()->route()?->getName();
    $currentUrl = url()->current();

    if (! filled($resolvedSection) || ! filled($resolvedSubnav)) {
        foreach ($navigation as $group) {
            $groupKey = $group['key'] ?? null;

            foreach ($group['items'] ?? [] as $item) {
                $matchesRoute = filled($currentRouteName) && (($item['route'] ?? null) === $currentRouteName);
                $matchesHref = filled($item['href'] ?? null) && url($item['href']) === $currentUrl;

                if ($matchesRoute || $matchesHref) {
                    $resolvedSection = $resolvedSection ?: $groupKey;
                    $resolvedSubnav = $resolvedSubnav ?: ($item['key'] ?? null);
                    break 2;
                }
            }
        }
    }

    $resolvedSection = $resolvedSection ?: ($navigation->first()['key'] ?? null);

    if (! filled($resolvedSubnav)) {
        $activeGroup = $navigation->firstWhere('key', $resolvedSection);
        $resolvedSubnav = $activeGroup['items'][0]['key'] ?? null;
    }

    $primaryRailItems = $navigation->map(fn (array $group) => [
        'key' => $group['key'] ?? null,
        'label' => $group['label'] ?? '',
        'href' => $group['href'] ?? '#',
        'icon' => $group['icon'] ?? null,
    ])->filter(fn (array $item) => filled($item['key']))->values()->all();

    $sidebarSections = $navigation->mapWithKeys(function (array $group) use ($navigationBadges) {
        $items = collect($group['items'] ?? [])->map(function (array $item) use ($navigationBadges) {
            $badgeKey = $item['badge_key'] ?? null;

            return [
                'key' => $item['key'] ?? null,
                'label' => $item['label'] ?? '',
                'href' => $item['href'] ?? '#',
                'route' => $item['route'] ?? null,
                'icon' => $item['icon'] ?? null,
                'badge' => $badgeKey ? ($navigationBadges[$badgeKey] ?? null) : ($item['badge'] ?? null),
            ];
        })->filter(fn (array $item) => filled($item['key']))->values()->all();

        return [
            $group['key'] => [
                'compose' => $group['compose'] ?? null,
                'items' => $items,
                'spaces_title' => $group['spaces_title'] ?? null,
                'spaces' => $group['spaces'] ?? [],
                'note_title' => $group['note_title'] ?? null,
                'note_body' => $group['note_body'] ?? null,
            ],
        ];
    })->all();

    $resolvedRightPanelHeaders = ! empty($rightPanelHeaders) ? $rightPanelHeaders : [
        $rightSidebarView => [
            'eyebrow' => 'DETAILS',
            'title' => 'Details',
            'description' => null,
        ],
    ];

    $resolvedRightPanels = ! empty($rightPanels) ? $rightPanels : [
        $rightSidebarView => [
            'blocks' => [
                [
                    'type' => 'detail',
                    'empty_state' => true,
                    'description' => 'Select an item to see the details.',
                ],
            ],
        ],
    ];
@endphp

<x-ui-kit::templates.workspace-shell
    :title="$title"
    :subtitle="$subtitle"
    :active-primary-section="$resolvedSection"
    :active-sidebar-item="$resolvedSubnav"
    :page-eyebrow="$pageEyebrow"
    :page-heading="$pageHeading"
    :page-description="$pageDescription"
    :primary-rail-items="$primaryRailItems"
    :sidebar-sections="$sidebarSections"
    :sidebar-width="$sidebarWidth"
    :sidebar-collapsed="$sidebarCollapsed"
    :sidebar-hover-expandable="$sidebarHoverExpandable"
    :spotlight-cards="$spotlightCards"
    :list-section="$listSection"
    :aside-blocks="$asideBlocks"
    :right-sidebar-view="$rightSidebarView"
    :right-primary-rail-items="$rightPrimaryRailItems"
    :right-panel-headers="$resolvedRightPanelHeaders"
    :right-panels="$resolvedRightPanels"
    :right-footer-actions="$rightFooterActions"
    :theme-colors="$themeColors"
    :show-right-sidebar="$showRightSidebar"
    :show-right-primary-rail="$showRightPrimaryRail"
    :profile-user="$profileUser"
    :profile-name="$profileName"
    :profile-email="$profileEmail"
    :profile-avatar-src="$profileAvatarSrc"
    :profile-edit-href="$profileEditHref"
    :profile-logout-href="$profileLogoutHref"
    :profile-edit-route="$profileEditRoute"
    :profile-logout-route="$profileLogoutRoute"
>
    @isset($brand)
        <x-slot:brand>
            {{ $brand }}
        </x-slot:brand>
    @endisset

    @isset($actions)
        <x-slot:actions>
            {{ $actions }}
        </x-slot:actions>
    @endisset

    @isset($rightSidebarHeader)
        <x-slot:rightSidebarHeader>
            {{ $rightSidebarHeader }}
        </x-slot:rightSidebarHeader>
    @endisset

    @isset($rightSidebarContent)
        <x-slot:rightSidebarContent>
            {{ $rightSidebarContent }}
        </x-slot:rightSidebarContent>
    @endisset

    @isset($floating)
        <x-slot:floating>
            {{ $floating }}
        </x-slot:floating>
    @endisset

    {{ $slot }}
</x-ui-kit::templates.workspace-shell>
