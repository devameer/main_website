<?php

namespace App\Livewire\Admin\Projects;

use App\Livewire\Component;
use App\Models\Project;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;

class Form extends Component
{
    public ?Project $project = null;

    #[Validate('required|string|max:120')]
    public string $name_en = '';

    #[Validate('required|string|max:120')]
    public string $name_ar = '';

    public string $role_en = '';
    public string $role_ar = '';
    public string $desc_en = '';
    public string $desc_ar = '';
    public string $overview_en = '';
    public string $overview_ar = '';
    public string $tags_en = '';
    public string $tags_ar = '';
    public string $highlights_en = '';
    public string $highlights_ar = '';

    public string $icon = '';
    public string $year = '';
    public string $url = '';
    public string $slug = '';
    public bool $is_published = true;

    public function mount(?Project $project = null): void
    {
        if ($project && $project->exists) {
            $this->project = $project;
            $this->name_en = $project->name_en ?? '';
            $this->name_ar = $project->name_ar ?? '';
            $this->role_en = $project->role_en ?? '';
            $this->role_ar = $project->role_ar ?? '';
            $this->desc_en = $project->desc_en ?? '';
            $this->desc_ar = $project->desc_ar ?? '';
            $this->overview_en = $project->overview_en ?? '';
            $this->overview_ar = $project->overview_ar ?? '';
            $this->tags_en = implode(', ', $project->tags_en ?? []);
            $this->tags_ar = implode(', ', $project->tags_ar ?? []);
            $this->highlights_en = implode("\n", $project->highlights_en ?? []);
            $this->highlights_ar = implode("\n", $project->highlights_ar ?? []);
            $this->icon = $project->icon ?? '';
            $this->year = $project->year ?? '';
            $this->url = $project->url ?? '';
            $this->slug = $project->slug ?? '';
            $this->is_published = (bool) $project->is_published;
        }
    }

    protected function parseList(string $value): array
    {
        return array_values(array_filter(array_map('trim', explode(',', $value)), fn ($v) => $v !== ''));
    }

    protected function parseLines(string $value): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $value)), fn ($v) => $v !== ''));
    }

    public function save(): void
    {
        $this->validate();

        $slug = trim($this->slug) !== '' ? Str::slug($this->slug) : Str::slug($this->name_en);

        $payload = [
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'role_en' => $this->role_en ?: null,
            'role_ar' => $this->role_ar ?: null,
            'desc_en' => $this->desc_en ?: null,
            'desc_ar' => $this->desc_ar ?: null,
            'overview_en' => $this->overview_en ?: null,
            'overview_ar' => $this->overview_ar ?: null,
            'tags_en' => $this->parseList($this->tags_en) ?: null,
            'tags_ar' => $this->parseList($this->tags_ar) ?: null,
            'highlights_en' => $this->parseLines($this->highlights_en) ?: null,
            'highlights_ar' => $this->parseLines($this->highlights_ar) ?: null,
            'icon' => $this->icon ?: null,
            'year' => $this->year ?: null,
            'url' => $this->url ?: null,
            'slug' => $slug,
            'is_published' => $this->is_published,
        ];

        if ($this->project && $this->project->exists) {
            $this->project->update($payload);
            $this->toastSuccess('Project updated successfully.', 'Saved');
        } else {
            $this->project = Project::create($payload);
            $this->toastSuccess('Project created successfully.', 'Created');
        }
    }

    public function render(): mixed
    {
        $isEdit = $this->project && $this->project->exists;

        return $this->page('livewire.admin.projects.form', $isEdit ? 'Edit Project' : 'New Project', [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Projects', 'url' => route('admin.projects.index')],
            ['label' => $isEdit ? 'Edit' : 'New'],
        ]);
    }
}
