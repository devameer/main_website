@php
    $isArabic = app()->getLocale() === 'ar';
    $button = 'inline-flex items-center justify-center rounded-lg bg-brand-700 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-brand-700/15 transition hover:-translate-y-0.5 hover:bg-brand-800';
    $outlineBtn = 'inline-flex items-center justify-center rounded-lg border border-slate-300 px-6 py-3.5 text-sm font-bold text-slate-700 transition hover:-translate-y-0.5 hover:border-brand-400 hover:text-brand-700';
    $items = [
        [$isArabic ? 'مصمم واجهات ومطوّر Front-end' : 'Designer who codes', 'bg-brand-500'],
        [$isArabic ? 'أكتب عن CSS وتجربة المستخدم' : 'Author of practical CSS articles', 'bg-amber-500'],
        [$isArabic ? 'أبني منتجات عربية ومتعددة اللغات' : 'Building multilingual products', 'bg-emerald-500'],
        [$isArabic ? 'مهتم بالإتاحة والأداء' : 'Accessibility & performance advocate', 'bg-violet-500'],
    ];
@endphp

<section class="relative overflow-hidden">
    <div class="pointer-events-none absolute -end-24 -top-24 size-80 rounded-full bg-brand-100/50 blur-3xl"></div>
    <div class="pointer-events-none absolute -start-20 bottom-0 size-72 rounded-full bg-violet-100/40 blur-3xl"></div>

    <div class="relative mx-auto grid w-full max-w-6xl items-center gap-12 px-4 py-16 sm:px-6 md:grid-cols-[1.2fr_.8fr] md:py-24">
        <div>
            <p class="mb-3 text-sm font-semibold uppercase tracking-[.16em] text-brand-600">{{ __('about.kicker') }}</p>
            <h1 class="text-4xl font-bold tracking-tight text-slate-900 md:text-6xl">{{ $isArabic ? 'مرحباً! أنا عامر' : 'Hello! I’m Ameer' }} 👋</h1>

            <ul class="mt-8 space-y-3">
                @foreach($items as $item)
                    <li class="flex items-center gap-3 text-base text-slate-700">
                        <span class="size-2.5 shrink-0 rounded-full {{ $item[1] }}"></span>
                        {{ $item[0] }}
                    </li>
                @endforeach
            </ul>

            <div class="mt-8 max-w-2xl space-y-4 text-lg leading-9 text-slate-600">
                <p>{!! __('about.lead') !!}</p>
                <p>{{ __('about.p1') }}</p>
            </div>

            <div class="mt-9 flex flex-wrap gap-3">
                <a class="{{ $button }}" href="{{ route('contact') }}">{{ $isArabic ? 'لنبدأ مشروعاً' : 'Start a project' }}</a>
                <a class="{{ $outlineBtn }}" href="{{ route('work') }}">{{ $isArabic ? 'شاهد أعمالي' : 'View my work' }}</a>
            </div>
        </div>

        <div class="relative mx-auto w-full max-w-sm">
            <div class="absolute -end-5 -top-5 size-28 rounded-full bg-amber-200/70 blur-2xl"></div>
            <div class="relative overflow-hidden rounded-3xl border border-slate-200 bg-linear-to-br from-emerald-100 via-blue-100 to-violet-100 p-6 shadow-2xl">
                <div class="relative grid min-h-80 place-items-center rounded-2xl border border-white/70 bg-white/40 backdrop-blur-sm">
                    <div class="text-center">
                        <div class="mx-auto grid size-32 place-items-center rounded-full border-8 border-white/60 bg-brand-600 text-6xl font-black text-white shadow-xl">ع</div>
                        <p class="mt-5 text-xl font-extrabold text-slate-800">{{ __('brand.name') }}</p>
                        <p class="mt-1 text-sm text-slate-600">{{ __('brand.role') }}</p>
                        <div class="mt-4 inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700">
                            <span class="relative flex size-2">
                                <span class="absolute inline-flex size-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex size-2 rounded-full bg-emerald-400"></span>
                            </span>
                            {{ $isArabic ? 'متاح' : 'Available' }}
                        </div>
                    </div>
                </div>
                <div class="absolute bottom-4 start-4 rounded-lg bg-brand-600 px-3 py-2 text-xs font-semibold text-white shadow-lg">{{ $isArabic ? 'القاهرة، مصر · يعمل عالمياً' : 'Cairo, Egypt · Working globally' }}</div>
            </div>
        </div>
    </div>
</section>
