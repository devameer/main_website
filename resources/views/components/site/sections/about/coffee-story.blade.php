@php $isArabic = app()->getLocale() === 'ar'; @endphp

<section class="py-20 md:py-28">
    <div class="mx-auto w-full max-w-6xl px-4 sm:px-6">
        <div class="grid items-center gap-12 md:grid-cols-2">
            {{-- Visual --}}
            <div class="relative order-2 flex min-h-80 items-center justify-center overflow-hidden rounded-3xl bg-linear-to-br from-[#2d1d13] via-[#4a2f1e] to-[#7a4a2b] p-10 shadow-xl md:order-1">
                <div class="pointer-events-none absolute -end-10 -top-10 size-40 rounded-full bg-amber-400/20 blur-3xl"></div>
                <div class="pointer-events-none absolute -start-10 bottom-0 size-40 rounded-full bg-orange-500/10 blur-3xl"></div>
                <div class="relative text-center">
                    <div class="mx-auto grid size-36 place-items-center rounded-full border border-white/15 bg-white/5 text-7xl backdrop-blur">☕</div>
                    <p class="mt-5 text-lg font-bold text-amber-50">Espresso</p>
                    <p class="text-sm text-amber-100/60">{{ $isArabic ? 'طقوس الصباح اليومية' : 'A daily morning ritual' }}</p>
                </div>
                <span class="absolute bottom-4 start-4 rounded-full bg-white/10 px-3 py-1 text-xs font-bold text-amber-100 backdrop-blur">{{ $isArabic ? 'استراحة قهوة' : 'Coffee break' }}</span>
            </div>

            {{-- Text --}}
            <div class="order-1 md:order-2">
                <p class="mb-2 text-sm font-semibold uppercase tracking-[.16em] text-brand-600">{{ $isArabic ? 'خارج الشاشة' : 'Off the screen' }}</p>
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 md:text-5xl">{{ $isArabic ? 'يبدأ يومي بفنجان إسبريسو' : 'Every day starts with espresso' }}</h2>
                <div class="mt-5 space-y-4 text-lg leading-9 text-slate-600">
                    <p>{{ $isArabic ? 'لطالما بدأ يومي بكوب إسبريسو. لدي ماكينة صغيرة في المنزل، وفي كل صباح أتعلم تفصيلاً جديداً عن الاستخلاص والطعم.' : 'I always start my day with a cup of espresso. I have a small home setup, and every morning brings one more detail to learn about extraction and taste.' }}</p>
                    <p>{{ $isArabic ? 'إذا أردت دعمي أو بدء حديث خفيف، فالقهوة دائماً مدخل جيد.' : 'If you want to support my work or start a light conversation, coffee is always a good opening.' }}</p>
                </div>
                <a href="{{ route('contact') }}" class="mt-7 inline-flex items-center gap-2 rounded-lg bg-rose-500 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-rose-500/15 transition hover:-translate-y-0.5 hover:bg-rose-600">{{ $isArabic ? 'ادعمني بقهوة ☕' : 'Support me with coffee ☕' }}</a>
            </div>
        </div>
    </div>
</section>
