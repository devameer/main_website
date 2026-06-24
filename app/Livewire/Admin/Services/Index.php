<?php

namespace App\Livewire\Admin\Services;

use App\Livewire\Component;
use App\Models\Service;
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
        $service = Service::findOrFail($id);
        $service->update(['is_published' => ! $service->is_published]);
        $this->toastSuccess($service->is_published ? 'Service published.' : 'Service hidden.');
    }

    public function move(int $id, string $direction): void
    {
        $service = Service::findOrFail($id);
        $current = (int) $service->sort_order;
        $swap = $direction === 'up'
            ? Service::where('sort_order', '<', $current)->orderByDesc('sort_order')->first()
            : Service::where('sort_order', '>', $current)->orderBy('sort_order')->first();

        if ($swap) {
            $service->update(['sort_order' => $swap->sort_order]);
            $swap->update(['sort_order' => $current]);
        }
    }

    public function delete(int $id): void
    {
        Service::findOrFail($id)->delete();
        $this->toastSuccess('Service deleted.', 'Deleted');
    }

    public function render(): mixed
    {
        $services = Service::query()
            ->when($this->search, fn ($q) => $q->where('title_en', 'like', "%{$this->search}%")
                ->orWhere('title_ar', 'like', "%{$this->search}%"))
            ->ordered()
            ->paginate(12);

        return $this->page('livewire.admin.services.index', 'Services', [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Services'],
        ], ['services' => $services]);
    }
}
