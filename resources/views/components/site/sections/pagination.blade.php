@props(['paginator'])

@if($paginator->hasPages())
    <div class="mt-10 flex justify-center gap-2">
        @if($paginator->onFirstPage())
            <span class="cursor-not-allowed rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-300">{{ __('common.previous') }}</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm text-slate-700 transition-colors hover:bg-slate-50">{{ __('common.previous') }}</a>
        @endif

        @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
            @if($page === $paginator->currentPage())
                <span class="rounded-lg bg-brand-700 px-4 py-2 text-sm font-medium text-white">{{ $page }}</span>
            @else
                <a href="{{ $url }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm text-slate-700 transition-colors hover:bg-slate-50">{{ $page }}</a>
            @endif
        @endforeach

        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm text-slate-700 transition-colors hover:bg-slate-50">{{ __('common.next') }}</a>
        @else
            <span class="cursor-not-allowed rounded-lg border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-300">{{ __('common.next') }}</span>
        @endif
    </div>
@endif
