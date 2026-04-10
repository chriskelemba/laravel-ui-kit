@props([
    'title' => null,
    'description' => null,
    'columns' => [],
    'rows' => [],
    'routePrefix' => null,
    'createRoute' => null,
    'createLabel' => 'Create',
    'actions' => true,
    'showAction' => true,
    'editAction' => true,
    'deleteAction' => true,
    'showRoute' => null,
    'editRoute' => null,
    'deleteRoute' => null,
    'showHeader' => true,
    'dateFormat' => 'Y-m-d',
])

@php
    $resolvedShowRoute = filled($showRoute) ? $showRoute : ($routePrefix ? $routePrefix . '.show' : null);
    $resolvedEditRoute = filled($editRoute) ? $editRoute : ($routePrefix ? $routePrefix . '.edit' : null);
    $resolvedDeleteRoute = filled($deleteRoute) ? $deleteRoute : ($routePrefix ? $routePrefix . '.destroy' : null);

    $showActions = $actions && (
        ($showAction && filled($resolvedShowRoute)) ||
        ($editAction && filled($resolvedEditRoute)) ||
        ($deleteAction && filled($resolvedDeleteRoute))
    );
    $normalizedColumns = collect($columns)->map(function ($column) use ($dateFormat) {
        if (is_string($column)) {
            return [
                'key' => $column,
                'label' => \Illuminate\Support\Str::headline($column),
                'type' => null,
                'format' => $dateFormat,
                'truncate' => null,
            ];
        }

        return [
            'key' => $column['key'] ?? null,
            'label' => $column['label'] ?? \Illuminate\Support\Str::headline($column['key'] ?? ''),
            'type' => $column['type'] ?? null,
            'format' => $column['format'] ?? $dateFormat,
            'truncate' => $column['truncate'] ?? null,
        ];
    })->filter(fn ($column) => filled($column['key']))->values();

    $headers = $normalizedColumns->pluck('label')->all();
    if ($showActions) {
        $headers[] = 'Actions';
    }

    $tableRows = collect($rows)->map(function ($row) use ($normalizedColumns, $showActions, $resolvedShowRoute, $resolvedEditRoute, $resolvedDeleteRoute, $showAction, $editAction, $deleteAction) {
        $cells = $normalizedColumns->map(function ($column) use ($row) {
            $value = data_get($row, $column['key']);

            if ($value instanceof \Carbon\CarbonInterface) {
                $value = $value->format($column['format']);
            } elseif ($column['type'] === 'date' && filled($value)) {
                $value = \Illuminate\Support\Carbon::parse($value)->format($column['format']);
            }

            $isDescription = \Illuminate\Support\Str::contains($column['key'], 'description');
            $truncateLimit = $column['truncate'] ?? ($isDescription ? 120 : null);

            if (is_string($value) && $truncateLimit && \Illuminate\Support\Str::length($value) > $truncateLimit) {
                return new \Illuminate\Support\HtmlString(view('ui-kit::partials.truncated-modal', [
                    'title' => $column['label'] ?? \Illuminate\Support\Str::headline($column['key']),
                    'text' => $value,
                    'limit' => $truncateLimit,
                ])->render());
            }

            if ($value === null || $value === '') {
                $value = '-';
            }

            return $value;
        })->values()->all();

        if ($showActions) {
            $cells[] = new \Illuminate\Support\HtmlString(view('ui-kit::partials.resource-actions', [
                'item' => $row,
                'showRoute' => $resolvedShowRoute,
                'editRoute' => $resolvedEditRoute,
                'deleteRoute' => $resolvedDeleteRoute,
                'showAction' => $showAction,
                'editAction' => $editAction,
                'deleteAction' => $deleteAction,
            ])->render());
        }

        return $cells;
    })->all();

    $rowCount = is_countable($rows) ? count($rows) : 0;
@endphp

<x-ui-kit::templates.crud-page
    :title="$title"
    :description="$description"
    :show-header="$showHeader"
    {{ $attributes }}
>
    @if ($createRoute)
        <x-slot:actions>
            <x-ui-kit::atoms.button variant="secondary" as="a" href="{{ route($createRoute) }}">
                {{ $createLabel }}
            </x-ui-kit::atoms.button>
        </x-slot:actions>
    @endif

    @isset($toolbar)
        <x-slot:toolbar>
            {{ $toolbar }}
        </x-slot:toolbar>
    @endisset

    <x-ui-kit::organisms.panel>
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <x-ui-kit::atoms.badge variant="secondary">{{ $rowCount }}</x-ui-kit::atoms.badge>
                <div class="text-xs" :class="theme === 'dark' ? 'text-slate-400' : 'text-slate-500'">
                    <div class="font-semibold uppercase tracking-wide">Table View</div>
                    <div>{{ $title ? \Illuminate\Support\Str::headline($title) : 'Records' }}</div>
                </div>
            </div>
            @isset($tableTools)
                <div class="w-full sm:w-auto">
                    {{ $tableTools }}
                </div>
            @endisset
        </div>

        <div class="mt-4">
            <x-ui-kit::organisms.table :headers="$headers" :rows="$tableRows" />
        </div>

        @isset($pagination)
            <div class="mt-5 flex items-center justify-end">
                {{ $pagination }}
            </div>
        @endisset
    </x-ui-kit::organisms.panel>
</x-ui-kit::templates.crud-page>
