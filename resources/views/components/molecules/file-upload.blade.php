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
    {{ $attributes->class(['flex w-full cursor-pointer flex-col items-center justify-center rounded-xl border border-dashed px-4 py-6 text-sm']) }}
    :class="theme === 'dark' ? 'border-white/10 text-slate-300 hover:border-white/20' : 'border-slate-200 text-slate-600 hover:border-slate-300'">
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
    <span class="font-semibold">{{ $label }}</span>
    <span x-show="fileName" x-cloak class="mt-2 text-xs font-medium text-slate-500" x-text="fileName"></span>
    <span x-show="!fileName" class="text-xs" :class="theme === 'dark' ? 'text-slate-500' : 'text-slate-400'">Drag and drop or click to browse</span>
</label>
