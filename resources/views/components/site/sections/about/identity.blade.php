@php $isArabic = app()->getLocale() === 'ar'; @endphp

<section class="relative overflow-hidden py-20 md:py-28">
    <div class="relative mx-auto max-w-3xl px-4 text-center sm:px-6">
        <div class="relative mx-auto grid size-56 place-items-center rounded-full border border-brand-100 bg-brand-50 shadow-[0_20px_60px_rgba(47,62,228,.16)] md:size-64">
            <div class="grid size-36 place-items-center rounded-full bg-linear-to-br from-brand-500 to-violet-500 text-6xl font-black text-white md:size-44">ع</div>

            <span class="absolute left-1/2 top-0 grid size-14 -translate-x-1/2 -translate-y-1/2 place-items-center rounded-full border border-slate-200 bg-white text-xs font-extrabold text-brand-600 shadow-lg">CSS</span>
            <span class="absolute right-0 top-1/4 grid size-14 translate-x-1/2 place-items-center rounded-full border border-slate-200 bg-white text-xs font-extrabold text-brand-600 shadow-lg">UX</span>
            <span class="absolute bottom-1/4 left-0 grid size-14 -translate-x-1/2 place-items-center rounded-full border border-slate-200 bg-white text-xs font-extrabold text-brand-600 shadow-lg">Vue</span>
            <span class="absolute bottom-0 right-1/4 grid size-14 translate-x-1/2 translate-y-1/2 place-items-center rounded-full border border-slate-200 bg-white text-xs font-extrabold text-brand-600 shadow-lg">A11Y</span>
        </div>

        <h2 class="mt-12 text-2xl font-bold tracking-tight text-slate-900 md:text-4xl">{{ $isArabic ? 'زوج، مصمم، مطوّر، كاتب، وصانع أشياء للويب' : 'Husband, designer, developer, author, and maker of things for the web' }}</h2>
        <p class="mx-auto mt-4 max-w-md text-base leading-8 text-slate-500">{{ $isArabic ? 'أحب صنع الأشياء التي تكون مفيدة، واضحة، وجميلة في الوقت نفسه.' : 'I enjoy making things that are useful, clear, and beautiful at the same time.' }}</p>
    </div>
</section>
