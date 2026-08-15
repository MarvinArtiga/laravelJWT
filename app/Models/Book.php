<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $author
 * @property string|null $isbn
 * @property string|null $description
 * @property int|null $published_year
 * @property bool $available
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'isbn',
        'description',
        'published_year',
        'available',
    ];

    protected $casts = [
        'available' => 'boolean',
        'published_year' => 'integer',
    ];
}
