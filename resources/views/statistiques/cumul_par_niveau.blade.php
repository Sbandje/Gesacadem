@extends('layouts.main')
@section('content')


 <div class="dash">
        <!-- Faire appelle au user en lui disans bienvenue -->
        <div class="dash-content">
            <main>
                <x-sidebar />
            </main>
            <aside class="dashboard-content">
                <div class="header">
                    <h1> Cumul des Paiements par Niveau</h1>
                    <p>École Gesacadem - Gestion des paiements</p>
                </div>

                <div class="actions-button">
                    <a href="{{ route('statistiques.detaillees') }}" class="btn btn-primary" id="sta-det">
                        Statistiques Détaillées
                    </a>
                    <a href="{{ route('statistiques.export.pdf') }}" class="btn btn-success" id="pdf-sta">
                        Exporter en PDF
                    </a>
                </div>

                <div class="cumul-pay">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Niveau</th>
                                <th>Nombre d'Étudiants</th>
                                <th>Cumul des Paiements</th>
                                <th>Moyenne par Étudiant</th>
                                <th>Pourcentage</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($statistiques as $stat)
                            <tr>
                                <td>
                                    <strong>{{ $stat['niveaux']->libelle }}</strong>
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $stat['nombre_etudiants'] }} étudiant(s)</span>
                                </td>
                                <td class="montant">
                                    <strong>{{ number_format($stat['cumul_paiements'], 2, ',', ' ') }} FCFA</strong>
                                </td>
                                <td class="montant">
                                    {{ number_format($stat['moyenne_par_etudiant'], 2, ',', ' ') }} FCFA
                                </td>
                                <td>
                                    @if($totalGeneral > 0)
                                        @php
                                            $pourcentage = ($stat['cumul_paiements'] / $totalGeneral) * 100;
                                        @endphp
                                        <div style="background-color: #e9ecef; border-radius: 4px; height: 20px;">
                                            <div style="background-color: #007bff; height: 100%; border-radius: 4px; width: {{ $pourcentage }}%; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px;">
                                                {{ round($pourcentage, 1) }}%
                                            </div>
                                        </div>
                                    @else
                                        0%
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('statistiques.detaillees', ['niveaux_id' => $stat['niveaux']->id]) }}" 
                                    class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">
                                        Détails
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="total-row">
                                <td><strong>TOTAL GÉNÉRAL</strong></td>
                                <td>
                                    @php
                                        $totalEtudiants = array_sum(array_column($statistiques, 'nombre_etudiants'));
                                    @endphp
                                    <strong>{{ $totalEtudiants }} étudiant(s)</strong>
                                </td>
                                <td class="montant">
                                    <strong>{{ number_format($totalGeneral, 2, ',', ' ') }} FCFA</strong>
                                </td>
                                <td class="montant">
                                    @if($totalEtudiants > 0)
                                        <strong>{{ number_format($totalGeneral / $totalEtudiants, 2, ',', ' ') }} FCFA</strong>
                                    @else
                                        0 FCFA
                                    @endif
                                </td>
                                <td>100%</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="info">
                    <h3> Résumé</h3>
                    <p><strong>Total des paiements:</strong> {{ number_format($totalGeneral, 2, ',', ' ') }} FCFA</p>
                    <p><strong>Nombre total d'étudiants:</strong> {{ $totalEtudiants }}</p>
                    <p><strong>Moyenne générale:</strong> 
                        @if($totalEtudiants > 0)
                            {{ number_format($totalGeneral / $totalEtudiants, 2, ',', ' ') }} FCFA par étudiant
                        @else
                            0 FCFA
                        @endif
                    </p>
                </div>
            </aside>
        </div>
    </div>

    
@endsection