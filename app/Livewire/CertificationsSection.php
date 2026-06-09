<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Certification;

class CertificationsSection extends Component
{
    public function render()
    {
        return view('livewire.certifications-section', [
            'certifications' => Certification::visible()->ordered()->get(),
        ]);
    }
}