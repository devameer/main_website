@props(['related'])

@if($related->isNotEmpty())
    <section class="border-t border-slate-100 bg-slate-50 py-14 md:py-20">
        <div class="mx-auto w-full max-w-5xl px-4 sm:px-6">
            <x-site.section-heading :kicker="__('articles.related_kicker')" :title="__('articles.related_title')" />
            <div class="grid gap-5 sm:grid-cols-3">
                @foreach ($related as $r)
                    <x-site.article-card :article="$r" />
                @endforeach
            </div>
        </div>
    </section>
@endif
