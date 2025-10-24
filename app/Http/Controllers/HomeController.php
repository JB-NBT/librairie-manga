<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil avec le carousel
     */
    public function index()
    {
        // Récupère les lectures "featured" pour le carousel
        $featuredBooks = Book::featured()->latest()->take(10)->get();
        
        return view('home', compact('featuredBooks'));
    }
}