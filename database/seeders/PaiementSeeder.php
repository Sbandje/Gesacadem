<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaiementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            Paiement::create([
                'etudiants_id' => 2,
                'montant' => 20000,
                'montant_total' => 100000,
                'date_paiement' => '2025-10-25',
                'mode_paiement' => 'virement_bancaire',
                'etat' => 'partiel',
                'reste_a_payer'
            ]);
    }
}
