@props([
    'title' => 'Dashboard',
    'subtitle' => null,
    'showSidebar' => true,
    'sidebarOpen' => true,
    'sidebarMode' => 'toggle', // toggle | static
    'showSidebarToggle' => true,
])

@php
    $hasSidebar = isset($sidebar) && $sidebar->hasActualContent();
    $resolvedShowSidebar = $showSidebar && $hasSidebar;
    $resolvedSidebarMode = $showSidebarToggle ? $sidebarMode : 'static';
@endphp

<x-ui-kit::templates.app-shell
    :title="$title"
    :subtitle="$subtitle"
    :show-sidebar="$resolvedShowSidebar"
    :sidebar-open="$sidebarOpen"
    :sidebar-mode="$resolvedSidebarMode"
    :show-sidebar-toggle="$showSidebarToggle"
    {{ $attributes }}
>
    @if ($hasSidebar)
        <x-slot:sidebar>
            {{ $sidebar }}
        </x-slot:sidebar>
    @endif

    @if (isset($header) && $header->hasActualContent())
        <x-slot:header>
            {{ $header }}
        </x-slot:header>
    @endif

    @if (isset($actions) && $actions->hasActualContent())
        <x-slot:actions>
            {{ $actions }}
        </x-slot:actions>
    @endif

    @if (isset($stats) && $stats->hasActualContent())
        <div class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            {{ $stats }}
        </div>
    @endif

    <div class="space-y-6">
        {{ $slot }}
    </div>
</x-ui-kit::templates.app-shell>
