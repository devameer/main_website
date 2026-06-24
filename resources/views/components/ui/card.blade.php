@props([
    'title' => null,
    'subtitle' => null,
    'bodyClass' => '',
    'headerClass' => '',
    'as' => 'div',
])

@php $classes = $attributes->merge(['class' => 'card']); @endphp

<{{ $as }} {{ $classes }}>
    @if (isset($header) || $title || $subtitle)
        <div class="card-header {{ $headerClass }}">
            <div class="min-w-0">
                @if ($title)<h3 class="card-title truncate">{{ $title }}</h3>@endif
                @if ($subtitle)<p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">{{ $subtitle }}</p>@endif
            </div>
            @isset($header)<div class="flex items-center gap-2">{{ $header }}</div>@endisset
        </div>
    @endif

    <div class="card-body {{ $bodyClass }}">
        {{ $slot }}
    </div>
</{{ $as }}>
