@props(['kicker' => null, 'title', 'subtitle' => null, 'center' => false, 'action' => null, 'actionLabel' => null, 'actionRoute' => null])

<div class="{{ $center ? 'text-center' : '' }} mb-8">
    @if($kicker)
        <p class="mb-2 text-xs font-semibold uppercase tracking-widest text-brand-600">{{ $kicker }}</p>
    @endif
    <div class="{{ $action || $actionRoute ? 'flex items-end justify-between gap-4' : '' }}">
        <h2 class="text-2xl font-bold leading-tight text-slate-900 md:text-3xl">{{ $title }}</h2>
        @if($actionRoute)
            <a href="{{ route($actionRoute) }}" class="shrink-0 inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold text-brand-700 transition-all duration-150 hover:bg-slate-100 hover:text-slate-900 disabled:opacity-50">
                {{ $actionLabel ?? __('common.view_all') }}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ app()->getLocale() === 'ar' ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        @endif
    </div>
    @if($subtitle)
        <p class="mt-3 max-w-2xl text-slate-500">{{ $subtitle }}</p>
    @endif
</div>
