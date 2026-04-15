<?php

namespace ChrisKelemba\LaravelUiKit\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ResourceSidebar
{
    public static function fromItems(
        iterable $items,
        string $resourceKey,
        string $resourceLabel,
        string $pageTitle,
        int $selectedIndex = 0,
        ?string $baseUrl = null,
    ): array {
        $items = collect($items)->values();
        $selectedIndex = max(0, min($selectedIndex, max(0, $items->count() - 1)));
        $selected = $items->get($selectedIndex);

        return [
            'view' => $resourceKey,
            'list_items' => self::listItems($items, $selectedIndex, $baseUrl),
            'headers' => [
                $resourceKey => [
                    'eyebrow' => 'Selected data',
                    'title' => $resourceLabel . ' Details',
                    'description' => 'Selected ' . Str::lower($resourceLabel) . ' details for this resource page.',
                ],
            ],
            'panels' => [
                $resourceKey => self::panel($selected, $resourceLabel, $pageTitle),
            ],
            'selected' => $selected,
        ];
    }

    private static function listItems(Collection $items, int $selectedIndex, ?string $baseUrl): array
    {
        return $items->map(function (array $item, int $index) use ($selectedIndex, $baseUrl) {
            $href = $baseUrl ? $baseUrl . '?' . http_build_query(['item' => $index]) : ($item['href'] ?? '#');

            return [
                'title' => $item['title'] ?? 'Untitled item',
                'subtitle' => $item['subtitle'] ?? null,
                'meta' => $item['meta'] ?? trim(($item['meta_label'] ?? 'Detail') . ' • ' . ($item['meta_value'] ?? 'Open')),
                'status' => $item['status'] ?? ($item['meta_value'] ?? 'Open'),
                'status_label' => $item['status_label'] ?? ($item['meta_label'] ?? 'Status'),
                'href' => $href,
                'action_href' => $item['action_href'] ?? $href,
                'selected' => $selectedIndex === $index,
            ];
        })->all();
    }

    private static function panel(?array $item, string $resourceLabel, string $pageTitle): array
    {
        if (! $item) {
            return [
                'blocks' => [
                    [
                        'type' => 'detail',
                        'title' => 'No ' . Str::lower($resourceLabel) . ' selected',
                        'description' => 'Choose a row from the list to inspect it here.',
                    ],
                ],
            ];
        }

        $details = $item['details'] ?? [
            ['label' => $item['meta_label'] ?? 'Status', 'value' => $item['meta_value'] ?? ($item['status'] ?? 'Open')],
            ['label' => 'Resource', 'value' => $resourceLabel],
            ['label' => 'Page', 'value' => $pageTitle],
        ];

        return [
            'blocks' => [
                [
                    'type' => 'detail',
                    'title' => $item['title'] ?? $resourceLabel,
                    'subtitle' => $item['subtitle'] ?? null,
                    'badge' => $item['badge'] ?? ($item['status'] ?? ($item['meta_value'] ?? null)),
                    'badge_class' => $item['badge_class'] ?? 'bg-sky-100 text-sky-700',
                    'description' => $item['description'] ?? null,
                ],
                [
                    'type' => 'key-value',
                    'eyebrow' => $item['details_eyebrow'] ?? 'Details',
                    'items' => $details,
                ],
            ],
        ];
    }
}
