@php
    $isArabic = app()->getLocale() === 'ar';
    $button = 'inline-flex items-center justify-center gap-1.5 rounded-lg bg-brand-700 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-brand-700/15 transition hover:-translate-y-0.5 hover:bg-brand-800';
    $outlineBtn = 'inline-flex items-center justify-center rounded-lg border border-slate-300 px-6 py-3.5 text-sm font-bold text-slate-700 transition hover:-translate-y-0.5 hover:border-brand-400 hover:text-brand-700';
@endphp

<x-site.layout
    :title="$project['name'] . ' — ' . __('brand.name')"
    :description="$project['desc']"
>

    {{-- Breadcrumb --}}
    <div class="border-b border-slate-100 bg-slate-50">
        <div class="mx-auto flex w-full max-w-6xl items-center gap-2 px-4 py-4 text-sm text-slate-400 sm:px-6">
            <a href="{{ route('work') }}" class="transition-colors hover:text-brand-700">{{ __('work.kicker') }}</a>
            <span>/</span>
            <span class="font-medium text-slate-600">{{ $project['name'] }}</span>
        </div>
    </div>

    {{-- Hero --}}
    <section class="relative overflow-hidden">
        <div class="pointer-events-none absolute -end-24 -top-24 size-80 rounded-full bg-brand-100/50 blur-3xl"></div>
        <div class="pointer-events-none absolute -start-20 bottom-0 size-72 rounded-full bg-violet-100/40 blur-3xl"></div>

        <div class="relative mx-auto grid w-full max-w-6xl items-center gap-12 px-4 py-16 sm:px-6 md:grid-cols-2 md:py-24">
            <div>
                <p class="mb-3 text-sm font-semibold uppercase tracking-[.16em] text-brand-600">{{ $isArabic ? 'دراسة حالة' : 'Case study' }}</p>
                <h1 class="text-4xl font-bold tracking-tight text-slate-900 md:text-6xl">{{ $project['name'] }}</h1>
                <div class="mt-4 flex flex-wrap items-center gap-3 text-sm">
                    <span class="rounded-full bg-brand-50 px-3 py-1 font-semibold text-brand-700">{{ $project['role'] }}</span>
                    <span class="text-slate-500">{{ $project['year'] }}</span>
                </div>
                <p class="mt-6 text-lg leading-9 text-slate-600">{{ $project['overview'] }}</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    @if(! empty($project['url']) && $project['url'] !== '#')
                        <a href="{{ $project['url'] }}" target="_blank" rel="noopener noreferrer" class="{{ $button }}">{{ $isArabic ? 'زيارة الموقع' : 'Visit site' }} ↗</a>
                    @endif
                    <a href="{{ route('contact') }}" class="{{ $project['url'] !== '#' ? $outlineBtn : $button }}">{{ $isArabic ? 'ابدأ مشروعاً مماثلاً' : 'Start a similar project' }}</a>
                </div>
            </div>

            <div class="relative">
                <div class="relative mx-auto grid aspect-[4/3] place-items-center overflow-hidden rounded-3xl border border-slate-200 bg-linear-to-br from-brand-50 via-white to-violet-50 shadow-2xl">
                    <span class="text-8xl transition-transform duration-500 hover:scale-110">{{ $project['icon'] }}</span>
                    <span class="absolute bottom-5 end-6 text-3xl font-black text-slate-100 md:text-4xl">{{ $project['name'] }}</span>
                </div>
            </div>
        </div>
    </section>

    {{-- Highlights --}}
    <section class="bg-[#f3f6ff] py-20 md:py-28">
        <div class="mx-auto w-full max-w-6xl px-4 sm:px-6">
            <div class="mb-10">
                <p class="mb-2 text-sm font-semibold uppercase tracking-[.16em] text-brand-600">{{ $isArabic ? 'أبرز النقاط' : 'Highlights' }}</p>
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 md:text-5xl">{{ $isArabic ? 'ما الذي يميّز هذا المشروع' : 'What makes this project' }}</h2>
            </div>
            <div class="grid gap-6 md:grid-cols-3">
                @foreach($project['highlights'] as $i => $h)
                    <div class="group flex flex-col rounded-2xl border border-slate-200 bg-white p-7 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                        <span class="grid size-12 place-items-center rounded-xl bg-brand-50 font-mono text-sm font-bold text-brand-600 transition-colors group-hover:bg-brand-600 group-hover:text-white">0{{ $i + 1 }}</span>
                        <p class="mt-5 text-lg font-semibold leading-relaxed text-slate-900">{{ $h }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Tech stack --}}
    <section class="py-20 md:py-28">
        <div class="mx-auto w-full max-w-6xl px-4 sm:px-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm md:p-12">
                <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="mb-2 text-sm font-semibold uppercase tracking-[.16em] text-brand-600">{{ $isArabic ? 'التقنيات' : 'Tech stack' }}</p>
                        <h2 class="text-2xl font-bold tracking-tight text-slate-900 md:text-4xl">{{ $isArabic ? 'الأدوات التي استخدمتها' : 'Tools I used' }}</h2>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach($project['tags'] as $tag)
                            <span class="rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-bold text-slate-700">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Next project --}}
    <section class="pb-20 md:pb-28">
        <div class="mx-auto w-full max-w-6xl px-4 sm:px-6">
            <a href="{{ route('work.show', $next['slug']) }}" class="group relative block overflow-hidden rounded-3xl border border-brand-700 bg-linear-to-br from-brand-600 to-brand-800 p-8 text-white shadow-xl transition hover:-translate-y-1 md:p-12">
                <div class="pointer-events-none absolute -end-10 -top-10 size-40 rounded-full bg-white/10 blur-2xl"></div>
                <div class="pointer-events-none absolute -start-10 -bottom-10 size-40 rounded-full bg-black/10 blur-2xl"></div>
                <div class="relative flex items-center justify-between gap-6">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[.16em] text-blue-200">{{ $isArabic ? 'المشروع التالي' : 'Next project' }}</p>
                        <h3 class="mt-3 flex items-center gap-3 text-2xl font-bold md:text-4xl">
                            <span class="text-3xl md:text-4xl">{{ $next['icon'] }}</span>
                            {{ $next['name'] }}
                        </h3>
                    </div>
                    <span class="shrink-0 text-3xl transition group-hover:translate-x-1 md:text-4xl">→</span>
                </div>
            </a>
        </div>
    </section>

    <x-site.sections.cta
        :title="__('work.cta_title')"
        :subtitle="__('work.cta_subtitle')"
        :button="__('work.cta_btn')"
        :href="route('contact')"
    />

</x-site.layout>
