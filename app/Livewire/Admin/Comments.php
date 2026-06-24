<?php

namespace App\Livewire\Admin;

use App\Livewire\Component;
use App\Models\Comment;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class Comments extends Component
{
    use WithPagination;

    #[Url(history: true, except: '')]
    public string $search = '';

    #[Url(history: true, except: '')]
    public string $status = '';

    /** @var array<int,int> */
    public array $selected = [];

    public bool $selectPage = false;

    public function updating($prop): void
    {
        if (in_array($prop, ['search', 'status'])) {
            $this->resetPage();
            $this->selected = [];
            $this->selectPage = false;
        }
    }

    public function updatedSelectPage($value): void
    {
        $this->selected = $value ? $this->comments->pluck('id')->map(fn ($id) => (int) $id)->all() : [];
    }

    #[Computed]
    public function statuses(): array
    {
        return ['' => 'All statuses'] + array_combine(
            Comment::STATUSES,
            array_map('ucfirst', Comment::STATUSES)
        );
    }

    #[Computed]
    public function counts(): array
    {
        return [
            'all' => Comment::count(),
            'pending' => Comment::where('status', 'pending')->count(),
            'approved' => Comment::where('status', 'approved')->count(),
            'spam' => Comment::where('status', 'spam')->count(),
        ];
    }

    #[Computed]
    public function comments()
    {
        return Comment::query()
            ->with('article:id,title')
            ->when($this->search, fn ($q) => $q->where('body', 'like', "%{$this->search}%")
                ->orWhere('author_name', 'like', "%{$this->search}%"))
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->latest()
            ->paginate(12);
    }

    public function setStatus(int $id, string $status): void
    {
        Comment::findOrFail($id)->update(['status' => $status]);
        $this->toastSuccess('Comment marked as ' . $status . '.', 'Updated');
    }

    public function bulkApprove(): void
    {
        if (empty($this->selected)) {
            $this->toastWarning('No comments selected.');

            return;
        }
        Comment::whereIn('id', $this->selected)->update(['status' => 'approved']);
        $count = count($this->selected);
        $this->reset('selected', 'selectPage');
        $this->toastSuccess("{$count} comment(s) approved.", 'Approved');
    }

    public function bulkSpam(): void
    {
        if (empty($this->selected)) {
            $this->toastWarning('No comments selected.');

            return;
        }
        Comment::whereIn('id', $this->selected)->update(['status' => 'spam']);
        $count = count($this->selected);
        $this->reset('selected', 'selectPage');
        $this->toastSuccess("{$count} comment(s) marked as spam.", 'Marked as spam');
    }

    public function delete(int $id): void
    {
        Comment::findOrFail($id)->delete();
        $this->toastSuccess('Comment deleted.', 'Deleted');
    }

    public function render(): mixed
    {
        $statusTone = ['pending' => 'warning', 'approved' => 'success', 'spam' => 'danger'];
        $statusLabel = ['pending' => 'Pending', 'approved' => 'Approved', 'spam' => 'Spam'];

        return $this->page('livewire.admin.comments', 'Comments', [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Comments'],
        ], [
            'comments' => $this->comments,
            'statusTone' => $statusTone,
            'statusLabel' => $statusLabel,
        ]);
    }
}
