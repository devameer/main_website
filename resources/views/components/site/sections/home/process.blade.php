@php
    $isArabic = app()->getLocale() === 'ar';
    $steps = [
        [
            'icon'  => '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>',
            'title' => $isArabic ? 'افهم' : 'Understand',
            'desc'  => $isArabic ? 'المستخدم والهدف والقيود، قبل أي بكسل.' : 'The user, goal, and constraints — before any pixel.',
        ],
        [
            'icon'  => '<path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>',
            'title' => $isArabic ? 'صمّم' : 'Design',
            'desc'  => $isArabic ? 'نظام بصري واضح يسبق التفاصيل.' : 'A clear visual system before the details.',
        ],
        [
            'icon'  => '<polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>',
            'title' => $isArabic ? 'ابنِ' : 'Build',
            'desc'  => $isArabic ? 'كود نظيف، سريع، وقابل للصيانة.' : 'Clean, fast, maintainable code.',
        ],
        [
            'icon'  => '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>',
            'title' => $isArabic ? 'اختبر' : 'Validate',
            'desc'  => $isArabic ? 'أداء، إتاحة، وتجربة هادئة.' : 'Performance, access, and a calm experience.',
        ],
    ];
@endphp

<section class="bg-[#f3f6ff] py-24 md:py-32">
    <div class="mx-auto w-full max-w-6xl px-4 sm:px-6">
        {{-- Header --}}
        <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end">
            <div class="max-w-2xl">
                <p class="mb-3 text-sm font-semibold uppercase tracking-[.2em] text-brand-600">{{ $isArabic ? 'كيف أعمل' : 'How I work' }}</p>
                <h2 class="text-4xl font-bold tracking-tight text-slate-900 md:text-6xl">{{ $isArabic ? 'تفاصيل صغيرة تصنع منتجاً أفضل' : 'Small details make a better product' }}</h2>
            </div>
            <a href="{{ route('about') }}" class="group inline-flex w-fit items-center gap-2 rounded-full border border-slate-300 px-6 py-3.5 text-base font-semibold text-slate-700 transition-colors hover:border-brand-400 hover:text-brand-700">
                {{ $isArabic ? 'اعرف المزيد' : 'Learn more' }}
                <span class="transition group-hover:translate-x-0.5">→</span>
            </a>
        </div>

        <p class="mt-8 max-w-xl text-base leading-8 text-slate-500">{{ $isArabic ? 'أربع خطوات واضحة، من فهم المشكلة إلى إطلاق تجربة متقنة.' : 'Four clear steps, from understanding the problem to shipping a polished experience.' }}</p>

        {{-- Flat cards with icons --}}
        <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($steps as $index => $step)
                <article class="group flex flex-col rounded-2xl border border-slate-200 bg-white p-7 transition-all duration-300 hover:border-brand-300 hover:shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="grid size-14 place-items-center rounded-xl bg-brand-50 text-brand-600 transition-colors duration-300 group-hover:bg-brand-600 group-hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6">{!! $step['icon'] !!}</svg>
                        </span>
                        <span class="font-mono text-sm font-semibold text-slate-300 transition-colors duration-300 group-hover:text-brand-400">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    <h3 class="mt-6 text-xl font-semibold text-slate-900 transition-colors group-hover:text-brand-700">{{ $step['title'] }}</h3>
                    <p class="mt-2 text-base leading-relaxed text-slate-500">{{ $step['desc'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
