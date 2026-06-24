<?php

namespace App\Livewire\Admin\Testimonials;

use App\Livewire\Component;
use App\Models\Testimonial;
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
        $t = Testimonial::findOrFail($id);
        $t->update(['is_published' => ! $t->is_published]);
        $this->toastSuccess($t->is_published ? 'Testimonial shown.' : 'Testimonial hidden.');
    }

    public function move(int $id, string $direction): void
    {
        $t = Testimonial::findOrFail($id);
        $current = (int) $t->sort_order;
        $swap = $direction === 'up'
            ? Testimonial::where('sort_order', '<', $current)->orderByDesc('sort_order')->first()
            : Testimonial::where('sort_order', '>', $current)->orderBy('sort_order')->first();

        if ($swap) {
            $t->update(['sort_order' => $swap->sort_order]);
            $swap->update(['sort_order' => $current]);
        }
    }

    public function delete(int $id): void
    {
        Testimonial::findOrFail($id)->delete();
        $this->toastSuccess('Testimonial deleted.', 'Deleted');
    }

    public function render(): mixed
    {
        $testimonials = Testimonial::query()
            ->when($this->search, fn ($q) => $q->where('body_en', 'like', "%{$this->search}%")
                ->orWhere('body_ar', 'like', "%{$this->search}%"))
            ->ordered()
            ->paginate(12);

        return $this->page('livewire.admin.testimonials.index', 'Testimonials', [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Testimonials'],
        ], ['testimonials' => $testimonials]);
    }
}
