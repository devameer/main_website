<x-site.layout
    :title="__('articles.index_title') . ' — ' . __('brand.name')"
    :description="__('articles.index_subtitle')"
>

    {{-- Header band --}}
    <section class="relative overflow-hidden border-b border-slate-100 bg-[#f3f6ff]">
        <div class="pointer-events-none absolute -end-24 -top-24 size-80 rounded-full bg-brand-200/40 blur-3xl"></div>
        <div class="pointer-events-none absolute -start-20 bottom-0 size-64 rounded-full bg-violet-200/30 blur-3xl"></div>

        <div class="relative mx-auto w-full max-w-6xl px-4 py-16 sm:px-6 md:py-24">
            <p class="mb-3 text-sm font-semibold uppercase tracking-[.16em] text-brand-600">{{ __('articles.index_kicker') }}</p>
            <h1 class="text-4xl font-bold tracking-tight text-slate-900 md:text-6xl">{{ __('articles.index_title') }}</h1>
            <p class="mt-4 max-w-2xl text-lg leading-8 text-slate-500">{{ __('articles.index_subtitle') }}</p>

            <x-site.sections.articles.index-filters :categories="$categories" :category="$category" />
        </div>
    </section>

    <x-site.sections.articles.index-featured :featured="$featured" :category="$category" />

    <x-site.sections.articles.index-list :articles="$articles" :category="$category" />

</x-site.layout>
