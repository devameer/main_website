@php
    $isArabic = app()->getLocale() === 'ar';
    $projects = \App\Models\Project::published()->ordered()->take(2)->get();
    $button = 'inline-flex items-center justify-center rounded-lg bg-brand-700 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-brand-700/15 transition hover:-translate-y-0.5 hover:bg-brand-800';
@endphp

<section class="mx-auto w-full max-w-6xl px-4 py-20 sm:px-6 md:py-28">
    <div class="mb-10 flex flex-col items-start justify-between gap-5 md:flex-row md:items-end">
        <div><p class="mb-2 text-sm font-bold text-brand-600">{{ __('home.featured_kicker') }}</p><h2 class="text-4xl font-extrabold tracking-tight text-brand-600 md:text-6xl">{{ __('home.featured_title') }}</h2><p class="mt-3 text-lg text-slate-500">{{ __('home.featured_subtitle') }}</p></div>
        <a class="{{ $button }}" href="{{ route('work') }}">{{ __('home.featured_action') }}</a>
    </div>
    <div class="grid gap-10 md:grid-cols-2 md:gap-4">
        @foreach($projects as $index => $project)
            <a href="{{ route('work') }}" class="group text-inherit">
                <div @class(['grid min-h-[380px] place-items-center overflow-hidden rounded-2xl p-7 md:min-h-[470px]', 'bg-[#d9f2ee]' => $index === 0, 'bg-[#fff1a8]' => $index !== 0])>
                    @if($index === 0)
                        <div class="h-[350px] w-48 translate-y-8 rounded-t-[2.2rem] border-[7px] border-b-0 border-[#b7ccca] bg-white p-5 shadow-2xl transition group-hover:translate-y-6">
                            <div class="mx-auto h-1.5 w-1/4 rounded-full bg-slate-300"></div><div class="mx-auto mt-8 grid size-24 place-items-center rounded-full bg-amber-100 text-3xl">{{ $project['icon'] }}</div><div class="mx-auto mt-7 h-2 w-3/4 rounded bg-slate-200"></div><div class="mx-auto mt-3 h-2 w-1/2 rounded bg-slate-200"></div><div class="mt-7 grid grid-cols-2 gap-2"><i class="h-20 rounded-lg bg-emerald-50"></i><i class="h-20 rounded-lg bg-emerald-50"></i></div>
                        </div>
                    @else
                        <div class="w-[92%] overflow-hidden rounded-lg border border-slate-300 bg-white shadow-2xl transition group-hover:-translate-y-1">
                            <div class="flex h-7 items-center gap-1.5 border-b bg-slate-100 px-3"><i class="size-1.5 rounded-full bg-slate-400"></i><i class="size-1.5 rounded-full bg-slate-400"></i><i class="size-1.5 rounded-full bg-slate-400"></i></div>
                            <div class="grid min-h-64 grid-cols-[24%_1fr]"><aside class="space-y-4 border-e bg-slate-50 p-4"><b class="block h-2 w-2/3 rounded bg-slate-600"></b><i class="block h-1.5 rounded bg-slate-200"></i><i class="block h-1.5 rounded bg-slate-200"></i><i class="block h-1.5 rounded bg-slate-200"></i></aside><div class="p-5"><b class="block h-2 w-1/3 rounded bg-slate-600"></b><div class="my-5 grid grid-cols-3 gap-2"><i class="h-12 rounded bg-amber-50"></i><i class="h-12 rounded bg-amber-50"></i><i class="h-12 rounded bg-amber-50"></i></div><div class="space-y-3">@for($row=0;$row<4;$row++)<i class="block h-px bg-slate-200"></i>@endfor</div></div></div>
                        </div>
                    @endif
                </div>
                    <div class="flex items-start justify-between gap-4 pt-4"><div><h3 class="text-lg font-bold text-slate-900 group-hover:text-brand-700">{{ $project['name'] }}</h3><p class="mt-1 text-sm leading-6 text-slate-500">{{ $project['desc'] }}</p></div><span class="text-xl text-brand-600">↗</span></div>
            </a>
        @endforeach
    </div>
</section>
