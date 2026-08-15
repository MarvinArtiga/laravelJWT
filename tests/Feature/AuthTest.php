<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_and_login_and_me_and_logout_flow(): void
    {
        $payload = [
            'name' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ];

        $this->postJson('/api/auth/register', $payload)
            ->assertStatus(201)
            ->assertJsonFragment(['email' => 'juan@example.com']);

        $login = $this->postJson('/api/auth/login', [
            'email' => 'juan@example.com',
            'password' => 'Password123',
        ]);

        $login->assertStatus(200)->assertJsonStructure(['access_token']);

        $token = $login->json('access_token');

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/auth/me')
            ->assertStatus(200)
            ->assertJsonFragment(['email' => 'juan@example.com']);

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/auth/logout')
            ->assertStatus(200)
            ->assertJsonFragment(['message' => 'Successfully logged out']);

        // token should no longer work
        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/auth/me')
            ->assertStatus(401);
    }
}
