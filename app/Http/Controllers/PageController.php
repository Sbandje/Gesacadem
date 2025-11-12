<?php

namespace App\Http\Controllers;
use App\Models\Etudiant;
use App\Models\Paiement;
use App\Models\Besoin;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function dashboard() {
        return view('front.dashboard');
    }


    public function etudiants()
    {
        // Récupérer tous les étudiants
        $etudiants = Etudiant::all();
        
        return view('front.etudiants', compact('etudiants'));
    }

    public function inscription()
    {
        $etudiants = Etudiant::all();

        return view('front.inscription', compact('etudiants'));
    }

    public function paiement()
    {
        $paiements = Paiement::with('etudiants')->get();
        return view('front.paiement', compact('paiements'));
    }

    
}

