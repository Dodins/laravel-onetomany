<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Get all books
    public function index()
    {
        return Book::all();
    }

    // Create a new book
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'student_id' => 'required|exists:students,id' // Ensure the student ID exists
        ]);

        return Book::create($request->all());
    }

    // Get a single book
    public function show(Book $book)
    {
        return $book;
    }

    // Update a book
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'string',
            'author' => 'string',
            'student_id' => 'exists:students,id' // Ensure the student ID exists
        ]);

        $book->update($request->all());

        return $book;
    }

    // Delete a book
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json(null, 204);
    }
}
