@php
    $isArabic = app()->getLocale() === 'ar';
    $testimonials = \App\Models\Testimonial::published()->ordered()->get();
@endphp

<section class="bg-[#f3f6ff] py-20 md:py-28">
    <div class="mx-auto w-full max-w-6xl px-4 sm:px-6">
        <div class="mb-10">
            <p class="mb-2 text-sm font-semibold uppercase tracking-[.16em] text-brand-600">{{ $isArabic ? 'آراء' : 'Testimonials' }}</p>
            <h2 class="text-3xl font-bold tracking-tight text-slate-900 md:text-5xl">{{ $isArabic ? 'كلمات لطيفة عن عملي' : 'Kind words about my work' }}</h2>
        </div>
        <div class="columns-1 gap-5 sm:columns-2 lg:columns-4">
            @foreach($testimonials as $quote)
                <article class="mb-5 break-inside-avoid rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <span class="block text-3xl leading-none text-brand-200">&ldquo;</span>
                    <p class="mt-1 text-sm leading-7 text-slate-600">{{ $quote['body'] }}</p>
                    <div class="mt-5 flex items-center gap-3">
                        <span class="grid size-9 place-items-center rounded-full bg-linear-to-br from-brand-500 to-violet-500 text-xs font-extrabold text-white">{{ $quote->initials }}</span>
                        <div>
                            <strong class="block text-sm text-slate-800">{{ $quote['author'] }}</strong>
                            <span class="text-xs text-slate-400">{{ $quote['role'] }}</span>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
