<x-site.layout
    :title="__('nav.services') . ' — ' . __('brand.name')"
    :description="__('services.subtitle')"
>

    <x-site.sections.page-header
        :kicker="__('services.kicker')"
        :title="__('services.title')"
        :subtitle="__('services.subtitle')"
    />

    @php $services = \App\Models\Service::published()->ordered()->get(); @endphp

    <section class="py-14 md:py-20">
        <div class="mx-auto w-full max-w-5xl px-4 sm:px-6">
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($services as $s)
                    <div class="flex flex-col gap-4 rounded-xl border border-slate-200 bg-white p-6 transition-shadow hover:shadow-md">
                        <div class="text-3xl">{{ $s['icon'] }}</div>
                        <div>
                            <h3 class="mb-2 font-bold text-slate-900">{{ $s['title'] }}</h3>
                            <p class="text-sm text-slate-500 leading-relaxed">{{ $s['desc'] }}</p>
                        </div>
                        <ul class="mt-auto space-y-1">
                            @foreach ($s['items'] as $item)
                                <li class="flex items-center gap-2 text-sm text-slate-600">
                                    <span class="h-1.5 w-1.5 shrink-0 rounded-full bg-brand-500"></span>
                                    {{ $item }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <x-site.sections.cta
        :title="__('services.cta_title')"
        :subtitle="__('services.cta_subtitle')"
        :button="__('services.cta_btn')"
        :href="route('contact')"
    />

</x-site.layout>
