@php
    $isArabic = app()->getLocale() === 'ar';
    $socials = [
        ['X', 'Twitter / X', 'https://twitter.com/ameer_alafash'],
        ['M', 'Mastodon', '#'],
        ['T', 'Threads', 'https://instagram.com/ameer_alafash'],
        ['in', 'LinkedIn', 'https://linkedin.com/in/ameer-alafash'],
        ['IG', 'Instagram', 'https://instagram.com/ameer_alafash'],
        ['GH', 'GitHub', 'https://github.com/ameer-alafash'],
        ['CP', 'CodePen', '#'],
        ['RSS', 'Feed', route('articles.index')],
    ];
@endphp

<section class="bg-[#f3f6ff] py-20 md:py-28">
    <div class="mx-auto w-full max-w-6xl px-4 sm:px-6">
        <div class="mb-10">
            <p class="mb-2 text-sm font-semibold uppercase tracking-[.16em] text-brand-600">{{ $isArabic ? 'تواصل' : 'Connect' }}</p>
            <h2 class="text-3xl font-bold tracking-tight text-slate-900 md:text-5xl">{{ $isArabic ? 'لنبقَ على تواصل' : 'Let’s connect' }}</h2>
            <p class="mt-3 text-lg text-slate-500">{{ $isArabic ? 'يمكنك التواصل معي عبر الشبكات التالية.' : 'You can connect with me through the following networks.' }}</p>
        </div>
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
            @foreach($socials as $social)
                <a href="{{ $social[2] }}" target="{{ str_starts_with($social[2], 'http') ? '_blank' : '_self' }}" rel="noopener noreferrer" class="group flex flex-col items-center justify-center gap-3 rounded-2xl border border-slate-200 bg-white p-6 text-center shadow-sm transition hover:-translate-y-1 hover:border-brand-200 hover:shadow-md">
                    <span class="grid size-12 place-items-center rounded-full bg-brand-50 text-sm font-extrabold text-brand-700 transition-colors group-hover:bg-brand-600 group-hover:text-white">{{ $social[0] }}</span>
                    <strong class="text-sm font-bold text-slate-700">{{ $social[1] }}</strong>
                </a>
            @endforeach
        </div>
    </div>
</section>
