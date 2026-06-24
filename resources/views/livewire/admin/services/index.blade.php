<div class="space-y-6">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Services</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Manage the services shown on the public site — fully bilingual.</p>
        </div>
        <x-ui.button variant="primary" icon="plus" href="{{ route('admin.services.create') }}">New Service</x-ui.button>
    </div>

    <div class="card overflow-hidden">
        <div class="flex items-center gap-3 border-b border-slate-200 p-4 dark:border-slate-800">
            <label class="search w-full lg:max-w-xs">
                <x-ui.icon name="search" size="16" class="text-slate-400" />
                <input type="search" wire:model.live.debounce.300ms="search" placeholder="Search services…" class="text-sm">
                @if ($search)
                    <button type="button" wire:click="$set('search','')" class="text-slate-400 hover:text-slate-600"><x-ui.icon name="x" size="15" /></button>
                @endif
            </label>
        </div>

        <div wire:loading.delay.class="opacity-60 pointer-events-none">
            @if ($services->isEmpty())
                <x-ui.empty-state icon="sparkles" :title="$search ? 'No matching services' : 'No services yet'" :description="$search ? 'Try a different search.' : 'Create your first service.'">
                    <x-slot:actions>
                        <x-ui.button variant="primary" size="sm" icon="plus" href="{{ route('admin.services.create') }}">New Service</x-ui.button>
                    </x-slot:actions>
                </x-ui.empty-state>
            @else
                <div class="table-wrap">
                    <table class="t-base">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th class="hidden md:table-cell">Items</th>
                                <th>Order</th>
                                <th>Published</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $service)
                                <tr wire:key="service-{{ $service->id }}">
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-[8px] bg-slate-100 text-xl dark:bg-slate-800">{{ $service->icon ?? '✨' }}</span>
                                            <div class="min-w-0 max-w-[260px]">
                                                <a href="{{ route('admin.services.edit', $service) }}" class="block truncate font-medium text-slate-800 hover:text-primary-600 dark:text-slate-100">{{ $service->title_en }}</a>
                                                <p class="truncate text-xs text-slate-400">{{ $service->title_ar }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="hidden md:table-cell text-slate-500">{{ count($service->items_en ?? []) }} items</td>
                                    <td>
                                        <div class="flex items-center gap-0.5">
                                            <button type="button" wire:click="move({{ $service->id }},'up')" class="btn btn-ghost btn-icon text-slate-400 hover:text-slate-700" aria-label="Move up"><x-ui.icon name="chevron-up" size="15" /></button>
                                            <button type="button" wire:click="move({{ $service->id }},'down')" class="btn btn-ghost btn-icon text-slate-400 hover:text-slate-700" aria-label="Move down"><x-ui.icon name="chevron-down" size="15" /></button>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" wire:click="togglePublished({{ $service->id }})" class="badge {{ $service->is_published ? 'badge-success' : 'badge-gray' }} cursor-pointer">
                                            {{ $service->is_published ? 'Published' : 'Hidden' }}
                                        </button>
                                    </td>
                                    <td>
                                        <div class="flex items-center justify-end gap-0.5">
                                            <x-ui.tooltip text="Edit"><a href="{{ route('admin.services.edit', $service) }}" class="btn btn-ghost btn-icon text-slate-500 hover:text-primary-600"><x-ui.icon name="pencil" size="16" /></a></x-ui.tooltip>
                                            <x-ui.tooltip text="Delete">
                                                <button type="button" wire:click="delete({{ $service->id }})" wire:confirm="Delete this service?" class="btn btn-ghost btn-icon text-slate-500 hover:text-danger-600">
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

                <div class="flex items-center justify-between border-t border-slate-200 px-4 py-3 dark:border-slate-800">
                    <span class="text-xs text-slate-500">Showing <span class="font-medium text-slate-700 dark:text-slate-300">{{ $services->firstItem() }}</span>–<span class="font-medium text-slate-700 dark:text-slate-300">{{ $services->lastItem() }}</span> of <span class="font-medium text-slate-700 dark:text-slate-300">{{ $services->total() }}</span></span>
                    {{ $services->withQueryString()->links('components.ui.pagination') }}
                </div>
            @endif
        </div>
    </div>
</div>
