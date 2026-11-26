<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    protected $fillable = [
        'role','company','location','period','additional_periods',
        'start_date','end_date','is_current',
        'bullets','sub_projects','company_url','sort_order',
    ];

    protected $casts = [
        'bullets'      => 'array',
        'sub_projects' => 'array',
        'additional_periods' => 'array',
        'is_current'   => 'boolean',
        'start_date'   => 'date',
        'end_date'     => 'date',
    ];

    public function scopeOrdered($query) { return $query->orderByDesc('start_date'); }

    /**
     * Every time period for this role as plain text: the main one first, then any
     * extra periods added in the admin panel (blank ones are skipped).
     *
     * @return list<string>
     */
    public function allPeriods(): array
    {
        $extra = collect($this->additional_periods ?? [])
            ->map(fn ($item) => trim((string) (is_array($item) ? ($item['period'] ?? '') : $item)))
            ->filter()
            ->all();

        return array_values(array_filter([trim((string) $this->period), ...$extra]));
    }
}
