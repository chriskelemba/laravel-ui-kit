@props([
    'action' => '#',
    'method' => 'POST',
    'fields' => [],
    'submitLabel' => 'Sign In',
    'rememberLabel' => null,
    'forgotPasswordHref' => null,
    'forgotPasswordLabel' => 'Forgot password?',
    'formClass' => null,
    'fieldGroupClass' => null,
    'footerClass' => null,
])

@php
    $method = strtoupper((string) $method);
    $httpMethod = in_array($method, ['GET', 'POST'], true) ? $method : 'POST';
    $fieldGroupClass = $fieldGroupClass ?: 'space-y-5';
    $footerClass = $footerClass ?: 'mt-8';
    $formClass = $formClass ?: 'flex h-full min-h-0 flex-col justify-center';

    $iconMap = [
        'user' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 19a4 4 0 00-8 0m4-8a4 4 0 100-8 4 4 0 000 8z"/>',
        'password' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.01-3.214 3.57-5.632 6.713-6.524m2.256-.342A9.955 9.955 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.17 5.568M15 12a3 3 0 00-3-3m0 0a2.99 2.99 0 00-2.12.879M12 9l-7.5 7.5M3 3l18 18"/>',
        'company-code' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 3h6M10 9h4M9 15h6M4 5a2 2 0 012-2h12a2 2 0 012 2v14l-4-2-4 2-4-2-4 2V5z"/>',
        'mail' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 7l9 6 9-6m-18 10h18V7H3v10z"/>',
    ];

    $resolveIcon = function (?string $icon) use ($iconMap): ?string {
        if (! filled($icon)) {
            return null;
        }

        return $iconMap[$icon] ?? $icon;
    };
@endphp

<x-ui-kit-form
    :action="$action"
    :method="$method"
    submit-label=""
    {{ $attributes->except(['class'])->class([$formClass]) }}
>
    <x-slot:actions>
        <div class="{{ $footerClass }} w-full">
            @isset($actions)
                {{ $actions }}
            @else
                <x-ui-kit-button type="submit" size="lg" class="w-full justify-center rounded-sm text-xl">
                    {{ $submitLabel }}
                </x-ui-kit-button>
            @endisset
        </div>
    </x-slot:actions>

    <div class="space-y-7">
        @isset($intro)
            <div>
                {{ $intro }}
            </div>
        @endisset

        <div class="{{ $fieldGroupClass }}">
            @foreach ($fields as $field)
                @php
                    $inputId = $field['id'] ?? $field['name'] ?? uniqid('auth-field-', false);
                    $label = $field['label'] ?? null;
                    $icon = $resolveIcon($field['icon'] ?? null);
                    $type = $field['type'] ?? 'text';
                    $value = $field['value'] ?? null;
                    $placeholder = $field['placeholder'] ?? null;
                    $labelClass = $field['label_class'] ?? 'mb-2 block text-sm font-medium';
                    $labelToneClass = $field['label_tone_class'] ?? 'aui-primary-text';
                    $wrapperClass = $field['wrapper_class'] ?? (
                        ($field['variant'] ?? null) === 'underline'
                            ? 'grid grid-cols-[4rem_minmax(0,1fr)] overflow-hidden border-b border-slate-300'
                            : 'grid grid-cols-[4rem_minmax(0,1fr)] overflow-hidden rounded-sm border border-slate-200'
                    );
                    $iconWrapperClass = $field['icon_wrapper_class'] ?? 'flex items-center justify-center bg-slate-50 text-slate-400';
                    $inputClass = $field['input_class'] ?? (
                        ($field['variant'] ?? null) === 'underline'
                            ? 'w-full border-0 bg-white px-4 py-3 text-xl text-slate-900 focus:outline-none focus:ring-0'
                            : 'w-full border-0 bg-slate-100 px-4 py-4 text-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-[color:var(--aui-primary-soft)]'
                    );
                @endphp

                <div>
                    @if ($label)
                        <label for="{{ $inputId }}" class="{{ $labelClass }} {{ $labelToneClass }}">{{ $label }}</label>
                    @endif
                    <div class="{{ $wrapperClass }}">
                        <div class="{{ $iconWrapperClass }}">
                            @if ($icon)
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $icon !!}</svg>
                            @endif
                        </div>
                        <input
                            id="{{ $inputId }}"
                            name="{{ $field['name'] ?? null }}"
                            type="{{ $type }}"
                            value="{{ $value }}"
                            placeholder="{{ $placeholder }}"
                            @if (! empty($field['autocomplete'])) autocomplete="{{ $field['autocomplete'] }}" @endif
                            @if (! empty($field['required'])) required @endif
                            class="{{ $inputClass }}"
                        >
                    </div>
                </div>
            @endforeach
        </div>

        @if ($rememberLabel || $forgotPasswordHref || isset($meta))
            <div class="flex items-center justify-between gap-4 text-sm text-slate-500">
                <div>
                    @if ($rememberLabel)
                        <x-ui-kit-checkbox :label="$rememberLabel" />
                    @elseif (isset($meta))
                        {{ $meta }}
                    @endif
                </div>

                @if ($forgotPasswordHref)
                    <a href="{{ $forgotPasswordHref }}" class="text-base font-medium aui-primary-text hover:opacity-80">{{ $forgotPasswordLabel }}</a>
                @endif
            </div>
        @endif
    </div>
</x-ui-kit-form>
