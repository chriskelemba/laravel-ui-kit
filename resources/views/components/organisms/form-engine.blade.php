@props([
    'fields' => [],
    'sections' => [],
    'columns' => 2,
    'idPrefix' => 'aui-field',
    'errors' => [],
    'values' => [],
])

{{-- Field schema keys:
    type, name, label, value, placeholder, required, readonly, disabled,
    help_text, options, id, wrapper_class.
--}}

@php
    $columnClass = match ((int) $columns) {
        1 => 'grid-cols-1',
        3 => 'grid-cols-1 md:grid-cols-3',
        default => 'grid-cols-1 md:grid-cols-2',
    };
@endphp

@php
    $resolvedSections = count($sections) > 0 ? $sections : [[
        'id' => 'default',
        'title' => null,
        'description' => null,
        'card' => false,
        'fields' => $fields,
    ]];

    $resolveFieldError = static function ($errors, ?string $name) {
        if (!filled($name)) {
            return null;
        }

        if (is_array($errors)) {
            return $errors[$name] ?? null;
        }

        if ($errors instanceof \Illuminate\Support\ViewErrorBag) {
            return $errors->first($name);
        }

        if ($errors instanceof \Illuminate\Support\MessageBag) {
            return $errors->first($name);
        }

        if (is_object($errors) && method_exists($errors, 'first')) {
            return $errors->first($name);
        }

        return null;
    };
@endphp

<div {{ $attributes->class(['space-y-4']) }}>
    @foreach ($resolvedSections as $sectionIndex => $section)
        @php
            $sectionFields = $section['fields'] ?? [];
            $sectionId = $section['id'] ?? ('section-' . $sectionIndex);
            $sectionCard = (bool) ($section['card'] ?? false);
        @endphp

        <section class="{{ $sectionCard ? 'rounded-xl border border-slate-200 p-4' : '' }}">
            @if (filled($section['title'] ?? null))
                <h3 class="text-base font-semibold text-slate-800">{{ $section['title'] }}</h3>
            @endif
            @if (filled($section['description'] ?? null))
                <p class="mt-1 text-sm text-slate-600">{{ $section['description'] }}</p>
            @endif

            <div class="mt-3 grid gap-4 {{ $columnClass }}">
                @foreach ($sectionFields as $index => $field)
                    @php
                        $type = $field['type'] ?? 'text';
                        $name = $field['name'] ?? null;
                        $label = $field['label'] ?? null;
                        $placeholder = $field['placeholder'] ?? null;
                        $required = (bool) ($field['required'] ?? false);
                        $readonly = (bool) ($field['readonly'] ?? false);
                        $disabled = (bool) ($field['disabled'] ?? false);
                        $helpText = $field['help_text'] ?? null;
                        $options = $field['options'] ?? [];
                        $value = $values[$name] ?? ($field['value'] ?? null);
                        $id = $field['id'] ?? ($idPrefix . '-' . $sectionId . '-' . $index);
                        $wrapperClass = $field['wrapper_class'] ?? '';
                        $error = $resolveFieldError($errors, $name);
                        $slotName = $name ? ('field_' . str_replace(['.', '-'], '_', $name)) : null;
                    @endphp

                    <div class="space-y-1 {{ $wrapperClass }}">
                        @if (filled($label))
                            <label for="{{ $id }}" class="text-sm font-medium text-slate-700">
                                {{ $label }}@if($required)<span class="text-rose-600"> *</span>@endif
                            </label>
                        @endif

                        @if ($slotName && isset(${$slotName}))
                            {{ ${$slotName} }}
                        @elseif ($type === 'select')
                            <x-ui-kit::molecules.select
                                :id="$id"
                                :name="$name"
                                :options="$options"
                                :placeholder="$placeholder"
                                :required="$required"
                                :disabled="$disabled"
                                data-aui-field
                                class="{{ $error ? 'aui-field-invalid' : '' }}"
                            />
                        @elseif ($type === 'textarea')
                            <x-ui-kit::molecules.textarea
                                :id="$id"
                                :name="$name"
                                :placeholder="$placeholder"
                                :required="$required"
                                :readonly="$readonly"
                                :disabled="$disabled"
                                data-aui-field
                                class="{{ $error ? 'aui-field-invalid' : '' }}"
                            >{{ $value }}</x-ui-kit::molecules.textarea>
                        @else
                            <x-ui-kit::atoms.input
                                :id="$id"
                                :name="$name"
                                :type="$type"
                                :value="$value"
                                :placeholder="$placeholder"
                                :required="$required"
                                :readonly="$readonly"
                                :disabled="$disabled"
                                data-aui-field
                                class="{{ $error ? 'aui-field-invalid' : '' }}"
                            />
                        @endif

                        @if (filled($error))
                            <p class="text-xs text-rose-600">{{ $error }}</p>
                        @elseif (filled($helpText))
                            <p class="text-xs text-slate-500">{{ $helpText }}</p>
                        @endif
                    </div>
                @endforeach

                {{ $slot }}
            </div>
        </section>
    @endforeach
</div>
