@props(['article'])

@php $dir = ($article->language === 'ar') ? 'rtl' : 'ltr'; @endphp

<section class="border-b border-slate-100 bg-white py-10">
    <div class="mx-auto w-full max-w-3xl px-4 sm:px-6">
        @if($article->category)
            <a href="{{ route('articles.index', ['category' => $article->category]) }}" class="mb-3 block text-xs font-semibold uppercase tracking-wide text-brand-600">{{ $article->category }}</a>
        @endif

        <h1 class="text-3xl font-extrabold leading-tight text-slate-900 md:text-4xl" dir="{{ $dir }}">{{ $article->display_title }}</h1>

        @if($article->excerpt)
            <p class="mt-4 text-lg leading-relaxed text-slate-500" dir="{{ $dir }}">{{ $article->excerpt }}</p>
        @endif

        <div class="mt-6 flex flex-wrap items-center gap-4 text-sm text-slate-400">
            <div class="flex items-center gap-2">
                @if($article->author_avatar)
                    <img src="{{ $article->author_avatar }}" alt="{{ $article->author }}" class="h-7 w-7 rounded-full object-cover" loading="lazy" decoding="async" width="28" height="28">
                @else
                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-brand-100 text-xs font-bold text-brand-700">ع</span>
                @endif
                <span class="font-medium text-slate-700">{{ $article->author }}</span>
            </div>
            @if($article->published_at)
                <time datetime="{{ $article->published_at->toDateString() }}">{{ $article->published_at->translatedFormat('d F Y') }}</time>
            @endif
            @if($article->reading_time)
                <span>{{ __('common.minutes_read', ['n' => $article->reading_time]) }}</span>
            @endif
            <span>{{ __('common.views', ['n' => number_format($article->views)]) }}</span>
        </div>
    </div>
</section>
