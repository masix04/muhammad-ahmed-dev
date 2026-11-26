<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;

class ProjectsGrid extends Component
{
    public string $activeTag  = 'All';
    public ?int   $openProjectId = null;
    public array  $allTags    = [];

    /** How many published projects use each tag (plus 'All'), for the filter chips. */
    public array  $tagCounts  = [];

    public function mount(): void
    {
        // Most-used technologies first, ties in alphabetical order
        $counts = Project::published()
            ->pluck('tech_tags')
            ->flatten()
            ->filter()
            ->countBy()
            ->sortKeys()
            ->sortByDesc(fn ($count) => $count);

        $this->allTags   = array_merge(['All'], $counts->keys()->all());
        $this->tagCounts = ['All' => Project::published()->count()] + $counts->all();
    }

    public function filterBy(string $tag): void
    {
        $this->activeTag = $tag;
    }

    public function openModal(int $id): void
    {
        $this->openProjectId = $id;
    }

    public function closeModal(): void
    {
        $this->openProjectId = null;

        // Remove this overflow-hidden when model is closed
        $this->js('document.body.classList.remove("overflow-hidden")');
    }

    public function render()
    {
        $query = Project::published()->ordered();

        if ($this->activeTag !== 'All') {
            $query->whereJsonContains('tech_tags', $this->activeTag);
        }

        return view('livewire.projects-grid', [
            'projects'    => $query->get(),
            'openProject' => $this->openProjectId
                ? Project::find($this->openProjectId)
                : null,
        ]);
    }
}