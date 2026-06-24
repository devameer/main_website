@php
    $comments ??= $this->comments;
    $counts = $this->counts;
    $hasFilters = $search || $status;
    $selectedCount = count($selected);
@endphp

<div class="space-y-6">
    {{-- Header + stat chips --}}
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Comments</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Moderate reader feedback across articles.</p>
        </div>
    </div>

    @php
        $chipTones = [
            'gray'    => 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300',
            'warning' => 'bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-warning-400',
            'success' => 'bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-400',
            'danger'  => 'bg-danger-50 text-danger-600 dark:bg-danger-500/15 dark:text-danger-400',
        ];
    @endphp
    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
        @foreach ([['all','All','gray','message-square'],['pending','Pending','warning','clock'],['approved','Approved','success','check-circle'],['spam','Spam','danger','alert-triangle']] as [$key,$label,$tone,$icon])
            <button type="button" wire:click="$set('status','{{ $key === 'all' ? '' : $key }}')"
                class="card flex items-center gap-3 p-4 text-left transition-colors hover:border-primary-300 {{ ($key === 'all' ? $status === '' : $status === $key) ? 'border-primary-500 ring-1 ring-primary-500/30' : '' }}">
                <span class="stat-icon {{ $chipTones[$tone] }}">
                    <x-ui.icon :name="$icon" size="18" />
                </span>
                <div>
                    <p class="text-lg font-bold text-slate-900 dark:text-white">{{ $counts[$key] }}</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ $label }}</p>
                </div>
            </button>
        @endforeach
    </div>

    <div class="card relative overflow-hidden">
        {{-- Toolbar --}}
        <div class="flex flex-col gap-3 border-b border-slate-200 p-4 dark:border-slate-800 sm:flex-row sm:items-center">
            <label class="search w-full sm:max-w-xs">
                <x-ui.icon name="search" size="16" class="text-slate-400" />
                <input type="search" wire:model.live.debounce.300ms="search" placeholder="Search comments or authors…" class="text-sm">
            </label>
            <select wire:model.live="status" class="select w-auto sm:ml-auto min-w-[140px] text-sm">
                @foreach ($this->statuses as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        {{-- Bulk bar --}}
        <div class="flex items-center justify-between gap-3 overflow-hidden border-b border-slate-200 bg-primary-50/60 px-4 py-2.5 dark:border-slate-800 dark:bg-primary-500/10 {{ $selectedCount === 0 ? 'hidden' : '' }}">
            <p class="text-sm font-medium text-primary-700 dark:text-primary-300">{{ $selectedCount }} selected</p>
            <div class="flex items-center gap-2">
                <button type="button" wire:click="bulkApprove" class="btn btn-secondary btn-sm"><x-ui.icon name="check-circle" size="15" /> Approve</button>
                <button type="button" wire:click="bulkSpam" class="btn btn-warning btn-sm"><x-ui.icon name="alert-triangle" size="15" /> Mark spam</button>
                <button type="button" wire:click="$set('selected', [])" class="btn btn-ghost btn-sm">Clear</button>
            </div>
        </div>

        @if ($comments->isEmpty())
            <x-ui.empty-state
                :icon="$hasFilters ? 'search' : 'message-square'"
                :title="$hasFilters ? 'No matching comments' : 'No comments yet'"
                :description="$hasFilters ? 'Try adjusting your search or filters.' : 'Reader comments will appear here for moderation.'"
            />
        @else
            <ul class="divide-y divide-slate-100 dark:divide-slate-800">
                @foreach ($comments as $comment)
                    <li wire:key="comment-{{ $comment->id }}" class="flex gap-4 p-4 {{ in_array($comment->id, $selected) ? 'bg-primary-50/40 dark:bg-primary-500/5' : '' }}">
                        <input type="checkbox" value="{{ $comment->id }}" wire:model.live="selected"
                            class="mt-1 h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500 dark:border-slate-600 dark:bg-slate-800"
                            aria-label="Select comment">

                        <img src="{{ $comment->author_avatar }}" alt="" class="h-9 w-9 rounded-full object-cover">

                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-sm font-semibold text-slate-800 dark:text-slate-100">{{ $comment->author_name }}</span>
                                <x-ui.badge :tone="$statusTone[$comment->status]" dot>{{ $statusLabel[$comment->status] }}</x-ui.badge>
                                @if ($comment->article)
                                    <span class="text-xs text-slate-400">on <span class="text-slate-500">“{{ \Illuminate\Support\Str::limit($comment->article->title, 40) }}”</span></span>
                                @endif
                                <span class="ml-auto text-xs text-slate-400">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="mt-1.5 text-sm text-slate-600 dark:text-slate-300">{{ $comment->body }}</p>
                            <div class="mt-2 flex items-center gap-3 text-xs">
                                @if ($comment->status !== 'approved')
                                    <button type="button" wire:click="setStatus({{ $comment->id }},'approved')" class="inline-flex items-center gap-1 font-medium text-success-600 hover:underline dark:text-success-400">
                                        <x-ui.icon name="check" size="13" /> Approve
                                    </button>
                                @else
                                    <button type="button" wire:click="setStatus({{ $comment->id }},'pending')" class="inline-flex items-center gap-1 font-medium text-slate-500 hover:underline">
                                        <x-ui.icon name="archive" size="13" /> Unapprove
                                    </button>
                                @endif
                                @if ($comment->status !== 'spam')
                                    <button type="button" wire:click="setStatus({{ $comment->id }},'spam')" class="inline-flex items-center gap-1 font-medium text-warning-600 hover:underline dark:text-warning-400">
                                        <x-ui.icon name="alert-triangle" size="13" /> Spam
                                    </button>
                                @endif
                                <button type="button" wire:click="toastInfo('Reply composer coming soon.')" class="inline-flex items-center gap-1 font-medium text-slate-500 hover:text-primary-600">
                                    <x-ui.icon name="message-square" size="13" /> Reply
                                </button>
                                <button type="button" wire:click="delete({{ $comment->id }})" wire:confirm="Delete this comment?" class="ml-auto inline-flex items-center gap-1 font-medium text-slate-400 hover:text-danger-600">
                                    <x-ui.icon name="trash-2" size="13" /> Delete
                                </button>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="flex items-center justify-between border-t border-slate-200 px-4 py-3 text-xs text-slate-500 dark:border-slate-800">
                <span>{{ $comments->total() }} comments</span>
                {{ $comments->withQueryString()->links('components.ui.pagination') }}
            </div>
        @endif
    </div>
</div>
