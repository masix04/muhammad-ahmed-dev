<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;

use App\Models\Skill;

class SkillsSection extends Component
{
    public string $activeCategory = 'All';

    public function getCategoriesProperty(): array
    {
        return [
            'All',
            Skill::query()
                ->distinct()
                ->pluck('category')
                ->toArray(),
        ];
    }

    #[Computed]
    public function filtered()
    {
        if ($this->activeCategory === 'All') {
            return Skill::orderBy('name')->get();
        }

        return Skill::where('category', $this->activeCategory)
            ->orderBy('name')
            ->get();
    }

    public function render()
    {
        $skills     = Skill::visible()->ordered()->get();
        $categories = $skills->pluck('category')->unique()->sort()->values()->prepend('All')->toArray();
        $filtered   = $this->activeCategory === 'All'
            ? $skills
            : $skills->where('category', $this->activeCategory);

        return view('livewire.skills-section', compact('skills', 'filtered', 'categories'));
    }
}