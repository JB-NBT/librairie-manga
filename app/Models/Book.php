<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // Autres propriétés et méthodes

    /**
     * Scope pour obtenir les livres en vedette.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}

