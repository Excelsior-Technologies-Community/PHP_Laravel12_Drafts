<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Oddvalue\LaravelDrafts\Concerns\HasDrafts;

class Post extends Model
{
    use HasFactory, HasDrafts;

    protected $fillable = [
        'title', 
        'content', 
        'status', 
        'is_published',
        'publisher_type',
        'publisher_id'
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function versions()
    {
        return $this->hasMany(PostVersion::class);
    }

    public static function withDrafts()
    {
        return static::query();
    }

    public static function createDraft($data)
    {
        return static::create([
            'title'          => $data['title'],
            'content'        => $data['content'],
            'status'         => 'draft',
            'is_published'   => false,
            'publisher_type' => \App\Models\User::class,
            'publisher_id'   => auth()->id() ?? 1,
        ]);
    }

    public static function createPublished($data)
    {
        return static::create([
            'title'          => $data['title'],
            'content'        => $data['content'],
            'status'         => 'published',
            'is_published'   => true,
            'publisher_type' => \App\Models\User::class,
            'publisher_id'   => auth()->id() ?? 1,
        ]);
    }
}