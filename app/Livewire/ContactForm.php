<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
// Livewire v4 uses Validate, NOT Rule

use App\Models\ContactMessage;

class ContactForm extends Component
{
    #[Validate('required|min:2|max:100')]
    public string $name    = '';

    #[Validate('required|email|max:150')]
    public string $email   = '';

    #[Validate('nullable|max:200')]
    public string $subject = '';

    #[Validate('required|min:20|max:2000')]
    public string $message = '';

    public bool $submitted = false;
    public bool $sending   = false;

    public function send(): void
    {
        $this->validate();
        $this->sending = true;

        ContactMessage::create([
            'name'       => $this->name,
            'email'      => $this->email,
            'subject'    => $this->subject ?: null,
            'message'    => $this->message,
            'ip_address' => request()->ip(),
        ]);

        $this->reset(['name', 'email', 'subject', 'message']);
        $this->sending   = false;
        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}