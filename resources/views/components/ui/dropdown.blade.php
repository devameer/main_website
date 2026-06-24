@props([
    'align' => 'right', // left | right
    'width' => 'w-56',
    'panelClass' => '',
])

@php
    $origin = $align === 'left' ? 'left-0' : 'right-0';
@endphp

<div
    x-data="{ open: false }"
    @keydown.escape.window="open = false"
    @click.outside="open = false"
    class="relative inline-block"
>
    <button type="button" @click="open = !open" class="inline-flex items-center" aria-haspopup="menu" :aria-expanded="open">
        {{ $trigger }}
    </button>

    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="popper absolute top-full mt-1.5 {{ $origin }} {{ $width }} origin-top-{{ $align }} {{ $panelClass }}"
        role="menu"
    >
        {{ $slot }}
    </div>
</div>
