@extends('layouts.main')

@section('title', 'Détails du Besoin - ' . $besoin->titre)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="details">
                <div class="details-besoin">
                    <h4 class="mb-0"> Détails du Besoin</h4>
                    <div class="btn-group">
                        <a href="{{ route('besoins.edit', $besoin) }}" class="btn btn-warning btn-sm">
                             Modifier
                        </a>
                        <a href="{{ route('besoins.index') }}" class="btn btn-secondary btn-sm">
                             Liste
                        </a>
                    </div>
                </div>
                <div class="list-besoins">
                    <!-- En-tête avec statuts -->
                    <div class="list-besoin">
                        <div class="col-md-8">
                            <h2>{{ $besoin->titre }}</h2>
                            <div class="d-flex gap-2 mb-2">
                                <span class="badge bg-{{ $besoin->couleur_priorite }} fs-6">
                                    Priorité: {{ $besoin->priorite }}
                                </span>
                                <span class="badge bg-{{ $besoin->couleur_statut }} fs-6">
                                     Statut: {{ $besoin->statut }}
                                </span>
                                <span class="badge bg-secondary fs-6">
                                    Type: {{ $besoin->type_besoin }}
                                </span>
                            </div>
                            @if($besoin->est_urgent)
                            <div class="alert alert-danger">
                                 <strong>BESOIN URGENT</strong> - Date limite dépassée
                            </div>
                            @endif
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6>Étudiant</h6>
                                    <h5>{{ $besoin->etudiant->nom ?? 'N/A' }} {{ $besoin->etudiant->prenom ?? '' }}</h5>
                                    <p class="mb-0 text-muted">{{ $besoin->etudiant->email ?? 'Email non disponible' }}</p>
                                    {{-- LIGNE CORRIGÉE --}}
                                    <small>Niveau: {{ $besoin->etudiant->niveau->nom ?? 'Non assigné' }}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informations principales -->
                    <div class="row">
                        <div class="">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0"> Description du Besoin</h6>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">{{ $besoin->description }}</p>
                                </div>
                            </div>

                            @if($besoin->notes_admin)
                            <div class="card border-info mb-4">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0"> Notes de l'Administration</h6>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">{{ $besoin->notes_admin }}</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="list-besoin-class">
                            <!-- Informations financières -->
                            <div class="list-besoin">
                                <div class="">
                                    <h6 class="mb-0"> Informations Financières</h6>
                                </div>
                                <div class="">
                                    @if($besoin->cout_estime)
                                    <p class="mb-2">
                                        <strong>Coût estimé:</strong><br>
                                        <span class="h5 text-primary">
                                            {{ number_format($besoin->cout_estime, 2, ',', ' ') }} €
                                        </span>
                                    </p>
                                    @else
                                    <p class="text-muted">Aucun coût estimé</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Dates importantes -->
                            <div class="list-besoin">
                                <div class="">
                                    <h6 class="mb-0"> Dates</h6>
                                </div>
                                <div class="">
                                    <p class="mb-2">
                                        <strong>Créé le:</strong><br>
                                        {{ $besoin->created_at->format('d/m/Y à H:i') }}
                                    </p>
                                    @if($besoin->date_limite)
                                    <p class="mb-2">
                                        <strong>Date limite:</strong><br>
                                        {{ \Carbon\Carbon::parse($besoin->date_limite)->format('d/m/Y') }}
                                        @if($besoin->est_urgent)
                                        <br><span class="text-danger">⚠ Dépassée</span>
                                        @endif
                                    </p>
                                    @endif
                                    @if($besoin->date_resolution)
                                    <p class="mb-0">
                                        <strong>Résolu le:</strong><br>
                                        {{ $besoin->date_resolution->format('d/m/Y à H:i') }}
                                    </p>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions rapides -->
                            <div class="list-besoin">
                                <div class="">
                                    <h6 class="mb-0"> Actions Rapides</h6>
                                </div>
                                <div class="">
                                    <div class="">
                                        <a href="{{ route('besoins.edit', $besoin) }}" 
                                           class="btn btn-warning btn-sm d-grid mb-2">
                                             Modifier le Statut
                                        </a>
                                        @if($besoin->etudiant && $besoin->etudiant->email)
                                        <a href="mailto:{{ $besoin->etudiant->email }}" 
                                           class="btn btn-info btn-sm ">
                                             Contacter l'Étudiant
                                        </a>
                                        @endif
                                        <form action="{{ route('besoins.destroy', $besoin) }}" 
                                              method="POST" class="d-grid">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce besoin ?')">
                                                 Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection