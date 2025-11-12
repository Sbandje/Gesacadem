<?php

namespace App\Http\Controllers;

use App\Models\Niveau;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class StatistiqueController extends Controller
{
    // Méthode pour lister le cumul des paiements par niveau
    public function cumulParNiveau()
    {
        // Récupérer tous les niveaux avec leurs étudiants et paiements
        $niveaux = Niveau::with(['etudiants.paiements'])->get();
        
        // Préparer les données pour la vue
        $statistiques = [];
        $totalGeneral = 0;
        
        foreach ($niveaux as $niveau) {
            $cumul = $niveau->cumulPaiements();
            $nombreEtudiants = $niveau->nombreEtudiants();
            
            $statistiques[] = [
                'niveaux' => $niveau,
                'cumul_paiements' => $cumul,
                'nombre_etudiants' => $nombreEtudiants,
                'moyenne_par_etudiant' => $nombreEtudiants > 0 ? $cumul / $nombreEtudiants : 0
            ];
            
            $totalGeneral += $cumul;
        }

        return view('statistiques.cumul_par_niveau', compact('statistiques', 'totalGeneral'));
    }

    // Méthode pour les statistiques détaillées avec filtres
    public function statistiquesDetaillees(Request $request)
    {
        // Récupérer les paramètres de filtre
        $niveauId = $request->get('niveaux_id');
        $dateDebut = $request->get('date_debut');
        $dateFin = $request->get('date_fin');

        // Construire la requête de base
        $query = Niveau::with(['etudiants.paiements']);

        // Appliquer les filtres
        if ($niveauId) {
            $query->where('id', $niveauId);
        }

        $niveaux = $query->get();
        
        $statistiques = [];
        $totalGeneral = 0;

        foreach ($niveaux as $niveau) {
            // Filtrer les paiements par date si spécifié
            $paiementsFiltres = $this->filtrerPaiementsParDate($niveau, $dateDebut, $dateFin);
            
            $cumul = $paiementsFiltres['total'];
            $nombrePaiements = $paiementsFiltres['count'];
            $nombreEtudiants = $niveau->etudiants()->count();

            $statistiques[] = [
                'niveaux' => $niveau,
                'cumul_paiements' => $cumul,
                'nombre_etudiants' => $nombreEtudiants,
                'nombre_paiements' => $nombrePaiements,
                'moyenne_par_etudiant' => $nombreEtudiants > 0 ? $cumul / $nombreEtudiants : 0,
                'paiements_filtres' => $paiementsFiltres['paiements']
            ];
            
            $totalGeneral += $cumul;
        }

        // Récupérer tous les niveaux pour le filtre
        $tousLesNiveaux = Niveau::all();

        return view('statistiques.detaillees', compact('statistiques', 'totalGeneral', 'tousLesNiveaux'));
    }

    // Méthode privée pour filtrer les paiements par date
    private function filtrerPaiementsParDate($niveau, $dateDebut, $dateFin)
    {
        $total = 0;
        $count = 0;
        $paiementsFiltres = [];

        foreach ($niveau->etudiants as $etudiant) {
            $query = $etudiant->paiements();

            if ($dateDebut) {
                $query->where('date_paiement', '>=', $dateDebut);
            }

            if ($dateFin) {
                $query->where('date_paiement', '<=', $dateFin);
            }

            $paiementsEtudiant = $query->get();
            
            foreach ($paiementsEtudiant as $paiement) {
                $total += $paiement->montant;
                $count++;
                $paiementsFiltres[] = $paiement;
            }
        }

        return [
            'total' => $total,
            'count' => $count,
            'paiements' => $paiementsFiltres
        ];
    }

    // Méthode pour exporter les statistiques en PDF
    public function exportPDF()
    {
        $niveaux = Niveau::with(['etudiants.paiements'])->get();
        
        $statistiques = [];
        $totalGeneral = 0;
        
        foreach ($niveaux as $niveau) {
            $cumul = $niveau->cumulPaiements();
            $nombreEtudiants = $niveau->nombreEtudiants();
            
            $statistiques[] = [
                'niveaux' => $niveau,
                'cumul_paiements' => $cumul,
                'nombre_etudiants' => $nombreEtudiants,
                'moyenne_par_etudiant' => $nombreEtudiants > 0 ? $cumul / $nombreEtudiants : 0
            ];
            
            $totalGeneral += $cumul;
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('statistiques.export-pdf', 
            compact('statistiques', 'totalGeneral')
        );

        return $pdf->download('cumul-paiements-par-niveau-' . date('Y-m-d') . '.pdf');
    }
}
