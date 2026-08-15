<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->name(),
            'isbn' => $this->faker->unique()->isbn13(),
            'description' => $this->faker->paragraph(),
            'published_year' => $this->faker->numberBetween(1900, 2024),
            'available' => $this->faker->boolean(80),
        ];
    }
}
