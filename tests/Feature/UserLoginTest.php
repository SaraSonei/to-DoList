<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_userLoginCorrectCredentials(): void
    {
        $user = User::factory()->create([
            'firstName'     => 'userTest',
            'lastName' => 'tester',
            'email' => 'user1@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'user1@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_userCannotLoginInvalidCredentials(): void
    {
        $user = User::factory()->create([
            'firstName'     => 'userTest',
            'lastName' => 'tester',
            'email' => 'wrong@example.com',
            'password' => bcrypt('correct-password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'wrong@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
