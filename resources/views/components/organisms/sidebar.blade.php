@props([
    'title' => null,
    'eyebrow' => null,
    'subtitle' => null,
    'items' => [],
    'side' => 'left',
    'variant' => 'nav',
])

@php
    use ChrisKelemba\LaravelUiKit\Support\IconResolver;

    $side = $side === 'right' ? 'right' : 'left';
    $variant = $variant === 'panel' ? 'panel' : 'nav';
    $indicatorPositionClass = $side === 'right' ? 'right-2' : 'left-2';
    $collapsedExpr = $side === 'right' ? '!rightSidebarCollapsed || rightSidebarHoverExpanded' : '!sidebarCollapsed || sidebarHoverExpanded';
    $surfaceClass = $side === 'right' ? 'aui-sidebar-surface-right' : 'aui-sidebar-surface-left';
    $titleClass = $side === 'right' ? 'aui-sidebar-title-right' : 'aui-sidebar-title-left';
    $linkClass = $side === 'right' ? 'aui-sidebar-link-right' : 'aui-sidebar-link-left';
    $iconClass = $side === 'right' ? 'aui-sidebar-icon-right' : 'aui-sidebar-icon-left';
    $badgeClass = $side === 'right' ? 'aui-sidebar-badge-right' : 'aui-sidebar-badge-left';
    $indicatorClass = $side === 'right' ? 'aui-sidebar-active-indicator-right' : 'aui-sidebar-active-indicator';
@endphp

@if ($variant === 'panel')
    <section {{ $attributes->class(['flex h-full min-h-0 flex-col ' . $surfaceClass]) }}>
        <div x-show="{{ $collapsedExpr }}" x-transition.opacity.duration.150ms class="flex h-full min-h-0 flex-col">
            @if ($eyebrow || $title || $subtitle || isset($actions))
                <div class="border-b px-5 py-4" :class="theme === 'dark' ? 'border-white/5' : ''">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            @if ($eyebrow)
                                <p class="text-[11px] font-bold uppercase tracking-[0.3em] {{ $titleClass }}">
                                    {{ $eyebrow }}
                                </p>
                            @endif
                            @if ($title)
                                <p class="mt-2 truncate text-base font-semibold {{ $linkClass }}">
                                    {{ $title }}
                                </p>
                            @endif
                            @if ($subtitle)
                                <p class="mt-1 text-sm leading-6 {{ $titleClass }}">
                                    {{ $subtitle }}
                                </p>
                            @endif
                        </div>

                        @isset($actions)
                            <div class="shrink-0">
                                {{ $actions }}
                            </div>
                        @endisset
                    </div>
                </div>
            @endif

            <div class="min-h-0 flex-1 overflow-y-auto px-5 py-5">
                {{ $slot }}
            </div>

            @isset($footer)
                <div class="border-t px-5 py-4" :class="theme === 'dark' ? 'border-white/5' : ''">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </section>
@else
    <nav {{ $attributes->class(['flex h-full flex-col px-4 py-5 ' . $surfaceClass]) }}>
        @isset($brand)
            <div class="mb-5 px-2">
                <div
                    class="flex min-h-12 items-center gap-3 rounded-2xl px-3 py-2 transition"
                    :class="theme === 'dark' ? 'hover:bg-white/5' : 'hover:bg-slate-100'"
                >
                    {{ $brand }}
                </div>
            </div>
        @else
            @if ($title)
                <div class="mb-5 px-3" x-show="{{ $collapsedExpr }}" x-transition.opacity.duration.150ms>
                    <p class="text-xs font-bold uppercase tracking-widest {{ $titleClass }}">
                        {{ $title }}
                    </p>
                </div>
            @endif
        @endisset
        
        <ul class="flex-1 space-y-1">
            @foreach ($items as $item)
                @php
                    $label = $item['label'] ?? '';
                    $href = $item['href'] ?? '#';
                    $icon = IconResolver::resolve($item['icon'] ?? null, $label);
                    $active = $item['active'] ?? false;
                    $badge = $item['badge'] ?? null;
                    $fallbackGlyph = strtoupper(substr(trim($label), 0, 1));
                @endphp
                <li>
                    <a
                        href="{{ $href }}"
                        class="aui-sidebar-link {{ $linkClass }} group relative flex items-center gap-3 rounded-full px-4 py-2.5 text-sm font-medium transition{{ $active ? ' is-active aui-sidebar-active' : '' }}"
                        title="{{ $label }}"
                    >
                        @if ($active)
                            <div class="absolute {{ $indicatorPositionClass }} h-6 w-1 rounded-full {{ $indicatorClass }}"></div>
                        @endif
                        
                        <span
                            class="flex h-5 w-5 shrink-0 items-center justify-center overflow-hidden rounded-full text-[11px] font-semibold {{ $icon ? '' : $iconClass }}"
                        >
                            @if ($icon)
                                {!! $icon !!}
                            @else
                                {{ $fallbackGlyph }}
                            @endif
                        </span>
                        
                        <span class="flex-1 truncate" x-show="{{ $collapsedExpr }}" x-transition.opacity.duration.150ms>{{ $label }}</span>
                        
                        @if ($badge)
                            <span
                                class="rounded-full px-2 py-0.5 text-[11px] font-medium {{ $badgeClass }}"
                                x-show="{{ $collapsedExpr }}"
                                x-transition.opacity.duration.150ms
                            >
                                {{ $badge }}
                            </span>
                        @else
                            <svg class="h-4 w-4 opacity-0 transition group-hover:translate-x-1 group-hover:opacity-100" x-show="{{ $collapsedExpr }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
        
        <div x-show="{{ $collapsedExpr }}" x-transition.opacity.duration.150ms>
            {{ $slot }}
        </div>
    </nav>
@endif
