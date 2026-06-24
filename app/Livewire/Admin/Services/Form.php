<?php

namespace App\Livewire\Admin\Services;

use App\Livewire\Component;
use App\Models\Service;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;

class Form extends Component
{
    public ?Service $service = null;

    #[Validate('required|string|max:120')]
    public string $title_en = '';

    #[Validate('required|string|max:120')]
    public string $title_ar = '';

    public string $desc_en = '';
    public string $desc_ar = '';
    public string $items_en = '';
    public string $items_ar = '';
    public string $icon = '';
    public string $slug = '';
    public bool $is_published = true;

    public function mount(?Service $service = null): void
    {
        if ($service && $service->exists) {
            $this->service = $service;
            $this->title_en = $service->title_en ?? '';
            $this->title_ar = $service->title_ar ?? '';
            $this->desc_en = $service->desc_en ?? '';
            $this->desc_ar = $service->desc_ar ?? '';
            $this->items_en = implode(', ', $service->items_en ?? []);
            $this->items_ar = implode(', ', $service->items_ar ?? []);
            $this->icon = $service->icon ?? '';
            $this->slug = $service->slug ?? '';
            $this->is_published = (bool) $service->is_published;
        }
    }

    public function save(): void
    {
        $this->validate();

        $slug = trim($this->slug) !== '' ? Str::slug($this->slug) : Str::slug($this->title_en);
        $parse = fn ($v) => array_values(array_filter(array_map('trim', explode(',', $v)), fn ($x) => $x !== ''));

        $payload = [
            'title_en' => $this->title_en,
            'title_ar' => $this->title_ar,
            'desc_en' => $this->desc_en ?: null,
            'desc_ar' => $this->desc_ar ?: null,
            'items_en' => $parse($this->items_en) ?: null,
            'items_ar' => $parse($this->items_ar) ?: null,
            'icon' => $this->icon ?: null,
            'slug' => $slug,
            'is_published' => $this->is_published,
        ];

        if ($this->service && $this->service->exists) {
            $this->service->update($payload);
            $this->toastSuccess('Service updated.', 'Saved');
        } else {
            $this->service = Service::create($payload);
            $this->toastSuccess('Service created.', 'Created');
        }
    }

    public function render(): mixed
    {
        $isEdit = $this->service && $this->service->exists;

        return $this->page('livewire.admin.services.form', $isEdit ? 'Edit Service' : 'New Service', [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Services', 'url' => route('admin.services.index')],
            ['label' => $isEdit ? 'Edit' : 'New'],
        ]);
    }
}
