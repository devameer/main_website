@php
    $isArabic = app()->getLocale() === 'ar';
    $contributions = [
        ['CSS', $isArabic ? 'كتاب تصحيح CSS' : 'Debugging CSS book'],
        ['41+', $isArabic ? 'مقالات تقنية' : 'Technical articles'],
        ['RTL', $isArabic ? 'دليل RTL' : 'RTL Styling 101'],
        ['OSS', $isArabic ? 'أدوات مفتوحة' : 'Open source tools'],
        ['A11Y', $isArabic ? 'إتاحة الويب' : 'Accessibility notes'],
    ];
@endphp

<section class="bg-[#f3f6ff] py-20 md:py-28">
    <div class="mx-auto w-full max-w-6xl px-4 sm:px-6">
        <div class="mb-10">
            <p class="mb-2 text-sm font-semibold uppercase tracking-[.16em] text-brand-600">{{ $isArabic ? 'إسهاماتي' : 'Contributions' }}</p>
            <h2 class="text-3xl font-bold tracking-tight text-slate-900 md:text-5xl">{{ $isArabic ? 'أبرز المساهمات' : 'Key contributions' }}</h2>
        </div>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
            @foreach($contributions as $index => $item)
                <article class="group rounded-2xl border border-slate-200 bg-white p-5 text-center shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <div @class(['grid h-24 place-items-center rounded-xl font-mono text-2xl font-extrabold transition-colors', 'bg-brand-600 text-white' => $index === 0, 'bg-slate-50 text-brand-600 group-hover:bg-brand-50' => $index !== 0])>{{ $item[0] }}</div>
                    <p class="mt-4 text-sm font-semibold text-slate-700">{{ $item[1] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
