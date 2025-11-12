@props(['inscriptions' => []])

@extends('layouts.main')

@section('register')
    <div class="dash">
        <!-- Faire appelle au user en lui disans bienvenue -->
        <div class="dash-content">
            <main>
                <x-sidebar />
            </main>
            <aside class="dashboard-content">
                <div class="regis-div">
                    <h1>Voir tous les inscriptions effectuées</h1>

                    <div class="inscriptions-list">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Email</th>
                                        <th>Date de Naissance</th>
                                        <th>Niveau</th>
                                        <th>Module</th>
                                        <th>Date de Début</th>
                                        <th>Date de Fin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($inscriptions) && $inscriptions->count() > 0)
                                    @foreach($inscriptions as $inscription)
                                        <tr>
                                            <td>{{ $inscription->nom }}</td>
                                            <td>{{ $inscription->prenom }}</td>
                                            <td>{{ $inscription->email }}</td>
                                            <td>{{ $inscription->date_naissance }}</td>
                                            <td>{{ $inscription->niveau }}</td>
                                            <td>{{ $inscription->module }}</td>
                                            <td>{{ $inscription->date_debut }}</td>
                                            <td>{{ $inscription->date_fin }}</td>
                                        </tr>
                                    @endforeach
                                    @else
                                        <p>Aucune inscription trouvée.</p>
                                    @endif
                                </tbody>
                            </table>
                       
                </div>
            </aside>
        </div>
    </div>
@endsection
