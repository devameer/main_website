@props(['latestArticles'])

@php
    $isArabic = app()->getLocale() === 'ar';
    $button = 'inline-flex items-center justify-center gap-1.5 rounded-lg bg-brand-700 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-brand-700/15 transition hover:-translate-y-0.5 hover:bg-brand-800';
    $featured = $latestArticles->first();
    $rest = $latestArticles->slice(1);
@endphp

@if($latestArticles->isNotEmpty())
    <section class="mx-auto w-full max-w-6xl px-4 py-20 sm:px-6 md:py-28">
        {{-- Header --}}
        <div class="mb-10 flex flex-col items-start justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="mb-2 text-sm font-bold uppercase tracking-[.16em] text-brand-600">{{ __('home.articles_kicker') }}</p>
                <h2 class="text-4xl font-extrabold tracking-tight text-brand-600 md:text-6xl">{{ __('home.articles_title') }}</h2>
            </div>
            <a class="{{ $button }} group" href="{{ route('articles.index') }}">
                {{ __('home.articles_action') }}
                <span class="transition group-hover:translate-x-0.5">→</span>
            </a>
        </div>

        {{-- Featured + list --}}
        <div class="grid gap-8 lg:grid-cols-[1.15fr_1fr] lg:gap-12">

            {{-- Featured article --}}
            @if($featured)
                <a href="{{ route('articles.show', $featured->slug) }}" @class([
                    'group relative flex flex-col justify-between overflow-hidden rounded-2xl border border-slate-200 bg-white p-7 shadow-sm transition hover:-translate-y-1 hover:border-brand-200 hover:shadow-xl md:p-9',
                    'lg:col-span-2' => $rest->isEmpty(),
                ])>
                    {{-- Decorative big index --}}
                    <span class="pointer-events-none absolute -end-3 -top-7 select-none text-[8rem] font-black leading-none text-brand-50 transition group-hover:text-brand-100">01</span>
                    {{-- Accent bar --}}
                    <span class="absolute inset-y-0 start-0 w-1 bg-linear-to-b from-brand-400 to-brand-700"></span>

                    <div class="relative">
                        <div class="flex flex-wrap items-center gap-2">
                            @if($featured->category)
                                <span class="rounded-full bg-brand-50 px-2.5 py-1 text-[11px] font-bold text-brand-700">{{ $featured->category }}</span>
                            @endif
                            <span class="rounded-full bg-amber-50 px-2.5 py-1 text-[11px] font-bold text-amber-600">{{ $isArabic ? 'مختار' : 'Featured' }}</span>
                        </div>
                        <h3 class="mt-4 text-3xl font-extrabold leading-snug text-slate-900 transition group-hover:text-brand-700 md:text-4xl">{{ $featured->display_title }}</h3>
                        @if($featured->excerpt)
                            <p class="mt-3 line-clamp-3 text-base leading-8 text-slate-500">{{ $featured->excerpt }}</p>
                        @endif
                    </div>

                    <div class="relative mt-6 flex items-center justify-between gap-4">
                        <div class="flex flex-wrap items-center gap-2 text-xs text-slate-400">
                            @if($featured->published_at)
                                <time>{{ $featured->published_at->translatedFormat('d M Y') }}</time>
                            @endif
                            @if($featured->reading_time)
                                <span>·</span>
                                <span>{{ __('common.minutes_read', ['n' => $featured->reading_time]) }}</span>
                            @endif
                        </div>
                        <span class="inline-flex shrink-0 items-center gap-1 text-sm font-bold text-brand-600">
                            {{ $isArabic ? 'اقرأ المقال' : 'Read article' }}
                            <span class="transition group-hover:translate-x-0.5">↗</span>
                        </span>
                    </div>
                </a>
            @endif

            {{-- Rest list --}}
            @if($rest->isNotEmpty())
                <div class="flex flex-col">
                    @foreach($rest as $index => $article)
                        <a href="{{ route('articles.show', $article->slug) }}" class="group relative flex items-center gap-4 border-t border-slate-200 py-4 transition-colors first:border-t-0 first:pt-0 hover:bg-brand-50/40 sm:px-2 sm:rounded-lg">
                            <span class="w-8 shrink-0 font-mono text-xs font-bold text-slate-300 transition group-hover:text-brand-500">{{ str_pad((string) ($index + 2), 2, '0', STR_PAD_LEFT) }}</span>
                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2 text-xs text-slate-400">
                                    @if($article->published_at)
                                        <time>{{ $article->published_at->translatedFormat('d M Y') }}</time>
                                    @endif
                                    @if($article->category)
                                        <span>·</span>
                                        <span class="font-semibold text-brand-600">{{ $article->category }}</span>
                                    @endif
                                </div>
                                <h3 class="mt-1 truncate text-base font-bold text-slate-800 transition group-hover:text-brand-700">{{ $article->display_title }}</h3>
                            </div>
                            <span class="shrink-0 text-brand-500 opacity-0 transition group-hover:translate-x-0.5 group-hover:opacity-100">↗</span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endif
