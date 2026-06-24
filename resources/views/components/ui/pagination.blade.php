@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center gap-1">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="flex h-8 w-8 cursor-not-allowed items-center justify-center rounded-md text-slate-300 dark:text-slate-600">
                <x-ui.icon name="chevron-left" size="16" />
            </span>
        @else
            <button type="button" wire:click="previousPage" wire:loading.attr="disabled" class="flex h-8 w-8 items-center justify-center rounded-md text-slate-500 transition-colors hover:bg-slate-100 dark:hover:bg-slate-800">
                <x-ui.icon name="chevron-left" size="16" />
            </button>
        @endif

        {{-- Numbers --}}
        @foreach ($elements as $element)
            @if (is_array($element))
                <span class="flex h-8 w-8 items-center justify-center text-slate-400">…</span>
            @else
                @if ($element == $paginator->currentPage())
                    <span class="flex h-8 min-w-8 items-center justify-center rounded-md bg-primary-600 px-2 text-sm font-semibold text-white">{{ $element }}</span>
                @else
                    <button type="button" wire:click="gotoPage({{ $element }})" class="flex h-8 min-w-8 items-center justify-center rounded-md px-2 text-sm font-medium text-slate-600 transition-colors hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800">{{ $element }}</button>
                @endif
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <button type="button" wire:click="nextPage" wire:loading.attr="disabled" class="flex h-8 w-8 items-center justify-center rounded-md text-slate-500 transition-colors hover:bg-slate-100 dark:hover:bg-slate-800">
                <x-ui.icon name="chevron-right" size="16" />
            </button>
        @else
            <span class="flex h-8 w-8 cursor-not-allowed items-center justify-center rounded-md text-slate-300 dark:text-slate-600">
                <x-ui.icon name="chevron-right" size="16" />
            </span>
        @endif
    </nav>
@endif
