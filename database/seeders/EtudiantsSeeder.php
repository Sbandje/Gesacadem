<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Etudiant;


class EtudiantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Etudiant::create([
            'nom' => 'Aklassou',
            'prenom' => 'belle',
            'email' => 'belle@exemple.com',
            'date_naissance' => '2000-05-15',
            'niveaux_id' => 1,
            'modules_id' => 2,
            'date_debut' => '2023-01-10',
            'date_fin' => '2023-06-10',
        ]); 
    }
}
