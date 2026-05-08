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
    $surfaceClass = $side === 'right' ? 'aui-sidebar-surface-right' : 'aui-sidebar-surface-left';
    $railClass = $side === 'right' ? 'aui-primary-rail-right' : 'aui-primary-rail-left';
    $iconClass = $side === 'right' ? 'aui-primary-rail-icon-right' : 'aui-primary-rail-icon-left';
@endphp

<nav
    {{ $attributes->class(['hidden h-full w-[5rem] shrink-0 px-2 py-4 lg:flex lg:flex-col ' . $borderClass . ' ' . $surfaceClass]) }}
    :class="theme === 'dark' ? 'border-white/5' : ''"
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
                class="group flex w-full flex-col items-center gap-2 rounded-3xl px-1 py-3 text-center text-[11px] font-medium leading-tight transition {{ $railClass }}{{ $active ? ' is-active' : '' }}"
                :class="(({{ $selectionExpr }}) === '{{ $key }}') ? 'is-active' : ''"
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
                    @click="{{ $activeVar }} = '{{ $key }}'; {{ $side === 'right' ? $collapsedVar . ' = false; rightSidebarVisible = true;' : '' }} {{ $hoverVar }} = null"
                @endif
            >
                <span class="flex h-10 w-14 items-center justify-center overflow-visible rounded-full text-lg leading-none transition {{ $iconClass }}">
                    @if ($icon)
                        {!! $icon !!}
                    @endif
                </span>
                <span class="max-w-full whitespace-nowrap text-[10px] leading-none">{{ $label }}</span>
            </a>
        @endforeach
    </div>
</nav>
