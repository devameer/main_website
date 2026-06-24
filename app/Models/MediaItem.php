<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaItem extends Model
{
    /** @use HasFactory<\Database\Factories\MediaItemFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 'path', 'type', 'mime_type', 'size',
        'width', 'height', 'collection', 'alt_text',
    ];

    protected $casts = [
        'size' => 'integer',
        'width' => 'integer',
        'height' => 'integer',
    ];

    public function formattedSize(): string
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = (int) floor(log(max($bytes, 1), 1024));

        return round($bytes / pow(1024, $i), $i > 0 ? 1 : 0) . ' ' . $units[$i];
    }

    public static function totalSize(): string
    {
        $bytes = self::sum('size');
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = (int) floor(log(max($bytes, 1), 1024));

        return round($bytes / pow(1024, $i), $i > 0 ? 1 : 0) . ' ' . $units[$i];
    }
}
