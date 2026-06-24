@props(['featured' => null, 'category' => null])

@if(! $category && $featured && $featured->isNotEmpty())
    <section class="py-16 md:py-24">
        <div class="mx-auto w-full max-w-6xl px-4 sm:px-6">
            <div class="mb-8">
                <p class="mb-2 text-sm font-semibold uppercase tracking-[.16em] text-brand-600">{{ __('articles.featured_kicker') }}</p>
                <h2 class="text-2xl font-bold tracking-tight text-slate-900 md:text-4xl">{{ __('articles.featured_title') }}</h2>
            </div>
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($featured as $article)
                    <x-site.article-card :article="$article" />
                @endforeach
            </div>
        </div>
    </section>
@endif
