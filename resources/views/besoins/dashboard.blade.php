@extends('layouts.main')



@section('content')
<div class="dash">
        <!-- Faire appelle au user en lui disans bienvenue -->
        <div class="dash-content">
            <main>
                <x-sidebar />
            </main>
            <aside class="dashboard-content">
                <div class="navbar_content">
                    <x-navbar/>
                </div>
                <div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <h1 class="mb-4 text-center" id="besoin-title"> Besoins des Étudiants</h1>
                            </div>
                        </div>

                        <!-- Cartes de statistiques -->
                        <div class="row mb-4">
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center" id="total-besoins-card">
                                            
                                            <div class="" >
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Total des Besoins
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">
                                                    {{ $statistiques->total }}
                                                </div>
                                            </div>
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                    En Attente
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">
                                                    {{ $statistiques->en_attente }}
                                                </div>
                                            </div>
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-danger shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="">
                                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                    Urgents
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">
                                                    {{ $statistiques->urgents }}
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Résolus
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800 text-center">
                                                    {{ $statistiques->resolus }}
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Besoins urgents -->
                            <div class="col-lg-6 mb-4">
                                <div class="card shadow">
                                    <div class="card-header bg-danger text-white">
                                        <h6 class="m-0 font-weight-bold"> Besoins Urgents</h6>
                                    </div>
                                    <div class="card-body">
                                        @if($besoinsUrgents->count() > 0)
                                            @foreach($besoinsUrgents as $besoin)
                                            <div class="alert alert-danger alert-dismissible fade show mb-2" role="alert">
                                                <strong>{{ $besoin->titre }}</strong>
                                                <br>
                                                <small>
                                                    Étudiant: {{ $besoin->etudiant->nom }} {{ $besoin->etudiant->prenom }}
                                                         Priorité: <span class="badge bg-dark">{{ $besoin->priorite }}</span>
                                                    @if($besoin->date_limite)
                                                         Échéance: {{ $besoin->date_limite->format('d/m/Y') }}
                                                    @endif
                                                </small>
                                                <a href="{{ route('besoins.show', $besoin) }}" class="btn btn-sm btn-light float-end">
                                                    Voir
                                                </a>
                                            </div>
                                            @endforeach
                                        @else
                                            <p class="text-muted">Aucun besoin urgent pour le moment.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Répartition par type -->
                            <div class="col-lg-6 mb-4">
                                <div class="card shadow">
                                    <div class="card-header bg-info text-white">
                                        <h6 class="m-0 font-weight-bold"> Répartition par Type</h6>
                                    </div>
                                    <div class="card-body">
                                        @foreach($repartitionTypes as $type)
                                        <div class="mb-2">
                                            <div class="d-flex justify-content-between">
                                                <span>{{ $type->type_besoin }}</span>
                                                <span class="badge bg-primary">{{ $type->count }}</span>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-info" role="progressbar" 
                                                    style="width: {{ ($type->count / $statistiques->total) * 100 }}%">
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Besoins récents -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card shadow">
                                    <div class="card-header justify-content-between align-items-center">
                                        <h6 class="m-1 font-weight-bold"> Besoins Récents</h6>
                                        <a href="{{ route('besoins.create') }}" class="btn btn-light btn-sm">
                                            Ajouter un besoin
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Étudiant</th>
                                                        <th>Type</th>
                                                        <th>Titre</th>
                                                        <th>Priorité</th>
                                                        <th>Statut</th>
                                                        <th>Date</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($besoinsRecents as $besoin)
                                                    <tr>
                                                        <td>
                                                        <small>Niveau: {{ $besoin->etudiant->niveaux->libelle ?? 'Non assigné' }}</small>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-secondary">{{ $besoin->type_besoin }}</span>
                                                        </td>
                                                        <td>{{ Str::limit($besoin->titre, 50) }}</td>
                                                        <td>
                                                            <span class="badge bg-{{ $besoin->couleur_priorite }}">
                                                                {{ $besoin->priorite }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-{{ $besoin->couleur_statut }}">
                                                                {{ $besoin->statut }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $besoin->created_at->format('d/m/Y') }}</td>
                                                        <td>
                                                            <a href="{{ route('besoins.show', $besoin) }}" 
                                                            class="btn btn-sm btn-info">Voir</a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="footer-class">
                    <x-footer/>
                </div>
                
            </aside>
        </div>
    </div>

@endsection
