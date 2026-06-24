@php
    $navLinks = [
        ['label' => __('nav.home'), 'route' => 'home'],
        ['label' => __('nav.articles'), 'route' => 'articles.index'],
        ['label' => __('nav.work'), 'route' => 'work'],
        ['label' => __('nav.services'), 'route' => 'services'],
        ['label' => __('nav.about'), 'route' => 'about'],
        ['label' => __('nav.contact'), 'route' => 'contact'],
    ];
    $socials = [
        ['label' => 'X', 'href' => \App\Models\Setting::get('social_twitter', 'https://twitter.com/ameer_alafash')],
        ['label' => 'in', 'href' => \App\Models\Setting::get('social_linkedin', 'https://linkedin.com/in/ameer-alafash')],
        ['label' => 'GH', 'href' => \App\Models\Setting::get('social_github', 'https://github.com/ameer-alafash')],
        ['label' => 'IG', 'href' => \App\Models\Setting::get('social_instagram', 'https://instagram.com/ameer_alafash')],
    ];
@endphp

<footer class="bg-linear-to-b from-[#102d75] to-[#0c1f55] px-4 pb-6 pt-12 text-center text-[#c9d4f2]">
    <div class="mx-auto w-full max-w-3xl">
        <a href="{{ route('home') }}" class="mx-auto -mt-16 grid size-11 place-items-center rounded-full border-4 border-white bg-brand-600 font-black text-white shadow-xl" aria-label="{{ __('brand.name') }}">ع</a>
        <p class="mt-4 text-xs text-blue-200">
            {{ app()->getLocale() === 'ar' ? 'وصلت إلى نهاية موقع' : 'That’s the end of' }}
            <strong class="text-white">{{ __('brand.name') }}</strong>.
        </p>

        <nav class="my-5 flex flex-wrap justify-center gap-x-5 gap-y-2" aria-label="{{ __('footer.pages_title') }}">
            @foreach($navLinks as $link)
                <a href="{{ route($link['route']) }}" class="text-xs font-semibold text-white hover:text-blue-200">{{ $link['label'] }}</a>
            @endforeach
        </nav>

        <div class="flex justify-center gap-2">
            @foreach($socials as $social)
                <a href="{{ $social['href'] }}" target="_blank" rel="noopener noreferrer" class="grid size-8 place-items-center rounded-full border border-white/20 text-[10px] font-extrabold text-blue-100 hover:bg-white hover:text-blue-900" aria-label="{{ $social['label'] }}">{{ $social['label'] }}</a>
            @endforeach
        </div>

        <div class="mx-auto my-8 h-px w-3/4 bg-white/10"></div>
        <p class="text-xl">👋</p>
        <p class="mt-2 text-xs text-blue-300">{{ app()->getLocale() === 'ar' ? 'تعال وقل مرحباً' : 'Come and say hello' }}</p>
        <button type="button" class="mx-auto mt-1 flex items-center justify-center gap-2 text-xl font-extrabold text-white" onclick="copyEmail('hey@devameer.com')">
            <span dir="ltr">hey@devameer.com</span><span class="text-xs text-blue-300" aria-hidden="true">⧉</span>
        </button>
        <span id="email-copied" class="block min-h-5 text-xs text-emerald-300 opacity-0 transition-opacity">{{ __('footer.email_copied') }}</span>
        <p class="mt-1 text-blue-400">&amp;</p>
        <a href="{{ route('contact') }}" class="text-xs text-blue-200 hover:text-white">{{ app()->getLocale() === 'ar' ? 'لنشرب قهوة' : 'Let’s grab a coffee' }} ☕</a>
        <p class="mt-10 text-[10px] text-blue-400">{{ __('footer.copyright', ['year' => date('Y')]) }}</p>
    </div>
</footer>
