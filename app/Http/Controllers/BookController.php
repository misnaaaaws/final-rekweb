<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookController extends Controller
{
    public function index()
    {
        $data= Book::all();
        return Inertia::render('Book/Index', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            Book::create($request->all());
            return response()->json(['message' => 'Bood added successfully'], 200);
        } catch (\Exception $e){
            logger()->error($e);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->update($request->all());
            return response()->json(['message' => 'Book updated successfully'], 200);
        } catch (\Exception $e) {
            logger()->error($e);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->delete();
            return response()->json(['message' => 'Book deleted successfully'], 200);
        } catch (\Exception $e) {
            logger()->error($e);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
