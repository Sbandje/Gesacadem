@extends('layouts.main')

@section('content')

<div class="edit-etudiants">
    <h2>Modifier un étudiant</h2>

    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('etudiants.update', $etudiant->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" value="{{ $etudiant->nom }}" required>
        </div>
        <div class="form-group">
            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" value="{{ $etudiant->prenom }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ $etudiant->email }}" required>
        </div>
        <div class="form-group">
            <label for="date_naissance">Date de naissance:</label>
            <input type="date" id="date_naissance" name="date_naissance" value="{{ $etudiant->date_naissance }}" required>
        </div>
        <div class="form-group">
            <label for="niveaux_id">Niveau:</label>
            <select name="niveaux_id" id="niveaux_id">
                <option value="debutant" {{ $etudiant->niveau == 'debutant' ? 'selected' : '' }}>Débutant</option>
                <option value="intermediaire" {{ $etudiant->niveau == 'intermediaire' ? 'selected' : '' }}>Intermédiaire</option>
                <option value="avance" {{ $etudiant->niveau == 'avance' ? 'selected' : '' }}>Avancé</option>
            </select>
        </div>
        <div class="form-group">
            <label for="modules_id">Module:</label>
           <select name="modules_id" id="modules_id">               
                   <option value="francais" {{ $etudiant->module == 'francais' ? 'selected' : '' }}>francais</option>
                    <option value="anglais" {{ $etudiant->module == 'anglais' ? 'selected' : '' }}>anglais</option>
                    <option value="allemand" {{ $etudiant->module == 'allemand' ? 'selected' : '' }}>allemand</option>
                    <option value="ruisse" {{ $etudiant->module == 'ruisse' ? 'selected' : '' }}>ruisse</option>
           </select>
        </div>
        <div class="form-group">
            <label for="date_debut">Date de début:</label>
            <input type="date" id="date_debut" name="date_debut" value="{{ $etudiant->date_debut }}" required>
        </div>
        <div class="form-group">
            <label for="date_fin">Date de fin:</label>
            <input type="date" id="date_fin" name="date_fin" value="{{ $etudiant->date_fin }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>

@endsection