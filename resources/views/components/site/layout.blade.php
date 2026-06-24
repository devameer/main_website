@props([
    'title'       => null,
    'description' => null,
    'ogImage'     => null,
    'dir'         => null,
    'lang'        => null,
])

@php
    $locale = app()->getLocale();
    $dir ??= $locale === 'ar' ? 'rtl' : 'ltr';
    $lang ??= $locale;
    $title ??= __('brand.name') . ' — ' . __('brand.role');
    $description ??= __('home.hero_desc');
    $ogImage ??= \App\Models\Setting::get('og_image') ?: null;

    $promoOn   = \App\Models\Setting::get('promo_enabled', '1') === '1';
    $promoText = \App\Models\Setting::get($locale === 'ar' ? 'promo_text_ar' : 'promo_text_en');
    $promoLink = \App\Models\Setting::get('promo_link', '');
@endphp

<!DOCTYPE html>
<html dir="{{ $dir }}" lang="{{ $lang }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <meta property="og:title"       content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:type"        content="website">
    @if($ogImage)
    <meta property="og:image"       content="{{ $ogImage }}">
    @endif
    <link rel="canonical" href="{{ url()->current() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700;800&family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&display=swap" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700;800&family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&display=swap"></noscript>

    @vite(['resources/css/site.css', 'resources/js/site.js'])
    @livewireStyles
</head>
<body class="min-h-screen" x-data>

    {{-- Promo bar (managed from Settings) --}}
    @if ($promoOn && $promoText)
        <div class="bg-brand-700 py-2 text-center text-xs font-medium text-white">
            {{ $promoText }}
            @if ($promoLink)
                <a href="{{ $promoLink }}" class="underline underline-offset-2 hover:text-brand-200">{{ __('promo.link') }}</a>
            @endif
        </div>
    @endif

    {{-- Header --}}
    <x-site.header />

    {{-- Main --}}
    <main>
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <x-site.footer />

    @livewireScripts
    @stack('scripts')
</body>
</html>
