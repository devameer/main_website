@props([
    'rows' => 5,
    'class' => '',
])

<div class="space-y-3 {{ $class }}">
    @for ($i = 0; $i < $rows; $i++)
        <div class="flex items-center gap-4">
            <div class="skeleton h-10 w-10 rounded-full"></div>
            <div class="flex-1 space-y-2">
                <div class="skeleton h-3 w-3/4 rounded"></div>
                <div class="skeleton h-3 w-1/2 rounded"></div>
            </div>
        </div>
    @endfor
</div>
