@php
    $folders = [
        'inbox'   => ['Inbox', 'mail'],
        'unread'  => ['Unread', 'mail'],
        'starred' => ['Starred', 'star'],
        'archived'=> ['Archived', 'archive'],
    ];
@endphp

<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Messages</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $counts['unread'] }} unread of {{ $counts['inbox'] }} in inbox.</p>
        </div>
        <label class="search w-full sm:w-72">
            <x-ui.icon name="search" size="16" class="text-slate-400" />
            <input type="search" wire:model.live.debounce.300ms="search" placeholder="Search messages…" class="text-sm">
        </label>
    </div>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        {{-- Folder list --}}
        <div class="space-y-1">
            @foreach ($folders as $key => [$label, $icon])
                <button type="button" wire:click="$set('folder','{{ $key }}')"
                    class="flex w-full items-center gap-3 rounded-[8px] px-3 py-2.5 text-sm font-medium transition-colors {{ $folder === $key ? 'bg-primary-50 text-primary-700 dark:bg-primary-500/15 dark:text-primary-300' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' }}">
                    <x-ui.icon :name="$icon" size="17" />
                    <span class="flex-1 text-left">{{ $label }}</span>
                    @if ($counts[$key] > 0)
                        <span class="badge {{ $key === 'unread' ? 'badge-primary' : 'badge-gray' }}">{{ $counts[$key] }}</span>
                    @endif
                </button>
            @endforeach
        </div>

        {{-- List + reading pane --}}
        <div class="lg:col-span-2">
            <div class="card overflow-hidden">
                @if ($messages->isEmpty())
                    <x-ui.empty-state
                        :icon="$search ? 'search' : 'inbox'"
                        :title="$search ? 'No matching messages' : 'No messages'"
                        :description="$search ? 'Try a different search.' : 'Your ' . $folder . ' is empty.'"
                    />
                @else
                    <div class="grid @if($selected) lg:grid-cols-5 @endif">
                        {{-- Message list --}}
                        <div class="{{ $selected ? 'lg:col-span-2 lg:border-r lg:border-slate-200 lg:dark:border-slate-800 ' : '' }}divide-y divide-slate-100 dark:divide-slate-800 max-h-[600px] overflow-y-auto">
                            @foreach ($messages as $message)
                                <button type="button" wire:click="open({{ $message->id }})"
                                    class="flex w-full items-start gap-3 px-4 py-3 text-left transition-colors hover:bg-slate-50 dark:hover:bg-slate-800/50 {{ $selectedId === $message->id ? 'bg-primary-50/60 dark:bg-primary-500/10' : '' }} {{ $message->status === 'unread' ? 'font-semibold' : '' }}">
                                    <img src="{{ $message->avatar }}" alt="" class="mt-0.5 h-9 w-9 rounded-full object-cover">
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center justify-between gap-2">
                                            <span class="truncate text-sm text-slate-800 dark:text-slate-100">{{ $message->name }}</span>
                                            <span class="shrink-0 text-[11px] text-slate-400">{{ $message->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="truncate text-xs {{ $message->status === 'unread' ? 'text-slate-700 dark:text-slate-200' : 'text-slate-500' }}">{{ $message->subject }}</p>
                                        <p class="truncate text-xs text-slate-400">{{ $message->body }}</p>
                                    </div>
                                    @if ($message->status === 'unread')
                                        <span class="mt-2 h-2 w-2 shrink-0 rounded-full bg-primary-500"></span>
                                    @elseif ($message->starred)
                                        <x-ui.icon name="star" size="14" class="mt-1.5 shrink-0 fill-warning-400 text-warning-400" />
                                    @endif
                                </button>
                            @endforeach
                        </div>

                        {{-- Reading pane --}}
                        @if ($selected)
                        <div class="hidden flex-col p-5 lg:col-span-3 lg:flex" wire:key="read-{{ $selected->id }}">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $selected->avatar }}" alt="" class="h-11 w-11 rounded-full object-cover">
                                    <div>
                                        <p class="font-semibold text-slate-900 dark:text-white">{{ $selected->name }}</p>
                                        <p class="text-xs text-slate-400">{{ $selected->email }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-0.5">
                                    <x-ui.tooltip text="{{ $selected->starred ? 'Unstar' : 'Star' }}">
                                        <button type="button" wire:click="toggleStar({{ $selected->id }})" class="btn btn-ghost btn-icon {{ $selected->starred ? 'text-warning-400' : 'text-slate-400' }}">
                                            <x-ui.icon name="star" size="17" class="{{ $selected->starred ? 'fill-warning-400' : '' }}" />
                                        </button>
                                    </x-ui.tooltip>
                                    <x-ui.tooltip text="Archive">
                                        <button type="button" wire:click="archive({{ $selected->id }})" class="btn btn-ghost btn-icon text-slate-400 hover:text-success-600">
                                            <x-ui.icon name="archive" size="17" />
                                        </button>
                                    </x-ui.tooltip>
                                    <x-ui.tooltip text="Delete">
                                        <button type="button" wire:click="delete({{ $selected->id }})" wire:confirm="Delete this message?" class="btn btn-ghost btn-icon text-slate-400 hover:text-danger-600">
                                            <x-ui.icon name="trash-2" size="17" />
                                        </button>
                                    </x-ui.tooltip>
                                    <x-ui.tooltip text="Close">
                                        <button type="button" wire:click="close" class="btn btn-ghost btn-icon text-slate-400">
                                            <x-ui.icon name="x" size="17" />
                                        </button>
                                    </x-ui.tooltip>
                                </div>
                            </div>
                            <h3 class="mt-4 text-base font-semibold text-slate-900 dark:text-white">{{ $selected->subject }}</h3>
                            <p class="mt-1 text-xs text-slate-400">{{ $selected->created_at->format('M j, Y \a\t g:i A') }}</p>
                            <div class="mt-4 flex-1 whitespace-pre-line text-sm leading-relaxed text-slate-600 dark:text-slate-300">{{ $selected->body }}</div>
                            <div class="mt-6 border-t border-slate-200 pt-4 dark:border-slate-800">
                                <div class="flex items-center gap-2">
                                    <x-ui.button variant="secondary" size="sm" icon="send" type="button" wire:click="toastInfo('Reply composer coming soon.')">Reply</x-ui.button>
                                    <x-ui.button variant="ghost" size="sm" icon="archive" type="button" wire:click="archive({{ $selected->id }})">Archive</x-ui.button>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="flex items-center justify-between border-t border-slate-200 px-4 py-3 text-xs text-slate-500 dark:border-slate-800">
                        <span>{{ $messages->total() }} messages</span>
                        {{ $messages->links('components.ui.pagination') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
