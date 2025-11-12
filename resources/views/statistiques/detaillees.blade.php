@extends('layouts.main')

@section('content')
    <div class="header">
        <h1> Statistiques Détaillées par Niveau</h1>
    </div>

    <!-- Filtres -->
    <div class="filters">
        <form action="{{ route('statistiques.detaillees') }}" method="GET" class="filter-form">
            <div class="form-group">
                <label for="niveau_id">Niveau</label>
                <select name="niveau_id" id="niveau_id" class="form-control">
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
            
            <div class="form-group">
                <div class="actions">
                    <button type="submit" class="btn btn-primary"> Filtrer</button>
                    <a href="{{ route('statistiques.detaillees') }}" class="btn btn-reset"> Réinitialiser</a>
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
                <td><strong>{{ $stat['niveaux']->nom }}</strong></td>
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

@endsection
