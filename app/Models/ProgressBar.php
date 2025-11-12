<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProgressBar extends Model

{
    public $pourcentage;
    public $couleur;
    public $montant;
    public $montantTotal;
    public $resteAPayer;
    public $showDetails;

    public function __construct($pourcentage, $couleur = null, $montantPaye = null, $montantTotal = null, $resteAPayer = null, $showDetails = false)
    {
        $this->pourcentage = $pourcentage;
        $this->couleur = $couleur ?? $this->determinerCouleur($pourcentage);
        $this->montant = $montantPaye;
        $this->montantTotal = $montantTotal;
        $this->resteAPayer = $resteAPayer;
        $this->showDetails = $showDetails;
    }

    private function determinerCouleur($pourcentage)
    {
        if ($pourcentage == 0) return 'danger';
        if ($pourcentage < 30) return 'danger';
        if ($pourcentage < 70) return 'warning';
        if ($pourcentage < 100) return 'info';
        return 'success';
    }

    public function render(): View|Closure|string
    {
        return view('components.progress-bar');
    }

}
