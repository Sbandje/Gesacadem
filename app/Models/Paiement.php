<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $table = 'paiements';

    protected $fillable = [
        'etudiants_id',
        'niveaux_id',
        'montant',
        'montant_total',
        'date_paiement',
        'mode_paiement',
        'reste_a_payer',
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

     // Méthode pour définir automatiquement le montant total
    public function setMontantTotalAttribute($value)
    {
        if (empty($value) && !empty($this->niveaux_id)) {
            $niveau = Niveau::find($this->niveaux_id);
            $this->attributes['montant_total'] = $niveau ? $niveau->montant_fixe : 0;
        } else {
            $this->attributes['montant_total'] = $value;
        }
    }
    
// Calcul des paiements effectués par étudiant
    
    public function totalPaiements()
    {
        return $this->where('etudiants_id', $this->etudiants_id)
                    ->where('niveaux_id', $this->niveaux_id)
                    ->sum('montant');
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

      public function getEtatAttribute($value)
    {
        // Si le reste à payer est 0, forcer l'état à "solde"
        if ($this->reste_a_payer <= 0) {
            return 'solde';
        }
        return $value;
    }
   
}
