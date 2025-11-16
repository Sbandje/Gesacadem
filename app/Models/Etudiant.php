<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    protected $table = 'etudiants';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'date_naissance',
        'niveaux_id',
        'modules_id',
        'date_debut',
        'date_fin',
    ];

    public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
    
     public function paiements()
    {
        return $this->hasMany(Paiement::class, 'etudiants_id');
    }

    public function paiementsParNiveau($niveauId)
    {
        return $this->paiements()->where('niveaux_id', $niveauId)->get();
    }

}
