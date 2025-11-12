<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = ['francais', 'anglais', 'allemand', 'ruisse'];

        foreach ($modules as $libelle) {
            \DB::table('modules')->insert([
                'libelle' => $libelle,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
