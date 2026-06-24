@props([
    'kicker'   => null,
    'title'    => null,
    'subtitle' => null,
    'maxWidth' => 'max-w-5xl',
])

<section class="border-b border-slate-200 bg-slate-50 py-10">
    <div class="mx-auto w-full {{ $maxWidth }} px-4 sm:px-6">
        @if($kicker)
            <p class="mb-2 text-xs font-semibold uppercase tracking-widest text-brand-600">{{ $kicker }}</p>
        @endif

        <h1 class="text-2xl font-bold leading-tight text-slate-900 md:text-3xl">{{ $title }}</h1>

        @if($subtitle)
            <p class="mt-3 max-w-2xl text-slate-500">{{ $subtitle }}</p>
        @endif

        {{ $slot }}
    </div>
</section>
