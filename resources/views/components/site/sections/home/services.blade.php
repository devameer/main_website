@php
    $isArabic = app()->getLocale() === 'ar';
    $services = \App\Models\Service::published()->ordered()->take(4)->get();
    $button = 'inline-flex items-center justify-center rounded-lg bg-brand-700 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-brand-700/15 transition hover:-translate-y-0.5 hover:bg-brand-800';
@endphp

<section class="overflow-hidden bg-[#f3f6ff] py-20 md:py-28">
    <div class="mx-auto w-full max-w-6xl px-4 sm:px-6">
        <div class="mb-10 flex flex-col items-start justify-between gap-5 md:flex-row md:items-end">
            <div>
                <p class="mb-2 text-sm font-bold text-brand-600">{{ __('home.services_kicker') }}</p>
                <h2 class="max-w-3xl text-4xl font-extrabold leading-tight tracking-tight text-brand-600 md:text-6xl">{{ $isArabic ? 'من الفكرة إلى واجهة تعمل بكفاءة' : 'From an idea to an interface that works' }}</h2>
            </div>
            <a class="{{ $button }}" href="{{ route('services') }}">{{ __('home.services_action') }}</a>
        </div>

        <div class="grid overflow-hidden rounded-2xl border border-brand-100 bg-white shadow-[0_18px_55px_rgba(49,63,135,.08)] md:grid-cols-[.8fr_1.3fr]">
            <div class="self-center p-8 md:p-12">
                <p class="text-xl leading-9 text-slate-600">{{ $isArabic ? 'تصميم وتطوير متكامل يضع المستخدم والأداء في مركز كل قرار.' : 'End-to-end design and development with users and performance at the center of every decision.' }}</p>
                <div class="mt-6 flex flex-wrap gap-2">
                    @foreach(array_slice(__('home.skills'), 0, 6) as $skill)
                        <span class="rounded-full border border-brand-100 bg-brand-50/50 px-3.5 py-1.5 text-xs font-bold text-slate-600">{{ $skill }}</span>
                    @endforeach
                </div>
            </div>
            <div class="relative grid min-h-[330px] place-items-center overflow-hidden bg-linear-to-br from-blue-100 via-violet-100 to-emerald-100 p-8 md:min-h-[430px]">
                <div class="absolute -end-12 -top-16 size-60 rounded-full bg-white/50 blur-sm"></div>
                <div class="relative w-[82%] -rotate-2 overflow-hidden rounded-xl border border-slate-300/60 bg-white shadow-2xl transition hover:rotate-0">
                    <div class="flex h-7 items-center gap-1.5 border-b border-slate-100 bg-slate-50 px-3"><i class="size-1.5 rounded-full bg-red-300"></i><i class="size-1.5 rounded-full bg-amber-300"></i><i class="size-1.5 rounded-full bg-green-300"></i></div>
                    <div class="grid min-h-56 grid-cols-[22%_1fr]">
                        <aside class="space-y-4 border-e border-slate-100 bg-slate-50 p-4"><b class="block h-2 w-2/3 rounded bg-brand-500"></b><i class="block h-1.5 rounded bg-brand-100"></i><i class="block h-1.5 w-3/4 rounded bg-brand-100"></i><i class="block h-1.5 rounded bg-brand-100"></i></aside>
                        <div class="p-5"><b class="block h-2.5 w-1/3 rounded bg-brand-700"></b><div class="mt-5 grid grid-cols-3 gap-2"><i class="h-12 rounded bg-brand-50"></i><i class="h-12 rounded bg-brand-50"></i><i class="h-12 rounded bg-brand-50"></i></div><div class="mt-4 flex h-24 items-end gap-2 rounded bg-slate-50 p-4"><i class="h-1/3 flex-1 rounded-t bg-brand-400"></i><i class="h-3/5 flex-1 rounded-t bg-brand-400"></i><i class="h-2/5 flex-1 rounded-t bg-brand-400"></i><i class="h-4/5 flex-1 rounded-t bg-brand-700"></i><i class="h-2/3 flex-1 rounded-t bg-brand-400"></i></div></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($services as $index => $service)
                <article class="relative min-h-52 rounded-xl border border-slate-200 bg-white/80 p-5">
                    <span class="absolute end-4 top-4 font-mono text-xs text-slate-400">0{{ $index + 1 }}</span>
                    <div class="mb-6 text-3xl">{{ $service['icon'] }}</div>
                    <h3 class="text-lg font-bold text-slate-900">{{ $service['title'] }}</h3>
                    <p class="mt-2 line-clamp-3 text-sm leading-7 text-slate-500">{{ $service['desc'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
