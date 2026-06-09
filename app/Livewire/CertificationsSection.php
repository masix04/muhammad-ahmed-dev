<?php

namespace App\Livewire;

use Livewire\Component;

class CertificationsSection extends Component
{
    public function render()
    {
        return view('livewire.certifications-section', [
            'certifications' => Certification::visible()->ordered()->get(),
        ]);
    }
}