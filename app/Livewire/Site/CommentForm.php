<?php

namespace App\Livewire\Site;

use App\Models\Article;
use App\Models\Comment;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CommentForm extends Component
{
    public int $articleId;

    #[Validate('required|string|max:100')]
    public string $authorName = '';

    #[Validate('required|email|max:150')]
    public string $authorEmail = '';

    #[Validate('required|string|min:5|max:1000')]
    public string $body = '';

    public bool $submitted = false;

    public function mount(int $articleId): void
    {
        $this->articleId = $articleId;
    }

    public function submit(): void
    {
        $this->validate();

        Comment::create([
            'article_id'   => $this->articleId,
            'author_name'  => $this->authorName,
            'author_email' => $this->authorEmail,
            'body'         => $this->body,
            'status'       => 'pending',
            'ip_address'   => request()->ip(),
        ]);

        $this->reset(['authorName', 'authorEmail', 'body']);
        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.site.comment-form');
    }
}
