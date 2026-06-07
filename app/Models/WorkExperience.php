<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    protected $fillable = [
        'role','company','location','period',
        'start_date','end_date','is_current',
        'bullets','sub_projects','company_url','sort_order',
    ];

    protected $casts = [
        'bullets'      => 'array',
        'sub_projects' => 'array',
        'is_current'   => 'boolean',
        'start_date'   => 'date',
        'end_date'     => 'date',
    ];

    public function scopeOrdered($query) { return $query->orderByDesc('start_date'); }
}
