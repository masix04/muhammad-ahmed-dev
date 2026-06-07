<?php

namespace App\Livewire;

use Livewire\Component;

class CertificationsSection extends Component
{
    public function render()
    {
        return view('livewire.certifications-section', [
            'certifications' => \App\Models\Certification::visible()->ordered()->get(),
        ]);
    }
}