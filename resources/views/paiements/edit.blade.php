@extends('layouts.main')

@section('content')

<div class="edit-paiements">
    <h2>Modifier un paiement</h2>

    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('paiements.update', $paiement->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="etudiants_nom">Nom de l'étudiant</label>
            <select name="etudiants_id" id="etudiants_id">
                @foreach($etudiants as $etudiant)
                    <option value="{{ $etudiant->id }}" {{ $paiement->etudiants_id == $etudiant->id ? 'selected' : '' }}>
                        {{ $etudiant->nom }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="montant">Montant</label>
            <input type="number" id="montant" name="montant" value="{{ $paiement->montant }}" required>
        </div>
        <div class="form-group">
            <label for="date_paiement">Date de paiement</label>
            <input type="date" id="date_paiement" name="date_paiement" value="{{ $paiement->date_paiement }}" required>
        </div>
        <div class="form-group">
            <label for="mode_paiement">Mode de paiement</label>
            <select name="mode_paiement" id="mode_paiement">
                <option value="espece" {{ $paiement->mode_paiement == 'espece' ? 'selected' : '' }}>Espèce</option>
                <option value="carte_bancaire" {{ $paiement->mode_paiement == 'carte_bancaire' ? 'selected' : '' }}>Carte Bancaire</option>
                <option value="virement_bancaire" {{ $paiement->mode_paiement == 'virement_bancaire' ? 'selected' : '' }}>Virement</option>
            </select>
        </div>
        <div class="form-group">
            <label for="etat">Etat</label>
            <select name="etat" id="etat">
                <option value="partiel" {{ $paiement->etat == 'en_attente' ? 'selected' : '' }}>Partiel</option>
                <option value="solde" {{ $paiement->etat == 'confirme' ? 'selected' : '' }}>Soldé</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>

@endsection