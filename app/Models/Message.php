<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'name', 'email', 'avatar', 'subject', 'body', 'status', 'starred', 'read_at',
    ];

    protected $casts = [
        'starred' => 'boolean',
        'read_at' => 'datetime',
    ];

    public const STATUSES = ['unread', 'read', 'archived'];
}
