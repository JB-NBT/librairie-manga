<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

// Page d'accueil avec carousel
Route::get('/', [HomeController::class, 'index'])->name('home');

// Routes pour gérer les lectures (CRUD)
Route::resource('books', BookController::class);