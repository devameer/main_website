@props(['article', 'bodyHtml'])

@php $dir = ($article->language === 'ar') ? 'rtl' : 'ltr'; @endphp

@if($article->cover_image)
    <div class="mx-auto w-full max-w-3xl px-4 py-8 sm:px-6">
        <img src="{{ $article->cover_image }}" alt="{{ $article->display_title }}" class="w-full rounded-2xl border border-slate-200 object-cover shadow-sm" fetchpriority="high" decoding="async" width="768" height="432">
    </div>
@endif

<section class="py-8">
    <div class="mx-auto w-full max-w-3xl px-4 sm:px-6">
        <div class="prose prose-slate max-w-none prose-headings:font-bold prose-a:text-brand-700 prose-a:no-underline hover:prose-a:underline" dir="{{ $dir }}">
            {!! $bodyHtml !!}
        </div>
    </div>
</section>

@if($article->secondary_keywords)
    <div class="mx-auto w-full max-w-3xl px-4 pb-8 sm:px-6">
        <div class="flex flex-wrap gap-2">
            @foreach ((array) $article->secondary_keywords as $kw)
                <span class="inline-block rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-medium text-slate-600 transition-colors hover:border-brand-300 hover:bg-brand-50 hover:text-brand-700">{{ $kw }}</span>
            @endforeach
        </div>
    </div>
@endif
