<x-site.layout :title="__('brand.name') . ' — ' . __('brand.role')">

    <x-site.sections.home.hero />
    <x-site.sections.home.intro />
    <x-site.sections.home.services />
    <x-site.sections.home.work />
    <x-site.sections.home.articles :latestArticles="$latestArticles" />
    <x-site.sections.home.process />
    <x-site.sections.home.community />
    <x-site.sections.newsletter />

</x-site.layout>
