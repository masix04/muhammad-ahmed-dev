<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

// Deliberately not ShouldQueue: QUEUE_CONNECTION is 'database' but nothing runs
// a queue worker, so a queued mail would sit in the jobs table and never send.
class ContactMessageReceived extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public ContactMessage $contactMessage) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Portfolio enquiry from ' . $this->contactMessage->name,
            // Lets you hit reply and answer the sender directly.
            replyTo: [new Address($this->contactMessage->email, $this->contactMessage->name)],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.contact-message-received',
            with: ['adminUrl' => url('/admin/contact-messages')],
        );
    }
}
