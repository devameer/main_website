@props([
    'label' => null,
    'hint' => null,
    'error' => null,
    'rows' => 4,
])

@php
    $fieldClass = 'field resize-y' . ($error ? ' field-error' : '');
    $id = $attributes->get('id');
    $extra = $attributes->except(['class']);
@endphp

<div>
    @if ($label)
        <label for="{{ $id }}" class="label">{{ $label }}</label>
    @endif

    <textarea id="{{ $id }}" rows="{{ $rows }}" class="{{ $fieldClass }}" {{ $extra }}>{{ $slot }}</textarea>

    @if ($error)
        <p class="field-hint flex items-center gap-1 text-danger-600 dark:text-danger-400">
            <x-ui.icon name="alert-triangle" size="12" /> {{ $error }}
        </p>
    @elseif ($hint)
        <p class="field-hint">{{ $hint }}</p>
    @endif
</div>
