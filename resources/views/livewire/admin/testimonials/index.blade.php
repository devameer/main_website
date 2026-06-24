<div class="space-y-6">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Testimonials</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Kind words shown on the About page — bilingual.</p>
        </div>
        <x-ui.button variant="primary" icon="plus" href="{{ route('admin.testimonials.create') }}">New Testimonial</x-ui.button>
    </div>

    <div class="card overflow-hidden">
        <div class="flex items-center gap-3 border-b border-slate-200 p-4 dark:border-slate-800">
            <label class="search w-full lg:max-w-xs">
                <x-ui.icon name="search" size="16" class="text-slate-400" />
                <input type="search" wire:model.live.debounce.300ms="search" placeholder="Search testimonials…" class="text-sm">
                @if ($search)
                    <button type="button" wire:click="$set('search','')" class="text-slate-400 hover:text-slate-600"><x-ui.icon name="x" size="15" /></button>
                @endif
            </label>
        </div>

        <div wire:loading.delay.class="opacity-60 pointer-events-none">
            @if ($testimonials->isEmpty())
                <x-ui.empty-state icon="quote" :title="$search ? 'No matches' : 'No testimonials yet'" :description="$search ? 'Try a different search.' : 'Add your first testimonial.'">
                    <x-slot:actions>
                        <x-ui.button variant="primary" size="sm" icon="plus" href="{{ route('admin.testimonials.create') }}">New Testimonial</x-ui.button>
                    </x-slot:actions>
                </x-ui.empty-state>
            @else
                <div class="table-wrap">
                    <table class="t-base">
                        <thead>
                            <tr>
                                <th>Quote</th>
                                <th class="hidden md:table-cell">Author</th>
                                <th>Order</th>
                                <th>Published</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($testimonials as $t)
                                <tr wire:key="t-{{ $t->id }}">
                                    <td>
                                        <div class="flex max-w-md items-center gap-3">
                                            <span class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-primary-100 text-xs font-bold text-primary-700">{{ $t->initials }}</span>
                                            <span class="line-clamp-2 text-sm text-slate-700 dark:text-slate-300">“{{ $t->body_en }}”</span>
                                        </div>
                                    </td>
                                    <td class="hidden md:table-cell text-slate-500">{{ $t->author_en }} · {{ $t->role_en }}</td>
                                    <td>
                                        <div class="flex items-center gap-0.5">
                                            <button type="button" wire:click="move({{ $t->id }},'up')" class="btn btn-ghost btn-icon text-slate-400 hover:text-slate-700"><x-ui.icon name="chevron-up" size="15" /></button>
                                            <button type="button" wire:click="move({{ $t->id }},'down')" class="btn btn-ghost btn-icon text-slate-400 hover:text-slate-700"><x-ui.icon name="chevron-down" size="15" /></button>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" wire:click="togglePublished({{ $t->id }})" class="badge {{ $t->is_published ? 'badge-success' : 'badge-gray' }} cursor-pointer">{{ $t->is_published ? 'Published' : 'Hidden' }}</button>
                                    </td>
                                    <td>
                                        <div class="flex items-center justify-end gap-0.5">
                                            <x-ui.tooltip text="Edit"><a href="{{ route('admin.testimonials.edit', $t) }}" class="btn btn-ghost btn-icon text-slate-500 hover:text-primary-600"><x-ui.icon name="pencil" size="16" /></a></x-ui.tooltip>
                                            <x-ui.tooltip text="Delete">
                                                <button type="button" wire:click="delete({{ $t->id }})" wire:confirm="Delete this testimonial?" class="btn btn-ghost btn-icon text-slate-500 hover:text-danger-600"><x-ui.icon name="trash-2" size="16" /></button>
                                            </x-ui.tooltip>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex items-center justify-between border-t border-slate-200 px-4 py-3 dark:border-slate-800">
                    <span class="text-xs text-slate-500">{{ $testimonials->total() }} total</span>
                    {{ $testimonials->withQueryString()->links('components.ui.pagination') }}
                </div>
            @endif
        </div>
    </div>
</div>
