<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Skill;

class SkillsSection extends Component
{
    public string $activeCategory = 'All';

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