<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;
use App\Models\User;

class BookTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate(): string
    {
        $user = User::factory()->create([
            'password' => bcrypt('Password123'),
        ]);

        $login = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'Password123',
        ]);

        return $login->json('access_token');
    }

    public function test_list_books_requires_auth(): void
    {
        $this->getJson('/api/books')->assertStatus(401);
    }

    public function test_create_update_delete_book_flow(): void
    {
        $token = $this->authenticate();

        $payload = [
            'title' => 'Cien años de soledad',
            'author' => 'Gabriel García Márquez',
            'isbn' => '9780307474728',
            'description' => 'Novela publicada en 1967.',
            'published_year' => 1967,
        ];

        $create = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/books', $payload)
            ->assertStatus(201)
            ->assertJsonFragment(['title' => 'Cien años de soledad']);

        $bookId = $create->json('id');

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/books/' . $bookId)
            ->assertStatus(200)
            ->assertJsonFragment(['id' => $bookId]);

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->patchJson('/api/books/' . $bookId, ['available' => false])
            ->assertStatus(200)
            ->assertJsonFragment(['available' => false]);

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->deleteJson('/api/books/' . $bookId)
            ->assertStatus(200)
            ->assertJsonFragment(['message' => 'Book deleted']);

        $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/books/' . $bookId)
            ->assertStatus(404);
    }
}
