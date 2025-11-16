@props(['etudiants' => []])
@extends('layouts.main')

@section('content')

<div class="inscription-container">
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
                    <div class="etu-content">
                        <div class="etudiant-title">
                            <h2>Gestion des Inscriptions</h2>
                            <a href="{{ route('etudiants.add') }}" class="etudiant-btn">Nouvelle Inscription</a>
                        </div>
                    </div>

                <!-- afficher la liste des étudiants inscrits avec leurs paiements -->
                 <div class="etudiants-list">
                    <h3>Liste des Étudiants Inscrits</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Module</th>
                                <th>Statut du Paiement</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($etudiants as $etudiant)
                            <tr>
                                <td>{{ $etudiant->nom }}</td>
                                <td>{{ $etudiant->prenom }}</td>
                                <td>{{ $etudiant->email}}</td>
                                <td>{{ $etudiant->modules_id }}</td>
                                <td>
                                    @if($etudiant->paiements->isNotEmpty())
                                        {{ $etudiant->paiements->last()->etat }}
                                    @else
                                        Aucun paiement
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                </div>
                <div class="footer">
                    <x-footer />
                </div>
                
            </aside>
        
</div>


@endsection
