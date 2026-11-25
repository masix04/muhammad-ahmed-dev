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
 
    /**
     * Public posts: switched on, and not dated in the future. A future
     * published_at therefore schedules the post — it appears by itself once
     * that moment passes, no job needed.
     */
    public function scopePublished($query)
    {
        return $query
            ->where('is_published', true)
            ->where(function ($q) {
                $q->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    public function scopeLatest3($query)
    {
        return $query->orderByDesc('published_at')->limit(3); 
    }
}
