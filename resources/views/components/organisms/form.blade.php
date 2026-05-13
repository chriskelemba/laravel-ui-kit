@props([
    'action' => '',
    'method' => 'POST',
    'submitLabel' => 'Save',
])

<form method="{{ in_array(strtoupper($method), ['GET', 'POST']) ? $method : 'POST' }}" action="{{ $action }}" novalidate data-aui-form {{ $attributes->class(['space-y-6']) }}>
    @csrf
    @if (!in_array(strtoupper($method), ['GET', 'POST']))
        @method($method)
    @endif

    <div class="space-y-6">
        {{ $slot }}
    </div>

    <div class="flex flex-wrap items-center justify-end gap-3 border-t border-slate-200/80 pt-4 dark:border-white/10">
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

@once
    @push('head')
        <style>
            .aui-field-invalid {
                border-color: rgb(244 63 94 / 0.9) !important;
                box-shadow: 0 0 0 1px rgb(244 63 94 / 0.12);
            }

            .aui-upload-invalid {
                border-color: rgb(244 63 94 / 0.9) !important;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            (() => {
                const errorClass = 'aui-client-error';

                const getFieldValue = field => {
                    if (field.type === 'file') {
                        return field.files && field.files.length > 0 ? '1' : '';
                    }

                    if (field.type === 'checkbox' || field.type === 'radio') {
                        return field.checked ? field.value : '';
                    }

                    return (field.value || '').trim();
                };

                const getFieldWrapper = field => field.closest('.space-y-1') || field.parentElement;

                const clearFieldError = field => {
                    field.classList.remove('aui-field-invalid');

                    const uploadLabel = field.closest('[data-aui-upload-label]');
                    if (uploadLabel) {
                        uploadLabel.classList.remove('aui-upload-invalid');
                    }

                    const wrapper = getFieldWrapper(field);
                    const error = wrapper ? wrapper.querySelector('.' + errorClass + '[data-aui-generated="true"]') : null;
                    if (error) {
                        error.remove();
                    }
                };

                const showFieldError = (field, message) => {
                    clearFieldError(field);

                    field.classList.add('aui-field-invalid');

                    const uploadLabel = field.closest('[data-aui-upload-label]');
                    if (uploadLabel) {
                        uploadLabel.classList.add('aui-upload-invalid');
                    }

                    const wrapper = getFieldWrapper(field);
                    if (!wrapper) return;

                    const error = document.createElement('p');
                    error.className = errorClass + ' text-sm text-rose-600';
                    error.dataset.auiGenerated = 'true';
                    error.innerHTML = '<span style="display:inline-flex;align-items:center;gap:0.4rem;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:0.95rem;height:0.95rem;flex:none;"><path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.198 0l7.355 12.735c1.154 1.999-.29 4.5-2.6 4.5H4.646c-2.31 0-3.754-2.501-2.6-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a1.125 1.125 0 1 0 0-2.25 1.125 1.125 0 0 0 0 2.25Z" clip-rule="evenodd"/></svg><span>' + message + '</span></span>';
                    wrapper.appendChild(error);
                };

                document.addEventListener('input', event => {
                    const field = event.target.closest('[data-aui-field]');
                    if (!field) return;

                    if (getFieldValue(field) !== '') {
                        clearFieldError(field);
                    }
                });

                document.addEventListener('change', event => {
                    const field = event.target.closest('[data-aui-field]');
                    if (!field) return;

                    if (getFieldValue(field) !== '') {
                        clearFieldError(field);
                    }
                });

                document.addEventListener('submit', event => {
                    const form = event.target;
                    if (!(form instanceof HTMLFormElement) || !form.hasAttribute('data-aui-form')) return;

                    let hasErrors = false;

                    form.querySelectorAll('[data-aui-field][required]').forEach(field => {
                        if (getFieldValue(field) === '') {
                            showFieldError(field, 'This field is required.');
                            hasErrors = true;
                            return;
                        }

                        clearFieldError(field);
                    });

                    if (hasErrors) {
                        event.preventDefault();
                    }
                }, true);
            })();
        </script>
    @endpush
@endonce
