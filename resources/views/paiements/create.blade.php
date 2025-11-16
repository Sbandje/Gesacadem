@props(['etudiants' => [], 'niveaux' => []])

@extends('layouts.main')

@section('content')

    <div class="add-paiements">
        <h2>Ajouter un paiement</h2>

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('paiements.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="etudiants_id">Nom de l'étudiant</label>
                <select name="etudiants_id" id="etudiants_id" required>
                    <option value="">-- Choisir un étudiant --</option>
                    @foreach($etudiants as $etudiant)
                        <option value="{{ $etudiant->id }}" {{ old('etudiants_id') == $etudiant->id ? 'selected' : '' }}>
                            {{ $etudiant->nom }} {{ $etudiant->prenom }} 
                            @if($etudiant->niveau)
                                ({{ $etudiant->niveau->libelle }})
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="niveaux_id">Niveau</label>
                <select name="niveaux_id" id="niveaux_id" required>
                    <option value="">-- Choisir un niveau --</option>
                    @foreach($niveaux as $niveau)
                        <option value="{{ $niveau->id }}" 
                                data-montant="{{ $niveau->montant_fixe }}"
                                {{ old('niveaux_id') == $niveau->id ? 'selected' : '' }}>
                            {{ $niveau->nom }} - {{ number_format($niveau->montant_fixe, 0, ',', ' ') }} FCFA
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="montant">Montant Payé (FCFA)</label>
                <input type="number" step="0.01" id="montant" name="montant" value="{{ old('montant') }}" required>
                <small>Montant total pour ce niveau: <span id="montant_total_info">0</span> FCFA</small>
            </div>

            <div class="form-group">
                <label for="date_paiement">Date de paiement</label>
                <input type="date" id="date_paiement" name="date_paiement" required>
            </div>
            <div class="form-group">
                <label for="mode_paiement">Mode de paiement</label>
                <select name="mode_paiement" id="mode_paiement">
                    <option value="espece">Espèce</option>
                    <option value="carte_bancaire">Carte Bancaire</option>
                    <option value="virement_bancaire">Virement</option>
                </select>
            </div>

            
                    
            <button type="submit" class="register-btn">Ajouter un paiement</button>
        </form>
    </div>
    <script>
        document.getElementById('niveaux_id').addEventListener('change', function() {
            updateCalculs();
        });

        document.getElementById('montant').addEventListener('input', function() {
            updateCalculs();
        });

        function updateCalculs() {
            const niveauSelect = document.getElementById('niveaux_id');
            const montantInput = document.getElementById('montant');
            const selectedOption = niveauSelect.options[niveauSelect.selectedIndex];
            const montantTotal = selectedOption ? selectedOption.getAttribute('data-montant') : 0;
            const montantPaye = parseFloat(montantInput.value) || 0;
            
            if (montantTotal) {
                document.getElementById('montant_total_info').textContent = 
                    new Intl.NumberFormat('fr-FR').format(montantTotal);
                
                const reste = montantTotal - montantPaye;
                document.getElementById('reste_info').textContent = 
                    new Intl.NumberFormat('fr-FR').format(Math.max(0, reste));
                
                // Changer la couleur selon le reste
                const resteElement = document.getElementById('reste_info');
                if (reste <= 0) {
                    resteElement.style.color = 'green';
                    resteElement.innerHTML += ' (Soldé)';
                } else {
                    resteElement.style.color = 'orange';
                    resteElement.innerHTML += ' (Partiel)';
                }
            } else {
                document.getElementById('montant_total_info').textContent = '0';
                document.getElementById('reste_info').textContent = '0';
            }
        }

        // Déclencher l'événement au chargement
        updateCalculs();
    </script>
@endsection
