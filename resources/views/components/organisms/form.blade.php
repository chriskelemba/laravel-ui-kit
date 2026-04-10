@props([
    'action' => '',
    'method' => 'POST',
    'submitLabel' => 'Save',
])

<form method="{{ in_array(strtoupper($method), ['GET', 'POST']) ? $method : 'POST' }}" action="{{ $action }}" {{ $attributes->class(['space-y-4']) }}>
    @csrf
    @if (!in_array(strtoupper($method), ['GET', 'POST']))
        @method($method)
    @endif

    <div class="space-y-4">
        {{ $slot }}
    </div>

    <div class="flex items-center justify-end gap-2">
        @isset($actions)
            {{ $actions }}
        @endisset
        @if (filled($submitLabel) && ! isset($actions))
            <x-ui-kit::atoms.button type="submit">
                {{ $submitLabel }}
            </x-ui-kit::atoms.button>
        @endif
    </div>
</form>
