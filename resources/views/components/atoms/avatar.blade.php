@props([
    'name' => 'User',
    'src' => null,
    'size' => 'md',
])

@php
    $resolvedSrc = \ChrisKelemba\LaravelUiKit\Support\MediaUrl::resolve($src);
    $sizes = [
        'sm' => 'h-8 w-8 text-xs',
        'md' => 'h-10 w-10 text-sm',
        'lg' => 'h-14 w-14 text-base',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $initials = collect(explode(' ', $name))->map(fn ($p) => mb_substr($p, 0, 1))->join('');
@endphp

<div {{ $attributes->class(['inline-flex items-center justify-center overflow-hidden rounded-full ' . $sizeClass]) }}
     :class="theme === 'dark' ? 'bg-white/10 text-slate-200' : 'bg-slate-100 text-slate-700'">
    @if ($resolvedSrc)
        <img src="{{ $resolvedSrc }}" alt="{{ $name }}" class="h-full w-full object-cover" />
    @else
        <span class="font-semibold uppercase">{{ $initials }}</span>
    @endif
</div>
