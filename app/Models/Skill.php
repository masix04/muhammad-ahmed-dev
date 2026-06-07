<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'name',
        'category',
        'proficiency',
        'icon',
        'sort_order',
        'is_visible'
    ];
    protected $casts    = [
        'is_visible' => 'boolean'
    ];

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }
    public function scopeOrdered($query)
    {
        return $query->orderBy('category')->orderBy('sort_order');
    }
}
