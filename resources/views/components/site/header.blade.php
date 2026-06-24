@php
    $links = [
        ['label' => __('nav.home'),      'route' => 'home'],
        ['label' => __('nav.articles'),  'route' => 'articles.index'],
        ['label' => __('nav.work'),      'route' => 'work'],
        ['label' => __('nav.services'),  'route' => 'services'],
        ['label' => __('nav.about'),     'route' => 'about'],
        ['label' => __('nav.contact'),   'route' => 'contact'],
    ];

    $switchTo     = app()->getLocale() === 'ar' ? 'en' : 'ar';
    $switchLabel  = app()->getLocale() === 'ar' ? 'EN' : 'ع';
    $currentRoute = request()->route()?->getName();
    $switchParams = array_merge(request()->route()?->parameters() ?? [], ['locale' => $switchTo]);
    $switchUrl    = $currentRoute && in_array($currentRoute, ['home','articles.index','articles.show','work','about','services','contact'])
        ? route($currentRoute, $switchParams)
        : "/{$switchTo}";
@endphp

<header class="sticky top-0 z-50 border-b border-slate-200 bg-white/90 backdrop-blur" x-data="siteNav()">
    <div class="mx-auto flex h-16 w-full max-w-5xl items-center justify-between gap-4 px-4 sm:px-6">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-slate-900 hover:text-brand-700">
            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-700 text-[13px] font-black text-white shadow">ع</span>
            <span class="hidden sm:inline">{{ __('brand.name') }}</span>
        </a>

        {{-- Desktop nav --}}
        <nav class="hidden items-center gap-1 md:flex">
            @foreach ($links as $link)
                <a
                    href="{{ route($link['route']) }}"
                    class="rounded-lg px-3 py-1.5 text-sm font-medium text-slate-600 transition-colors hover:bg-slate-100 hover:text-brand-700 {{ request()->routeIs($link['route']) ? 'font-semibold text-brand-700' : '' }}"
                >{{ $link['label'] }}</a>
            @endforeach
        </nav>

        {{-- CTA + Mobile toggle --}}
        <div class="flex items-center gap-2">
            <a href="{{ $switchUrl }}"
               class="flex h-9 items-center gap-1 rounded-lg border border-slate-200 px-3 text-xs font-bold text-slate-600 transition-colors hover:bg-slate-50"
               aria-label="{{ $switchTo === 'ar' ? 'العربية' : 'English' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.6 9h16.8M3.6 15h16.8M11.5 3a17 17 0 000 18M12.5 3a17 17 0 010 18"/></svg>
                <span>{{ $switchLabel }}</span>
            </a>

            <a href="{{ route('contact') }}" class="hidden sm:inline-flex inline-flex items-center gap-2 rounded-lg bg-brand-700 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-150 hover:bg-brand-800 disabled:opacity-50">{{ __('nav.cta') }}</a>

            {{-- Mobile hamburger --}}
            <button
                type="button"
                @click="toggle()"
                class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 md:hidden"
                :aria-expanded="open"
            >
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="open" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="-translate-y-2 opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-end="-translate-y-2 opacity-0"
        class="border-t border-slate-200 bg-white px-4 py-3 md:hidden"
        @click.outside="close()"
    >
        <nav class="flex flex-col gap-1">
            @foreach ($links as $link)
                <a
                    href="{{ route($link['route']) }}"
                    class="rounded-lg px-3 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-100 {{ request()->routeIs($link['route']) ? 'bg-brand-50 text-brand-700' : '' }}"
                    @click="close()"
                >{{ $link['label'] }}</a>
            @endforeach
            <div class="mt-2 border-t border-slate-100 pt-2">
                <a href="{{ route('contact') }}" class="inline-flex w-full items-center gap-2 justify-center rounded-lg bg-brand-700 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-150 hover:bg-brand-800 disabled:opacity-50">{{ __('nav.cta') }}</a>
            </div>
        </nav>
    </div>
</header>
