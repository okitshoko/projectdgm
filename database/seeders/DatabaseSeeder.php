<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Création du Super Administrateur DGM
        User::firstOrCreate(
            ['email' => 'okitshoko@gmail.com'],
            [
                'name'     => 'OKIT',
                'password' => \Illuminate\Support\Facades\Hash::make('okit12'),
                'role'     => 'admin',
            ]
        );
    }
}
