@props([
    'variant' => 'primary', // primary | secondary | ghost | danger | success | warning
    'size' => 'md',         // sm | md | lg | icon
    'as' => 'button',       // button | a
    'href' => null,
    'loading' => false,
    'icon' => null,
    'iconRight' => null,
])

@php
    $classes = 'btn btn-' . $variant . ' btn-' . $size;
    if ($loading) {
        $classes .= ' pointer-events-none opacity-70';
    }
    $tag = ($as === 'a' || $href) ? 'a' : 'button';

    $merged = $attributes->merge(['class' => $classes]);
    if ($tag === 'button' && ! $attributes->has('type')) {
        $merged = $merged->merge(['type' => 'button']);
    }
@endphp

<{{ $tag }} @if ($tag === 'a') href="{{ $href }}" @endif {{ $merged }}>
    @if ($loading)
        <x-ui.icon name="loader" size="16" class="animate-spin" />
    @elseif ($icon)
        <x-ui.icon :name="$icon" size="16" />
    @endif

    @isset($slot)<span>{{ $slot }}</span>@endisset

    @if ($iconRight && ! $loading)
        <x-ui.icon :name="$iconRight" size="16" />
    @endif
</{{ $tag }}>
