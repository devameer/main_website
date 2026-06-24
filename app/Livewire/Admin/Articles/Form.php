<?php

namespace App\Livewire\Admin\Articles;

use App\Livewire\Component;
use App\Models\Article;
use App\Services\MarkdownImporter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public ?Article $article = null;

    #[Validate('nullable|string|max:200')]
    public string $title = '';

    #[Validate('required|string|max:200')]
    public string $title_en = '';

    #[Validate('nullable|string')]
    public string $body = '';

    #[Validate('required|string')]
    public string $body_en = '';

    public string $excerpt = '';
    public string $language = 'en';
    public string $category = 'Engineering';
    public string $status = 'draft';
    public ?string $published_at = null;

    public string $meta_title = '';
    public string $meta_description = '';

    // SEO studio fields
    public string $primary_keyword = '';
    public string $secondary_keywords = ''; // edited as comma-separated string
    public string $search_intent = '';
    public string $target_audience = '';
    public string $reading_time = '';

    public string $slug = '';

    public $coverUpload = null;
    public string $cover_image = '';

    /** Uploaded .md file for "Import from Markdown". */
    public $markdownFile = null;

    /** Active translation tab: en | ar */
    public string $tab = 'en';

    public function mount(?Article $article = null): void
    {
        if ($article && $article->exists) {
            $this->article = $article;
            $this->title = $article->title ?? '';
            $this->title_en = $article->title_en ?? '';
            $this->body = $article->body ?? '';
            $this->body_en = $article->body_en ?? '';
            $this->excerpt = $article->excerpt ?? '';
            $this->slug = $article->slug ?? '';
            $this->language = $article->language ?? 'en';
            $this->category = $article->category ?? 'Engineering';
            $this->status = $article->status ?? 'draft';
            $this->published_at = $article->published_at?->format('Y-m-d\TH:i');
            $this->meta_title = $article->meta_title ?? '';
            $this->meta_description = $article->meta_description ?? '';
            $this->primary_keyword = $article->primary_keyword ?? '';
            $this->secondary_keywords = implode(', ', $article->secondary_keywords ?? []);
            $this->search_intent = $article->search_intent ?? '';
            $this->target_audience = $article->target_audience ?? '';
            $this->reading_time = $article->reading_time ?? '';
            $this->cover_image = $article->cover_image ?? '';
        }
    }

    #[Computed]
    public function categories(): array
    {
        return ['Engineering', 'Design', 'Product', 'Tutorials', 'News'];
    }

    #[Computed]
    public function statuses(): array
    {
        return array_combine(Article::STATUSES, array_map('ucfirst', Article::STATUSES));
    }

    public function updatedCoverUpload(): void
    {
        $this->validate(['coverUpload' => 'image|max:2048']);
    }

    #[Computed]
    public function markdownSamples(): array
    {
        return app(MarkdownImporter::class)->sampleFiles();
    }

    /** Triggered when a .md file is chosen via the upload input. */
    public function updatedMarkdownFile(): void
    {
        $this->validate(['markdownFile' => 'file|mimes:md,txt|max:5120']);

        $content = file_get_contents($this->markdownFile->getRealPath());

        // Persist the uploaded markdown file to storage/app/markdown/.
        $savedAs = $this->storeUploadedMarkdown($this->markdownFile, $content);

        $this->applyImport($content);
        $this->markdownFile = null;
        $this->toastSuccess("Imported into fields & saved as {$savedAs}.", 'Stored');
    }

    /** Persist an uploaded markdown file with a safe, collision-free name. */
    protected function storeUploadedMarkdown($file, string $content): string
    {
        $base = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) ?: 'article';
        $ext = strtolower($file->getClientOriginalExtension() ?: 'md');
        if (! in_array($ext, ['md', 'markdown', 'txt'])) {
            $ext = 'md';
        }

        $disk = Storage::disk('local');
        if (! $disk->exists('markdown')) {
            $disk->makeDirectory('markdown');
        }

        $filename = "{$base}.{$ext}";
        $i = 1;
        while ($disk->exists("markdown/{$filename}")) {
            $filename = "{$base}-{$i}.{$ext}";
            $i++;
        }

        $disk->put("markdown/{$filename}", $content);

        return $filename;
    }

    /** List previously-uploaded markdown files from storage/app/markdown/. */
    #[Computed]
    public function storedMarkdown(): array
    {
        $disk = Storage::disk('local');
        if (! $disk->exists('markdown')) {
            return [];
        }

        return collect($disk->files('markdown'))
            ->filter(fn ($p) => preg_match('/\.(md|markdown|txt)$/i', $p))
            ->map(fn ($p) => [
                'name' => basename($p),
                'size' => $disk->size($p),
                'modified' => $disk->lastModified($p),
            ])
            ->sortByDesc('modified')
            ->values()
            ->all();
    }

    /** Re-import a previously-stored markdown file into the active language tab. */
    public function loadStoredMarkdown(string $name): void
    {
        if (! $this->isSafeStoredName($name)) {
            $this->toastError('Invalid file name.');

            return;
        }
        $disk = Storage::disk('local');
        if (! $disk->exists("markdown/{$name}")) {
            $this->toastError('File not found.');

            return;
        }

        $this->applyImport($disk->get("markdown/{$name}"));
    }

    /** Delete a previously-stored markdown file. */
    public function deleteStoredMarkdown(string $name): void
    {
        if (! $this->isSafeStoredName($name)) {
            $this->toastError('Invalid file name.');

            return;
        }
        $disk = Storage::disk('local');
        if ($disk->exists("markdown/{$name}")) {
            $disk->delete("markdown/{$name}");
            $this->toastSuccess("{$name} deleted.", 'Removed');
        }
    }

    protected function isSafeStoredName(string $name): bool
    {
        return $name === basename($name) && (bool) preg_match('/^[A-Za-z0-9._-]+$/', $name);
    }

    /** Load a shipped sample file (English or Arabic). */
    public function loadSampleMarkdown(string $name): void
    {
        $content = app(MarkdownImporter::class)->readSample($name);
        if (! $content) {
            $this->toastError('Could not load that markdown file.');

            return;
        }

        // Switch the active tab to the file's language so the user sees the result.
        $this->tab = str_ends_with($name, '-ar.md') ? 'ar' : 'en';
        $this->applyImport($content);
    }

    /** Parse the comma-separated secondary keywords string into a clean array (null when empty). */
    protected function keywordsToArray(): ?array
    {
        if (trim($this->secondary_keywords) === '') {
            return null;
        }

        $arr = array_values(array_filter(
            array_map('trim', explode(',', $this->secondary_keywords)),
            fn ($v) => $v !== '',
        ));

        return $arr ?: null;
    }

    /** Parse markdown and fill the fields for the active language tab. */
    protected function applyImport(string $content): void
    {
        $data = app(MarkdownImporter::class)->parse($content);
        $lang = $this->tab;

        if ($lang === 'ar') {
            if ($data['title'] !== '') $this->title = $data['title'];
            if ($data['body'] !== '') $this->body = $data['body'];
        } else {
            if ($data['title'] !== '') $this->title_en = $data['title'];
            if ($data['body'] !== '') $this->body_en = $data['body'];
        }

        // Shared content fields (only overwrite when the markdown provides them).
        if ($data['slug'] !== '') $this->slug = $data['slug'];
        if ($data['meta_title'] !== '') $this->meta_title = $data['meta_title'];
        if ($data['meta_description'] !== '') $this->meta_description = $data['meta_description'];
        if ($data['excerpt'] !== '') $this->excerpt = $data['excerpt'];

        // SEO studio fields.
        if ($data['primary_keyword'] !== '') $this->primary_keyword = $data['primary_keyword'];
        if (! empty($data['secondary_keywords'])) $this->secondary_keywords = implode(', ', $data['secondary_keywords']);
        if ($data['search_intent'] !== '') $this->search_intent = $data['search_intent'];
        if ($data['target_audience'] !== '') $this->target_audience = $data['target_audience'];
        if ($data['reading_time'] !== '') $this->reading_time = $data['reading_time'];

        $this->toastSuccess(
            'Filled the ' . ($lang === 'ar' ? 'Arabic' : 'English') . ' fields from markdown.',
            'Imported',
        );

        // Re-render the markdown editor previews after Livewire morphs the textareas.
        $this->js("setTimeout(() => window.dispatchEvent(new Event('editor-refresh')), 80)");
    }

    public function save(string $target = 'draft'): void
    {
        // Validate the required #[Validate]-attributed fields.
        $this->validate();

        $status = match ($target) {
            'publish'  => 'published',
            'schedule' => 'scheduled',
            default    => 'draft',
        };

        if ($this->coverUpload) {
            $path = $this->coverUpload->store('covers', 'public');
            $this->cover_image = asset('storage/' . $path);
        }

        $publishedAt = $this->published_at
            ? $this->published_at
            : ($status === 'published' ? now()->format('Y-m-d H:i:s') : null);

        $payload = [
            'title' => $this->title,
            'title_en' => $this->title_en,
            'body' => $this->body,
            'body_en' => $this->body_en,
            'excerpt' => $this->excerpt,
            'slug' => $this->slug !== '' ? $this->slug : null,
            'language' => $this->language,
            'category' => $this->category,
            'status' => $status,
            'published_at' => $publishedAt,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'primary_keyword' => $this->primary_keyword ?: null,
            'secondary_keywords' => $this->keywordsToArray(),
            'search_intent' => $this->search_intent ?: null,
            'target_audience' => $this->target_audience ?: null,
            'reading_time' => $this->reading_time ?: null,
            'cover_image' => $this->cover_image ?: null,
            'author_avatar' => 'https://i.pravatar.cc/64?img=12',
            'author' => 'Ameer Ahmad',
        ];

        if ($this->article && $this->article->exists) {
            $this->article->update($payload);
            $this->toastSuccess('Article updated successfully.', 'Saved');
        } else {
            $this->article = Article::create($payload);
            $this->toastSuccess('Article created successfully.', 'Created');
        }

        $this->status = $status;
    }

    public function preview(): void
    {
        $this->toastInfo('Opening preview…', 'Preview');
    }

    public function render(): mixed
    {
        $isEdit = $this->article && $this->article->exists;

        return $this->page('livewire.admin.articles.form', $isEdit ? 'Edit Article' : 'New Article', [
            ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
            ['label' => 'Articles', 'url' => route('admin.articles.index')],
            ['label' => $isEdit ? 'Edit' : 'New'],
        ]);
    }
}
