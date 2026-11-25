<?php

namespace Tests\Feature;

use App\Livewire\ContactForm;
use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    private function fill(string $message = 'I would like to talk about a Laravel project with you.')
    {
        return Livewire::test(ContactForm::class)
            ->set('name', 'Sana Recruiter')
            ->set('email', 'sana@example.test')
            ->set('subject', 'Laravel role')
            ->set('message', $message);
    }

    public function test_a_valid_message_is_saved_and_emailed(): void
    {
        Mail::fake();
        SiteSetting::set('email', 'me@example.test');

        $this->fill()->call('send')->assertHasNoErrors()->assertSet('submitted', true);

        $this->assertDatabaseHas('contact_messages', ['email' => 'sana@example.test', 'name' => 'Sana Recruiter']);
        Mail::assertSent(ContactMessageReceived::class, fn ($mail) => $mail->hasTo('me@example.test'));
    }

    public function test_invalid_input_is_rejected(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'A')
            ->set('email', 'not-an-email')
            ->set('message', 'too short')
            ->call('send')
            ->assertHasErrors(['name', 'email', 'message']);

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_a_filled_honeypot_looks_like_success_but_saves_and_sends_nothing(): void
    {
        Mail::fake();

        $this->fill()->set('website', 'http://spam.example')->call('send')->assertSet('submitted', true);

        $this->assertDatabaseCount('contact_messages', 0);
        Mail::assertNothingSent();
    }

    public function test_a_visitor_is_limited_to_three_messages_per_window(): void
    {
        Mail::fake();

        foreach (range(1, 3) as $i) {
            $this->fill("Message number {$i}: hello, I have a project to discuss.")->call('send')->assertHasNoErrors();
        }

        $this->fill('Message number 4: hello, I have a project to discuss.')
            ->call('send')
            ->assertHasErrors('message')
            ->assertSet('submitted', false);

        $this->assertDatabaseCount('contact_messages', 3);
    }

    public function test_a_failing_mail_server_does_not_lose_the_message(): void
    {
        SiteSetting::set('email', 'me@example.test');
        Mail::shouldReceive('to')->andThrow(new \RuntimeException('SMTP is down'));

        $this->fill()->call('send')->assertSet('submitted', true);

        $this->assertSame(1, ContactMessage::count());
    }
}
