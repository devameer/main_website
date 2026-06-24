@props([
    'label' => '',
    'value' => '',
    'icon' => 'activity',
    'tone' => 'primary',   // primary | success | warning | danger | info
    'delta' => null,       // e.g. '+12%'
    'deltaUp' => true,     // is the delta positive
])

@php
    $iconTones = [
        'primary' => 'bg-primary-50 text-primary-600 dark:bg-primary-500/15 dark:text-primary-400',
        'success' => 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-400',
        'warning' => 'bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-warning-400',
        'danger'  => 'bg-danger-50 text-danger-600 dark:bg-danger-500/15 dark:text-danger-400',
        'info'    => 'bg-info-50 text-info-600 dark:bg-info-500/15 dark:text-info-400',
    ];
    $deltaTone = $deltaUp ? 'text-success-600 dark:text-success-400' : 'text-danger-600 dark:text-danger-400';
@endphp

<div {{ $attributes->merge(['class' => 'card p-5']) }}>
    <div class="flex items-start justify-between gap-3">
        <div class="min-w-0">
            <p class="text-xs font-medium text-slate-500 dark:text-slate-400">{{ $label }}</p>
            <p class="mt-2 text-2xl font-bold tracking-tight text-slate-900 dark:text-white">{{ $value }}</p>
            @if ($delta)
                <p class="mt-2 inline-flex items-center gap-1 text-xs font-semibold {{ $deltaTone }}">
                    <x-ui.icon :name="$deltaUp ? 'trending-up' : 'trending-down'" size="13" />
                    {{ $delta }}
                    <span class="font-normal text-slate-400">vs last month</span>
                </p>
            @endif
        </div>
        <span class="stat-icon {{ $iconTones[$tone] ?? $iconTones['primary'] }}">
            <x-ui.icon :name="$icon" size="20" />
        </span>
    </div>
</div>
