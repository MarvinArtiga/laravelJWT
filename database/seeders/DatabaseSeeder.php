<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create or update an admin user for testing
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('Password123'),
                'email_verified_at' => now(),
            ]
        );

        // Create additional users
        User::factory(4)->create();

        // Create sample books
        Book::factory()->count(5)->create();
    }
}
