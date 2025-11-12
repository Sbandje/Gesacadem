@extends('layouts.main')

@section('title', 'Tableau de Bord - Besoins des Étudiants')

@section('content')

<div class="index-class">
    <div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1> Gestion des Besoins des Étudiants</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('besoins.create') }}" class="btn btn-primary">
                 Nouveau Besoin
            </a>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="mb-0"> Filtres</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('besoins.index') }}" method="GET" class="row g-3">
                @csrf
                <div class="col-md-3">
                    <label for="statut" class="form-label">Statut</label>
                    <select name="statut" id="statut" class="form-select">
                        <option value="">Tous les statuts</option>
                        <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="en_cours" {{ request('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                        <option value="résolu" {{ request('statut') == 'résolu' ? 'selected' : '' }}>Résolu</option>
                        <option value="rejeté" {{ request('statut') == 'rejeté' ? 'selected' : '' }}>Rejeté</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="priorite" class="form-label">Priorité</label>
                    <select name="priorite" id="priorite" class="form-select">
                        <option value="">Toutes les priorités</option>
                        <option value="faible" {{ request('priorite') == 'faible' ? 'selected' : '' }}>Faible</option>
                        <option value="moyenne" {{ request('priorite') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                        <option value="élevée" {{ request('priorite') == 'élevée' ? 'selected' : '' }}>Élevée</option>
                        <option value="urgent" {{ request('priorite') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="type" class="form-label">Type</label>
                    <select name="type" id="type" class="form-select">
                        <option value="">Tous les types</option>
                        @foreach($typesBesoin as $key => $value)
                        <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="etudiant_id" class="form-label">Étudiant</label>
                    <select name="etudiant_id" id="etudiant_id" class="form-select">
                        <option value="">Tous les étudiants</option>
                        @foreach($etudiants as $etudiant)
                        <option value="{{ $etudiant->id }}" {{ request('etudiant_id') == $etudiant->id ? 'selected' : '' }}>
                            {{ $etudiant->nom }} {{ $etudiant->prenom }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary">Filtrer</button>
                    <a href="{{ route('besoins.index') }}" class="btn btn-secondary">Réinitialiser</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Cartes de statistiques rapides -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $statistiques['total'] }}</h4>
                            <small>Total Besoins</small>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $statistiques['en_attente'] }}</h4>
                            <small>En Attente</small>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $statistiques['urgents'] }}</h4>
                            <small>Urgents</small>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $statistiques['resolus'] }}</h4>
                            <small>Résolus</small>
                        </div>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des besoins -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Liste des Besoins</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Étudiant</th>
                            <th>Type</th>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Priorité</th>
                            <th>Statut</th>
                            <th>Coût Estimé</th>
                            <th>Date Limite</th>
                            <th>Créé le</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($besoins as $besoin)
                        <tr class="{{ $besoin->est_urgent ? 'table-danger' : '' }}">
                            <td>
                                <strong>{{ $besoin->etudiant->nom ?? 'N/A' }} {{ $besoin->etudiant->prenom ?? '' }}</strong>
                                <br>
                                <small class="text-muted">{{ $besoin->etudiant->email ?? 'Email non disponible' }}</small>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $besoin->type_besoin }}</span>
                            </td>
                            <td>
                                <strong>{{ $besoin->titre }}</strong>
                                @if($besoin->est_urgent)
                                <span class="badge bg-danger">URGENT</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($besoin->description, 80) }}</td>
                            <td>
                                <span class="badge bg-{{ $besoin->couleur_priorite }}">
                                    {{ $besoin->priorite }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $besoin->couleur_statut }}">
                                    {{ $besoin->icone_statut }} {{ $besoin->statut }}
                                </span>
                            </td>
                            <td>
                                @if($besoin->cout_estime)
                                {{ number_format($besoin->cout_estime, 2, ',', ' ') }} FCFA
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($besoin->date_limite)
                                {{ $besoin->date_limite->format('d/m/Y') }}
                                @if($besoin->est_urgent)
                                <br><small class="text-danger">⚠ Dépassée</small>
                                @endif
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $besoin->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('besoins.show', $besoin) }}" 
                                       class="btn btn-info" title="Voir">
                                        
                                    </a>
                                    <a href="{{ route('besoins.edit', $besoin) }}" 
                                       class="btn btn-warning" title="Modifier">
                                        
                                    </a>
                                    <form action="{{ route('besoins.destroy', $besoin) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" 
                                                title="Supprimer"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce besoin ?')">
                                            
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <br>
                                Aucun besoin trouvé
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <p class="mb-0">
                        Affichage de {{ $besoins->firstItem() }} à {{ $besoins->lastItem() }} 
                        sur {{ $besoins->total() }} besoins
                    </p>
                </div>
                <div>
                    {{ $besoins->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
