@props([
    'label' => null,
    'hint' => null,
    'error' => null,
    'options' => [],
    'placeholder' => null,
])

@php
    $id = $attributes->get('id');
    $fieldClass = 'field appearance-none pr-9' . ($error ? ' field-error' : '');
    $extra = $attributes->except(['class']);
@endphp

<div>
    @if ($label)
        <label for="{{ $id }}" class="label">{{ $label }}</label>
    @endif

    <div class="relative">
        <select id="{{ $id }}" class="{{ $fieldClass }}" {{ $extra }}>
            @if ($placeholder)
                <option value="" disabled {{ !old($attributes->get('name')) ? 'selected' : '' }}>{{ $placeholder }}</option>
            @endif
            @foreach ($options as $value => $labelText)
                <option value="{{ $value }}" @selected(old($attributes->get('name')) === (string) $value)>{{ $labelText }}</option>
            @endforeach
            {{ $slot ?? '' }}
        </select>
        <span class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">
            <x-ui.icon name="chevron-down" size="16" />
        </span>
    </div>

    @if ($error)
        <p class="field-hint flex items-center gap-1 text-danger-600 dark:text-danger-400">
            <x-ui.icon name="alert-triangle" size="12" /> {{ $error }}
        </p>
    @elseif ($hint)
        <p class="field-hint">{{ $hint }}</p>
    @endif
</div>
