<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Affiche toutes les lectures
     */
    public function index()
    {
        $books = Book::latest()->get();
        return view('books.index', compact('books'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Enregistre une nouvelle lecture
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'web_link' => 'required|url',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_featured' => 'nullable|boolean',
        ]);

        $book = new Book();
        $book->title = $validatedData['title'];
        $book->type = $validatedData['type'];
        $book->web_link = $validatedData['web_link'];
        $book->description = $validatedData['description'];
        $book->is_featured = $validatedData['is_featured'] ?? false;

        // Gestion de l'image (si présente)
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $book->image_path = $imagePath;
        }

        $book->save();

        return redirect()->route('books.index')->with('success', 'Livre ajouté avec succès!');
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    /**
     * Met à jour une lecture
     */
    public function update(Request $request, Book $book)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string',
            'web_link' => 'required|url',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_featured' => 'nullable|boolean',
        ]);

        $book->title = $validatedData['title'];
        $book->type = $validatedData['type'];
        $book->web_link = $validatedData['web_link'];
        $book->description = $validatedData['description'];
        $book->is_featured = $validatedData['is_featured'] ?? false;

        // Mise à jour de l'image (si présente)
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image (si elle existe)
            if ($book->image_path) {
                Storage::disk('public')->delete($book->image_path);
            }
            $imagePath = $request->file('image')->store('images', 'public');
            $book->image_path = $imagePath;
        }

        $book->save();

        return redirect()->route('books.index')->with('success', 'Livre mis à jour avec succès!');
    }


    /**
     * Supprime une lecture
     */
    public function destroy(Book $book)
    {
        $book->deleteImage();
        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Lecture supprimée avec succès !');
    }
}
