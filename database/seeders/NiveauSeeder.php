<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NiveauSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $niveaux = ['debutant', 'intermediaire', 'avance'];

        foreach ($niveaux as $libelle) {
            \DB::table('niveaux')->insert([
                'libelle' => $libelle,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        
    }
}
