@props([
    'text' => null,
    'placement' => 'top', // top | bottom | left | right
])

@php
    $pos = match ($placement) {
        'bottom' => 'top-full left-1/2 -translate-x-1/2 mt-1.5',
        'left' => 'right-full top-1/2 -translate-y-1 mr-1.5',
        'right' => 'left-full top-1/2 -translate-y-1/2 ml-1.5',
        default => 'bottom-full left-1/2 -translate-x-1/2 -translate-y-full -top-1 mb-1.5',
    };
@endphp

<span class="group relative inline-flex" role="presentation">
    {{ $slot }}
    @if ($text)
        <span class="tooltip {{ $pos }}" role="tooltip">{{ $text }}</span>
    @endif
</span>
