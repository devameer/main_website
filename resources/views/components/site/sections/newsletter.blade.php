@php
    $isArabic = app()->getLocale() === 'ar';
    $perks = [
        $isArabic ? 'أفكار عملية وقصيرة' : 'Short, practical ideas',
        $isArabic ? 'روابط وأدوات مفيدة' : 'Useful links & tools',
        $isArabic ? 'بلا رسائل مزعجة' : 'No spam, ever',
    ];
@endphp

<section class="relative overflow-hidden bg-[#f3f6ff] py-20 md:py-28">
    {{-- Decorative background blobs --}}
    <div class="pointer-events-none absolute -start-20 top-0 size-72 rounded-full bg-brand-200/40 blur-3xl"></div>
    <div class="pointer-events-none absolute -end-16 bottom-0 size-80 rounded-full bg-violet-200/40 blur-3xl"></div>

    <div class="relative mx-auto grid w-full max-w-6xl items-center gap-12 px-4 sm:px-6 md:grid-cols-2 md:gap-16">

        {{-- Visual: stylized newsletter card --}}
        <div class="relative order-2 mx-auto w-full max-w-md md:order-1">
            {{-- Floating envelope badge --}}
            <div class="absolute -end-3 -top-6 z-20 grid size-16 rotate-6 place-items-center rounded-2xl bg-linear-to-br from-brand-500 to-brand-700 text-3xl text-white shadow-xl shadow-brand-600/30">✉</div>
            {{-- Floating sparkle --}}
            <div class="absolute -start-3 top-1/2 z-20 grid size-10 -rotate-12 place-items-center rounded-xl border border-amber-200 bg-amber-50 text-lg text-amber-500 shadow-lg">★</div>

            {{-- Back card for depth --}}
            <div class="absolute inset-x-8 -top-4 -z-0 h-full -rotate-3 rounded-2xl border border-slate-200/70 bg-white/70 shadow-lg"></div>

            {{-- Main email card --}}
            <div class="relative z-10 rotate-2 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl transition duration-500 hover:rotate-0">
                {{-- Gradient header --}}
                <div class="relative flex items-center gap-3 bg-linear-to-br from-brand-600 to-brand-800 px-5 py-4 text-white">
                    <div class="grid size-10 shrink-0 place-items-center rounded-full bg-white/15 text-lg backdrop-blur">✦</div>
                    <div class="min-w-0">
                        <p class="truncate text-sm font-bold leading-tight">{{ $isArabic ? 'نشرة عامر البريدية' : 'Ameer’s Newsletter' }}</p>
                        <p class="truncate text-[11px] text-white/70" dir="ltr">from: devameer.com</p>
                    </div>
                    <span class="ms-auto shrink-0 rounded-full bg-white/15 px-2 py-0.5 text-[10px] font-semibold backdrop-blur">{{ $isArabic ? 'أسبوعية' : 'Weekly' }}</span>
                </div>

                {{-- Body preview --}}
                <div class="space-y-3 p-6">
                    <p class="text-sm font-bold text-slate-800">{{ $isArabic ? 'مرحباً يا قارئي العزيز،' : 'Hello friend,' }}</p>
                    <div class="space-y-2">
                        <div class="h-2.5 w-full rounded-full bg-slate-100"></div>
                        <div class="h-2.5 w-11/12 rounded-full bg-slate-100"></div>
                        <div class="h-2.5 w-4/5 rounded-full bg-brand-100"></div>
                    </div>
                    <div class="flex items-center gap-2 pt-1">
                        <span class="grid size-7 place-items-center rounded-full bg-brand-100 text-[11px] font-bold text-brand-700">ع</span>
                        <div class="h-2 w-24 rounded-full bg-slate-100"></div>
                    </div>
                </div>

                {{-- Footer strip --}}
                <div class="flex items-center justify-between border-t border-slate-100 bg-slate-50 px-6 py-3 text-[10px] text-slate-400">
                    <span class="tracking-tight text-amber-400">★★★★★</span>
                    <span>{{ $isArabic ? 'رسالة قصيرة، قيّمة' : 'Short, valuable notes' }}</span>
                </div>
            </div>
        </div>

        {{-- Content --}}
        <div class="order-1 md:order-2">
            <span class="inline-flex items-center gap-2 rounded-full border border-brand-200 bg-white px-4 py-1.5 text-sm font-bold text-brand-700 shadow-sm">
                <span class="relative flex size-2">
                    <span class="absolute inline-flex size-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex size-2 rounded-full bg-emerald-400"></span>
                </span>
                {{ $isArabic ? 'رسائل بلا ضوضاء' : 'Useful notes, no noise' }}
            </span>

            <h2 class="mt-5 text-4xl font-extrabold tracking-tight text-brand-600 md:text-6xl">{{ __('home.newsletter_title') }}</h2>

            <p class="mt-5 max-w-md text-lg leading-8 text-slate-600">{{ __('home.newsletter_desc') }}</p>

            <ul class="mt-6 flex flex-wrap gap-2">
                @foreach($perks as $perk)
                    <li class="inline-flex items-center gap-1.5 rounded-full bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-slate-200">
                        <span class="grid size-4 place-items-center rounded-full bg-emerald-100 text-[9px] font-bold text-emerald-600">✓</span>
                        {{ $perk }}
                    </li>
                @endforeach
            </ul>

            <div class="mt-8 max-w-md">
                <livewire:site.newsletter />
            </div>

            <p class="mt-3 text-xs text-slate-400">🔒 {{ $isArabic ? 'بريدك خاص. أراسل فقط حين يكون لدي ما يستحق المشاركة.' : 'Your email stays private. I only write when there’s something worth sharing.' }}</p>
        </div>
    </div>
</section>
