@php
    $isArabic = app()->getLocale() === 'ar';
    $gear = ['Sage Barista Pro', 'Precision basket', 'Hand grinder', 'Distribution tool', 'Digital scale', 'Fresh beans'];
@endphp

<section class="bg-[#f3f6ff] py-20 md:py-28">
    <div class="mx-auto w-full max-w-6xl px-4 sm:px-6">
        <div class="grid items-center gap-12 md:grid-cols-[1.3fr_.7fr]">
            <div>
                <p class="mb-2 text-sm font-semibold uppercase tracking-[.16em] text-brand-600">{{ $isArabic ? 'خلف الكوب' : 'Behind the cup' }}</p>
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 md:text-5xl">{{ $isArabic ? 'عدة الإسبريسو الخاصة بي' : 'My espresso gear' }}</h2>
                <p class="mt-4 text-lg leading-9 text-slate-600">{{ $isArabic ? 'أملك بعض الأدوات البسيطة التي تساعدني في الوصول إلى كوب متوازن كل صباح.' : 'A small, focused setup that helps me make a balanced cup every morning.' }}</p>
                <ul class="mt-6 grid grid-cols-1 gap-3 sm:grid-cols-2">
                    @foreach($gear as $item)
                        <li class="flex items-center gap-2.5 text-base text-slate-700">
                            <span class="grid size-5 shrink-0 place-items-center rounded-full bg-brand-100 text-xs font-bold text-brand-700">✓</span>
                            {{ $item }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="grid min-h-72 place-items-center rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                <div class="relative h-40 w-44">
                    <div class="absolute inset-x-0 top-0 h-28 rounded-2xl border-2 border-slate-200 bg-slate-50"></div>
                    <div class="absolute left-1/2 top-4 h-3 w-16 -translate-x-1/2 rounded-full bg-slate-200"></div>
                    <div class="absolute left-1/2 top-12 h-2 w-10 -translate-x-1/2 rounded-full bg-slate-200"></div>
                    <div class="absolute bottom-0 left-1/2 h-16 w-14 -translate-x-1/2 rounded-b-xl border-2 border-t-0 border-slate-200 bg-slate-50"></div>
                    <div class="absolute bottom-3 left-1/2 h-6 w-16 -translate-x-1/2 rounded-b-lg border-2 border-t-0 border-brand-200 bg-brand-50"></div>
                </div>
            </div>
        </div>
    </div>
</section>
