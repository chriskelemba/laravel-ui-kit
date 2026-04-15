<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', config('app.name'))</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @php
            $uiKitCss = config('ui-kit.assets.css.src', 'ui-kit/assets/ui-kit.css');
            $uiKitCssEnabled = config('ui-kit.assets.css.enabled', true) && $uiKitCss;
            $uiKitCssVersion = class_exists(\Composer\InstalledVersions::class)
                ? \Composer\InstalledVersions::getPrettyVersion('chriskelemba/laravel-ui-kit')
                : null;
            $hasViteAssets = file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot'));
        @endphp

        @if ($hasViteAssets)
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        @if ($uiKitCssEnabled && (! $hasViteAssets || config('ui-kit.assets.css.load_with_vite', false)))
            <link rel="stylesheet" href="{{ url($uiKitCss) }}@if($uiKitCssVersion)?v={{ $uiKitCssVersion }}@endif">
        @endif

        @if (config('ui-kit.icons.font_awesome.enabled', true))
            <link rel="stylesheet" href="{{ config('ui-kit.icons.font_awesome.src') }}">
        @endif

        <script>
            (function () {
                try {
                    var theme = localStorage.getItem('aui-theme') || 'light';
                    document.documentElement.setAttribute('data-aui-theme', theme);
                } catch (e) {
                    // Ignore read/write errors (e.g. private mode)
                }
            })();
        </script>
        @include('ui-kit::partials.theme-styles')
        <style>
            :root { --aui-header-height: 4.75rem; }
            html[data-aui-theme="dark"] body { background-color: #0f172a; color: #e2e8f0; }
            html[data-aui-theme="light"] body { background-color: #f6f8fc; color: #1f2937; }
            html[data-aui-theme="dark"] .aui-sidebar { background-color: rgba(15, 23, 42, 0.95); border-color: rgba(255, 255, 255, 0.05); }
            html[data-aui-theme="light"] .aui-sidebar { background-color: rgba(255, 255, 255, 0.92); border-color: rgba(226, 232, 240, 0.9); }
            html[data-aui-theme="dark"] .aui-overlay { background-color: rgba(0, 0, 0, 0.7); }
            html[data-aui-theme="light"] .aui-overlay { background-color: rgba(15, 23, 42, 0.4); }
            html[data-aui-theme="dark"] .aui-sidebar-title { color: #64748b; }
            html[data-aui-theme="light"] .aui-sidebar-title { color: #6b7280; }
            html[data-aui-theme="dark"] .aui-sidebar-link { color: #94a3b8; }
            html[data-aui-theme="dark"] .aui-sidebar-link:hover { background-color: rgba(255, 255, 255, 0.05); color: #ffffff; }
            html[data-aui-theme="dark"] .aui-sidebar-link.is-active { color: #ffffff; }
            html[data-aui-theme="light"] .aui-sidebar-link { color: #4b5563; }
            html[data-aui-theme="light"] .aui-sidebar-link:hover { background-color: #eef2ff; color: #111827; }
            html[data-aui-theme="light"] .aui-sidebar-link.is-active { color: #111827; }
            .aui-shell-body { display: flex; min-height: calc(100vh - var(--aui-header-height)); }
            .aui-sidebar { flex-shrink: 0; z-index: 40; }
            .aui-main { flex: 1; min-height: calc(100vh - var(--aui-header-height)); padding: 2rem 1.5rem; }
            @media (min-width: 1024px) {
                .aui-main { padding-left: 2rem; padding-right: 2rem; }
            }
            [x-cloak] { display: none !important; }
        </style>

        @stack('head')
    </head>
    <body class="min-h-screen">
        @yield('content')

        @if (config('ui-kit.alpine.enabled'))
            <script
                src="{{ config('ui-kit.alpine.src') }}"
                @if (config('ui-kit.alpine.defer', true)) defer @endif
            ></script>
        @endif
        @stack('scripts')
    </body>
</html>
