<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Oddvalue\LaravelDrafts\Concerns\HasDrafts;

class Post extends Model
{
    use HasDrafts;

    protected $fillable = [
        'title',
        'content',
        'is_published'
    ];
}