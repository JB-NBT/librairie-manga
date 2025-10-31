<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route test simple pour vérifier Laravel fonctionne
Route::get('/test', function () {
    return 'Laravel fonctionne ✅';
});

// Route d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// Routes pour l'authentification (Breeze)
require __DIR__.'/auth.php';

// Routes protégées par auth pour le dashboard et les livres
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Routes pour le profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes CRUD pour les livres
    Route::resource('books', BookController::class);
});
