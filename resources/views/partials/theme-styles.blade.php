@php
    $colors = config('ui-kit.theme.colors', []);
@endphp

<style>
    :root {
        --aui-primary: {{ $colors['primary'] ?? '#2563eb' }};
        --aui-primary-hover: {{ $colors['primary_hover'] ?? '#1d4ed8' }};
        --aui-primary-soft: {{ $colors['primary_soft'] ?? 'rgba(37, 99, 235, 0.14)' }};
        --aui-primary-softer: {{ $colors['primary_softer'] ?? 'rgba(37, 99, 235, 0.08)' }};
        --aui-primary-contrast: {{ $colors['primary_contrast'] ?? '#ffffff' }};
        --aui-accent: {{ $colors['accent'] ?? '#7c3aed' }};
        --aui-accent-soft: {{ $colors['accent_soft'] ?? 'rgba(124, 58, 237, 0.16)' }};
        --aui-success: {{ $colors['success'] ?? '#16a34a' }};
        --aui-success-soft: {{ $colors['success_soft'] ?? 'rgba(22, 163, 74, 0.14)' }};
        --aui-warning: {{ $colors['warning'] ?? '#d97706' }};
        --aui-warning-soft: {{ $colors['warning_soft'] ?? 'rgba(217, 119, 6, 0.14)' }};
        --aui-danger: {{ $colors['danger'] ?? '#e11d48' }};
        --aui-danger-soft: {{ $colors['danger_soft'] ?? 'rgba(225, 29, 72, 0.14)' }};
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

    .aui-sidebar-active {
        background-image: linear-gradient(to right, var(--aui-primary-softer), color-mix(in srgb, var(--aui-accent) 12%, transparent));
    }

    .aui-primary-rail-icon-active {
        background-color: color-mix(in srgb, var(--aui-accent) 18%, white 82%);
        color: color-mix(in srgb, var(--aui-accent) 78%, black 22%);
    }

    .group:hover .aui-primary-rail-icon-hoverable,
    .group:focus-visible .aui-primary-rail-icon-hoverable {
        background-color: color-mix(in srgb, var(--aui-accent) 10%, white 90%);
        color: color-mix(in srgb, var(--aui-accent) 66%, black 18%);
    }

    .group:hover .aui-primary-rail-icon-active,
    .group:focus-visible .aui-primary-rail-icon-active {
        background-color: color-mix(in srgb, var(--aui-accent) 18%, white 82%);
        color: color-mix(in srgb, var(--aui-accent) 78%, black 22%);
    }

    .aui-sidebar-active-indicator {
        background-image: linear-gradient(to bottom, var(--aui-primary), var(--aui-accent));
    }

    .aui-focus:focus {
        border-color: var(--aui-primary);
    }

    .aui-focus:focus,
    .aui-focus:focus-visible {
        --tw-ring-color: var(--aui-primary-soft);
    }
</style>
