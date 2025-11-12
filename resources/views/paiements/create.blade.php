@props(['etudiants' => []])

@extends('layouts.main')

@section('content')

    <div class="add-paiements">
        <h2>Ajouter un paiement</h2>

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('paiements.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="etudiants_id">Nom de l'étudiant</label>
                <select name="etudiants_id" id="etudiants_id" required>
                    <option value="">-- Choisir un étudiant --</option>
                    @foreach($etudiants as $etudiant)
                        <option value="{{ $etudiant->id }}" {{ old('etudiants_id') == $etudiant->id ? 'selected' : '' }}>
                            {{ $etudiant->nom }} {{ $etudiant->prenom }} 
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="montant">Montant</label>
                <input type="number" id="montant" name="montant" required>
            </div>

            <div class="form-group">
                <label for="montant_total">Montant total à payer (FCFA)</label>
                <input type="number" step="0.01" name="montant_total" id="montant_total" value="{{ old('montant_total') }}" required>
            </div>
            <div class="form-group">
                <label for="date_paiement">Date de paiement</label>
                <input type="date" id="date_paiement" name="date_paiement" required>
            </div>
            <div class="form-group">
                <label for="mode_paiement">Mode de paiement</label>
                <select name="mode_paiement" id="mode_paiement">
                    <option value="espece">Espèce</option>
                    <option value="carte_bancaire">Carte Bancaire</option>
                    <option value="virement_bancaire">Virement</option>
                </select>
            </div>

            <div class="form-group">
                <label for="etat">Etat</label>
                <select name="etat" id="etat">
                    <option value="partiel">Partiel</option>
                    <option value="solde">Soldé</option>
                </select>
            </div>
                    
            <button type="submit" class="register-btn">Ajouter un paiement</button>
        </form>
    </div>
@endsection
