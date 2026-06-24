@php $isArabic = app()->getLocale() === 'ar'; @endphp

<section class="relative isolate overflow-hidden bg-navy-950 text-white">
    {{-- Layered background gradient --}}
    <div class="absolute inset-0 -z-10 bg-linear-to-br from-[#0a1330] via-[#13265c] to-[#2f54c4]"></div>
    {{-- Masked grid --}}
    <div class="absolute inset-0 -z-10 opacity-20 [background-image:linear-gradient(rgba(255,255,255,.12)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,.12)_1px,transparent_1px)] [background-size:64px_64px] [mask-image:radial-gradient(ellipse_75%_65%_at_50%_42%,black,transparent)]"></div>
    {{-- Subtle film grain --}}
    <div class="pointer-events-none absolute inset-0 -z-10 opacity-[0.06] mix-blend-soft-light" style="background-image:url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22140%22 height=%22140%22><filter id=%22n%22><feTurbulence type=%22fractalNoise%22 baseFrequency=%220.9%22 numOctaves=%222%22/></filter><rect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23n)%22/></svg>')"></div>
    {{-- Glow orbs --}}
    <div class="absolute -start-32 -top-40 -z-10 size-[30rem] rounded-full bg-sky-500/30 blur-[110px] animate-float-slow"></div>
    <div class="absolute -bottom-44 end-[6%] -z-10 size-[28rem] rounded-full bg-violet-600/40 blur-[110px] animate-float"></div>
    <div class="absolute start-[26%] top-[32%] -z-10 size-72 rounded-full bg-brand-500/25 blur-[90px]"></div>

    {{-- Floating code editor card --}}
    <div class="absolute end-[-26%] top-[7%] -z-10 hidden rotate-3 lg:block">
        <div class="animate-float-slow overflow-hidden rounded-2xl border border-white/15 bg-slate-950/70 opacity-80 shadow-2xl backdrop-blur-xl">
            <div class="flex h-11 w-[44vw] max-w-[620px] items-center gap-2 border-b border-white/10 bg-white/5 px-4">
                <i class="size-2.5 rounded-full bg-rose-400"></i><i class="size-2.5 rounded-full bg-amber-300"></i><i class="size-2.5 rounded-full bg-emerald-400"></i>
                <span class="mx-auto h-2 w-2/5 rounded-full bg-white/10"></span>
            </div>
            <div dir="ltr" class="w-[44vw] max-w-[620px] space-y-2.5 p-8 text-left font-mono text-sm leading-relaxed text-blue-100/90">
                <p><span class="me-4 select-none text-slate-600">1</span><span class="text-violet-300">const</span> <span class="text-sky-300">ameer</span> <span class="text-slate-500">=</span> &#123;</p>
                <p><span class="me-4 select-none text-slate-600">2</span>&nbsp;&nbsp;<span class="text-amber-200">role</span>: <span class="text-emerald-300">'Designer & Dev'</span>,</p>
                <p><span class="me-4 select-none text-slate-600">3</span>&nbsp;&nbsp;<span class="text-amber-200">stack</span>: [<span class="text-emerald-300">'UI'</span>, <span class="text-emerald-300">'Web'</span>, <span class="text-emerald-300">'A11y'</span>],</p>
                <p><span class="me-4 select-none text-slate-600">4</span>&nbsp;&nbsp;<span class="text-amber-200">shipping</span>: <span class="text-emerald-300">true</span><span class="ms-0.5 inline-block w-2 animate-blink text-sky-300">▍</span></p>
                <p><span class="me-4 select-none text-slate-600">5</span>&#125;;</p>
            </div>
        </div>
    </div>

    {{-- Floating phone card --}}
    <div class="absolute -bottom-16 start-[5%] -z-10 hidden -rotate-6 lg:block">
        <div class="animate-float h-96 w-48 rounded-[2.5rem] border border-white/15 bg-white/10 p-4 shadow-2xl backdrop-blur-xl">
            <div class="mx-auto h-1.5 w-1/4 rounded-full bg-white/30"></div>
            <div class="mx-auto mt-7 grid size-20 place-items-center rounded-2xl bg-linear-to-br from-emerald-300 to-brand-500 text-3xl shadow-[0_0_40px_rgba(80,220,210,.5)]">✦</div>
            <div class="mx-auto mt-5 h-2.5 w-3/4 rounded-full bg-white/25"></div>
            <div class="mx-auto mt-2.5 h-2.5 w-1/2 rounded-full bg-white/15"></div>
            <div class="mt-5 grid grid-cols-2 gap-2">
                <div class="h-12 rounded-lg bg-white/10"></div>
                <div class="h-12 rounded-lg bg-white/10"></div>
            </div>
            <div class="mt-2 h-7 rounded-lg bg-white/15"></div>
        </div>
    </div>

    {{-- Center content --}}
    <div class="relative mx-auto flex min-h-[560px] max-w-5xl flex-col items-center justify-center px-4 py-28 text-center md:min-h-[720px]">
        <span class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-5 py-2 text-sm font-semibold text-blue-100 backdrop-blur">
            <span class="relative flex size-2">
                <span class="absolute inline-flex size-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex size-2 rounded-full bg-emerald-400"></span>
            </span>
            {{ $isArabic ? 'متاح لمشاريع جديدة' : 'Available for new projects' }}
        </span>

        <p class="mb-4 text-sm font-bold uppercase tracking-[.2em] text-blue-200/80">{{ __('home.hero_kicker') }}</p>

        <h1 class="flex flex-col items-center gap-2.5 text-[clamp(2.5rem,7vw,5.5rem)] font-bold leading-[1.05] tracking-[-.045em]">
            <span class="flex flex-wrap items-end justify-center gap-x-3 gap-y-2.5">
                <span class="w-fit -rotate-1 rounded-xl bg-brand-600 px-4 pb-2.5 shadow-[0_20px_50px_-12px_rgba(47,62,228,.7)]">{{ __('home.hero_title_1') }}</span>
                <span class="w-fit rotate-1 rounded-xl bg-linear-to-br from-brand-400 to-brand-700 px-4 pb-2.5 shadow-[0_20px_50px_-12px_rgba(47,62,228,.7)]">{{ __('home.hero_highlight') }}</span>
            </span>
            <span class="text-white/90">{{ __('home.hero_title_2') }}</span>
        </h1>

        {{-- <p class="mt-7 max-w-xl text-sm leading-7 text-blue-100/75 md:text-base">{{ __('home.hero_desc') }}</p>

        <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
            <a href="{{ route('contact') }}" class="group inline-flex items-center gap-2 rounded-xl bg-white px-6 py-3 text-sm font-bold text-brand-700 shadow-lg transition hover:-translate-y-0.5 hover:bg-blue-50">
                {{ __('home.btn_contact') }} <span class="transition group-hover:translate-x-0.5">→</span>
            </a>
            <a href="{{ route('work') }}" class="inline-flex items-center gap-2 rounded-xl border border-white/20 bg-white/5 px-6 py-3 text-sm font-bold text-white backdrop-blur transition hover:-translate-y-0.5 hover:bg-white/10">
                {{ __('home.btn_work') }}
            </a>
        </div>

        <dl class="mt-12 grid grid-cols-3 gap-4 text-center sm:gap-10">
            @foreach([
                ['5+', $isArabic ? 'سنوات خبرة' : 'Years'],
                ['40+', $isArabic ? 'مشروع' : 'Projects'],
                ['100%', $isArabic ? 'التزام' : 'Craft'],
            ] as $stat)
                <div class="flex flex-col">
                    <dt class="bg-linear-to-br from-white to-blue-200 bg-clip-text text-2xl font-extrabold text-transparent md:text-3xl">{{ $stat[0] }}</dt>
                    <dd class="mt-1 text-[11px] uppercase tracking-wider text-blue-200/70">{{ $stat[1] }}</dd>
                </div>
            @endforeach
        </dl> --}}
    </div>

    {{-- Tech ticker --}}
    <div class="relative flex items-center overflow-hidden border-y border-white/10 bg-white/[0.03] py-3 backdrop-blur">
        <span class="z-10 flex shrink-0 items-center gap-1.5 border-e border-white/10 px-5 text-[10px] font-bold uppercase tracking-wider text-blue-200/80">
            <span class="text-amber-300">★</span> {{ $isArabic ? 'أبني بـ' : 'Built with' }}
        </span>
        <div class="relative flex overflow-hidden [mask-image:linear-gradient(90deg,transparent,black_8%,black_92%,transparent)]">
            <div class="flex w-max animate-marquee items-center gap-8 px-4 text-xs font-semibold text-blue-100/70 hover:[animation-play-state:paused]" dir="ltr">
                @foreach(array_merge(__('home.skills'), __('home.skills')) as $skill)
                    <span class="flex items-center gap-8">{{ $skill }}<i class="size-1 rounded-full bg-brand-400/60"></i></span>
                @endforeach
            </div>
        </div>
    </div>

    <p class="absolute end-4 top-4 text-[10px] font-medium text-white/50">{{ $isArabic ? 'تصميم وتطوير: عامر علافش' : 'Designed & built by Ameer Alafash' }}</p>
</section>
