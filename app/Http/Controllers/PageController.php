<?php

namespace App\Http\Controllers;
use App\Models\Etudiant;
use App\Models\Paiement;
use App\Models\Besoin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function dashboard() {
        // Récupérer les données pour le dashboard
            $totalEtudiants = Etudiant::count();
            $totalPaiements = Paiement::sum('montant'); // ou count() selon votre besoin
            $besoinsEnAttente = Besoin::where('statut', 'en_attente')->count();
            $recentEtudiants = Etudiant::where('created_at', '>=', now()->subWeek())
                                        ->orderBy('created_at', 'desc')
                                        ->get();

            $totalBesoins = Besoin::count();
        // Récupérer les étudiants récents
         $recentEtudiants = Etudiant::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Récupérer les besoins urgents
        $besoinsUrgents = Besoin::with('etudiant')
            ->where('priorite', 'urgent')
            ->where('statut', '!=', 'résolu')
            ->latest()
            ->limit(5)
            ->get();
            
        // Récupérer les paiements récents
        $recentPaiements = Paiement::with('etudiant')
            ->latest()
            ->limit(5)
            ->get();

        return view('front.dashboard', compact(
            'totalEtudiants',
            'totalPaiements',
            'besoinsEnAttente',
            'recentEtudiants',
            'totalBesoins',
            'besoinsUrgents',
            'recentPaiements'
        ));
        
    }


    public function etudiants()
    {
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
        $paiements = Paiement::with('etudiant')->get();
        return view('front.paiement', compact('paiements'));
    }
}

