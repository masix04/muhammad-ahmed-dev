<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitors_are_sent_to_the_admin_login(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_a_user_can_open_the_admin_even_when_not_running_locally(): void
    {
        // Filament answers 403 outside APP_ENV=local unless the user model says yes.
        config(['app.env' => 'production']);

        $user = User::factory()->create();

        $this->actingAs($user)->get('/admin')->assertOk();
    }
}
