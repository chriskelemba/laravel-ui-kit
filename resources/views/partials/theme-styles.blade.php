@php
    $themeColors = array_merge(
        config('ui-kit.theme.colors', []),
        $themeColors ?? [],
        $theme ?? []
    );

    $sidebarDefaults = config('ui-kit.theme.sidebars', []);
    $leftSidebarTheme = array_merge($sidebarDefaults['left'] ?? [], $leftSidebarTheme ?? []);
    $rightSidebarTheme = array_merge($sidebarDefaults['right'] ?? [], $rightSidebarTheme ?? []);
@endphp

<style>
    :root {
        --aui-primary: {{ $themeColors['primary'] ?? '#2563eb' }};
        --aui-secondary: {{ $themeColors['secondary'] ?? '#0f172a' }};
        --aui-secondary-hover: {{ $themeColors['secondary_hover'] ?? '#1e293b' }};
        --aui-secondary-soft: {{ $themeColors['secondary_soft'] ?? 'rgba(15, 23, 42, 0.08)' }};
        --aui-secondary-contrast: {{ $themeColors['secondary_contrast'] ?? '#ffffff' }};
        --aui-primary-hover: {{ $themeColors['primary_hover'] ?? '#1d4ed8' }};
        --aui-primary-soft: {{ $themeColors['primary_soft'] ?? 'rgba(37, 99, 235, 0.14)' }};
        --aui-primary-softer: {{ $themeColors['primary_softer'] ?? 'rgba(37, 99, 235, 0.08)' }};
        --aui-primary-contrast: {{ $themeColors['primary_contrast'] ?? '#ffffff' }};
        --aui-accent: {{ $themeColors['accent'] ?? '#7c3aed' }};
        --aui-accent-soft: {{ $themeColors['accent_soft'] ?? 'rgba(124, 58, 237, 0.16)' }};
        --aui-success: {{ $themeColors['success'] ?? '#16a34a' }};
        --aui-success-soft: {{ $themeColors['success_soft'] ?? 'rgba(22, 163, 74, 0.14)' }};
        --aui-warning: {{ $themeColors['warning'] ?? '#d97706' }};
        --aui-warning-soft: {{ $themeColors['warning_soft'] ?? 'rgba(217, 119, 6, 0.14)' }};
        --aui-danger: {{ $themeColors['danger'] ?? '#e11d48' }};
        --aui-danger-soft: {{ $themeColors['danger_soft'] ?? 'rgba(225, 29, 72, 0.14)' }};
        --aui-sidebar-left-bg: {{ $leftSidebarTheme['background'] ?? '#ffffff' }};
        --aui-sidebar-left-border: {{ $leftSidebarTheme['border'] ?? 'rgba(226, 232, 240, 0.9)' }};
        --aui-sidebar-left-title: {{ $leftSidebarTheme['title'] ?? '#64748b' }};
        --aui-sidebar-left-text: {{ $leftSidebarTheme['text'] ?? '#475569' }};
        --aui-sidebar-left-muted: {{ $leftSidebarTheme['muted'] ?? '#94a3b8' }};
        --aui-sidebar-left-hover-bg: {{ $leftSidebarTheme['hover_background'] ?? '#eff6ff' }};
        --aui-sidebar-left-hover-text: {{ $leftSidebarTheme['hover_text'] ?? '#0f172a' }};
        --aui-sidebar-left-active-bg: {{ $leftSidebarTheme['active_background'] ?? 'linear-gradient(to right, rgba(37, 99, 235, 0.08), rgba(124, 58, 237, 0.12))' }};
        --aui-sidebar-left-active-text: {{ $leftSidebarTheme['active_text'] ?? '#0f172a' }};
        --aui-sidebar-left-icon-bg: {{ $leftSidebarTheme['icon_background'] ?? '#f8fafc' }};
        --aui-sidebar-left-icon-text: {{ $leftSidebarTheme['icon_text'] ?? '#475569' }};
        --aui-sidebar-left-badge-bg: {{ $leftSidebarTheme['badge_background'] ?? '#f1f5f9' }};
        --aui-sidebar-left-badge-text: {{ $leftSidebarTheme['badge_text'] ?? '#64748b' }};
        --aui-sidebar-left-indicator: {{ $leftSidebarTheme['indicator'] ?? 'linear-gradient(to bottom, #2563eb, #7c3aed)' }};
        --aui-sidebar-left-rail-text: {{ $leftSidebarTheme['rail_text'] ?? '#64748b' }};
        --aui-sidebar-left-rail-hover-text: {{ $leftSidebarTheme['rail_hover_text'] ?? '#0f172a' }};
        --aui-sidebar-left-rail-active-text: {{ $leftSidebarTheme['rail_active_text'] ?? '#0f172a' }};
        --aui-sidebar-left-rail-icon-bg: {{ $leftSidebarTheme['rail_icon_background'] ?? '#ffffff' }};
        --aui-sidebar-left-rail-icon-hover-bg: {{ $leftSidebarTheme['rail_icon_hover_background'] ?? '#eff6ff' }};
        --aui-sidebar-left-rail-icon-hover-text: {{ $leftSidebarTheme['rail_icon_hover_text'] ?? '#2563eb' }};
        --aui-sidebar-left-rail-icon-active-bg: {{ $leftSidebarTheme['rail_icon_active_background'] ?? '#dbeafe' }};
        --aui-sidebar-left-rail-icon-active-text: {{ $leftSidebarTheme['rail_icon_active_text'] ?? '#1d4ed8' }};
        --aui-sidebar-right-bg: {{ $rightSidebarTheme['background'] ?? '#ffffff' }};
        --aui-sidebar-right-border: {{ $rightSidebarTheme['border'] ?? 'rgba(226, 232, 240, 0.9)' }};
        --aui-sidebar-right-title: {{ $rightSidebarTheme['title'] ?? '#64748b' }};
        --aui-sidebar-right-text: {{ $rightSidebarTheme['text'] ?? '#475569' }};
        --aui-sidebar-right-muted: {{ $rightSidebarTheme['muted'] ?? '#94a3b8' }};
        --aui-sidebar-right-hover-bg: {{ $rightSidebarTheme['hover_background'] ?? '#eff6ff' }};
        --aui-sidebar-right-hover-text: {{ $rightSidebarTheme['hover_text'] ?? '#0f172a' }};
        --aui-sidebar-right-active-bg: {{ $rightSidebarTheme['active_background'] ?? 'linear-gradient(to right, rgba(37, 99, 235, 0.08), rgba(124, 58, 237, 0.12))' }};
        --aui-sidebar-right-active-text: {{ $rightSidebarTheme['active_text'] ?? '#0f172a' }};
        --aui-sidebar-right-icon-bg: {{ $rightSidebarTheme['icon_background'] ?? '#f8fafc' }};
        --aui-sidebar-right-icon-text: {{ $rightSidebarTheme['icon_text'] ?? '#475569' }};
        --aui-sidebar-right-badge-bg: {{ $rightSidebarTheme['badge_background'] ?? '#f1f5f9' }};
        --aui-sidebar-right-badge-text: {{ $rightSidebarTheme['badge_text'] ?? '#64748b' }};
        --aui-sidebar-right-indicator: {{ $rightSidebarTheme['indicator'] ?? 'linear-gradient(to bottom, #2563eb, #7c3aed)' }};
        --aui-sidebar-right-rail-text: {{ $rightSidebarTheme['rail_text'] ?? '#64748b' }};
        --aui-sidebar-right-rail-hover-text: {{ $rightSidebarTheme['rail_hover_text'] ?? '#0f172a' }};
        --aui-sidebar-right-rail-active-text: {{ $rightSidebarTheme['rail_active_text'] ?? '#0f172a' }};
        --aui-sidebar-right-rail-icon-bg: {{ $rightSidebarTheme['rail_icon_background'] ?? '#ffffff' }};
        --aui-sidebar-right-rail-icon-hover-bg: {{ $rightSidebarTheme['rail_icon_hover_background'] ?? '#eff6ff' }};
        --aui-sidebar-right-rail-icon-hover-text: {{ $rightSidebarTheme['rail_icon_hover_text'] ?? '#2563eb' }};
        --aui-sidebar-right-rail-icon-active-bg: {{ $rightSidebarTheme['rail_icon_active_background'] ?? '#dbeafe' }};
        --aui-sidebar-right-rail-icon-active-text: {{ $rightSidebarTheme['rail_icon_active_text'] ?? '#1d4ed8' }};
    }

    .aui-primary-bg {
        background-color: var(--aui-primary);
        color: var(--aui-primary-contrast);
    }

    .aui-primary-bg:hover {
        background-color: var(--aui-primary-hover);
    }

    .aui-danger-bg {
        background-color: var(--aui-danger);
        color: #fff;
    }

    .aui-danger-bg:hover {
        background-color: color-mix(in srgb, var(--aui-danger) 88%, black);
    }

    .aui-primary-text {
        color: var(--aui-primary);
    }

    .aui-primary-soft-bg {
        background-color: var(--aui-primary-soft);
    }

    .aui-primary-softest-bg {
        background-color: var(--aui-primary-softer);
    }

    .aui-primary-border {
        border-color: var(--aui-primary-soft);
    }

    .aui-primary-ring {
        --tw-ring-color: var(--aui-primary-soft);
    }

    .aui-primary-gradient {
        background-image: linear-gradient(to right, var(--aui-primary), var(--aui-accent));
        color: var(--aui-primary-contrast);
    }

    .aui-primary-gradient-soft {
        background-image: linear-gradient(to bottom right, var(--aui-primary-soft), var(--aui-accent-soft));
    }

    .aui-primary-shadow {
        box-shadow: 0 10px 30px -12px var(--aui-primary-soft);
    }

    .aui-primary-shadow:hover {
        box-shadow: 0 18px 40px -18px var(--aui-primary);
    }

    .aui-chart-gradient {
        background-image: linear-gradient(to top, var(--aui-primary), var(--aui-accent));
    }

    .aui-primary-fill {
        fill: var(--aui-primary);
    }

    .aui-primary-stroke {
        stroke: var(--aui-primary);
    }

    .aui-accent-fill {
        fill: var(--aui-accent);
    }

    .aui-accent-stroke {
        stroke: var(--aui-accent);
    }

    .aui-status-success {
        color: var(--aui-success);
        background-color: var(--aui-success-soft);
    }

    .aui-status-warning {
        color: var(--aui-warning);
        background-color: var(--aui-warning-soft);
    }

    .aui-status-danger {
        color: var(--aui-danger);
        background-color: var(--aui-danger-soft);
    }

    .aui-alert-info {
        color: var(--aui-primary);
        border-color: var(--aui-primary-soft);
        background-color: var(--aui-primary-softer);
    }

    .aui-alert-success {
        color: var(--aui-success);
        border-color: var(--aui-success-soft);
        background-color: color-mix(in srgb, var(--aui-success) 8%, transparent);
    }

    .aui-alert-warning {
        color: var(--aui-warning);
        border-color: var(--aui-warning-soft);
        background-color: color-mix(in srgb, var(--aui-warning) 8%, transparent);
    }

    .aui-alert-danger {
        color: var(--aui-danger);
        border-color: var(--aui-danger-soft);
        background-color: color-mix(in srgb, var(--aui-danger) 8%, transparent);
    }

    .aui-sidebar-surface-left {
        background-color: var(--aui-sidebar-left-bg);
        border-color: var(--aui-sidebar-left-border);
    }

    .aui-sidebar-surface-right {
        background-color: var(--aui-sidebar-right-bg);
        border-color: var(--aui-sidebar-right-border);
    }

    .aui-sidebar-title-left {
        color: var(--aui-sidebar-left-title);
    }

    .aui-sidebar-title-right {
        color: var(--aui-sidebar-right-title);
    }

    .aui-sidebar-link-left {
        color: var(--aui-sidebar-left-text);
    }

    .aui-sidebar-link-left:hover {
        background: var(--aui-sidebar-left-hover-bg);
        color: var(--aui-sidebar-left-hover-text);
    }

    .aui-sidebar-link-left.is-active {
        color: var(--aui-sidebar-left-active-text);
    }

    .aui-sidebar-link-left.aui-sidebar-active {
        background: var(--aui-sidebar-left-active-bg);
    }

    .aui-sidebar-link-right {
        color: var(--aui-sidebar-right-text);
    }

    .aui-sidebar-link-right:hover {
        background: var(--aui-sidebar-right-hover-bg);
        color: var(--aui-sidebar-right-hover-text);
    }

    .aui-sidebar-link-right.is-active {
        color: var(--aui-sidebar-right-active-text);
    }

    .aui-sidebar-link-right.aui-sidebar-active {
        background: var(--aui-sidebar-right-active-bg);
    }

    .aui-sidebar-icon-left {
        background-color: var(--aui-sidebar-left-icon-bg);
        color: var(--aui-sidebar-left-icon-text);
    }

    .aui-sidebar-icon-right {
        background-color: var(--aui-sidebar-right-icon-bg);
        color: var(--aui-sidebar-right-icon-text);
    }

    .aui-sidebar-badge-left {
        background-color: var(--aui-sidebar-left-badge-bg);
        color: var(--aui-sidebar-left-badge-text);
    }

    .aui-sidebar-badge-right {
        background-color: var(--aui-sidebar-right-badge-bg);
        color: var(--aui-sidebar-right-badge-text);
    }

    .aui-primary-rail-left {
        color: var(--aui-sidebar-left-rail-text);
    }

    .aui-primary-rail-left:hover,
    .aui-primary-rail-left:focus-visible,
    .aui-primary-rail-left.is-active {
        color: var(--aui-sidebar-left-rail-hover-text);
    }

    .aui-primary-rail-right {
        color: var(--aui-sidebar-right-rail-text);
    }

    .aui-primary-rail-right:hover,
    .aui-primary-rail-right:focus-visible,
    .aui-primary-rail-right.is-active {
        color: var(--aui-sidebar-right-rail-hover-text);
    }

    .aui-primary-rail-icon-left {
        background-color: var(--aui-sidebar-left-rail-icon-bg);
    }

    .aui-primary-rail-left:hover .aui-primary-rail-icon-left,
    .aui-primary-rail-left:focus-visible .aui-primary-rail-icon-left {
        background-color: var(--aui-sidebar-left-rail-icon-hover-bg);
        color: var(--aui-sidebar-left-rail-icon-hover-text);
    }

    .aui-primary-rail-left.is-active .aui-primary-rail-icon-left {
        background-color: var(--aui-sidebar-left-rail-icon-active-bg);
        color: var(--aui-sidebar-left-rail-icon-active-text);
    }

    .aui-primary-rail-icon-right {
        background-color: var(--aui-sidebar-right-rail-icon-bg);
    }

    .aui-primary-rail-right:hover .aui-primary-rail-icon-right,
    .aui-primary-rail-right:focus-visible .aui-primary-rail-icon-right {
        background-color: var(--aui-sidebar-right-rail-icon-hover-bg);
        color: var(--aui-sidebar-right-rail-icon-hover-text);
    }

    .aui-primary-rail-right.is-active .aui-primary-rail-icon-right {
        background-color: var(--aui-sidebar-right-rail-icon-active-bg);
        color: var(--aui-sidebar-right-rail-icon-active-text);
    }

    .aui-sidebar-active-indicator {
        background-image: var(--aui-sidebar-left-indicator);
    }

    .aui-sidebar-active-indicator-right {
        background-image: var(--aui-sidebar-right-indicator);
    }

    .aui-focus:focus {
        border-color: var(--aui-primary);
    }

    .aui-focus:focus,
    .aui-focus:focus-visible {
        --tw-ring-color: var(--aui-primary-soft);
    }
</style>
