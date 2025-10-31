<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy
{
    /**
     * Determine si l'utilisateur peut voir n'importe quel livre
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view books');
    }

    /**
     * Determine si l'utilisateur peut voir ce livre
     */
    public function view(User $user, Book $book): bool
    {
        // L'utilisateur peut voir son propre livre ou s'il est admin
        return $user->id === $book->user_id || $user->hasRole('admin');
    }

    /**
     * Determine si l'utilisateur peut créer des livres
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create books');
    }

    /**
     * Determine si l'utilisateur peut mettre à jour ce livre
     */
    public function update(User $user, Book $book): bool
    {
        // L'utilisateur peut éditer son propre livre ou s'il est admin
        return $user->id === $book->user_id || $user->hasRole('admin');
    }

    /**
     * Determine si l'utilisateur peut supprimer ce livre
     */
    public function delete(User $user, Book $book): bool
    {
        // L'utilisateur peut supprimer son propre livre ou s'il est admin
        return $user->id === $book->user_id || $user->hasRole('admin');
    }

    /**
     * Determine si l'utilisateur peut restaurer ce livre (soft delete)
     */
    public function restore(User $user, Book $book): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine si l'utilisateur peut supprimer définitivement ce livre
     */
    public function forceDelete(User $user, Book $book): bool
    {
        return $user->hasRole('admin');
    }
}