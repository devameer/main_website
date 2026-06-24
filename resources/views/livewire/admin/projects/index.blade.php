<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Projects</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Manage the work shown on the public site — fully bilingual.</p>
        </div>
        <x-ui.button variant="primary" icon="plus" href="{{ route('admin.projects.create') }}">New Project</x-ui.button>
    </div>

    <div class="card overflow-hidden">
        {{-- Toolbar --}}
        <div class="flex items-center gap-3 border-b border-slate-200 p-4 dark:border-slate-800">
            <label class="search w-full lg:max-w-xs">
                <x-ui.icon name="search" size="16" class="text-slate-400" />
                <input type="search" wire:model.live.debounce.300ms="search" placeholder="Search projects…" class="text-sm">
                @if ($search)
                    <button type="button" wire:click="$set('search','')" class="text-slate-400 hover:text-slate-600"><x-ui.icon name="x" size="15" /></button>
                @endif
            </label>
        </div>

        <div wire:loading.delay.class="opacity-60 pointer-events-none">
            @if ($projects->isEmpty())
                <x-ui.empty-state
                    icon="briefcase"
                    :title="$search ? 'No matching projects' : 'No projects yet'"
                    :description="$search ? 'Try a different search.' : 'Create your first project to showcase your work.'"
                >
                    <x-slot:actions>
                        <x-ui.button variant="primary" size="sm" icon="plus" href="{{ route('admin.projects.create') }}">New Project</x-ui.button>
                    </x-slot:actions>
                </x-ui.empty-state>
            @else
                <div class="table-wrap">
                    <table class="t-base">
                        <thead>
                            <tr>
                                <th>Project</th>
                                <th class="hidden md:table-cell">Role</th>
                                <th class="hidden sm:table-cell">Year</th>
                                <th class="hidden lg:table-cell">Tags</th>
                                <th>Order</th>
                                <th>Published</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                                <tr wire:key="project-{{ $project->id }}">
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <span class="grid h-10 w-10 shrink-0 place-items-center rounded-[8px] bg-slate-100 text-xl dark:bg-slate-800">{{ $project->icon ?? '📦' }}</span>
                                            <div class="min-w-0 max-w-[260px]">
                                                <a href="{{ route('admin.projects.edit', $project) }}" class="block truncate font-medium text-slate-800 hover:text-primary-600 dark:text-slate-100">{{ $project->name_en }}</a>
                                                <p class="truncate text-xs text-slate-400">{{ $project->name_ar }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="hidden md:table-cell text-slate-600 dark:text-slate-300">{{ $project->role_en ?: '—' }}</td>
                                    <td class="hidden sm:table-cell text-slate-500">{{ $project->year ?: '—' }}</td>
                                    <td class="hidden lg:table-cell">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach (($project->tags_en ?? []) as $tag)
                                                <span class="badge badge-gray">{{ $tag }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-0.5">
                                            <button type="button" wire:click="move({{ $project->id }},'up')" class="btn btn-ghost btn-icon text-slate-400 hover:text-slate-700" aria-label="Move up"><x-ui.icon name="chevron-up" size="15" /></button>
                                            <button type="button" wire:click="move({{ $project->id }},'down')" class="btn btn-ghost btn-icon text-slate-400 hover:text-slate-700" aria-label="Move down"><x-ui.icon name="chevron-down" size="15" /></button>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" wire:click="togglePublished({{ $project->id }})" class="badge {{ $project->is_published ? 'badge-success' : 'badge-gray' }} cursor-pointer" wire:confirm="{{ $project->is_published ? 'Hide this project?' : 'Publish this project?' }}">
                                            {{ $project->is_published ? 'Published' : 'Hidden' }}
                                        </button>
                                    </td>
                                    <td>
                                        <div class="flex items-center justify-end gap-0.5">
                                            <x-ui.tooltip text="View on site"><a href="{{ route('work.show', $project->slug) }}" target="_blank" class="btn btn-ghost btn-icon text-slate-500 hover:text-info-600"><x-ui.icon name="external-link" size="15" /></a></x-ui.tooltip>
                                            <x-ui.tooltip text="Edit"><a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-ghost btn-icon text-slate-500 hover:text-primary-600"><x-ui.icon name="pencil" size="16" /></a></x-ui.tooltip>
                                            <x-ui.tooltip text="Delete">
                                                <button type="button" wire:click="delete({{ $project->id }})" wire:confirm="Delete this project?" class="btn btn-ghost btn-icon text-slate-500 hover:text-danger-600">
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
                    <span class="text-xs text-slate-500">
                        Showing <span class="font-medium text-slate-700 dark:text-slate-300">{{ $projects->firstItem() }}</span>–<span class="font-medium text-slate-700 dark:text-slate-300">{{ $projects->lastItem() }}</span> of <span class="font-medium text-slate-700 dark:text-slate-300">{{ $projects->total() }}</span>
                    </span>
                    {{ $projects->withQueryString()->links('components.ui.pagination') }}
                </div>
            @endif
        </div>
    </div>
</div>
