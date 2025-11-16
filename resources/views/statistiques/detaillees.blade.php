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
                <div class="stat-content">
                    <div class="header-stat">
                        <h1> Statistiques Détaillées par Niveau</h1>
                    </div>

                    <div class="det-stat">
                        
                        
                            <!-- Filtres -->
                                <div class="filters">
                                    <form action="{{ route('statistiques.detaillees') }}" method="GET" class="filter-form">
                                    <div class="fil-stat">
                                        <div class="form-group">
                                            <label for="niveaux_id">Niveau</label>
                                            <select name="niveaux_id" id="niveaux_id" class="form-control">
                                                <option value="">Tous les niveaux</option>
                                                @foreach($tousLesNiveaux as $niveau)
                                                    <option value="{{ $niveau->id }}" 
                                                        {{ request('niveaux_id') == $niveau->id ? 'selected' : '' }}>
                                                        {{ $niveau->libelle }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="date_debut">Date de début</label>
                                            <input type="date" name="date_debut" id="date_debut" 
                                                value="{{ request('date_debut') }}" class="form-control">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="date_fin">Date de fin</label>
                                            <input type="date" name="date_fin" id="date_fin" 
                                                value="{{ request('date_fin') }}" class="form-control">
                                        </div>
                                    </div>
                                
                                <div class="form-group">
                                    <div class="actions">
                                        <button type="submit" class="btn btn-primary" id="filter-b"> Filtrer</button>
                                        <a href="{{ route('statistiques.detaillees') }}" class="btn btn-reset" id="rese-btn"> Réinitialiser</a>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Tableau des résultats -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Niveau</th>
                                    <th>Étudiants</th>
                                    <th>Paiements</th>
                                    <th>Cumul</th>
                                    <th>Moyenne/Étudiant</th>
                                    <th>Dernier paiement</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statistiques as $stat)
                                <tr>
                                    <td><strong>{{ $stat['niveaux']->libelle }}</strong></td>
                                    <td>{{ $stat['nombre_etudiants'] }}</td>
                                    <td>{{ $stat['nombre_paiements'] }}</td>
                                    <td class="montant">{{ number_format($stat['cumul_paiements'], 2, ',', ' ') }} FCFA</td>
                                    <td class="montant">{{ number_format($stat['moyenne_par_etudiant'], 2, ',', ' ') }} FCFA</td>
                                    <td>
                                        @if(count($stat['paiements_filtres']) > 0)
                                            {{ collect($stat['paiements_filtres'])->last()->date_paiement->format('d/m/Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div>
                    <x-footer />
                </div>
            </aside>
        </div>
    </div>


    

@endsection
