@php $isArabic = app()->getLocale() === 'ar'; @endphp

<section class="border-y border-slate-100 bg-[#f3f6ff]">
    <div class="mx-auto w-full max-w-6xl px-4 py-12 sm:px-6 md:py-16">
        <p class="text-center text-sm font-semibold text-slate-500">{{ $isArabic ? 'عملت مع فرق ومنتجات في قطاعات مختلفة، وأستخدم هذه الأدوات يومياً' : 'I have worked across different teams and products, and I use these tools every day' }}</p>
        <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
            @foreach(['Vue.js', 'Nuxt', 'React', 'Next.js', 'Laravel', 'Tailwind CSS', 'WordPress', 'Figma'] as $tool)
                <span class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-700 shadow-sm">{{ $tool }}</span>
            @endforeach
        </div>
    </div>
</section>
