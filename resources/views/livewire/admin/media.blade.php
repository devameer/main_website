@php
    $items ??= $this->items;
    $stats = $this->stats;
    $selectedCount = count($selected);
    $preview = $previewId ? \App\Models\MediaItem::find($previewId) : null;
@endphp

<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Media Library</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $stats['count'] }} items · {{ $stats['images'] }} images · {{ $stats['size'] }} used.</p>
        </div>
        <div class="flex items-center gap-2">
            <x-ui.button variant="secondary" icon="download" wire:click="toastInfo('Import from URL coming soon.')">Import</x-ui.button>
            <x-ui.button variant="primary" icon="upload" wire:click="$set('showUpload', true)">Upload</x-ui.button>
        </div>
    </div>

    <div class="card overflow-hidden">
        {{-- Toolbar --}}
        <div class="flex flex-col gap-3 border-b border-slate-200 p-4 dark:border-slate-800 sm:flex-row sm:items-center">
            <label class="search w-full sm:max-w-xs">
                <x-ui.icon name="search" size="16" class="text-slate-400" />
                <input type="search" wire:model.live.debounce.300ms="search" placeholder="Search media by name…" class="text-sm">
            </label>
            <select wire:model.live="collection" class="select w-auto sm:ml-auto min-w-[140px] text-sm">
                @foreach ($this->collections as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
            @if ($selectedCount > 0)
                <button type="button" wire:click="bulkDelete" wire:confirm="Delete the selected media?" class="btn btn-danger btn-sm">
                    <x-ui.icon name="trash-2" size="15" /> Delete {{ $selectedCount }}
                </button>
            @endif
        </div>

        {{-- Upload dropzone (toggle) --}}
        @if ($showUpload)
        <div class="border-b border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-800/40">
            <label class="flex cursor-pointer flex-col items-center justify-center gap-2 rounded-[8px] border-2 border-dashed border-slate-300 px-4 py-8 text-center transition-colors hover:border-primary-400 hover:bg-primary-50/40 dark:border-slate-600 dark:hover:bg-primary-500/5">
                @if ($upload)
                    <x-ui.icon name="loader" size="22" class="animate-spin text-primary-600" />
                    <span class="text-sm font-medium text-primary-600">Uploading…</span>
                @else
                    <x-ui.icon name="upload" size="26" class="text-slate-400" />
                    <span class="text-sm font-medium text-slate-600 dark:text-slate-300">Click to upload or drag & drop</span>
                    <span class="text-xs text-slate-400">PNG, JPG, GIF up to 5MB</span>
                @endif
                <input type="file" wire:model="upload" accept="image/*" class="hidden">
            </label>
            <div class="mt-2 text-center">
                <button type="button" wire:click="$set('showUpload', false)" class="text-xs text-slate-400 hover:text-slate-600">Cancel</button>
            </div>
        </div>
        @endif

        @if ($items->isEmpty())
            <x-ui.empty-state icon="image" title="No media found" :description="$search || $collection ? 'Try adjusting your search or filters.' : 'Upload your first image to the library.'">
                <x-slot:actions>
                    <x-ui.button variant="primary" size="sm" icon="upload" wire:click="$set('showUpload', true)">Upload media</x-ui.button>
                </x-slot:actions>
            </x-ui.empty-state>
        @else
            <div class="grid grid-cols-2 gap-3 p-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6">
                @foreach ($items as $item)
                    <div wire:key="media-{{ $item->id }}"
                        class="group relative cursor-pointer overflow-hidden rounded-[8px] border border-slate-200 transition-shadow hover:shadow-md dark:border-slate-800 {{ in_array($item->id, $selected) ? 'ring-2 ring-primary-500' : '' }}"
                        wire:click="$set('previewId', {{ $item->id }})">

                        <div class="aspect-square overflow-hidden bg-slate-100 dark:bg-slate-800">
                            <img src="{{ $item->path }}" alt="{{ $item->alt_text ?: $item->name }}" loading="lazy" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                        </div>

                        <div class="p-2">
                            <p class="truncate text-xs font-medium text-slate-700 dark:text-slate-200">{{ $item->name }}</p>
                            <p class="text-[10px] text-slate-400">{{ $item->formattedSize() }}</p>
                        </div>

                        {{-- Hover actions --}}
                        <div class="absolute inset-x-0 top-0 flex justify-between bg-gradient-to-b from-slate-900/50 to-transparent p-1.5 opacity-0 transition-opacity group-hover:opacity-100">
                            <input type="checkbox" value="{{ $item->id }}" wire:model.live="selected" wire:click.stop
                                class="h-4 w-4 rounded border-white bg-white/90 text-primary-600"
                                aria-label="Select {{ $item->name }}">
                            <div class="flex gap-0.5">
                                <button type="button" wire:click.stop="copyUrl({{ $item->id }})" class="rounded bg-white/90 p-1 text-slate-600 hover:text-primary-600"><x-ui.icon name="link-2" size="13" /></button>
                                <button type="button" wire:click.stop="delete({{ $item->id }})" wire:confirm="Delete this media?" class="rounded bg-white/90 p-1 text-slate-600 hover:text-danger-600"><x-ui.icon name="trash-2" size="13" /></button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex items-center justify-between border-t border-slate-200 px-4 py-3 text-xs text-slate-500 dark:border-slate-800">
                <span>{{ $items->total() }} items</span>
                {{ $items->withQueryString()->links('components.ui.pagination') }}
            </div>
        @endif
    </div>

    {{-- Preview modal --}}
    @if ($preview)
    <x-ui.modal maxWidth="max-w-2xl">
    <x-slot:header>
        <div class="min-w-0">
            <h3 class="card-title truncate">{{ $preview->name }}</h3>
            <p class="mt-0.5 text-xs text-slate-400">{{ $preview->collection }} · {{ $preview->formattedSize() }} · {{ $preview->width }}×{{ $preview->height }}</p>
        </div>
    </x-slot:header>

    <div class="space-y-4">
        <div class="overflow-hidden rounded-[8px] bg-slate-100 dark:bg-slate-800">
            <img src="{{ $preview->path }}" alt="{{ $preview->alt_text ?: $preview->name }}" class="max-h-80 w-full object-contain">
        </div>

        <div class="grid grid-cols-2 gap-3 text-sm">
            <div>
                <p class="text-xs text-slate-400">Uploaded</p>
                <p class="font-medium text-slate-700 dark:text-slate-200">{{ $preview->created_at->format('M j, Y') }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400">Type</p>
                <p class="font-medium text-slate-700 dark:text-slate-200">{{ $preview->mime_type ?? 'image/jpeg' }}</p>
            </div>
            <div class="col-span-2">
                <p class="text-xs text-slate-400">URL</p>
                <div class="flex items-center gap-2">
                    <code class="flex-1 truncate rounded bg-slate-100 px-2 py-1 text-xs text-slate-600 dark:bg-slate-800 dark:text-slate-300">{{ $preview->path }}</code>
                    <button type="button" wire:click="copyUrl({{ $preview->id }})" class="btn btn-secondary btn-icon"><x-ui.icon name="copy" size="15" /></button>
                </div>
            </div>
        </div>
    </div>

    <x-slot:footer>
        <x-ui.button variant="secondary" wire:click="$set('previewId', null)">Close</x-ui.button>
        <x-ui.button variant="danger" icon="trash-2" wire:click="delete({{ $preview->id }})" wire:confirm="Delete this media?">Delete</x-ui.button>
    </x-slot:footer>
    </x-ui.modal>
    @endif
</div>
