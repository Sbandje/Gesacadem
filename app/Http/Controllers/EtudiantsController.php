<?php

namespace App\Http\Controllers;
use App\Models\Etudiant; 
use App\Models\Niveau;
use App\Models\Module;

use Illuminate\Http\Request;

class EtudiantsController extends Controller
{
    public function etudiants()
{
    $etudiants = Etudiant::all();
    return view('front.etudiants', compact('etudiants')); 
}

    public function create()
    {
        $niveaux = Niveau::all();
        $modules = Module::all();
        
        return view('etudiants.add', compact('niveaux', 'modules'));
    }

   public function store(Request $request) {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:etudiants,email',
            'date_naissance' => 'required|date',
            'niveaux_id' => 'required|exists:niveaux,id',
            'modules_id' => 'required|exists:modules,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
        ]);

        Etudiant::create($validated);

        return redirect()->route('front.etudiants')->with('success', 'Étudiant ajouté avec succès.');
   }

    public function edit($id)
    {
        $etudiant = Etudiant::findOrFail($id);
        return view('etudiants.edit', compact('etudiant'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:etudiants,email,' . $id,
            'date_naissance' => 'required|date',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
        ]);

        $etudiant = Etudiant::findOrFail($id);
        $etudiant->update($validated);

        return redirect()->route('front.etudiants')->with('success', 'Étudiant mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $etudiant = Etudiant::findOrFail($id);
        $etudiant->delete();

        return redirect()->route('front.etudiants')->with('success', 'Étudiant supprimé avec succès.');
    }

    

}
