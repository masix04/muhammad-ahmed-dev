<?php

namespace App\Livewire;

use Livewire\Component;

class CareerTimeline extends Component
{
    public array $openItems = [];

    public function toggle(int $id): void
    {
        if (in_array($id, $this->openItems)) {
            $this->openItems = array_values(
                array_filter($this->openItems, fn($i) => $i !== $id)
            );
        } else {
            $this->openItems[] = $id;
        }
    }

    public function render()
    {
        $experiences = \App\Models\WorkExperience::ordered()->get();

        // Auto-open the most recent entry on first render
        if (empty($this->openItems) && $experiences->isNotEmpty()) {
            $this->openItems = [$experiences->first()->id];
        }

        return view('livewire.career-timeline', compact('experiences'));
    }
}
