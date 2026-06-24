<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;

    protected $fillable = [
        'article_id', 'author_name', 'author_email', 'author_avatar',
        'body', 'status', 'likes', 'ip_address',
    ];

    protected $casts = [
        'likes' => 'integer',
    ];

    public const STATUSES = ['pending', 'approved', 'spam'];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
