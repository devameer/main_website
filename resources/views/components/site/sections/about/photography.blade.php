@php $isArabic = app()->getLocale() === 'ar'; @endphp

<section class="py-20 md:py-28">
    <div class="mx-auto w-full max-w-6xl px-4 sm:px-6">
        <div class="grid items-center gap-12 md:grid-cols-2">
            <div>
                <p class="mb-2 text-sm font-semibold uppercase tracking-[.16em] text-brand-600">{{ $isArabic ? 'هواية' : 'Hobby' }}</p>
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 md:text-5xl">{{ $isArabic ? 'أحب التصوير' : 'I love photography' }} 📷</h2>
                <div class="mt-5 space-y-4 text-lg leading-9 text-slate-600">
                    <p>{{ $isArabic ? 'أحمل الكاميرا عندما أسافر أو أمشي في المدينة. يساعدني التصوير على ملاحظة الضوء، التكوين، والتفاصيل التي قد تمر سريعاً.' : 'I carry a camera when I travel or walk through the city. Photography trains me to notice light, composition, and the details that are easy to miss.' }}</p>
                    <p>{{ $isArabic ? 'هذه الملاحظة البصرية تنعكس مباشرة على عملي في تصميم الواجهات.' : 'That visual awareness feeds directly into my interface design work.' }}</p>
                </div>
            </div>
            <div class="relative aspect-[4/3] overflow-hidden rounded-3xl bg-linear-to-br from-emerald-900 via-cyan-700 to-sky-300 shadow-xl">
                <div class="absolute inset-x-0 bottom-0 h-1/2 bg-[linear-gradient(35deg,transparent_20%,rgba(255,255,255,.22)_21%,transparent_23%,transparent_45%,rgba(255,255,255,.18)_46%,transparent_48%)]"></div>
                <div class="absolute end-4 bottom-4 max-w-[10rem] rounded-2xl bg-white/90 p-4 text-center text-xs font-bold text-slate-700 shadow-lg backdrop-blur">{{ $isArabic ? 'ألتقط لحظات من المدن والطبيعة' : 'Cities, details, and quiet moments' }}</div>
            </div>
        </div>
        <div class="mt-14 grid grid-cols-4 gap-4 border-t border-slate-200 pt-8 sm:grid-cols-5">
            @foreach(['from-emerald-200 to-green-500','from-amber-100 to-orange-400','from-sky-200 to-blue-500','from-rose-100 to-rose-400','from-stone-200 to-amber-600'] as $index => $gradient)
                <div class="{{ $index === 4 ? 'hidden sm:block' : '' }} -rotate-2 rounded-xl bg-linear-to-br {{ $gradient }} p-2 shadow-md transition hover:rotate-0"><div class="aspect-[4/3] rounded-lg bg-white/30"></div></div>
            @endforeach
        </div>
    </div>
</section>
