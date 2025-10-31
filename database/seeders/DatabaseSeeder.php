<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Réinitialiser le cache des permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ========================================
        // 1. CRÉER LES PERMISSIONS
        // ========================================
        $permissions = [
            'view books',
            'create books',
            'edit books',
            'delete books',
            'manage users',
            'manage roles',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // ========================================
        // 2. CRÉER LES RÔLES ET ASSIGNER LES PERMISSIONS
        // ========================================
        
        // Rôle Admin : Toutes les permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // Rôle User : Permissions limitées
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo([
            'view books',
            'create books',
            'edit books',
            'delete books'
        ]);

        // ========================================
        // 3. CRÉER UN ADMIN
        // ========================================
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@manga.com',
            'password' => bcrypt('admin123'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        // ========================================
        // 4. CRÉER UN USER NORMAL
        // ========================================
        $normalUser = User::create([
            'name' => 'John Doe',
            'email' => 'user@manga.com',
            'password' => bcrypt('user123'),
            'email_verified_at' => now(),
        ]);
        $normalUser->assignRole('user');

        // ========================================
        // 5. CRÉER DES LIVRES POUR L'ADMIN (FEATURED)
        // ========================================
        Book::factory()->count(5)->featured()->create([
            'user_id' => $admin->id
        ]);

        // ========================================
        // 6. CRÉER DES LIVRES POUR L'UTILISATEUR NORMAL
        // ========================================
        Book::factory()->count(10)->create([
            'user_id' => $normalUser->id
        ]);

        // ========================================
        // 7. CRÉER DES UTILISATEURS SUPPLÉMENTAIRES AVEC LIVRES
        // ========================================
        User::factory(5)->create()->each(function ($user) {
            $user->assignRole('user');
            Book::factory()->count(rand(3, 8))->create([
                'user_id' => $user->id
            ]);
        });

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('👤 Admin: admin@manga.com / admin123');
        $this->command->info('👤 User: user@manga.com / user123');
    }
}