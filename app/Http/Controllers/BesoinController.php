<?php
// app/Http/Controllers/BesoinController.php

namespace App\Http\Controllers;

use App\Models\Besoin;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BesoinController extends Controller
{
    // Liste de tous les besoins
    public function index(Request $request)
    {
        $query = Besoin::with(['etudiant.niveaux']);

        // Filtres
        if ($request->has('statut') && $request->statut) {
            $query->where('statut', $request->statut);
        }

        if ($request->has('priorite') && $request->priorite) {
            $query->where('priorite', $request->priorite);
        }

        if ($request->has('type') && $request->type) {
            $query->where('type_besoin', $request->type);
        }

        if ($request->has('etudiants_id') && $request->etudiants_id) {
            $query->where('etudiants_id', $request->etudiants_id);
        }

        $besoins = $query->latest()->paginate(20);

        $statistiques = [
            'total' => Besoin::count(),
            'en_attente' => Besoin::enAttente()->count(),
            'urgents' => Besoin::urgents()->count(),
            'resolus' => Besoin::where('statut', 'résolu')->count(),
        ];

        $etudiants = Etudiant::all();
        $typesBesoin = $this->getTypesBesoin();

        return view('besoins.index', compact('besoins', 'statistiques', 'etudiants', 'typesBesoin'));
    }

    // Formulaire de création
    public function create()
    {
        $etudiants = Etudiant::all();
        $typesBesoin = $this->getTypesBesoin();
        
        return view('besoins.create', compact('etudiants', 'typesBesoin'));
    }

    // Enregistrer un nouveau besoin
    public function store(Request $request)
    {
        $validated = $request->validate([
            'etudiants_id' => 'required|exists:etudiants,id',
            'type_besoin' => 'required|string|max:255',
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'priorite' => 'required|in:faible,moyenne,élevée,urgent',
            'cout_estime' => 'nullable|numeric|min:0',
            'date_limite' => 'nullable|date|after_or_equal:today',
        ]);

         Besoin::create($validated);

        return redirect()->route('besoins.index')
            ->with('success', 'Besoin enregistré avec succès!');
    }

    // Afficher un besoin spécifique
    public function show(Besoin $besoin)
    {
        $besoin->load('etudiant');
        return view('besoins.show', compact('besoin'));
    }

    // Formulaire d'édition
    public function edit(Besoin $besoin)
    {
        $etudiants = Etudiant::all();
        $typesBesoin = $this->getTypesBesoin();
        
        return view('besoins.edit', compact('besoin', 'etudiants', 'typesBesoin'));
    }

    // Mettre à jour un besoin
    public function update(Request $request, Besoin $besoin)
    {
        $validated = $request->validate([
            'etudiants_id' => 'required|exists:etudiants,id',
            'type_besoin' => 'required|string|max:255',
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'priorite' => 'required|in:faible,moyenne,élevée,urgent',
            'statut' => 'required|in:en_attente,en_cours,résolu,rejeté',
            'cout_estime' => 'nullable|numeric|min:0',
            'date_limite' => 'nullable|date',
            'notes_admin' => 'nullable|string',
        ]);

        // Si le statut passe à "résolu", enregistrer la date
        if ($validated['statut'] === 'résolu' && $besoin->statut !== 'résolu') {
            $validated['date_resolution'] = now();
        }

        $besoin->update($validated);

        return redirect()->route('besoins.show', $besoin)
            ->with('success', 'Besoin mis à jour avec succès!');
    }

    // Supprimer un besoin
    public function destroy(Besoin $besoin)
    {
        $besoin->delete();

        return redirect()->route('besoins.index')
            ->with('success', 'Besoin supprimé avec succès!');
    }

    // Tableau de bord des besoins
    public function dashboard()
    {
        $statistiques = DB::table('besoins')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('COUNT(CASE WHEN statut = "en_attente" THEN 1 END) as en_attente')
            ->selectRaw('COUNT(CASE WHEN statut = "en_cours" THEN 1 END) as en_cours')
            ->selectRaw('COUNT(CASE WHEN statut = "résolu" THEN 1 END) as resolus')
            ->selectRaw('COUNT(CASE WHEN statut = "rejeté" THEN 1 END) as rejetes')
            ->selectRaw('COUNT(CASE WHEN priorite = "urgent" THEN 1 END) as urgents')
            ->first();

        $besoinsRecents = Besoin::with('etudiant')
            ->latest()
            ->limit(10)
            ->get();

        $besoinsUrgents = Besoin::with('etudiant')
            ->urgents()
            ->where('statut', '!=', 'résolu')
            ->latest()
            ->get();

        $repartitionTypes = DB::table('besoins')
            ->select('type_besoin', DB::raw('COUNT(*) as count'))
            ->groupBy('type_besoin')
            ->get();

        return view('besoins.dashboard', compact(
            'statistiques', 
            'besoinsRecents', 
            'besoinsUrgents',
            'repartitionTypes'
        ));
    }

    // Méthode privée pour les types de besoins
    private function getTypesBesoin()
    {
        return [
           'paiement_scolarité' => 'Scolaire', 
            'hébergement' => 'Hébergement',
            'modification_module' => 'Modification de Module',
        ];
    }
}