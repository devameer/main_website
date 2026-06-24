<?php

namespace App\Livewire\Admin;

use App\Livewire\Component;
use App\Models\Article;
use App\Models\Category;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\WithPagination;

class Categories extends Component
{
    use WithPagination;

    #[Validate('required|string|max:80')]
    public string $name = '';

    #[Validate('nullable|string|max:160')]
    public string $description = '';

    #[Validate('required|string|max:20')]
    public string $color = 'primary';

    public bool $showModal = false;
    public ?int $editingId = null;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function colors(): array
    {
        return [
            'primary' => 'Primary',
            'success' => 'Success',
            'warning' => 'Warning',
            'danger' => 'Danger',
            'info' => 'Info',
        ];
    }

    public function openModal(?int $id = null): void
    {
        $this->resetValidation();
        $this->editingId = $id;

        if ($id) {
            $cat = Category::findOrFail($id);
            $this->name = $cat->name;
            $this->description = $cat->description ?? '';
            $this->color = $cat->color;
        } else {
            $this->reset(['name', 'description', 'color']);
            $this->color = 'primary';
        }

        $this->showModal = true;
    }

    public function save(): void
    {
        $data = $this->validate();

        if ($this->editingId) {
            Category::findOrFail($this->editingId)->update($data);
            $this->toastSuccess('Category updated.', 'Saved');
        } else {
            Category::create($data);
            $this->toastSuccess('Category created.', 'Created');
        }

        $this->showModal = false;
        $this->reset(['name', 'description', 'color', 'editingId']);
    }

    public function delete(int $id): void
    {
        $cat = Category::findOrFail($id);
        $inUse = Article::where('category', $cat->name)->count();

        if ($inUse) {
            $this->toastError("Cannot delete — {$inUse} article(s) use this category.", 'In use');
            return;
        }

        $cat->delete();
        $this->toastSuccess('Category deleted.', 'Deleted');
    }

    public function render(): mixed
    {
        $categories = Category::query()
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->withCount(['articles'])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(12);

        return $this->page('livewire.admin.categories', 'Categories', [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Categories'],
        ], [
            'categories' => $categories,
        ]);
    }
}
