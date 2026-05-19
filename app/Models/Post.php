<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'is_published'];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    // Scope to include drafts
    public static function withDrafts()
    {
        return static::query();
    }

    // Create draft post
    public static function createDraft($data)
    {
        return static::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'is_published' => false,
        ]);
    }

    // Create published post
    public static function createPublished($data)
    {
        return static::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'is_published' => true,
        ]);
    }
}