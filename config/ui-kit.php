<?php

return [
    'component_prefix' => 'ui-kit',
    'branding' => [
        'logo' => null,
        'name' => env('APP_NAME', 'Laravel'),
        'subtitle' => null,
        'href' => '/',
    ],
    'alpine' => [
        'enabled' => true,
        'src' => 'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js',
        'defer' => true,
    ],
    'assets' => [
        'css' => [
            'enabled' => true,
            'src' => 'vendor/ui-kit/css/ui-kit.css',
            'load_with_vite' => true,
        ],
    ],
    'icons' => [
        'font_awesome' => [
            'enabled' => true,
            'src' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css',
        ],
        'aliases' => [
            'overview' => 'fa-solid fa-house',
            'home' => 'fa-solid fa-house',
            'dashboard' => 'fa-solid fa-house',
            'users' => 'fa-solid fa-users',
            'user' => 'fa-solid fa-user',
            'tasks' => 'fa-solid fa-list-check',
            'task' => 'fa-solid fa-list-check',
            'rbac' => 'fa-solid fa-shield-halved',
            'reminders' => 'fa-solid fa-bell',
            'buttons' => 'fa-solid fa-bars-staggered',
            'inputs' => 'fa-solid fa-keyboard',
            'forms' => 'fa-solid fa-file-lines',
            'navigation' => 'fa-solid fa-compass',
            'data' => 'fa-solid fa-table',
            'overlays' => 'fa-solid fa-clone',
            'feedback' => 'fa-solid fa-message',
            'lists' => 'fa-solid fa-list',
            'sidebar' => 'fa-solid fa-table-columns',
            'utilities' => 'fa-solid fa-screwdriver-wrench',
            'display' => 'fa-solid fa-display',
            'visuals' => 'fa-solid fa-chart-line',
            'meetings' => 'fa-solid fa-calendar-days',
            'approvals' => 'fa-solid fa-circle-check',
            'evaluations' => 'fa-solid fa-star',
            'board_calendar' => 'fa-solid fa-calendar-days',
            'upcoming_meetings' => 'fa-solid fa-calendar-week',
            'committees' => 'fa-solid fa-people-group',
            'minutes_archive' => 'fa-solid fa-box-archive',
            'pending_queue' => 'fa-solid fa-inbox',
            'delegations' => 'fa-solid fa-share-from-square',
            'history' => 'fa-solid fa-clock-rotate-left',
            'rules' => 'fa-solid fa-scale-balanced',
            'quarterly_reviews' => 'fa-solid fa-clipboard-check',
            'templates' => 'fa-solid fa-copy',
            'departments' => 'fa-solid fa-building',
            'calibration' => 'fa-solid fa-sliders',
            'activity' => 'fa-solid fa-arrow-trend-up',
            'details' => 'fa-solid fa-circle-info',
            'settings' => 'fa-solid fa-gear',
        ],
    ],
    'theme' => [
        'colors' => [
            'primary' => '#2563eb',
            'primary_hover' => '#1d4ed8',
            'primary_soft' => 'rgba(37, 99, 235, 0.14)',
            'primary_softer' => 'rgba(37, 99, 235, 0.08)',
            'primary_contrast' => '#ffffff',
            'accent' => '#7c3aed',
            'accent_soft' => 'rgba(124, 58, 237, 0.16)',
            'success' => '#16a34a',
            'success_soft' => 'rgba(22, 163, 74, 0.14)',
            'warning' => '#d97706',
            'warning_soft' => 'rgba(217, 119, 6, 0.14)',
            'danger' => '#e11d48',
            'danger_soft' => 'rgba(225, 29, 72, 0.14)',
        ],
    ],
    'auth' => [
        'layout' => 'split', // split | stacked
        'content_variant' => 'card', // card | panel
        'content_side' => 'right', // left | right | center
        'content_width' => 'md', // xs | sm | md | lg | xl | 2xl | 3xl | 4xl | half | full | custom css value
        'card_position' => 'center', // left | center | right
        'content_alignment' => 'center', // start | center | end
        'show_theme_toggle' => true,
        'panel_width' => '32rem',
        'background' => [
            'type' => 'solid', // solid | image
            'color' => '#0f172a',
            'image' => null,
            'position' => 'center',
            'size' => 'cover',
            'overlay' => 'rgba(15, 23, 42, 0.58)',
        ],
        'card' => [
            'max_width' => '30rem',
            'padding' => '2rem',
            'surface' => 'glass', // glass | solid | none
        ],
        'brand' => [
            'inherit' => true,
            'logo' => null,
            'name' => null,
            'subtitle' => null,
            'href' => null,
        ],
    ],
];
