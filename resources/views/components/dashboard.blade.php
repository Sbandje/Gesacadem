@props([
    'totalEtudiants' => 0,
    'totalPaiements' => 0,
    'besoinsEnAttente' => 0,
    'recentEtudiants' => [],
    'totalBesoins' => 0,
    'besoinsUrgents' => [],
    'recentPaiements' => [],
])

<div id="dashboard" class="content-section">
                    
<div class="row mb-4">
    <h2 class="text">Tableau de bord</h2>
    <div class="col-md-3">
        <div class="card stat-card">
            <i class="fas fa-user-graduate"></i>
            <!-- afficher le total paiement -->

            <div class="number" >{{ $totalEtudiants }}</div>
            <div class="label">Étudiants inscrits</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card">
            <i class="fas fa-money-bill-wave"></i>
            <div class="number">{{ number_format($totalPaiements, 0, ',', ' ') }}</div>
            <div class="label">Total des paiements</div>
        </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <i class="fas fa-clock"></i>
                <div class="number">{{ $besoinsEnAttente  }}</div>
                <div class="label">Besoins en attente</div>
            </div>
        </div>
    </div>

</div>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success')}}</div>
        @endif
    <div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Nombre d'etudiants par niveau</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="paymentsChart" height="250"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Etudiants inscrits dans la semaine</h5>
                    </div>
                    <div class="card-body">
                       <table class="table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Niveau</th>
                                <th>Date d'inscription</th>
                                <th>Détails</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                                 @forelse($recentEtudiants as $etudiant)
                               <tr>
                                   
                                        <td>{{ $etudiant->nom ?? 'N/A'}}</td>
                                        <td>{{ $etudiant->niveau ?? 'N/A'}}</td>
                                        <td>{{ $etudiant->created_at->format('Y-m-d') }}</td>
                                        <td><a href="#" class="icone"><i class="fa-solid fa-info"></i></a></td>
                               
                                    
                               
                                @empty
                                <td colspan="4">Aucun étudiant récent.</td>
                                </tr>
                                @endforelse
                            
                            
                        </tbody>
                       </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

