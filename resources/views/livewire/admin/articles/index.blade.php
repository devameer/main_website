@php
    $articles ??= $this->articles;
    $hasFilters = $search || $status || $language;
    $selectedCount = count($selected);
@endphp

<div class="space-y-6">
{{-- Header --}}
<div class="flex flex-wrap items-end justify-between gap-4">
    <div>
        <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Articles</h2>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Create, edit and publish content across languages.</p>
    </div>
    <div class="flex items-center gap-2">
        <x-ui.button variant="secondary" icon="download">Export</x-ui.button>
        <x-ui.button variant="primary" icon="plus" href="{{ route('admin.articles.create') }}">New Article</x-ui.button>
    </div>
</div>

<div class="card relative overflow-hidden">
    {{-- Toolbar --}}
    <div class="flex flex-col gap-3 border-b border-slate-200 p-4 dark:border-slate-800 lg:flex-row lg:items-center">
        <label class="search w-full lg:max-w-xs">
            <x-ui.icon name="search" size="16" class="text-slate-400" />
            <input type="search" wire:model.live.debounce.300ms="search" placeholder="Search by title or author…" class="text-sm">
            @if ($search)
                <button type="button" wire:click="$set('search','')" class="text-slate-400 hover:text-slate-600"><x-ui.icon name="x" size="15" /></button>
            @endif
        </label>

        <div class="flex flex-wrap items-center gap-2 lg:ml-auto">
            <select wire:model.live="status" class="select w-auto min-w-[140px] text-sm">
                @foreach ($this->statuses as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>

            <select wire:model.live="language" class="select w-auto min-w-[140px] text-sm">
                @foreach ($this->languages as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>

            {{-- View toggle --}}
            <div class="flex items-center gap-0.5 rounded-[8px] border border-slate-200 bg-white p-0.5 dark:border-slate-700 dark:bg-slate-800">
                <button type="button" wire:click="$set('viewMode','table')" class="btn btn-icon {{ $viewMode === 'table' ? 'bg-slate-100 text-primary-600 dark:bg-slate-700' : 'text-slate-400 hover:text-slate-600' }}" aria-label="Table view">
                    <x-ui.icon name="list" size="16" />
                </button>
                <button type="button" wire:click="$set('viewMode','grid')" class="btn btn-icon {{ $viewMode === 'grid' ? 'bg-slate-100 text-primary-600 dark:bg-slate-700' : 'text-slate-400 hover:text-slate-600' }}" aria-label="Grid view">
                    <x-ui.icon name="grid" size="16" />
                </button>
            </div>

            @if ($hasFilters)
                <button type="button" wire:click="resetFilters" class="btn btn-ghost btn-sm text-slate-500">
                    <x-ui.icon name="x" size="15" /> Clear
                </button>
            @endif
        </div>
    </div>

    {{-- Bulk action bar --}}
    <div
        wire:offline.class="opacity-60"
        class="flex items-center justify-between gap-3 overflow-hidden border-b border-slate-200 bg-primary-50/60 px-4 py-2.5 transition-all dark:border-slate-800 dark:bg-primary-500/10"
        @class([ 'hidden' => $selectedCount === 0 ])
    >
        <p class="text-sm font-medium text-primary-700 dark:text-primary-300">
            {{ $selectedCount }} selected
        </p>
        <div class="flex items-center gap-2">
            <button type="button" wire:click="bulkPublish" wire:target="bulkPublish" class="btn btn-secondary btn-sm">
                <x-ui.icon name="check-circle" size="15" /> Publish
            </button>
            <button type="button" wire:click="bulkDelete" wire:confirm="Delete the selected articles?" class="btn btn-danger btn-sm">
                <x-ui.icon name="trash-2" size="15" /> Delete
            </button>
            <button type="button" wire:click="$set('selected', [])" class="btn btn-ghost btn-sm">Clear</button>
        </div>
    </div>

    {{-- Table / states --}}
    <div wire:loading.delay.class="opacity-60 pointer-events-none">
        @if ($articles->isEmpty())
            <x-ui.empty-state
                :icon="$hasFilters ? 'search' : 'file-text'"
                :title="$hasFilters ? 'No matching articles' : 'No articles yet'"
                :description="$hasFilters ? 'Try adjusting your search or filters to find what you are looking for.' : 'Get started by creating your first article.'"
            >
                <x-slot:actions>
                    @if ($hasFilters)
                        <x-ui.button variant="secondary" size="sm" icon="refresh-cw" wire:click="resetFilters">Reset filters</x-ui.button>
                    @else
                        <x-ui.button variant="primary" size="sm" icon="plus" href="{{ route('admin.articles.create') }}">New Article</x-ui.button>
                    @endif
                </x-slot:actions>
            </x-ui.empty-state>
        @else
            @if ($viewMode === 'grid')
                <div class="grid grid-cols-1 gap-4 p-4 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach ($articles as $article)
                        <div wire:key="card-{{ $article->id }}" class="group flex flex-col overflow-hidden rounded-[8px] border border-slate-200 transition-shadow hover:shadow-md dark:border-slate-800">
                            <div class="relative aspect-[16/9] overflow-hidden">
                                <img src="{{ $article->cover_image }}" alt="" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105" loading="lazy">
                                <span class="absolute left-2 top-2"><x-ui.badge :tone="$statusTone[$article->status]" dot>{{ $statusLabel[$article->status] }}</x-ui.badge></span>
                                <span class="absolute right-2 top-2 badge badge-gray uppercase">{{ $article->language }}</span>
                            </div>
                            <div class="flex flex-1 flex-col p-4">
                                <p class="text-xs text-slate-400">{{ $article->category }}</p>
                                <a href="{{ route('admin.articles.edit', $article) }}" class="mt-1 line-clamp-2 font-semibold text-slate-800 hover:text-primary-600 dark:text-slate-100">{{ $article->display_title }}</a>
                                <p class="mt-1 line-clamp-2 text-xs text-slate-500 dark:text-slate-400">{{ $article->excerpt }}</p>
                                <div class="mt-auto flex items-center justify-between pt-3 text-xs text-slate-400">
                                    <span class="inline-flex items-center gap-1"><x-ui.icon name="eye" size="13" /> {{ number_format($article->views) }}</span>
                                    <span>{{ $article->published_at?->format('M j') ?? '—' }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
            <div class="table-wrap">
                <table class="t-base">
                    <thead>
                        <tr>
                            <th class="w-10">
                                <input
                                    type="checkbox"
                                    wire:model.live="selectPage"
                                    class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500 dark:border-slate-600 dark:bg-slate-800"
                                    aria-label="Select all on page"
                                >
                            </th>
                            <th>
                                <button type="button" wire:click="sort('title')" class="inline-flex items-center gap-1 hover:text-slate-700 dark:hover:text-slate-200">
                                    Article
                                    @if ($sortBy === 'title')<x-ui.icon name="chevron-{{ $sortDir === 'asc' ? 'up' : 'down' }}" size="13" />@endif
                                </button>
                            </th>
                            <th>Language</th>
                            <th class="hidden md:table-cell">Author</th>
                            <th>
                                <button type="button" wire:click="sort('status')" class="inline-flex items-center gap-1 hover:text-slate-700 dark:hover:text-slate-200">
                                    Status
                                    @if ($sortBy === 'status')<x-ui.icon name="chevron-{{ $sortDir === 'asc' ? 'up' : 'down' }}" size="13" />@endif
                                </button>
                            </th>
                            <th class="hidden lg:table-cell">Published</th>
                            <th class="hidden sm:table-cell">Views</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($articles as $article)
                            <tr @class(['bg-primary-50/40 dark:bg-primary-500/5' => in_array($article->id, $selected)]) wire:key="article-{{ $article->id }}">
                                <td>
                                    <input
                                        type="checkbox"
                                        value="{{ $article->id }}"
                                        wire:model.live="selected"
                                        class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500 dark:border-slate-600 dark:bg-slate-800"
                                        aria-label="Select {{ $article->title }}"
                                    >
                                </td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $article->cover_image }}" alt="" class="h-10 w-14 rounded-md object-cover ring-1 ring-slate-200 dark:ring-slate-700" loading="lazy">
                                        <div class="min-w-0 max-w-[280px]">
                                            <a href="{{ route('admin.articles.edit', $article) }}" class="block truncate font-medium text-slate-800 hover:text-primary-600 dark:text-slate-100">{{ $article->display_title }}</a>
                                            <p class="truncate text-xs text-slate-400">{{ $article->category }} · {{ $article->excerpt }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-gray uppercase">{{ $article->language }}</span>
                                </td>
                                <td class="hidden md:table-cell">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ $article->author_avatar }}" alt="" class="h-6 w-6 rounded-full object-cover">
                                        <span class="text-slate-600 dark:text-slate-300">{{ $article->author }}</span>
                                    </div>
                                </td>
                                <td>
                                    <x-ui.badge :tone="$statusTone[$article->status]" dot>{{ $statusLabel[$article->status] }}</x-ui.badge>
                                </td>
                                <td class="hidden lg:table-cell text-slate-500">
                                    {{ $article->published_at?->format('M j, Y') ?? '—' }}
                                </td>
                                <td class="hidden sm:table-cell">
                                    <span class="inline-flex items-center gap-1 text-slate-600 dark:text-slate-300">
                                        <x-ui.icon name="eye" size="14" class="text-slate-400" />
                                        {{ number_format($article->views) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="flex items-center justify-end gap-0.5">
                                        <x-ui.tooltip text="Preview"><a href="#" class="btn btn-ghost btn-icon text-slate-500 hover:text-info-600"><x-ui.icon name="eye" size="16" /></a></x-ui.tooltip>
                                        <x-ui.tooltip text="Edit"><a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-ghost btn-icon text-slate-500 hover:text-primary-600"><x-ui.icon name="pencil" size="16" /></a></x-ui.tooltip>
                                        <x-ui.tooltip text="Copy"><button type="button" class="btn btn-ghost btn-icon text-slate-500 hover:text-slate-700"><x-ui.icon name="copy" size="16" /></button></x-ui.tooltip>
                                        <x-ui.tooltip text="Delete">
                                            <button type="button" wire:click="delete({{ $article->id }})" wire:confirm="Delete this article?" class="btn btn-ghost btn-icon text-slate-500 hover:text-danger-600">
                                                <x-ui.icon name="trash-2" size="16" />
                                            </button>
                                        </x-ui.tooltip>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            {{-- Footer / pagination --}}
            <div class="flex flex-col items-center justify-between gap-3 border-t border-slate-200 px-4 py-3 dark:border-slate-800 sm:flex-row">
                <div class="flex items-center gap-3 text-xs text-slate-500">
                    <span>
                        Showing <span class="font-medium text-slate-700 dark:text-slate-300">{{ $articles->firstItem() }}</span>–
                        <span class="font-medium text-slate-700 dark:text-slate-300">{{ $articles->lastItem() }}</span> of
                        <span class="font-medium text-slate-700 dark:text-slate-300">{{ $articles->total() }}</span>
                    </span>
                    <select wire:model.live="perPage" class="select h-8 w-auto py-1 text-xs">
                        @foreach ([10, 25, 50] as $n)<option value="{{ $n }}">{{ $n }} / page</option>@endforeach
                    </select>
                </div>

                {{ $articles->withQueryString()->links('components.ui.pagination') }}
            </div>
        @endif
    </div>

    {{-- Skeleton overlay while loading --}}
    <div wire:loading.delay class="absolute inset-0 z-10 flex items-start justify-center bg-white/60 pt-32 backdrop-blur-[1px] dark:bg-slate-900/60">
        <div class="flex items-center gap-2 text-sm font-medium text-primary-600 dark:text-primary-400">
            <x-ui.icon name="loader" size="16" class="animate-spin" /> Loading articles…
        </div>
    </div>
</div>
</div>
