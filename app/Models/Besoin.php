<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Besoin extends Model
{
    protected $fillable = [
        'etudiants_id',
        'type_besoin',
        'titre',
        'description',
        'priorite',
        'statut',
        'cout_estime',
        'date_limite',
        'notes_admin',
        'date_resolution'
    ];

    protected $casts = [
        'cout_estime' => 'decimal:2',
        'date_limite' => 'date',
        'date_resolution' => 'datetime'
    ];

    // Relation avec l'étudiant
    public function etudiant(): BelongsTo
    {
        return $this->belongsTo(Etudiant::class);
    }

    // Accesseur pour la couleur de priorité
    public function getCouleurPrioriteAttribute(): string
    {
        return match($this->priorite) {
            'faible' => 'success',
            'moyenne' => 'warning',
            'élevée' => 'danger',
            'urgent' => 'dark',
            default => 'secondary'
        };
    }

    // Accesseur pour la couleur de statut
    public function getCouleurStatutAttribute(): string
    {
        return match($this->statut) {
            'en_attente' => 'secondary',
            'en_cours' => 'info',
            'résolu' => 'success',
            'rejeté' => 'danger',
            default => 'secondary'
        };
    }

    // Accesseur pour l'icône de statut
    public function getIconeStatutAttribute(): string
    {
        return match($this->statut) {
            'en_attente' => '⏳',
            'en_cours' => '🔄',
            'résolu' => '✅',
            'rejeté' => '❌',
            default => '📋'
        };
    }

    // Vérifier si le besoin est urgent (date limite dépassée)
    public function getEstUrgentAttribute(): bool
    {
        if (!$this->date_limite) {
            return false;
        }
        
        return $this->date_limite < now() && $this->statut !== 'résolu';
    }

    // Scope pour les besoins en attente
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    // Scope pour les besoins urgents
    public function scopeUrgents($query)
    {
        return $query->where('priorite', 'urgent')
                    ->orWhere(function($q) {
                        $q->where('date_limite', '<', now())
                          ->where('statut', '!=', 'résolu');
                    });
    }

    // Scope par type de besoin
    public function scopeParType($query, $type)
    {
        return $query->where('type_besoin', $type);
    }
}