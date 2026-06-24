@php $isArabic = app()->getLocale() === 'ar'; @endphp

<x-site.layout
    :title="__('nav.work') . ' — ' . __('brand.name')"
    :description="__('work.subtitle')"
>

    {{-- Header band --}}
    <section class="relative overflow-hidden border-b border-slate-100 bg-[#f3f6ff]">
        <div class="pointer-events-none absolute -end-24 -top-24 size-80 rounded-full bg-brand-200/40 blur-3xl"></div>
        <div class="pointer-events-none absolute -start-20 bottom-0 size-64 rounded-full bg-violet-200/30 blur-3xl"></div>

        <div class="relative mx-auto w-full max-w-6xl px-4 py-16 sm:px-6 md:py-24">
            <p class="mb-3 text-sm font-semibold uppercase tracking-[.16em] text-brand-600">{{ __('work.kicker') }}</p>
            <h1 class="text-4xl font-bold tracking-tight text-slate-900 md:text-6xl">{{ __('work.title') }}</h1>
            <p class="mt-4 max-w-2xl text-lg leading-8 text-slate-500">{{ __('work.subtitle') }}</p>
        </div>
    </section>

    {{-- Projects grid --}}
    <section class="py-16 md:py-24">
        <div class="mx-auto w-full max-w-6xl px-4 sm:px-6">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @php
                    $gradients = [
                        'from-brand-100 to-violet-100',
                        'from-emerald-100 to-sky-100',
                        'from-amber-100 to-orange-100',
                        'from-rose-100 to-pink-100',
                        'from-sky-100 to-indigo-100',
                        'from-violet-100 to-fuchsia-100',
                    ];
                @endphp

                @foreach($projects as $index => $p)
                    <a href="{{ route('work.show', $p['slug']) }}" class="group flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white transition-all duration-300 hover:-translate-y-1.5 hover:border-brand-200 hover:shadow-xl">
                        <div class="relative grid h-40 place-items-center overflow-hidden bg-linear-to-br {{ $gradients[$index % count($gradients)] }}">
                            <span class="text-6xl transition-transform duration-500 group-hover:scale-110">{{ $p['icon'] }}</span>
                            <span class="absolute end-4 top-4 rounded-full bg-white/80 px-2.5 py-1 text-xs font-bold text-slate-600 backdrop-blur">{{ $p['year'] }}</span>
                        </div>
                        <div class="flex flex-1 flex-col p-6">
                            <p class="text-xs font-semibold uppercase tracking-wide text-brand-600">{{ $p['role'] }}</p>
                            <h3 class="mt-1.5 text-lg font-bold text-slate-900 transition-colors group-hover:text-brand-700">{{ $p['name'] }}</h3>
                            <p class="mt-2 line-clamp-2 text-sm leading-6 text-slate-500">{{ $p['desc'] }}</p>
                            <div class="mt-4 flex flex-wrap gap-1.5">
                                @foreach($p['tags'] as $tag)
                                    <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">{{ $tag }}</span>
                                @endforeach
                            </div>
                            <span class="mt-5 inline-flex items-center gap-1.5 text-sm font-bold text-brand-600">
                                {{ $isArabic ? 'عرض المشروع' : 'View project' }}
                                <span class="transition group-hover:translate-x-0.5">→</span>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <x-site.sections.cta
        :title="__('work.cta_title')"
        :subtitle="__('work.cta_subtitle')"
        :button="__('work.cta_btn')"
        :href="route('contact')"
    />

</x-site.layout>
