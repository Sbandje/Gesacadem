<?php

namespace App\Http\Controllers;
use App\Models\Etudiant;
use App\Models\Paiement;
use App\Models\Niveau;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;



class PaiementController extends Controller
{

    public function create()
    {
        $paiements = Paiement::all();
        $etudiants = Etudiant::all(); 
        $niveaux =Niveau::all();
        return view('paiements.create', compact('paiements', 'etudiants', 'niveaux'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'etudiants_id' => 'required|exists:etudiants,id',
            'niveaux_id' => 'required|exists:niveaux,id',
            'montant' => 'required|numeric|min:0',
            'date_paiement' => 'required|date',
            'mode_paiement' => 'required|in:espece,carte_bancaire,virement_bancaire',
            
        ]);

        // Récupérer le niveau et son montant fixe
        $niveau = Niveau::findOrFail($validated['niveaux_id']);
        $montantTotal = $niveau->montant_fixe;
        $montantPaye = $validated['montant'];

        // Calculer le total déjà payé pour cet étudiant dans ce niveau
        $totalDejaPaye = Paiement::where('etudiants_id', $validated['etudiants_id'])
                                ->where('niveaux_id', $validated['niveaux_id'])
                                ->sum('montant');
        
        $totalApresPaiement = $totalDejaPaye + $montantPaye;
        $resteAPayer = $montantTotal - $totalApresPaiement;

        // Déterminer le statut
        $statut = $resteAPayer <= 0 ? 'solde' : 'partiel';

        // Créer le paiement
        $paiement = Paiement::create([
            'etudiants_id' => $validated['etudiants_id'],
            'niveaux_id' => $validated['niveaux_id'],
            'montant' => $montantPaye,
            'montant_total' => $montantTotal,
            'date_paiement' => $validated['date_paiement'],
            'mode_paiement' => $validated['mode_paiement'],
            'reste_a_payer' => max(0, $resteAPayer),
            'etat' => $statut,
        ]);

        return redirect()->route('receipt.show', $paiement->id)
            ->with('success', 'Paiement enregistré avec succès!');
    }



    // Pour les paiements supplémentaires (si l'étudiant paye en plusieurs fois)
    public function addPayment(Request $request, $id)
    {
        // Trouver le paiement existant
        $paiementExistant = Paiement::findOrFail($id);

        // Valider le montant supplémentaire
        $validated = $request->validate([
            'montant_supplementaire' => 'required|numeric|min:0',
            'date_paiement' => 'required|date',
            'mode_paiement' => 'required|in:espèces,carte_bancaire,chèque,virement',
        ]);

        // Créer un nouveau paiement pour le supplément
        $nouveauPaiement = Paiement::create([
            'etudiants_id' => $paiementExistant->etudiants_id,
            'montant_total' => $paiementExistant->montant_total,
            'montant' => $validated['montant_supplementaire'],
            'mode_paiement' => $validated['mode_paiement'],
            'date_paiement' => $validated['date_paiement'],
            'reste_a_payer' => max(0, $paiementExistant->reste_a_payer - $validated['montant_supplementaire']),
            'statut' => ($paiementExistant->reste_a_payer - $validated['montant_supplementaire']) <= 0 ? 'soldé' : 'partiel',
        ]);

        // Mettre à jour le paiement existant avec le nouveau reste à payer et le statut
        $paiementExistant->update([
            'reste_a_payer' => max(0, $paiementExistant->reste_a_payer - $validated['montant_supplementaire']),
            'statut' => ($paiementExistant->reste_a_payer - $validated['montant_supplementaire']) <= 0 ? 'soldé' : 'partiel',
        ]);

      

        return redirect()->route('receipt.show', ['id' => $paiements->id])
                        ->with('success', 'Paiement enregistré avec succès.');
    }

    public function edit($id)
    {
        $paiement = Paiement::findOrFail($id);
        $etudiants = Etudiant::all(); 
        $niveaux = Niveau::all();
        return view('paiements.edit', compact('paiement', 'etudiants', 'niveaux'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'etudiants_id' => 'required|exists:etudiants,id',
            'niveaux_id' => 'required|exists:niveaux,id',
            'montant' => 'required|numeric',
            'date_paiement' => 'required|date',
            'mode_paiement' => 'required|in:espece,carte_bancaire,virement_bancaire',
        ]);

        $paiement = Paiement::findOrFail($id);
        
        // Récupérer le nouveau niveau et son montant
        $niveau = Niveau::findOrFail($request->niveaux_id);
        $montantTotal = $niveau->montant_fixe;

        // Recalculer le total payé pour cet étudiant dans ce niveau (excluant le paiement actuel)
        $totalDejaPaye = Paiement::where('etudiants_id', $request->etudiants_id)
                                ->where('niveaux_id', $request->niveaux_id)
                                ->where('id', '!=', $id)
                                ->sum('montant');
        
        $totalApresPaiement = $totalDejaPaye + $request->montant;
        $resteAPayer = $montantTotal - $totalApresPaiement;
        $statut = $resteAPayer <= 0 ? 'solde' : 'partiel';

        $paiement->update([
            'etudiants_id' => $request->etudiants_id,
            'niveaux_id' => $request->niveaux_id,
            'montant' => $request->montant,
            'montant_total' => $montantTotal,
            'date_paiement' => $request->date_paiement,
            'mode_paiement' => $request->mode_paiement,
            'reste_a_payer' => max(0, $resteAPayer),
            'etat' => $statut,
        ]);

        return redirect()->route('front.paiement')->with('success', 'Paiement mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $paiement = Paiement::findOrFail($id);
        $paiement->delete();

        return redirect()->route('front.paiement')->with('success', 'Paiement supprimé avec succès.');
    }
}
