<?php

namespace App\Livewire\Admin\Projects;

use App\Livewire\Component;
use App\Models\Project;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url(history: true, except: '')]
    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function togglePublished(int $id): void
    {
        $project = Project::findOrFail($id);
        $project->update(['is_published' => ! $project->is_published]);

        $this->toastSuccess($project->is_published ? 'Project published.' : 'Project hidden.');
    }

    public function move(int $id, string $direction): void
    {
        $project = Project::findOrFail($id);
        $current = (int) $project->sort_order;

        if ($direction === 'up') {
            $swap = Project::where('sort_order', '<', $current)->orderByDesc('sort_order')->first();
        } else {
            $swap = Project::where('sort_order', '>', $current)->orderBy('sort_order')->first();
        }

        if ($swap) {
            $project->update(['sort_order' => $swap->sort_order]);
            $swap->update(['sort_order' => $current]);
        }
    }

    public function delete(int $id): void
    {
        Project::findOrFail($id)->delete();
        $this->toastSuccess('Project deleted.', 'Deleted');
    }

    public function render(): mixed
    {
        $projects = Project::query()
            ->when($this->search, fn ($q) => $q->where('name_en', 'like', "%{$this->search}%")
                ->orWhere('name_ar', 'like', "%{$this->search}%"))
            ->ordered()
            ->paginate(12);

        return $this->page('livewire.admin.projects.index', 'Projects', [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Projects'],
        ], ['projects' => $projects]);
    }
}
