<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $table = 'paiements';

    protected $fillable = [
        'etudiants_id',
        'montant',
        'montant_total',
        'date_paiement',
        'mode_paiement',
        'reste_payer',
        'etat',
    ];

        protected $casts = [
        'montant' => 'decimal:2',
        'montant_total' => 'decimal:2',
        'reste_a_payer' => 'decimal:2',
        'date_paiement' => 'date'
    ];

     public function niveau()
    {
        return $this->belongsTo(Niveau::class, 'niveaux_id');
    }

    
    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'etudiants_id');
    }

    
    public function module()
    {
        return $this->belongsTo(Module::class, 'modules_id');
    }
    

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'etudiants_id');
    }

    
    public function totalPaiements()
    {
        return $this->paiements()->sum('montant');
    }

    public function pourcentagePaiement()
    {
        if ($this->montant_total <= 0) {
            return 0;
        }
        
        $pourcentage = ($this->totalPaiements() / $this->montant_total) * 100;
        
        // Limiter à 100% maximum
        return min(round($pourcentage, 2), 100);
    }

     public function resteAPayer()
    {
        return max(0, $this->montant_total - $this->totalPaiements());
    }

    
    // Méthode pour vérifier si le paiement est soldé
    public function estSolde()
    {
        return $this->reste_a_payer >= 0;
    }

    
   
}
