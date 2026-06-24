@php
    $isArabic = app()->getLocale() === 'ar';
    $button = 'inline-flex items-center justify-center gap-1.5 rounded-lg bg-brand-700 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-brand-700/15 transition hover:-translate-y-0.5 hover:bg-brand-800';
@endphp

<section class="py-20 md:py-28">
    <div class="mx-auto max-w-3xl px-4 text-center sm:px-6">
        <div class="mx-auto mb-5 flex w-fit items-center gap-3 text-brand-500">
            <span class="h-px w-10 bg-brand-200"></span><span class="text-2xl">⚑</span><span class="h-px w-10 bg-brand-200"></span>
        </div>
        <p class="mb-2 text-sm font-semibold uppercase tracking-[.16em] text-brand-600">{{ $isArabic ? 'البداية' : 'The beginning' }}</p>
        <h2 class="text-3xl font-bold tracking-tight text-slate-900 md:text-5xl">{{ $isArabic ? 'كيف بدأ كل شيء؟' : 'How it all started' }}</h2>
        <p class="mt-6 text-lg leading-9 text-slate-600">{{ $isArabic ? 'بدأت رحلتي بالفضول: كيف تتحول فكرة بسيطة إلى شيء يمكن للناس استخدامه؟ تعلّمت التصميم والبرمجة بالتوازي، ومع كل مشروع أصبحت أرى العلاقة بين التفاصيل الصغيرة والنتيجة الكبيرة.' : 'It started with curiosity: how does a simple idea become something people can use? I learned design and development side by side, and every project made the connection between small details and the final experience clearer.' }}</p>
        <p class="mt-4 text-lg leading-9 text-slate-600">{{ __('about.p2') }}</p>
        <a href="{{ route('work') }}" class="{{ $button }} group mt-8">{{ $isArabic ? 'استكشف الرحلة' : 'Explore the timeline' }} <span class="transition group-hover:translate-x-0.5">→</span></a>
    </div>
</section>
