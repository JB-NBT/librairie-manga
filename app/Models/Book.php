<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Book extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse
     */
    protected $fillable = [
        'title',
        'type',
        'web_link',
        'description',
        'image_path',
        'is_featured',
        'user_id'
    ];

    /**
     * Les attributs qui doivent être castés
     */
    protected $casts = [
        'is_featured' => 'boolean',
    ];

    /**
     * Relation : Un livre appartient à un utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope pour obtenir les livres en vedette
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Accessor pour obtenir l'URL complète de l'image
     */
    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            return Storage::url($this->image_path);
        }
        
        // Image par défaut si aucune image n'est définie
        return asset('images/default-book.jpg');
    }

    /**
     * Méthode pour supprimer l'image du storage
     */
    public function deleteImage()
    {
        if ($this->image_path && Storage::disk('public')->exists($this->image_path)) {
            Storage::disk('public')->delete($this->image_path);
        }
    }

    /**
     * Hook : Supprimer l'image automatiquement à la suppression du livre
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($book) {
            $book->deleteImage();
        });
    }
}