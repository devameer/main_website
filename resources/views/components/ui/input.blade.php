@props([
    'label' => null,
    'hint' => null,
    'error' => null,
    'icon' => null,
])

@php
    $id = $attributes->get('id', old("field_{$attributes->get('name')}"));
    $fieldClass = 'field' . ($error ? ' field-error' : '');
    $extra = $attributes->except(['class']);
@endphp

<div>
    @if ($label)
        <label for="{{ $id }}" class="label">{{ $label }}</label>
    @endif

    <div class="relative">
        @if ($icon)
            <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                <x-ui.icon :name="$icon" size="16" />
            </span>
        @endif

        <input id="{{ $id }}" class="{{ $fieldClass }} {{ $icon ? 'pl-9' : '' }}" {{ $extra }}>
    </div>

    @if ($error)
        <p class="field-hint flex items-center gap-1 text-danger-600 dark:text-danger-400">
            <x-ui.icon name="alert-triangle" size="12" /> {{ $error }}
        </p>
    @elseif ($hint)
        <p class="field-hint">{{ $hint }}</p>
    @endif
</div>
