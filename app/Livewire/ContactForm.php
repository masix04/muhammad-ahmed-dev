<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
// Livewire v4 uses Validate, NOT Rule

use Illuminate\Support\Facades\Mail;

use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use App\Models\SiteSetting;

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

        $contactMessage = ContactMessage::create([
            'name'       => $this->name,
            'email'      => $this->email,
            'subject'    => $this->subject ?: null,
            'message'    => $this->message,
            'ip_address' => request()->ip(),
        ]);

        $this->notify($contactMessage);

        $this->reset(['name', 'email', 'subject', 'message']);
        $this->sending   = false;
        $this->submitted = true;
    }

    /**
     * Email the enquiry so it survives a redeploy, which wipes the database.
     * The row is already saved, so a mail outage must not fail the submission —
     * log it and let the sender see their success state.
     */
    private function notify(ContactMessage $contactMessage): void
    {
        $recipient = SiteSetting::get('email') ?: config('mail.from.address');

        if (! $recipient) {
            return;
        }

        try {
            Mail::to($recipient)->send(new ContactMessageReceived($contactMessage));
        } catch (\Throwable $e) {
            report($e);
        }
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}