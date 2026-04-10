@props([
    'title' => 'Details',
    'text' => '',
    'limit' => 120,
])

@php
    $preview = \Illuminate\Support\Str::limit($text, $limit);
@endphp

<x-ui-kit::molecules.modal :title="$title" size="lg">
    <x-slot:trigger>
        <button type="button" class="text-left">
            <span class="line-clamp-2 text-sm underline decoration-dotted underline-offset-2"
                :class="theme === 'dark' ? 'text-slate-200 hover:text-white' : 'text-slate-700 hover:text-slate-900'">
                {{ $preview }}
            </span>
        </button>
    </x-slot:trigger>

    <div class="space-y-2 text-sm" :class="theme === 'dark' ? 'text-slate-200' : 'text-slate-700'">
        {!! nl2br(e($text)) !!}
    </div>
</x-ui-kit::molecules.modal>
