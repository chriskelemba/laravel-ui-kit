@props([
    'items' => [],
    'side' => 'left',
])

@php
    use ChrisKelemba\LaravelUiKit\Support\IconResolver;

    $side = $side === 'right' ? 'right' : 'left';
    $borderClass = $side === 'right' ? 'border-l' : 'border-r';
    $hoverVar = $side === 'right' ? 'hoverRightPrimarySection' : 'hoverPrimarySection';
    $activeVar = $side === 'right' ? 'activeRightPrimarySection' : 'activePrimarySection';
    $collapsedVar = $side === 'right' ? 'rightSidebarCollapsed' : 'sidebarCollapsed';
@endphp

<nav
    {{ $attributes->class(['hidden h-full w-[5rem] shrink-0 px-2 py-4 lg:flex lg:flex-col ' . $borderClass]) }}
    :class="theme === 'dark' ? 'border-white/5 bg-slate-950/90' : 'border-slate-200/80 bg-white/90'"
>
    <div class="flex flex-1 flex-col items-center gap-2">
        @foreach ($items as $item)
            @php
                $key = $item['key'] ?? \Illuminate\Support\Str::slug($item['label'] ?? '');
                $label = $item['label'] ?? '';
                $href = $item['href'] ?? '#';
                $icon = IconResolver::resolve($item['icon'] ?? null, $label);
                $active = (bool) ($item['active'] ?? false);
                $togglesSidebar = (bool) ($item['toggles_sidebar'] ?? false);
                $preventsNavigation = $togglesSidebar && ($href === '#' || $href === '');
                $selectionExpr = $activeVar;
                $baseItemClasses = 'text-slate-400 hover:text-slate-200';
                $baseItemClassesLight = 'text-slate-500 hover:text-slate-700';
                $iconBaseClasses = $active
                    ? ($side === 'right' ? 'bg-transparent group-hover:bg-white/5' : 'bg-transparent')
                    : 'bg-transparent group-hover:bg-white/5';
                $iconBaseClassesLight = $active
                    ? ($side === 'right' ? 'bg-transparent group-hover:bg-white/80' : 'bg-transparent')
                    : 'bg-transparent group-hover:bg-white/80';
            @endphp
            <a
                href="{{ $href }}"
                class="group flex w-full flex-col items-center gap-2 rounded-3xl px-1 py-3 text-center text-[11px] font-medium leading-tight transition"
                @if ($side !== 'right')
                    @mouseenter="{{ $hoverVar }} = null"
                    @focus="{{ $hoverVar }} = null"
                @endif
                @if ($side === 'right')
                    @mouseenter="if (window.innerWidth >= 1024 && rightSidebarCollapsible && rightSidebarCollapsed) rightSidebarHoverExpanded = true; {{ $hoverVar }} = '{{ $key }}'"
                    @focus="if (window.innerWidth >= 1024 && rightSidebarCollapsible && rightSidebarCollapsed) rightSidebarHoverExpanded = true; {{ $hoverVar }} = '{{ $key }}'"
                @endif
                @if ($preventsNavigation)
                    @click.prevent="{{ $activeVar }} = '{{ $key }}'; {{ $collapsedVar }} = false; sidebarOpen = true; {{ $hoverVar }} = null"
                @elseif ($togglesSidebar)
                    @click="{{ $activeVar }} = '{{ $key }}'; {{ $collapsedVar }} = false; {{ $side === 'right' ? 'rightSidebarVisible = true;' : 'sidebarOpen = true;' }} {{ $hoverVar }} = null"
                @endif
                :class="(theme === 'dark'
                    ? ('{{ $baseItemClasses }}')
                    : ('{{ $baseItemClassesLight }}'))
                    + ((({{ $selectionExpr }}) === '{{ $key }}')
                        ? ' ' + (theme === 'dark' ? 'text-white' : 'text-slate-900')
                        : '')"
            >
                <span class="aui-primary-rail-icon-hoverable flex h-10 w-14 items-center justify-center overflow-visible rounded-full text-lg leading-none transition"
                    :class="(theme === 'dark'
                        ? '{{ $iconBaseClasses }}'
                        : '{{ $iconBaseClassesLight }}')
                        + ((({{ $selectionExpr }}) === '{{ $key }}')
                            ? ' ' + (theme === 'dark'
                                ? 'bg-white/15 text-white aui-primary-rail-icon-active'
                                : 'aui-primary-rail-icon-active')
                            : '')">
                    @if ($icon)
                        {!! $icon !!}
                    @endif
                </span>
                <span class="max-w-full whitespace-nowrap text-[10px] leading-none">{{ $label }}</span>
            </a>
        @endforeach
    </div>
</nav>
