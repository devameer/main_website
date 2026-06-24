@php
    $isArabic = app()->getLocale() === 'ar';
    $button = 'inline-flex items-center justify-center rounded-lg bg-brand-700 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-brand-700/15 transition hover:-translate-y-0.5 hover:bg-brand-800';
@endphp

<section class="mx-auto w-full max-w-3xl px-4 py-20 sm:px-6 md:py-28">
    <p class="mb-2 text-sm font-bold text-brand-600">{{ $isArabic ? 'مرحباً، أنا عامر' : 'Hi, I’m Ameer' }}</p>
    <h2 class="text-4xl font-extrabold leading-tight tracking-tight text-brand-600 md:text-6xl">{{ $isArabic ? 'أربط بين التصميم المتقن والتطوير القابل للتوسع.' : 'I bridge the gap between thoughtful design and scalable development.' }}</h2>
    <p class="mt-6 text-lg leading-9 text-slate-600">{{ __('home.hero_desc') }}</p>
    <p class="mt-2 text-lg leading-9 text-slate-600">{{ $isArabic ? 'أبني واجهات سريعة، واضحة وسهلة الاستخدام؛ من الفكرة الأولى وحتى الإطلاق.' : 'I build fast, clear, and easy-to-use interfaces — from the first idea through launch.' }}</p>
    <a class="{{ $button }} mt-6" href="{{ route('contact') }}">{{ $isArabic ? 'لنبدأ مشروعاً' : 'Start a project' }}</a>
</section>
