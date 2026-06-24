<?php

namespace App\Livewire\Admin;

use App\Livewire\Component;
use App\Models\Message;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class Messages extends Component
{
    use WithPagination;

    #[Url(history: true, except: 'inbox')]
    public string $folder = 'inbox'; // inbox | unread | starred | archived

    #[Url(history: true, except: '')]
    public string $search = '';

    public ?int $selectedId = null;

    public function updating($prop): void
    {
        if (in_array($prop, ['folder', 'search'])) {
            $this->resetPage();
        }
    }

    public function open(int $id): void
    {
        $this->selectedId = $id;
        $message = Message::find($id);
        if ($message && $message->status === 'unread') {
            $message->update(['status' => 'read', 'read_at' => now()]);
        }
    }

    public function close(): void
    {
        $this->selectedId = null;
    }

    public function toggleStar(int $id): void
    {
        $message = Message::findOrFail($id);
        $message->update(['starred' => ! $message->starred]);
    }

    public function archive(int $id): void
    {
        Message::findOrFail($id)->update(['status' => 'archived']);
        if ($this->selectedId === $id) {
            $this->selectedId = null;
        }
        $this->toastSuccess('Message archived.', 'Archived');
    }

    public function delete(int $id): void
    {
        Message::findOrFail($id)->delete();
        if ($this->selectedId === $id) {
            $this->selectedId = null;
        }
        $this->toastSuccess('Message deleted.', 'Deleted');
    }

    public function render(): mixed
    {
        $query = Message::query()
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('subject', 'like', "%{$this->search}%"))
            ->when($this->folder, function ($q) {
                match ($this->folder) {
                    'unread' => $q->where('status', 'unread'),
                    'starred' => $q->where('starred', true),
                    'archived' => $q->where('status', 'archived'),
                    default => $q->where('status', '!=', 'archived'),
                };
            });

        $messages = (clone $query)->latest()->paginate(15)->withQueryString();
        $selected = $this->selectedId ? Message::find($this->selectedId) : null;

        $counts = [
            'inbox' => Message::where('status', '!=', 'archived')->count(),
            'unread' => Message::where('status', 'unread')->count(),
            'starred' => Message::where('starred', true)->count(),
            'archived' => Message::where('status', 'archived')->count(),
        ];

        return $this->page('livewire.admin.messages', 'Messages', [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Messages'],
        ], [
            'messages' => $messages,
            'selected' => $selected,
            'counts' => $counts,
        ]);
    }
}
