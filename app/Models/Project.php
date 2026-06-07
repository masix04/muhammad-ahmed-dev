<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'full_description',
        'tech_tags',
        'demo_video_url',
        'github_url',
        'live_url',
        'thumbnail',
        'is_featured',
        'is_published',
        'sort_order',
        'category',
    ];

    protected $casts = [
        'tech_tags'   => 'array',
        'is_featured' => 'boolean',
        'is_published'=> 'boolean',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('created_at');
    }

    public function getYoutubeEmbedAttribute(): ?string
    {
        if (!$this->demo_video_url) return null;
        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\s]+)/', $this->demo_video_url, $m);
        return isset($m[1]) ? "https://www.youtube.com/embed/{$m[1]}" : $this->demo_video_url;
    }
}
