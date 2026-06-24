@props(['article'])

<a href="{{ route('articles.show', $article->slug) }}" class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white transition-all duration-300 hover:-translate-y-1 hover:border-brand-200 hover:shadow-xl">
    <div class="relative aspect-video overflow-hidden">
        @if($article->cover_image)
            <img src="{{ $article->cover_image }}" alt="{{ $article->display_title }}" class="size-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy" decoding="async">
        @else
            <div class="flex size-full items-center justify-center bg-linear-to-br from-brand-100 via-brand-50 to-violet-50">
                <span class="text-5xl font-black text-brand-300 transition-colors group-hover:text-brand-400">{{ mb_substr($article->display_title, 0, 1) }}</span>
            </div>
        @endif
        @if($article->category)
            <span class="absolute start-3 top-3 rounded-full bg-white/90 px-2.5 py-1 text-xs font-bold text-brand-700 shadow-sm backdrop-blur">{{ $article->category }}</span>
        @endif
    </div>

    <div class="flex flex-1 flex-col p-5">
        <h3 class="text-lg font-bold leading-snug text-slate-900 transition-colors group-hover:text-brand-700">{{ $article->display_title }}</h3>

        @if($article->excerpt)
            <p class="mt-2 line-clamp-2 text-sm leading-6 text-slate-500">{{ $article->excerpt }}</p>
        @endif

        <div class="mt-auto flex items-center gap-3 pt-5 text-xs text-slate-400">
            @if($article->published_at)
                <time datetime="{{ $article->published_at->toDateString() }}">{{ $article->published_at->translatedFormat('d M Y') }}</time>
            @endif
            @if($article->reading_time)
                <span class="size-1 rounded-full bg-slate-300"></span>
                <span>{{ __('common.minutes_read', ['n' => $article->reading_time]) }}</span>
            @endif
        </div>
    </div>
</a>
