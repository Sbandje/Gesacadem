<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{
    protected $table = 'niveaux';

    protected $fillable = [
        'libelle',
    ];

    public function etudiants()
    {
        return $this->hasMany(Etudiant::class, 'niveaux_id');
    }

    // Méthode pour calculer le cumul des paiements du niveau
    public function cumulPaiements()
    {
        // Récupérer tous les étudiants de ce niveau avec leurs paiements
        $etudiants = $this->etudiants()->with('paiements')->get();
        
        // Calculer le total des paiements
        $total = 0;
        foreach ($etudiants as $etudiant) {
            $total += $etudiant->paiements->sum('montant');
        }
        
        return $total;
    }

    // Méthode pour compter le nombre d'étudiants dans le niveau
    public function nombreEtudiants()
    {
        return $this->etudiants()->count();
    }

    // Méthode pour calculer la moyenne des paiements par étudiant
    public function moyennePaiementsParEtudiant()
    {
        $nombreEtudiants = $this->nombreEtudiants();
        if ($nombreEtudiants > 0) {
            return $this->cumulPaiements() / $nombreEtudiants;
        }
        return 0;
    }
}
