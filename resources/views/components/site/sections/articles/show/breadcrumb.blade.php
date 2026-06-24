@props(['article'])

<div class="border-b border-slate-100 bg-slate-50 py-3">
    <div class="mx-auto flex w-full max-w-5xl items-center gap-2 px-4 text-sm text-slate-400 sm:px-6">
        <a href="{{ route('home') }}" class="hover:text-brand-700">{{ __('articles.breadcrumb_home') }}</a>
        <span>/</span>
        <a href="{{ route('articles.index') }}" class="hover:text-brand-700">{{ __('articles.breadcrumb_articles') }}</a>
        @if($article->category)
            <span>/</span>
            <a href="{{ route('articles.index', ['category' => $article->category]) }}" class="hover:text-brand-700">{{ $article->category }}</a>
        @endif
    </div>
</div>
