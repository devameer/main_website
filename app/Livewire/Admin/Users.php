<?php

namespace App\Livewire\Admin;

use App\Livewire\Component;
use App\Models\User;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    #[Url(history: true, except: '')]
    public string $search = '';

    #[Url(history: true, except: '')]
    public string $role = '';

    public function updating($prop): void
    {
        if (in_array($prop, ['search', 'role'])) {
            $this->resetPage();
        }
    }

    public function toggleActive(int $id): void
    {
        $user = User::findOrFail($id);
        $user->update(['active' => ! $user->active]);
        $this->toastSuccess($user->active ? 'User activated.' : 'User deactivated.', 'Updated');
    }

    public function render(): mixed
    {
        $users = User::query()
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%"))
            ->when($this->role, fn ($q) => $q->where('role', $this->role))
            ->orderByDesc('id')
            ->paginate(12);

        $roleTone = ['admin' => 'danger', 'editor' => 'primary', 'author' => 'info', 'viewer' => 'gray'];

        return $this->page('livewire.admin.users', 'Users', [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Users'],
        ], [
            'users' => $users,
            'roleTone' => $roleTone,
        ]);
    }
}
