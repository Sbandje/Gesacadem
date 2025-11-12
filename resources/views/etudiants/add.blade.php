<!-- Ajout ou création des étudiants -->
@extends('layouts.main')

@section('content')

    <div class="add-etudiants">
        <h2>Ajouter un étudiant</h2>

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('etudiants.store') }}" method="POST">
            @csrf
            <div class="form-groupetu">
                <div class="form-group">
                    <label for="nom">Nom:</label>
                    <input type="text" id="nom" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom:</label>
                    <input type="text" id="prenom" name="prenom" required>
                </div>
            </div>


            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="date_naissance">Date de naissance:</label>
                <input type="date" id="date_naissance" name="date_naissance" required>
            </div>
            <div class="form-group">
                <label for="niveaux_id">Niveau</label>
                <select name="niveaux_id" id="niveaux_id" class="form-control" required>
                    <option value="">Sélectionnez un module</option>
                    @foreach($niveaux as $niveau)
                        <option value="{{ $niveau->id }}">{{ $niveau->libelle }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="modules_id">Module</label>
                <select name="modules_id" id="modules_id" class="form-control" required>
                    <option value="">Sélectionnez un module</option>
                    @foreach($modules as $module)
                        <option value="{{ $module->id }}">{{ $module->libelle }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-groupetu">
                <div class="form-group">
                    <label for="date_debut">Date de début</label>
                    <input type="date" id="date_debut" name="date_debut" placeholder="Votre date_debut d'étude" required>
                </div>
                <div class="form-group">
                    <label for="date_fin">Date de début</label>
                    <input type="date" id="date_fin" name="date_fin" placeholder="Votre date_fin d'étude" required>
                </div>
            </div>

            <button type="submit" class="register-btn">Inscrire un étudiants</button>
        </form>
    </div>
@endsection