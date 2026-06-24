<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Categories</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Organize your articles into a taxonomy.</p>
        </div>
        <x-ui.button variant="primary" icon="plus" wire:click="openModal">New Category</x-ui.button>
    </div>

    {{-- Toolbar --}}
    <div class="card overflow-hidden">
        <div class="border-b border-slate-200 p-4 dark:border-slate-800">
            <label class="search w-full sm:max-w-xs">
                <x-ui.icon name="search" size="16" class="text-slate-400" />
                <input type="search" wire:model.live.debounce.300ms="search" placeholder="Search categories…" class="text-sm">
            </label>
        </div>

        @if ($categories->isEmpty())
            <x-ui.empty-state
                :icon="$search ? 'search' : 'folder'"
                :title="$search ? 'No matching categories' : 'No categories yet'"
                :description="$search ? 'Try a different search term.' : 'Create your first category to organize articles.'"
            >
                <x-slot:actions>
                    <x-ui.button variant="primary" size="sm" icon="plus" wire:click="openModal">New Category</x-ui.button>
                </x-slot:actions>
            </x-ui.empty-state>
        @else
            <div class="table-wrap">
                <table class="t-base">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Color</th>
                            <th class="hidden md:table-cell">Description</th>
                            <th>Articles</th>
                            <th class="hidden sm:table-cell">Created</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr wire:key="cat-{{ $category->id }}">
                                <td>
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-8 w-8 items-center justify-center rounded-[8px] bg-primary-50 text-primary-600 dark:bg-primary-500/15 dark:text-primary-400">
                                            <x-ui.icon name="tag" size="15" />
                                        </span>
                                        <span class="font-medium text-slate-800 dark:text-slate-100">{{ $category->name }}</span>
                                    </div>
                                </td>
                                <td><x-ui.badge :tone="$category->color" dot>{{ ucfirst($category->color) }}</x-ui.badge></td>
                                <td class="hidden md:table-cell max-w-xs"><span class="line-clamp-1 text-slate-500">{{ $category->description ?? '—' }}</span></td>
                                <td>
                                    <span class="badge badge-gray">{{ $category->articles_count }}</span>
                                </td>
                                <td class="hidden sm:table-cell text-slate-500">{{ $category->created_at->format('M j, Y') }}</td>
                                <td>
                                    <div class="flex items-center justify-end gap-0.5">
                                        <x-ui.tooltip text="Edit">
                                            <button type="button" wire:click="openModal({{ $category->id }})" class="btn btn-ghost btn-icon text-slate-500 hover:text-primary-600">
                                                <x-ui.icon name="pencil" size="16" />
                                            </button>
                                        </x-ui.tooltip>
                                        <x-ui.tooltip text="Delete">
                                            <button type="button" wire:click="delete({{ $category->id }})" wire:confirm="Delete this category?" class="btn btn-ghost btn-icon text-slate-500 hover:text-danger-600">
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

            <div class="flex items-center justify-between border-t border-slate-200 px-4 py-3 text-xs text-slate-500 dark:border-slate-800">
                <span>{{ $categories->total() }} categories</span>
                {{ $categories->withQueryString()->links('components.ui.pagination') }}
            </div>
        @endif
    </div>

    {{-- Create / edit modal --}}
    @if ($showModal)
    <x-ui.modal maxWidth="max-w-md">
    <x-slot:header>
        <div>
            <h3 class="card-title">{{ $editingId ? 'Edit Category' : 'New Category' }}</h3>
            <p class="mt-0.5 text-xs text-slate-400">{{ $editingId ? 'Update the category details.' : 'Add a new way to organize articles.' }}</p>
        </div>
    </x-slot:header>

    <div class="space-y-4">
        <div>
            <label class="label">Name</label>
            <input type="text" wire:model="name" placeholder="e.g. Engineering" class="field">
            @error('name')<p class="field-hint text-danger-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="label">Description</label>
            <textarea wire:model="description" rows="2" placeholder="Optional short description" class="field resize-y"></textarea>
            @error('description')<p class="field-hint text-danger-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <span class="label">Color tag</span>
            @php
                $colorDots = ['primary' => 'bg-primary-500', 'success' => 'bg-success-500', 'warning' => 'bg-warning-500', 'danger' => 'bg-danger-500', 'info' => 'bg-info-500'];
            @endphp
            <div class="flex flex-wrap gap-2">
                @foreach ($this->colors as $value => $label)
                    <button type="button" wire:click="$set('color','{{ $value }}')"
                        class="inline-flex items-center gap-1.5 rounded-[8px] border px-3 py-1.5 text-xs font-medium transition-colors {{ $color === $value ? 'border-primary-500 bg-primary-50 text-primary-700 dark:bg-primary-500/15 dark:text-primary-300' : 'border-slate-200 text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800' }}">
                        <span class="h-2 w-2 rounded-full {{ $colorDots[$value] }}"></span>{{ $label }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <x-slot:footer>
        <x-ui.button variant="secondary" wire:click="$set('showModal', false)">Cancel</x-ui.button>
        <x-ui.button variant="primary" icon="check" wire:click="save" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="save">{{ $editingId ? 'Save changes' : 'Create category' }}</span>
            <span wire:loading wire:target="save">Saving…</span>
        </x-ui.button>
    </x-slot:footer>
    </x-ui.modal>
    @endif
</div>
