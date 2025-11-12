<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Utilisateur par défaut
        User::create([
            'nom' => 'BANDJE MEZUI Anabelle',
            'email' => 'anabelle@test.com',
            'password' => bcrypt('anabelle123'),
        ]);
    }
}
