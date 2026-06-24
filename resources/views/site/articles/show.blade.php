@php
    $metaTitle = $article->meta_title ?: ($article->display_title . ' — ' . __('brand.name'));
    $metaDesc  = $article->meta_description ?: $article->excerpt;
@endphp

<x-site.layout
    :title="$metaTitle"
    :description="$metaDesc"
    :ogImage="$article->cover_image"
>

    <x-site.sections.articles.show.breadcrumb :article="$article" />
    <x-site.sections.articles.show.header :article="$article" />
    <x-site.sections.articles.show.body :article="$article" :bodyHtml="$bodyHtml" />
    <x-site.sections.articles.show.related :related="$related" />
    <x-site.sections.articles.show.comments :approvedComments="$approvedComments" :article="$article" />

</x-site.layout>
