@php
    $roles = ['' => 'All roles'] + array_combine(\App\Models\User::ROLES, array_map('ucfirst', \App\Models\User::ROLES));
@endphp

<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Team Members</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Manage who has access to the admin panel.</p>
        </div>
        <x-ui.button variant="primary" icon="plus" wire:click="toastInfo('Invite flow coming soon.')">Invite member</x-ui.button>
    </div>

    <div class="card overflow-hidden">
        {{-- Toolbar --}}
        <div class="flex flex-col gap-3 border-b border-slate-200 p-4 dark:border-slate-800 sm:flex-row sm:items-center">
            <label class="search w-full sm:max-w-xs">
                <x-ui.icon name="search" size="16" class="text-slate-400" />
                <input type="search" wire:model.live.debounce.300ms="search" placeholder="Search by name or email…" class="text-sm">
            </label>
            <select wire:model.live="role" class="select w-auto sm:ml-auto min-w-[140px] text-sm">
                @foreach ($roles as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        @if ($users->isEmpty())
            <x-ui.empty-state icon="users" title="No members found" description="Try adjusting your search or filters." />
        @else
            <div class="table-wrap">
                <table class="t-base">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th class="hidden md:table-cell">Role</th>
                            <th class="hidden lg:table-cell">Status</th>
                            <th class="hidden sm:table-cell">Joined</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr wire:key="user-{{ $user->id }}">
                                <td>
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $user->avatar }}" alt="" class="h-10 w-10 rounded-full object-cover">
                                        <div class="min-w-0">
                                            <p class="truncate font-medium text-slate-800 dark:text-slate-100">{{ $user->name }}</p>
                                            <p class="truncate text-xs text-slate-400">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden md:table-cell">
                                    <span class="badge badge-{{ $roleTone[$user->role] ?? 'gray' }}">{{ ucfirst($user->role) }}</span>
                                </td>
                                <td class="hidden lg:table-cell">
                                    @if ($user->active)
                                        <span class="badge badge-success dot">Active</span>
                                    @else
                                        <span class="badge badge-gray dot">Inactive</span>
                                    @endif
                                </td>
                                <td class="hidden sm:table-cell text-slate-500">{{ $user->created_at->format('M j, Y') }}</td>
                                <td>
                                    <div class="flex items-center justify-end gap-0.5">
                                        <x-ui.tooltip text="{{ $user->active ? 'Deactivate' : 'Activate' }}">
                                            <button type="button" wire:click="toggleActive({{ $user->id }})" wire:confirm="Change this user's status?" class="btn btn-ghost btn-icon text-slate-500 {{ $user->active ? 'hover:text-danger-600' : 'hover:text-success-600' }}">
                                                <x-ui.icon name="{{ $user->active ? 'circle-x' : 'circle-check' }}" size="16" />
                                            </button>
                                        </x-ui.tooltip>
                                        <x-ui.tooltip text="Edit">
                                            <button type="button" wire:click="toastInfo('Profile editing coming soon.')" class="btn btn-ghost btn-icon text-slate-500 hover:text-primary-600">
                                                <x-ui.icon name="pencil" size="16" />
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
                <span>{{ $users->total() }} members</span>
                {{ $users->links('components.ui.pagination') }}
            </div>
        @endif
    </div>
</div>
