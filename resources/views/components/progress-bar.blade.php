

<div class="progress-container">
    <!-- Barre de progression -->
    <div class="progress" style="height: 20px;">
        <div class="progress-bar bg-{{ $couleur }}"
             role="progressbar" 
             style="width: {{ $pourcentage }}%;"
             aria-valuenow="{{ $pourcentage }}" 
             aria-valuemin="0" 
             aria-valuemax="100">
            {{ $pourcentage }}%
        </div>
    </div>

    <!-- Détails optionnels -->
    @if($showDetails && $montantTotal)
    <div class="progress-details mt-2">
        <small class="text-muted">
            <strong>Payé:</strong> {{ number_format($montantPaye, 2, ',', ' ') }} € / 
            <strong>Total:</strong> {{ number_format($montantTotal, 2, ',', ' ') }} € |
            <strong>Reste:</strong> {{ number_format($resteAPayer, 2, ',', ' ') }} €
        </small>
    </div>
    @endif

    <!-- Statut textuel -->
    <div class="progress-status mt-1">
        @if($pourcentage == 0)
            <span class="badge bg-danger">Non payé</span>
        @elseif($pourcentage == 100)
            <span class="badge bg-success">Soldé ✓</span>
        @else
            <span class="badge bg-warning">En cours ({{ $pourcentage }}%)</span>
        @endif
    </div>
</div>

<style>
.progress-container {
    margin: 10px 0;
}
.progress {
    background-color: #e9ecef;
    border-radius: 4px;
    overflow: hidden;
}
.progress-bar {
    transition: width 0.6s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: bold;
}
.badge {
    font-size: 11px;
}
</style>