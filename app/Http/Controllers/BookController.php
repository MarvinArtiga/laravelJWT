<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all(['id','title','author','isbn','description','published_year','available']);

        return response()->json(['data' => $books], Response::HTTP_OK);
    }

    public function show(Book $book)
    {
        return response()->json($book, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $data = $request->only(['title','author','isbn','description','published_year','available']);

        $validator = Validator::make($data, [
            'title' => ['required','string','max:255'],
            'author' => ['required','string','max:255'],
            'isbn' => ['nullable','string','max:255','unique:books,isbn'],
            'description' => ['nullable','string'],
            'published_year' => ['nullable','integer'],
            'available' => ['nullable','boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (! isset($data['available'])) {
            $data['available'] = true;
        }

        $book = Book::create($data);

        return response()->json($book, Response::HTTP_CREATED);
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->only(['title','author','isbn','description','published_year','available']);

        $rules = [
            'title' => ['sometimes','required','string','max:255'],
            'author' => ['sometimes','required','string','max:255'],
            'isbn' => ['nullable','string','max:255','unique:books,isbn,' . $book->id],
            'description' => ['nullable','string'],
            'published_year' => ['nullable','integer'],
            'available' => ['nullable','boolean'],
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $book->fill($data);
        $book->save();

        return response()->json($book, Response::HTTP_OK);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json(['message' => 'Book deleted'], Response::HTTP_OK);
    }
}
