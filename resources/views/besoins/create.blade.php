
@extends('layouts.main')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"> Nouveau Besoin pour un Étudiant</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('besoins.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="etudiants_id" class="form-label">Étudiant *</label>
                                <select name="etudiants_id" id="etudiants_id" class="form-select" required>
                                    <option value="">Sélectionner un étudiant</option>
                                    @foreach($etudiants as $etudiant)
                                    <option value="{{ $etudiant->id }}" {{ old('etudiant_id') == $etudiant->id ? 'selected' : '' }}>
                                        {{ $etudiant->nom }} {{ $etudiant->prenom }} - {{ $etudiant->email }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('etudiant_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="type_besoin" class="form-label">Type de Besoin *</label>
                                <select name="type_besoin" id="type_besoin" class="form-select" required>
                                    <option value="">Sélectionner un type</option>
                                    @foreach($typesBesoin as $key => $value)
                                    <option value="{{ $key }}" {{ old('type_besoin') == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('type_besoin')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre du Besoin *</label>
                            <input type="text" name="titre" id="titre" class="form-control" 
                                   value="{{ old('titre') }}" required placeholder="Ex: Achat d'ordinateur portable">
                            @error('titre')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description Détaillée *</label>
                            <textarea name="description" id="description" class="form-control" 
                                      rows="5" required placeholder="Décrivez le besoin en détail...">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="priorite" class="form-label">Priorité *</label>
                                <select name="priorite" id="priorite" class="form-select" required>
                                    <option value="moyenne" {{ old('priorite') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                                    <option value="faible" {{ old('priorite') == 'faible' ? 'selected' : '' }}>Faible</option>
                                    <option value="élevée" {{ old('priorite') == 'élevée' ? 'selected' : '' }}>Élevée</option>
                                    <option value="urgent" {{ old('priorite') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                </select>
                                @error('priorite')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="cout_estime" class="form-label">Coût Estimé (€)</label>
                                <input type="number" step="0.01" name="cout_estime" id="cout_estime" 
                                       class="form-control" value="{{ old('cout_estime') }}" 
                                       placeholder="0.00">
                                @error('cout_estime')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="date_limite" class="form-label">Date Limite</label>
                                <input type="date" name="date_limite" id="date_limite" 
                                       class="form-control" value="{{ old('date_limite') }}">
                                @error('date_limite')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('besoins.index') }}" class="btn btn-secondary me-md-2">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                 Enregistrer le Besoin
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection