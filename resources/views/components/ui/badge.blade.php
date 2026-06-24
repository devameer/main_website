@props([
    'tone' => 'gray',   // gray | primary | success | warning | danger | info
    'dot' => false,     // render a leading dot
    'dotTone' => null,
])

@php
    $classes = $attributes->merge(['class' => 'badge badge-' . $tone]);
    $dotTone = $dotTone ?? $tone;
    $dotColors = [
        'gray' => 'bg-slate-400', 'primary' => 'bg-primary-500', 'success' => 'bg-success-500',
        'warning' => 'bg-warning-500', 'danger' => 'bg-danger-500', 'info' => 'bg-info-500',
    ];
@endphp

<span {{ $classes }}>
    @if ($dot)<span class="badge-dot {{ $dotColors[$dotTone] ?? 'bg-slate-400' }}"></span>@endif
    {{ $slot }}
</span>
