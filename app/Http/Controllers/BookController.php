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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'web_link' => 'required|url',
            'description' => 'nullable|string',
            'type' => 'required|in:manga,webtoon,autre',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_featured' => 'boolean',
        ]);

        // Upload de l'image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('books', 'public');
            $validated['image_path'] = $imagePath;
        }

        $validated['is_featured'] = $request->has('is_featured');

        Book::create($validated);

        return redirect()->route('books.index')
            ->with('success', 'Lecture ajoutée avec succès !');
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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'web_link' => 'required|url',
            'description' => 'nullable|string',
            'type' => 'required|in:manga,webtoon,autre',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_featured' => 'boolean',
        ]);

        // Upload de la nouvelle image si fournie
        if ($request->hasFile('image')) {
            // Supprime l'ancienne image
            $book->deleteImage();
            
            $imagePath = $request->file('image')->store('books', 'public');
            $validated['image_path'] = $imagePath;
        }

        $validated['is_featured'] = $request->has('is_featured');

        $book->update($validated);

        return redirect()->route('books.index')
            ->with('success', 'Lecture mise à jour avec succès !');
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