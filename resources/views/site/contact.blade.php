<x-site.layout
    :title="__('nav.contact') . ' — ' . __('brand.name')"
    :description="__('contact.subtitle')"
>

    <x-site.sections.page-header
        :kicker="__('contact.kicker')"
        :title="__('contact.title')"
        :subtitle="__('contact.subtitle')"
        maxWidth="max-w-4xl"
    />

    <section class="py-14 md:py-20">
        <div class="mx-auto w-full max-w-4xl px-4 sm:px-6">
            <div class="grid gap-10 lg:grid-cols-[1fr_1.6fr]">
                <x-site.sections.contact.info />
                <x-site.sections.contact.form />
            </div>
        </div>
    </section>

</x-site.layout>
