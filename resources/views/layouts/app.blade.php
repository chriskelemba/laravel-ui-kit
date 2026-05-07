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
            document.documentElement.setAttribute('data-aui-theme', 'light');
        </script>
        @include('ui-kit::partials.theme-styles')
        <style>
            :root { --aui-header-height: 4.75rem; }
            html[data-aui-theme="light"] body { background-color: #f6f8fc; color: #1f2937; }
            html[data-aui-theme="light"] .aui-sidebar { background-color: var(--aui-sidebar-left-bg); border-color: var(--aui-sidebar-left-border); }
            html[data-aui-theme="light"] .aui-overlay { background-color: rgba(15, 23, 42, 0.4); }
            .aui-shell-body { display: flex; min-height: calc(100vh - var(--aui-header-height)); }
            .aui-sidebar { flex-shrink: 0; z-index: 40; }
            .aui-main { flex: 1; min-height: calc(100vh - var(--aui-header-height)); padding: 2rem 1.5rem; }
            @media (min-width: 1024px) {
                .aui-main { padding-left: 2rem; padding-right: 2rem; }
            }
            [x-cloak] { display: none !important; }
            .aui-page-loader[hidden] { display: none !important; }
        </style>

        @stack('head')
    </head>
    <body class="min-h-screen">
        <div id="aui-page-loader" class="aui-page-loader fixed inset-0 z-[120] hidden items-center justify-center bg-slate-950/18 backdrop-blur-[2px]">
            <div class="flex items-center gap-3 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-medium text-slate-700 shadow-2xl">
                <svg class="h-5 w-5 animate-spin text-slate-500" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-opacity="0.25" stroke-width="3"></circle>
                    <path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="3" stroke-linecap="round"></path>
                </svg>
                <span>Loading...</span>
            </div>
        </div>
        @yield('content')

        @if (config('ui-kit.alpine.enabled'))
            <script
                src="{{ config('ui-kit.alpine.src') }}"
                @if (config('ui-kit.alpine.defer', true)) defer @endif
            ></script>
        @endif
        <script>
            (() => {
                const loader = document.getElementById('aui-page-loader');
                if (!loader) return;

                const showLoader = () => {
                    loader.classList.remove('hidden');
                    loader.classList.add('flex');
                };

                window.addEventListener('aui:page-loading', showLoader);

                document.addEventListener('click', event => {
                    const link = event.target.closest('a[href]');
                    if (!link) return;

                    const href = link.getAttribute('href') || '';
                    const target = link.getAttribute('target');
                    const isHash = href.startsWith('#');
                    const isJs = href.toLowerCase().startsWith('javascript:');
                    const isDownload = link.hasAttribute('download');
                    const isNewTab = target === '_blank';
                    const isModified = event.metaKey || event.ctrlKey || event.shiftKey || event.altKey || event.button !== 0;

                    if (isHash || isJs || isDownload || isNewTab || isModified) return;

                    showLoader();
                });

                document.addEventListener('submit', event => {
                    if (event.target instanceof HTMLFormElement) {
                        showLoader();
                    }
                });

                window.addEventListener('pageshow', () => {
                    loader.classList.add('hidden');
                    loader.classList.remove('flex');
                });
            })();
        </script>
        @stack('scripts')
    </body>
</html>
