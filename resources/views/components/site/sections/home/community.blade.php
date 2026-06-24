@php $isArabic = app()->getLocale() === 'ar'; @endphp

<section class="mx-auto w-full max-w-6xl px-4 py-20 sm:px-6 md:py-28">
    <div class="mb-10">
        <p class="mb-2 text-sm font-bold text-brand-600">{{ $isArabic ? 'أشارك المجتمع' : 'I give back to the community' }}</p>
        <h2 class="text-4xl font-extrabold tracking-tight text-brand-600 md:text-6xl">{{ $isArabic ? 'مساهمات الويب' : 'Web contributions' }}</h2>
    </div>
    <div class="grid gap-4 md:grid-cols-2">
        @foreach([
            ['CSS', $isArabic ? 'مقالات عملية' : 'Practical articles', $isArabic ? 'حلول واضحة لمشكلات الواجهات اليومية.' : 'Clear solutions to everyday front-end problems.', 'articles.index'],
            ['OSS', $isArabic ? 'مشاريع مفتوحة' : 'Open projects', $isArabic ? 'أدوات وتجارب صغيرة قابلة لإعادة الاستخدام.' : 'Reusable tools and focused experiments.', 'work'],
            ['UI', $isArabic ? 'أنظمة واجهات' : 'Interface systems', $isArabic ? 'مكوّنات مرنة تنمو مع المنتج.' : 'Flexible components that scale with the product.', 'services'],
            ['1:1', $isArabic ? 'مراجعات تقنية' : 'Technical reviews', $isArabic ? 'ملاحظات عملية لتحسين الكود والتجربة.' : 'Actionable feedback for code and UX.', 'contact'],
        ] as $item)
            <a href="{{ route($item[3]) }}" class="group grid min-h-52 gap-5 rounded-xl border border-slate-200 bg-slate-50 p-5 hover:border-brand-200 hover:shadow-lg sm:grid-cols-[1fr_45%]">
                <div class="self-center">
                    <span class="text-xs font-extrabold text-slate-400">{{ $item[0] }}</span>
                    <h3 class="mt-2 text-lg font-bold text-slate-800 group-hover:text-brand-700">{{ $item[1] }}</h3>
                    <p class="mt-2 text-sm leading-7 text-slate-500">{{ $item[2] }}</p>
                </div>
                <div class="grid min-h-32 place-items-center rounded-lg border border-slate-200 bg-white">
                    <div class="grid grid-cols-2 gap-2 p-5">
                        <i class="size-10 rounded bg-blue-100"></i><i class="size-10 rounded bg-brand-100"></i><i class="size-10 rounded bg-brand-200"></i><i class="size-10 rounded bg-sky-100"></i>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</section>
