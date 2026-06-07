<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;

class ProjectsGrid extends Component
{
    public string $activeTag  = 'All';
    public ?int   $openProjectId = null;
    public array  $allTags    = [];

    public function mount(): void
    {
        $tags = Project::published()
            ->pluck('tech_tags')
            ->flatten()
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->toArray();

        $this->allTags = array_merge(['All'], $tags);
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

        $featuredProjects = Project::query()
            ->where('is_featured', true)
            ->latest()->take(7)->get();

        return view('livewire.projects-grid', [
            'projects'    => $query->get(),
            'openProject' => $this->openProjectId
                ? Project::find($this->openProjectId)
                : null,
            'featuredProjects' => $featuredProjects,
        ]);
    }
}