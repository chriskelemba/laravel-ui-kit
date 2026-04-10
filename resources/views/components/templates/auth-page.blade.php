@props([
    'title' => null,
    'subtitle' => null,
    'theme' => null,
    'layout' => null,
    'contentVariant' => null,
    'contentSide' => null,
    'contentWidth' => null,
    'cardPosition' => null,
    'contentAlignment' => null,
    'backgroundType' => null,
    'backgroundColor' => null,
    'backgroundImage' => null,
    'backgroundPosition' => null,
    'backgroundSize' => null,
    'backgroundOverlay' => null,
    'showThemeToggle' => null,
    'panelWidth' => null,
    'cardMaxWidth' => null,
    'cardPadding' => null,
    'cardSurface' => null,
    'cardBackground' => null,
    'cardBorderColor' => null,
    'cardTextColor' => null,
    'cardMutedColor' => null,
    'logoSrc' => null,
    'logoAlt' => null,
    'logoHref' => null,
    'brandName' => null,
    'brandSubtitle' => null,
])

@php
    $propAliases = [
        'layout' => 'layout',
        'theme' => 'theme',
        'content-variant' => 'contentVariant',
        'content-side' => 'contentSide',
        'content-width' => 'contentWidth',
        'card-position' => 'cardPosition',
        'content-alignment' => 'contentAlignment',
        'background-type' => 'backgroundType',
        'background-color' => 'backgroundColor',
        'background-image' => 'backgroundImage',
        'background-position' => 'backgroundPosition',
        'background-size' => 'backgroundSize',
        'background-overlay' => 'backgroundOverlay',
        'show-theme-toggle' => 'showThemeToggle',
        'panel-width' => 'panelWidth',
        'card-max-width' => 'cardMaxWidth',
        'card-padding' => 'cardPadding',
        'card-surface' => 'cardSurface',
        'card-background' => 'cardBackground',
        'card-border-color' => 'cardBorderColor',
        'card-text-color' => 'cardTextColor',
        'card-muted-color' => 'cardMutedColor',
        'logo-src' => 'logoSrc',
        'logo-alt' => 'logoAlt',
        'logo-href' => 'logoHref',
        'brand-name' => 'brandName',
        'brand-subtitle' => 'brandSubtitle',
    ];

    foreach ($propAliases as $attributeName => $variableName) {
        if ($attributes->has($attributeName)) {
            ${$variableName} = $attributes->get($attributeName);
        }
    }

    $rootAttributes = $attributes->except(array_keys($propAliases));
    $branding = config('ui-kit.branding', []);
    $authConfig = config('ui-kit.auth', []);
    $authBackground = $authConfig['background'] ?? [];
    $authCard = $authConfig['card'] ?? [];
    $authBrand = $authConfig['brand'] ?? [];
    $inheritBrand = (bool) ($authBrand['inherit'] ?? true);

    $layout = $layout ?? ($authConfig['layout'] ?? 'split');
    $contentVariant = $contentVariant ?? ($authConfig['content_variant'] ?? 'card');
    $contentSide = $contentSide ?? ($authConfig['content_side'] ?? 'right');
    $contentWidth = $contentWidth ?? ($authConfig['content_width'] ?? 'md');
    $cardPosition = $cardPosition ?? ($authConfig['card_position'] ?? 'center');
    $contentAlignment = $contentAlignment ?? ($authConfig['content_alignment'] ?? 'center');
    $backgroundType = $backgroundType ?? ($authBackground['type'] ?? 'solid');
    $backgroundColor = $backgroundColor ?? ($authBackground['color'] ?? '#0f172a');
    $backgroundImage = $backgroundImage ?? ($authBackground['image'] ?? null);
    $backgroundPosition = $backgroundPosition ?? ($authBackground['position'] ?? 'center');
    $backgroundSize = $backgroundSize ?? ($authBackground['size'] ?? 'cover');
    $backgroundOverlay = $backgroundOverlay ?? ($authBackground['overlay'] ?? 'rgba(15, 23, 42, 0.58)');
    $showThemeToggle = $showThemeToggle ?? ($authConfig['show_theme_toggle'] ?? true);
    $panelWidth = $panelWidth ?? ($authConfig['panel_width'] ?? '32rem');
    $cardMaxWidth = $cardMaxWidth ?? ($authCard['max_width'] ?? '30rem');
    $cardPadding = $cardPadding ?? ($authCard['padding'] ?? '2rem');
    $cardSurface = $cardSurface ?? ($authCard['surface'] ?? 'glass');

    $brandName = $brandName ?? ($authBrand['name'] ?? null) ?? ($inheritBrand ? ($branding['name'] ?? config('app.name')) : null);
    $brandSubtitle = $brandSubtitle ?? ($authBrand['subtitle'] ?? null) ?? ($inheritBrand ? ($branding['subtitle'] ?? null) : null);
    $logoSrc = $logoSrc ?? ($authBrand['logo'] ?? null) ?? ($inheritBrand ? ($branding['logo'] ?? null) : null);
    $logoHref = $logoHref ?? ($authBrand['href'] ?? null) ?? ($inheritBrand ? ($branding['href'] ?? '/') : null);
    $logoAlt = $logoAlt ?? $brandName ?? config('app.name', 'Brand');
    $theme = $theme ?? [];

    $layoutClasses = [
        'split' => 'lg:grid lg:min-h-screen lg:grid-cols-[minmax(0,1.15fr)_minmax(20rem,32rem)]',
        'stacked' => 'min-h-screen',
    ];

    $positionClasses = [
        'left' => 'justify-start',
        'center' => 'justify-center',
        'right' => 'justify-end',
    ];

    $alignmentClasses = [
        'start' => 'items-start',
        'center' => 'items-center',
        'end' => 'items-end',
    ];

    $surfaceClasses = [
        'glass' => [
            'dark' => 'border border-white/10 bg-slate-900/72 shadow-2xl shadow-black/30 backdrop-blur-xl',
            'light' => 'border border-white/20 bg-white/78 shadow-2xl shadow-slate-950/15 backdrop-blur-xl',
        ],
        'solid' => [
            'dark' => 'border border-white/10 bg-slate-950 shadow-2xl shadow-black/30',
            'light' => 'border border-slate-200 bg-white shadow-2xl shadow-slate-950/10',
        ],
        'none' => [
            'dark' => 'border-0 bg-transparent shadow-none',
            'light' => 'border-0 bg-transparent shadow-none',
        ],
    ];

    $widthMap = [
        'xs' => '20rem',
        'sm' => '24rem',
        'md' => '30rem',
        'lg' => '34rem',
        'xl' => '40rem',
        '2xl' => '48rem',
        '3xl' => '56rem',
        '4xl' => '64rem',
        'half' => '50vw',
        'full' => '100%',
    ];

    $resolvedLayoutClass = $layoutClasses[$layout] ?? $layoutClasses['split'];
    $resolvedPositionClass = $positionClasses[$cardPosition] ?? $positionClasses['center'];
    $resolvedAlignmentClass = $alignmentClasses[$contentAlignment] ?? $alignmentClasses['center'];
    $resolvedSurfaceClass = $surfaceClasses[$cardSurface] ?? $surfaceClasses['glass'];

    $resolvedContentWidth = $widthMap[$contentWidth] ?? $contentWidth ?? '30rem';
    $panelWidth = $panelWidth ?? $resolvedContentWidth;

    $panelSideClass = $contentSide === 'left' ? 'lg:order-first' : 'lg:order-last';
    $heroSideClass = $contentSide === 'left' ? 'lg:order-last' : 'lg:order-first';
    $floatingPositionClass = [
        'left' => 'justify-start',
        'center' => 'justify-center',
        'right' => 'justify-end',
    ][$contentSide] ?? 'justify-end';
    $floatingRailClass = [
        'left' => 'lg:absolute lg:inset-y-10 lg:left-10 lg:right-10',
        'center' => 'lg:absolute lg:inset-y-10 lg:left-10 lg:right-10',
        'right' => 'lg:absolute lg:inset-y-10 lg:left-10 lg:right-10',
    ][$contentSide] ?? 'lg:absolute lg:inset-y-10 lg:left-10 lg:right-10';
    $mobilePanelBrandVisible = $contentSide !== 'center';

    if ($layout === 'split' && in_array($contentVariant, ['panel', 'flush'], true)) {
        $resolvedLayoutClass = 'lg:grid lg:min-h-screen lg:grid-cols-[minmax(0,1fr)_minmax(24rem,var(--aui-auth-panel-width))]';
    }

    if ($layout === 'split' && in_array($contentVariant, ['card', 'bubble', 'full'], true)) {
        $resolvedLayoutClass = 'min-h-screen';
    }

    $backgroundStyle = collect([
        'background-color' => $backgroundColor,
        'background-image' => $backgroundType === 'image' && filled($backgroundImage)
            ? "linear-gradient({$backgroundOverlay}, {$backgroundOverlay}), url('{$backgroundImage}')"
            : null,
        'background-position' => $backgroundPosition,
        'background-size' => $backgroundSize,
    ])->filter()->map(fn (string $value, string $key) => $key . ': ' . $value)->implode('; ');

    $cardStyle = collect([
        'max-width' => $cardMaxWidth ?? $resolvedContentWidth,
        'padding' => $cardPadding,
    ])->map(fn (string $value, string $key) => $key . ': ' . $value)->implode('; ');

    $floatingCardStyle = collect([
        'max-width' => 'min(' . ($cardMaxWidth ?? $resolvedContentWidth) . ', calc(100vw - 10rem))',
        'padding' => $cardPadding,
        'max-height' => in_array($contentVariant, ['card', 'bubble'], true) ? 'calc(100vh - 5rem)' : null,
    ])->filter()->map(fn (string $value, string $key) => $key . ': ' . $value)->implode('; ');

    $contentPanelStyle = 'padding: ' . $cardPadding . ';';
    $floatingContentStyle = collect([
        'max-width' => in_array($contentVariant, ['card', 'bubble'], true) ? $resolvedContentWidth : null,
        'width' => $contentVariant === 'full' ? '100%' : null,
    ])->filter()->map(fn (string $value, string $key) => $key . ': ' . $value)->implode('; ');

    $bubbleSurfaceClass = [
        'dark' => 'border border-white/10 bg-slate-950/92 shadow-2xl shadow-black/35 backdrop-blur-lg',
        'light' => 'border border-slate-200/80 bg-white/97 shadow-2xl shadow-slate-950/12 backdrop-blur-md',
    ];

    $themeStyle = collect([
        '--aui-primary' => $theme['primary'] ?? null,
        '--aui-primary-hover' => $theme['primary_hover'] ?? null,
        '--aui-primary-soft' => $theme['primary_soft'] ?? null,
        '--aui-primary-softer' => $theme['primary_softer'] ?? null,
        '--aui-primary-contrast' => $theme['primary_contrast'] ?? null,
        '--aui-accent' => $theme['accent'] ?? null,
        '--aui-accent-soft' => $theme['accent_soft'] ?? null,
        '--aui-danger' => $theme['danger'] ?? null,
        '--aui-danger-soft' => $theme['danger_soft'] ?? null,
        '--aui-auth-card-bg' => $cardBackground,
        '--aui-auth-card-border' => $cardBorderColor,
        '--aui-auth-card-text' => $cardTextColor,
        '--aui-auth-card-muted' => $cardMutedColor,
    ])->filter()->map(fn (string $value, string $key) => $key . ': ' . $value)->implode('; ');
@endphp

<style>
    @media (min-width: 1024px) {
        .aui-auth-floating-rail {
            position: fixed;
            top: 2.5rem;
            bottom: 2.5rem;
            display: flex;
            z-index: 30;
            pointer-events: none;
        }

        .aui-auth-floating-rail[data-side='left'] {
            left: 3rem;
            right: 4.5rem;
        }

        .aui-auth-floating-rail[data-side='center'] {
            left: 3.75rem;
            right: 3.75rem;
        }

        .aui-auth-floating-rail[data-side='right'] {
            left: 4.5rem;
            right: 5.5rem;
        }

        .aui-auth-stage {
            min-height: calc(100vh - 5rem);
        }

        .aui-auth-floating-rail[data-side='left'] { justify-content: flex-start; }
        .aui-auth-floating-rail[data-side='center'] { justify-content: center; }
        .aui-auth-floating-rail[data-side='right'] { justify-content: flex-end; }

        .aui-auth-floating-rail[data-align='start'] {
            align-items: flex-start;
        }

        .aui-auth-floating-rail[data-align='center'] {
            align-items: center;
        }

        .aui-auth-floating-rail[data-align='end'] {
            align-items: flex-end;
        }

        .aui-auth-floating-background[data-side='left'] {
            padding-left: calc(var(--aui-auth-floating-width) + 5rem);
        }

        .aui-auth-floating-background[data-side='right'] {
            padding-right: calc(var(--aui-auth-floating-width) + 5rem);
        }
    }

    .aui-auth-card-surface {
        color: var(--aui-auth-card-text, inherit);
    }

    .aui-auth-card-surface[data-custom-card='true'] {
        background: var(--aui-auth-card-bg);
        border-color: var(--aui-auth-card-border, transparent);
        color: var(--aui-auth-card-text, inherit);
    }

    .aui-auth-card-surface[data-custom-card='true'] :where(.aui-auth-card-text) {
        color: var(--aui-auth-card-text, inherit);
    }

    .aui-auth-card-surface[data-custom-card='true'] :where(.aui-auth-card-muted) {
        color: var(--aui-auth-card-muted, var(--aui-auth-card-text, inherit));
    }

    @media (min-width: 1024px) {
        .aui-auth-card-surface[data-side='right'] {
            transform: translateX(-6rem);
        }
    }
</style>

<div
    x-cloak
    x-data="{ theme: localStorage.getItem('aui-theme') || 'light' }"
    x-init="
        $watch('theme', value => {
            localStorage.setItem('aui-theme', value);
            document.documentElement.setAttribute('data-aui-theme', value);
        });
    "
    {{ $rootAttributes->class(['relative isolate min-h-screen overflow-hidden']) }}
    style="--aui-auth-panel-width: {{ $panelWidth }}; --aui-auth-floating-width: {{ $resolvedContentWidth }}; {{ $themeStyle }}"
    :class="theme === 'dark' ? 'bg-slate-950 text-slate-100' : 'bg-slate-100 text-slate-900'"
>
    <div class="{{ $resolvedLayoutClass }} min-h-screen">
        <section
            class="relative overflow-hidden px-6 py-8 sm:px-8 lg:min-h-screen lg:px-12 lg:py-10 {{ $heroSideClass }}"
            style="{{ $backgroundStyle }}"
        >
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.16),transparent_36%),radial-gradient(circle_at_bottom_left,rgba(255,255,255,0.12),transparent_28%)]"></div>

            @isset($background)
                <div class="aui-auth-floating-background absolute inset-0" data-side="{{ $contentSide }}">
                    {{ $background }}
                </div>
            @endisset

            <div class="aui-auth-stage relative flex flex-col {{ $resolvedAlignmentClass }}" style="min-height: calc(100vh - 4rem);">
                <div class="flex items-start justify-between gap-4">
                    <div class="min-h-12">
                        @isset($logo)
                            {{ $logo }}
                        @else
                            @if ($logoSrc || $brandName || $brandSubtitle)
                                @if ($logoHref)
                                    <a href="{{ $logoHref }}" class="inline-flex items-center gap-3">
                                        @if ($logoSrc)
                                            <img src="{{ $logoSrc }}" alt="{{ $logoAlt }}" class="h-11 w-auto max-w-[9rem] object-contain">
                                        @endif
                                        @if ($brandName || $brandSubtitle)
                                            <span class="block">
                                                @if ($brandName)
                                                    <span class="block text-sm font-semibold tracking-[0.2em] text-white/90 uppercase">{{ $brandName }}</span>
                                                @endif
                                                @if ($brandSubtitle)
                                                    <span class="mt-1 block text-sm text-white/70">{{ $brandSubtitle }}</span>
                                                @endif
                                            </span>
                                        @endif
                                    </a>
                                @else
                                    <div class="inline-flex items-center gap-3">
                                        @if ($logoSrc)
                                            <img src="{{ $logoSrc }}" alt="{{ $logoAlt }}" class="h-11 w-auto max-w-[9rem] object-contain">
                                        @endif
                                        @if ($brandName || $brandSubtitle)
                                            <div>
                                                @if ($brandName)
                                                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-white/90">{{ $brandName }}</p>
                                                @endif
                                                @if ($brandSubtitle)
                                                    <p class="mt-1 text-sm text-white/70">{{ $brandSubtitle }}</p>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            @endif
                        @endisset
                    </div>

                    @if ($showThemeToggle && $contentVariant !== 'panel')
                        <button
                            type="button"
                            @click="theme = theme === 'dark' ? 'light' : 'dark'"
                            class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-white/20 bg-white/10 text-white backdrop-blur-md transition hover:bg-white/20"
                            aria-label="Toggle theme"
                        >
                            <svg x-show="theme === 'dark'" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3a9 9 0 108.94 7.5A7 7 0 0112 3z"/>
                            </svg>
                            <svg x-show="theme !== 'dark'" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364-6.364-1.414 1.414M7.05 16.95l-1.414 1.414m12.728 0-1.414-1.414M7.05 7.05 5.636 5.636M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                            </svg>
                        </button>
                    @endif
                </div>

                @if (! in_array($contentVariant, ['panel', 'flush', 'full'], true))
                    <div class="mt-12 flex flex-1 {{ $resolvedAlignmentClass }} lg:mt-0">
                        <div class="aui-auth-floating-rail flex w-full {{ $floatingPositionClass }}" data-side="{{ $contentSide }}" data-align="{{ $contentAlignment }}">
                            <div
                                class="aui-auth-card-surface w-full overflow-y-auto pointer-events-auto {{ $contentVariant === 'bubble' ? 'rounded-[2.25rem]' : 'rounded-[2rem]' }}"
                                data-custom-card="{{ ($cardBackground || $cardBorderColor || $cardTextColor || $cardMutedColor) ? 'true' : 'false' }}"
                                data-side="{{ $contentSide }}"
                                style="{{ $floatingCardStyle }}; {{ $floatingContentStyle }}"
                                :class="theme === 'dark'
                                    ? '{{ $contentVariant === 'bubble' ? $bubbleSurfaceClass['dark'] : $resolvedSurfaceClass['dark'] }}'
                                    : '{{ $contentVariant === 'bubble' ? $bubbleSurfaceClass['light'] : $resolvedSurfaceClass['light'] }}'"
                            >
                                @if ($title || $subtitle)
                                    <div class="mb-8">
                                        @if ($title)
                                            <h1 class="text-3xl font-semibold tracking-tight" :class="theme === 'dark' ? 'text-white' : 'text-slate-900'">
                                                {{ $title }}
                                            </h1>
                                        @endif
                                        @if ($subtitle)
                                            <p class="mt-3 text-sm sm:text-base" :class="theme === 'dark' ? 'text-slate-300' : 'text-slate-600'">
                                                {{ $subtitle }}
                                            </p>
                                        @endif
                                    </div>
                                @endif

                                {{ $slot }}
                            </div>
                        </div>
                    </div>
                @endif

                @isset($aside)
                    <div class="relative mt-8 max-w-2xl text-white">
                        {{ $aside }}
                    </div>
                @endisset
            </div>
        </section>

        @if (in_array($contentVariant, ['panel', 'flush'], true))
            <aside
                class="relative flex min-h-screen flex-col overflow-hidden {{ $panelSideClass }}"
                style="{{ $contentPanelStyle }}"
                :class="theme === 'dark'
                    ? '{{ $contentSide === 'left' ? 'border-r border-white/10' : 'border-l border-white/10' }} {{ $contentVariant === 'flush' ? 'bg-slate-950/96 backdrop-blur-md' : 'bg-slate-950' }}'
                    : '{{ $contentSide === 'left' ? 'border-r border-slate-200' : 'border-l border-slate-200' }} {{ $contentVariant === 'flush' ? 'bg-white/96 backdrop-blur-md' : 'bg-white' }}'"
            >
                <div class="flex items-start justify-between gap-4">
                    <div class="min-h-12">
                        @isset($panelLogo)
                            {{ $panelLogo }}
                        @elseif ($mobilePanelBrandVisible && ($logoSrc || $brandName || $brandSubtitle))
                            <div class="inline-flex items-center gap-3 lg:hidden">
                                @if ($logoSrc)
                                    <img src="{{ $logoSrc }}" alt="{{ $logoAlt }}" class="h-10 w-auto max-w-[8rem] object-contain">
                                @endif
                                @if ($brandName || $brandSubtitle)
                                    <div>
                                        @if ($brandName)
                                            <p class="text-sm font-semibold tracking-[0.2em] uppercase" :class="theme === 'dark' ? 'text-slate-100' : 'text-slate-800'">{{ $brandName }}</p>
                                        @endif
                                        @if ($brandSubtitle)
                                            <p class="mt-1 text-xs" :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'">{{ $brandSubtitle }}</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    @if ($showThemeToggle)
                        <button
                            type="button"
                            @click="theme = theme === 'dark' ? 'light' : 'dark'"
                            class="inline-flex h-11 w-11 items-center justify-center rounded-full border transition"
                            :class="theme === 'dark'
                                ? 'border-white/10 bg-white/5 text-slate-200 hover:bg-white/10'
                                : 'border-slate-200 bg-white text-slate-700 shadow-sm hover:bg-slate-50'"
                            aria-label="Toggle theme"
                        >
                            <svg x-show="theme === 'dark'" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3a9 9 0 108.94 7.5A7 7 0 0112 3z"/>
                            </svg>
                            <svg x-show="theme !== 'dark'" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364-6.364-1.414 1.414M7.05 16.95l-1.414 1.414m12.728 0-1.414-1.414M7.05 7.05 5.636 5.636M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                            </svg>
                        </button>
                    @endif
                </div>

                <div class="mt-8 flex-1 overflow-hidden">
                    @if ($title || $subtitle)
                        <div class="mb-8">
                            @if ($title)
                                <h1 class="text-3xl font-semibold tracking-tight" :class="theme === 'dark' ? 'text-white' : 'text-slate-900'">
                                    {{ $title }}
                                </h1>
                            @endif
                            @if ($subtitle)
                                <p class="mt-3 text-sm sm:text-base" :class="theme === 'dark' ? 'text-slate-300' : 'text-slate-600'">
                                    {{ $subtitle }}
                                </p>
                            @endif
                        </div>
                    @endif

                    {{ $slot }}
                </div>

                @isset($footer)
                    <div class="mt-8">
                        {{ $footer }}
                    </div>
                @endisset
            </aside>
        @endif

        @if ($contentVariant === 'full')
            <aside
                class="relative min-h-screen"
                :class="theme === 'dark' ? 'bg-slate-950/78 backdrop-blur-md' : 'bg-white/85 backdrop-blur-md'"
            >
                <div class="mx-auto flex min-h-screen w-full items-center justify-center px-6 py-10 sm:px-8 lg:px-12">
                    <div
                        class="w-full rounded-[2rem]"
                        style="max-width: {{ $resolvedContentWidth }}; padding: {{ $cardPadding }};"
                        :class="theme === 'dark' ? '{{ $resolvedSurfaceClass['dark'] }}' : '{{ $resolvedSurfaceClass['light'] }}'"
                    >
                        @if ($title || $subtitle)
                            <div class="mb-8">
                                @if ($title)
                                    <h1 class="text-3xl font-semibold tracking-tight" :class="theme === 'dark' ? 'text-white' : 'text-slate-900'">
                                        {{ $title }}
                                    </h1>
                                @endif
                                @if ($subtitle)
                                    <p class="mt-3 text-sm sm:text-base" :class="theme === 'dark' ? 'text-slate-300' : 'text-slate-600'">
                                        {{ $subtitle }}
                                    </p>
                                @endif
                            </div>
                        @endif

                        {{ $slot }}

                        @isset($footer)
                            <div class="mt-8">
                                {{ $footer }}
                            </div>
                        @endisset
                    </div>
                </div>
            </aside>
        @endif
    </div>
</div>
