@props(['articles' => null, 'category' => null])

<section class="border-t border-slate-100 py-16 md:py-24">
    <div class="mx-auto w-full max-w-6xl px-4 sm:px-6">
        <div class="mb-8">
            <p class="mb-2 text-sm font-semibold uppercase tracking-[.16em] text-brand-600">{{ __('articles.all_kicker') }}</p>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900 md:text-4xl">{{ $category ?? __('articles.all_title') }}</h2>
        </div>

        @if($articles->isEmpty())
            <div class="rounded-2xl border border-dashed border-slate-300 py-20 text-center">
                <p class="text-slate-400">{{ __('common.no_articles') }}</p>
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($articles as $article)
                    <x-site.article-card :article="$article" />
                @endforeach
            </div>

            <x-site.sections.pagination :paginator="$articles" />
        @endif
    </div>
</section>
