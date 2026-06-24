<?php

namespace App\Livewire\Admin\Testimonials;

use App\Livewire\Component;
use App\Models\Testimonial;
use Livewire\Attributes\Validate;

class Form extends Component
{
    public ?Testimonial $testimonial = null;

    #[Validate('required|string|max:6')]
    public string $initials = '';

    #[Validate('required|string')]
    public string $body_en = '';

    public string $body_ar = '';
    public string $author_en = '';
    public string $author_ar = '';
    public string $role_en = '';
    public string $role_ar = '';
    public bool $is_published = true;

    public function mount(?Testimonial $testimonial = null): void
    {
        if ($testimonial && $testimonial->exists) {
            $this->testimonial = $testimonial;
            $this->initials = $testimonial->initials ?? '';
            $this->body_en = $testimonial->body_en ?? '';
            $this->body_ar = $testimonial->body_ar ?? '';
            $this->author_en = $testimonial->author_en ?? '';
            $this->author_ar = $testimonial->author_ar ?? '';
            $this->role_en = $testimonial->role_en ?? '';
            $this->role_ar = $testimonial->role_ar ?? '';
            $this->is_published = (bool) $testimonial->is_published;
        }
    }

    public function save(): void
    {
        $this->validate();

        $payload = [
            'initials' => $this->initials,
            'body_en' => $this->body_en,
            'body_ar' => $this->body_ar ?: null,
            'author_en' => $this->author_en ?: $this->initials,
            'author_ar' => $this->author_ar ?: $this->initials,
            'role_en' => $this->role_en ?: null,
            'role_ar' => $this->role_ar ?: null,
            'is_published' => $this->is_published,
        ];

        if ($this->testimonial && $this->testimonial->exists) {
            $this->testimonial->update($payload);
            $this->toastSuccess('Testimonial updated.', 'Saved');
        } else {
            $this->testimonial = Testimonial::create($payload);
            $this->toastSuccess('Testimonial created.', 'Created');
        }
    }

    public function render(): mixed
    {
        $isEdit = $this->testimonial && $this->testimonial->exists;

        return $this->page('livewire.admin.testimonials.form', $isEdit ? 'Edit Testimonial' : 'New Testimonial', [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Testimonials', 'url' => route('admin.testimonials.index')],
            ['label' => $isEdit ? 'Edit' : 'New'],
        ]);
    }
}
