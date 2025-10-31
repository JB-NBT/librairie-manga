<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BookController extends Controller
{
    use AuthorizesRequests;

    /**
     * Appliquer le middleware d'authentification
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Affiche toutes les lectures de l'utilisateur connecté
     */
    public function index()
    {
        // Récupérer uniquement les livres de l'utilisateur connecté
        $books = auth()->user()->books()->latest()->get();
        
        return view('books.index', compact('books'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        // Vérifier la permission
        $this->authorize('create', Book::class);
        
        return view('books.create');
    }

    /**
     * Enregistre une nouvelle lecture
     */
    public function store(Request $request)
    {
        // Vérifier la permission
        $this->authorize('create', Book::class);

        // Validation des données
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                'min:2'
            ],
            'type' => [
                'required',
                'in:manga,webtoon,autre'
            ],
            'web_link' => [
                'required',
                'url',
                'max:500'
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000'
            ],
            'image' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:2048' // 2MB max
            ],
            'is_featured' => [
                'nullable',
                'boolean'
            ],
        ], [
            // Messages personnalisés en français
            'title.required' => 'Le titre est obligatoire.',
            'title.min' => 'Le titre doit contenir au moins 2 caractères.',
            'title.max' => 'Le titre ne peut pas dépasser 255 caractères.',
            'type.required' => 'Le type est obligatoire.',
            'type.in' => 'Le type doit être manga, webtoon ou autre.',
            'web_link.required' => 'Le lien web est obligatoire.',
            'web_link.url' => 'Le lien doit être une URL valide.',
            'image.required' => 'Une image de couverture est obligatoire.',
            'image.image' => 'Le fichier doit être une image.',
            'image.mimes' => 'L\'image doit être au format: jpeg, png, jpg, gif ou webp.',
            'image.max' => 'L\'image ne peut pas dépasser 2MB.',
        ]);

        // Créer le livre et l'associer à l'utilisateur connecté
        $book = new Book($validated);
        $book->user_id = auth()->id();
        $book->is_featured = $request->boolean('is_featured');

        // Gestion de l'upload d'image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('books', 'public');
            $book->image_path = $imagePath;
        }

        $book->save();

        return redirect()
            ->route('books.index')
            ->with('success', 'Lecture ajoutée avec succès !');
    }

    /**
     * Affiche une lecture spécifique
     */
    public function show(Book $book)
    {
        // Vérifier que l'utilisateur peut voir ce livre
        $this->authorize('view', $book);
        
        return view('books.show', compact('book'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(Book $book)
    {
        // Vérifier que l'utilisateur peut éditer ce livre
        $this->authorize('update', $book);
        
        return view('books.edit', compact('book'));
    }

    /**
     * Met à jour une lecture
     */
    public function update(Request $request, Book $book)
    {
        // Vérifier la permission
        $this->authorize('update', $book);

        // Validation
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                'min:2'
            ],
            'type' => [
                'required',
                'in:manga,webtoon,autre'
            ],
            'web_link' => [
                'required',
                'url',
                'max:500'
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000'
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:2048'
            ],
            'is_featured' => [
                'nullable',
                'boolean'
            ],
        ], [
            'title.required' => 'Le titre est obligatoire.',
            'title.min' => 'Le titre doit contenir au moins 2 caractères.',
            'type.in' => 'Le type doit être manga, webtoon ou autre.',
            'web_link.url' => 'Le lien doit être une URL valide.',
            'image.image' => 'Le fichier doit être une image.',
            'image.max' => 'L\'image ne peut pas dépasser 2MB.',
        ]);

        // Mise à jour des données
        $book->fill($validated);
        $book->is_featured = $request->boolean('is_featured');

        // Mise à jour de l'image si présente
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($book->image_path) {
                Storage::disk('public')->delete($book->image_path);
            }
            
            $imagePath = $request->file('image')->store('books', 'public');
            $book->image_path = $imagePath;
        }

        $book->save();

        return redirect()
            ->route('books.index')
            ->with('success', 'Lecture mise à jour avec succès !');
    }

    /**
     * Supprime une lecture
     */
    public function destroy(Book $book)
    {
        // Vérifier la permission
        $this->authorize('delete', $book);

        $book->delete(); // L'image sera supprimée automatiquement via le hook

        return redirect()
            ->route('books.index')
            ->with('success', 'Lecture supprimée avec succès !');
    }
}