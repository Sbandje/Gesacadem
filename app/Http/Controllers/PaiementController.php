<?php

namespace App\Http\Controllers;
use App\Models\Etudiant;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;



class PaiementController extends Controller
{

    public function create()
    {
        $paiements = Paiement::all();
        $etudiants = Etudiant::all(); 
        return view('paiements.create', compact('paiements', 'etudiants'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'etudiants_id' => 'required|exists:etudiants,id',
            'montant' => 'required|numeric|min:0',
            'montant_total' => 'numeric|min:0',
            'date_paiement' => 'required|date',
            'mode_paiement' => 'required|in:espece,carte_bancaire,virement_bancaire',
            'etat' => 'required|in:partiel,solde,annule',
        ]);

        $paiements = Paiement::create($request->all());
        

        // Calculer le reste à payer
        $montantTotal = $validated['montant_total'];
        $montantPaye = $validated['montant'];
        $resteAPayer = $montantTotal - $montantPaye;
        


        // Déterminer le statut
        $statut = $resteAPayer <= 0 ? 'soldé' : 'partiel';

        // Ajouter les champs calculés aux données validées
        $validated['reste_a_payer'] = max(0, $resteAPayer); // Éviter les valeurs négatives
        $validated['etat'] = $statut;


        // Rediriger vers le reçu
        return redirect()->route('receipt.show', $paiements->id)
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

        // Mettre à jour le paiement existant (optionnel - selon votre logique métier)
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
        return view('paiements.edit', compact('paiement', 'etudiants'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'etudiants_id' => 'required|exists:etudiants,id',
            'montant' => 'required|numeric',
            'date_paiement' => 'required|date',
            'mode_paiement' => 'required|in:espece,carte_bancaire,virement_bancaire',
            'etat' => 'required|in:partiel,solde,annule',
        ]);

        $paiement = Paiement::findOrFail($id);
        $paiement->update($request->all());

        return redirect()->route('front.paiement')->with('success', 'Paiement mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $paiement = Paiement::findOrFail($id);
        $paiement->delete();

        return redirect()->route('front.paiement')->with('success', 'Paiement supprimé avec succès.');
    }
}
