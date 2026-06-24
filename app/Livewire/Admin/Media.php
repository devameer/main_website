<?php

namespace App\Livewire\Admin;

use App\Livewire\Component;
use App\Models\MediaItem;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Media extends Component
{
    use WithFileUploads, WithPagination;

    #[Url(history: true, except: '')]
    public string $search = '';

    #[Url(history: true, except: '')]
    public string $collection = '';

    /** @var array<int> */
    public array $selected = [];

    public ?int $previewId = null;

    public $upload = null;

    public string $uploadName = '';

    public bool $showUpload = false;

    public function updating($prop): void
    {
        if (in_array($prop, ['search', 'collection'])) {
            $this->resetPage();
            $this->selected = [];
        }
    }

    #[Computed]
    public function collections(): array
    {
        return ['' => 'All collections'] + MediaItem::query()
            ->select('collection')
            ->distinct()
            ->orderBy('collection')
            ->pluck('collection', 'collection')
            ->all();
    }

    #[Computed]
    public function stats(): array
    {
        return [
            'count' => MediaItem::count(),
            'size' => MediaItem::totalSize(),
            'images' => MediaItem::where('type', 'image')->count(),
        ];
    }

    #[Computed]
    public function items()
    {
        return MediaItem::query()
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when($this->collection, fn ($q) => $q->where('collection', $this->collection))
            ->latest()
            ->paginate(24);
    }

    public function updatedUpload(): void
    {
        $this->validate([
            'upload' => 'required|image|max:5120',
        ]);

        $name = $this->uploadName ?: $this->upload->getClientOriginalName();

        MediaItem::create([
            'name' => $name,
            'path' => 'https://picsum.photos/seed/' . uniqid() . '/1200/800',
            'type' => 'image',
            'mime_type' => $this->upload->getMimeType(),
            'size' => $this->upload->getSize(),
            'width' => 1200,
            'height' => 800,
            'collection' => $this->collection ?: 'default',
            'alt_text' => $name,
        ]);

        $this->reset(['upload', 'uploadName', 'showUpload']);
        $this->toastSuccess($name . ' uploaded.', 'Uploaded');
    }

    public function delete(int $id): void
    {
        MediaItem::findOrFail($id)->delete();
        if ($this->previewId === $id) {
            $this->previewId = null;
        }
        $this->toastSuccess('Media deleted.', 'Deleted');
    }

    public function bulkDelete(): void
    {
        if (empty($this->selected)) {
            $this->toastWarning('No media selected.');

            return;
        }
        $count = count($this->selected);
        MediaItem::destroy($this->selected);
        $this->selected = [];
        $this->toastSuccess("{$count} item(s) deleted.", 'Deleted');
    }

    public function copyUrl(int $id): void
    {
        $item = MediaItem::findOrFail($id);
        $this->dispatch('notify', type: 'info', message: 'URL copied: ' . Str::limit($item->path, 40));
    }

    public function render(): mixed
    {
        return $this->page('livewire.admin.media', 'Media', [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Media'],
        ], [
            'items' => $this->items,
        ]);
    }
}
