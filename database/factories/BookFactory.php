<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['manga', 'webtoon', 'autre'];
        
        // Titres de mangas/webtoons populaires pour plus de réalisme
        $titles = [
            'One Piece',
            'Naruto',
            'Attack on Titan',
            'Demon Slayer',
            'My Hero Academia',
            'Tower of God',
            'Solo Leveling',
            'The Beginning After The End',
            'Omniscient Reader',
            'Jujutsu Kaisen',
            'Chainsaw Man',
            'Spy x Family',
            'Berserk',
            'Vagabond',
            'Vinland Saga',
            'Tokyo Ghoul',
            'Death Note',
            'Fullmetal Alchemist',
            'Hunter x Hunter',
            'Bleach'
        ];

        return [
            'title' => fake()->randomElement($titles) . ' ' . fake()->numberBetween(1, 100),
            'type' => fake()->randomElement($types),
            'web_link' => fake()->url(),
            'description' => fake()->paragraph(3),
            'image_path' => null, // On peut ajouter des images par défaut plus tard
            'is_featured' => fake()->boolean(30), // 30% de chance d'être featured
            'user_id' => User::factory(), // Crée automatiquement un user si nécessaire
        ];
    }

    /**
     * Indique que le livre est en vedette
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    /**
     * Indique le type manga
     */
    public function manga(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'manga',
        ]);
    }

    /**
     * Indique le type webtoon
     */
    public function webtoon(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'webtoon',
        ]);
    }
}