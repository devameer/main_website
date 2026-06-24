@props([
    'title'    => null,
    'subtitle' => null,
    'button'   => null,
    'href'     => null,
])

<section class="border-t border-slate-100 bg-slate-50 py-14 md:py-20">
    <div class="mx-auto w-full max-w-5xl px-4 text-center sm:px-6">
        <h2 class="mb-4 text-2xl font-bold leading-tight text-slate-900 md:text-3xl">{{ $title }}</h2>
        <p class="mx-auto mb-8 mt-3 max-w-2xl text-slate-500">{{ $subtitle }}</p>
        <a href="{{ $href }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-700 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-150 hover:bg-brand-800 disabled:opacity-50">{{ $button }}</a>
    </div>
</section>
