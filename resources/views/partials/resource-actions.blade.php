<div class="flex flex-wrap gap-2">
    @if (($showAction ?? true) && filled($showRoute))
        <x-ui-kit::atoms.button
            variant="secondary"
            size="sm"
            as="a"
            href="{{ route($showRoute, $item->getKey()) }}"
            title="View"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span class="sr-only">View</span>
        </x-ui-kit::atoms.button>
    @endif
    @if (($editAction ?? true) && filled($editRoute))
        <x-ui-kit::atoms.button
            variant="secondary"
            size="sm"
            as="a"
            href="{{ route($editRoute, $item->getKey()) }}"
            title="Edit"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 11l6.414-6.414a2 2 0 112.828 2.828L11.828 13.828A2 2 0 0110.414 14H9v-3z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 20h14"/>
            </svg>
            <span class="sr-only">Edit</span>
        </x-ui-kit::atoms.button>
    @endif
    @if (($deleteAction ?? true) && filled($deleteRoute))
        <form method="POST" action="{{ route($deleteRoute, $item->getKey()) }}">
            @csrf
            @method('DELETE')
            <x-ui-kit::atoms.button
                variant="danger"
                size="sm"
                type="submit"
                onclick="return confirm('Delete this record?')"
                title="Delete"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 7h12M9 7V5a1 1 0 011-1h4a1 1 0 011 1v2M10 11v6M14 11v6M6 7l1 12a2 2 0 002 2h6a2 2 0 002-2l1-12"/>
                </svg>
                <span class="sr-only">Delete</span>
            </x-ui-kit::atoms.button>
        </form>
    @endif
</div>
