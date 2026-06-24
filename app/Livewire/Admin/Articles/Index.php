<?php

namespace App\Livewire\Admin\Articles;

use App\Livewire\Component;
use App\Models\Article;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url(history: true, except: '')]
    public string $search = '';

    #[Url(history: true, except: '')]
    public string $status = '';

    #[Url(history: true, except: '')]
    public string $language = '';

    #[Url(history: true, except: 'created_at')]
    public string $sortBy = 'created_at';

    #[Url(history: true, except: 'desc')]
    public string $sortDir = 'desc';

    #[Url(history: true, except: 'table')]
    public string $viewMode = 'table'; // table | grid

    public int $perPage = 10;

    /** @var array<int,int> */
    public array $selected = [];

    public bool $selectPage = false;

    public bool $loading = false;

    public function updating($prop): void
    {
        if (in_array($prop, ['search', 'status', 'language', 'perPage'])) {
            $this->resetPage();
        }
        if (in_array($prop, ['search', 'status', 'language'])) {
            $this->loading = true;
        }
    }

    public function updatedSelectPage($value): void
    {
        $this->selected = $value ? $this->articles->pluck('id')->map(fn ($id) => (int) $id)->all() : [];
    }

    public function sort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDir = 'asc';
        }
    }

    #[Computed]
    public function statuses(): array
    {
        return ['' => 'All statuses'] + array_combine(
            Article::STATUSES,
            array_map('ucfirst', Article::STATUSES)
        );
    }

    #[Computed]
    public function languages(): array
    {
        return ['' => 'All languages', 'en' => 'English', 'ar' => 'Arabic'];
    }

    #[Computed]
    public function articles()
    {
        return Article::query()
            ->when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%")
                ->orWhere('author', 'like', "%{$this->search}%"))
            ->when($this->status, fn ($q) => $q->where('status', $this->status))
            ->when($this->language, fn ($q) => $q->where('language', $this->language))
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);
    }

    public function bulkDelete(): void
    {
        if (empty($this->selected)) {
            $this->toastWarning('No articles selected.');
            return;
        }
        Article::destroy($this->selected);
        $count = count($this->selected);
        $this->selected = [];
        $this->selectPage = false;
        $this->toastSuccess("{$count} article(s) deleted.", 'Deleted');
    }

    public function bulkPublish(): void
    {
        if (empty($this->selected)) {
            $this->toastWarning('No articles selected.');
            return;
        }
        Article::whereIn('id', $this->selected)->update(['status' => 'published']);
        $count = count($this->selected);
        $this->selected = [];
        $this->selectPage = false;
        $this->toastSuccess("{$count} article(s) published.", 'Published');
    }

    public function delete(int $id): void
    {
        Article::findOrFail($id)->delete();
        $this->toastSuccess('Article deleted.', 'Deleted');
    }

    public function resetFilters(): void
    {
        $this->reset('search', 'status', 'language');
        $this->resetPage();
    }

    public function render(): mixed
    {
        $articles = $this->articles;

        return $this->page('livewire.admin.articles.index', 'Articles', [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Articles'],
        ], [
            'articles' => $articles,
            'statusTone' => [
                'published' => 'success', 'draft' => 'warning',
                'scheduled' => 'info', 'archived' => 'gray',
            ],
            'statusLabel' => [
                'published' => 'Published', 'draft' => 'Draft',
                'scheduled' => 'Scheduled', 'archived' => 'Archived',
            ],
        ]);
    }
}
