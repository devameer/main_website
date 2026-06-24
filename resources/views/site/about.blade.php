<x-site.layout
    :title="__('nav.about') . ' — ' . __('brand.name')"
    :description="strip_tags(__('about.lead'))"
>

    <x-site.sections.about.profile />
    <x-site.sections.about.skills-strip />
    <x-site.sections.about.identity />
    <x-site.sections.about.contributions />
    <x-site.sections.about.origin-story />
    <x-site.sections.about.testimonials />
    <x-site.sections.about.coffee-story />
    <x-site.sections.about.espresso-kit />
    <x-site.sections.about.photography />
    <x-site.sections.about.social />
    <x-site.sections.newsletter />

</x-site.layout>
