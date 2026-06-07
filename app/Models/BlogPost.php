<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'tags',
        'cover_image',
        'is_published',
        'published_at',
        'read_time_minutes'
    ];
 
    protected $casts = [
        'tags'         => 'array',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];
 
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeLatest3($query)
    {
        return $query->orderByDesc('published_at')->limit(3); 
    }
}
