<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Niveau;
use Illuminate\Database\Seeder;

class NiveauSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $niveaux = [
            [
                'libelle' => 'débutant',
                'montant_fixe' => 150000,
                'description' => 'Niveau débutant'
            ],
            [
                'libelle' => 'intermédiaire',
                'montant_fixe' => 200000,
                'description' => 'Niveau intermédiaire'
            ],
            [
                'libelle' => 'avancé',
                'montant_fixe' => 250000,
                'description' => 'Niveau avancé'
            ],
        ];

        foreach ($niveaux as $niveau) {
            Niveau::create($niveau);
        }
    }
}
