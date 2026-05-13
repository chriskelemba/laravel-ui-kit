@props([
    'label' => 'Upload file',
    'name' => 'file',
    'id' => null,
    'accept' => null,
])

@php
    $inputId = $id ?: $name;
@endphp

<label
    data-aui-upload-label
    x-data="{ previewUrl: null, fileName: null, isImage: false }"
    {{ $attributes->class(['aui-form-upload flex w-full cursor-pointer flex-col items-center justify-center rounded-[28px] border border-dashed px-5 py-8 text-center text-sm transition duration-200']) }}
    :class="theme === 'dark' ? 'border-white/10 bg-slate-950/40 text-slate-300 hover:border-white/20 hover:bg-slate-950/60' : 'border-slate-200 bg-white/90 text-slate-600 hover:border-slate-300 hover:bg-white'">
    <input
        id="{{ $inputId }}"
        type="file"
        name="{{ $name }}"
        data-aui-field
        @if($accept) accept="{{ $accept }}" @endif
        class="hidden"
        @required($attributes->has('required'))
        @change="
            const file = $event.target.files[0];
            if (!file) {
                previewUrl = null;
                fileName = null;
                isImage = false;
                return;
            }

            fileName = file.name;
            isImage = file.type.startsWith('image/');

            if (isImage) {
                previewUrl = URL.createObjectURL(file);
            } else {
                previewUrl = null;
            }
        "
    />
    <template x-if="previewUrl && isImage">
        <img :src="previewUrl" alt="Upload preview" class="mb-4 max-h-48 w-full rounded-lg object-cover">
    </template>
    <span class="mb-3 inline-flex h-12 w-12 items-center justify-center rounded-2xl aui-primary-gradient-soft">
        <svg class="h-5 w-5 aui-primary-text" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M10 2a.75.75 0 0 1 .75.75v7.69l2.72-2.72a.75.75 0 1 1 1.06 1.06l-4 4a.75.75 0 0 1-1.06 0l-4-4a.75.75 0 1 1 1.06-1.06l2.72 2.72V2.75A.75.75 0 0 1 10 2ZM4.5 13.75A.75.75 0 0 1 5.25 14.5v.25c0 .69.56 1.25 1.25 1.25h7c.69 0 1.25-.56 1.25-1.25v-.25a.75.75 0 0 1 1.5 0v.25a2.75 2.75 0 0 1-2.75 2.75h-7a2.75 2.75 0 0 1-2.75-2.75v-.25a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd"/>
        </svg>
    </span>
    <span class="font-semibold" :class="theme === 'dark' ? 'text-white' : 'text-slate-900'">{{ $label }}</span>
    <span x-show="fileName" x-cloak class="mt-2 text-xs font-medium text-slate-500" x-text="fileName"></span>
    <span x-show="!fileName" class="text-xs" :class="theme === 'dark' ? 'text-slate-500' : 'text-slate-400'">Drag and drop or click to browse</span>
</label>
