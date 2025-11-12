@extends('layouts.main')

@section('content')
<div class="receipt-content">

    <div class="dash">
        <!-- Faire appelle au user en lui disans bienvenue -->
        <div class="dash-content">
            <main>
                <x-sidebar />
            </main>
            <aside class="dashboard-content">
                <div class="actions">
                    <a href="{{ route('receipt.download', $paiement->id) }}" class="btn btn-primary">
                        <i class="fa-solid fa-download"></i> Télécharger le PDF
                    </a>
                    <a href="{{ route('receipt.print', $paiement->id) }}" class="btn btn-success">
                        <i class="fa-solid fa-print"></i> Imprimer le reçu
                    </a>
                    <a href="{{ route('paiements.create') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Nouveau paiement
                    </a>
                </div>

            <div class="receipt">
                <h2>Reçu de Paiement</h2>

                <p><strong>Nom de l'étudiant :</strong> {{ $paiement->etudiant->nom }}</p>
                <p><strong>Montant payé :</strong> {{ number_format($paiement->montant, 2) }} EUR</p>
                <p><strong>Date de paiement :</strong> {{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') }}</p>
                <p><strong>Mode de paiement :</strong> {{ ucfirst(str_replace('_', ' ', $paiement->mode_paiement)) }}</p>

                <p>Merci pour votre paiement!</p>
            </div>

                <div class="header">
                    <h1>REÇU DE PAIEMENT</h1>
                    <h3>École Gesacadem</h3>
                </div>

                <div class="info">
                    <p><strong>Numéro de reçu:</strong> #{{ str_pad($paiement->id, 6, '0', STR_PAD_LEFT) }}</p>
                    <p><strong>Date d'émission:</strong> {{ now()->format('d/m/Y H:i') }}</p>
                    <p><strong>Statut:</strong> 
                        <span class="statut-{{ $paiement->statut }}">
                            {{ $paiement->statut == 'soldé' ? '✅ Paiement soldé' : '⏳ Paiement partiel' }}
                        </span>
                    </p>
                </div>

                <div class="info">
                    <h3>Informations de l'étudiant</h3>
                    <p><strong>Nom:</strong> {{ $paiement->etudiant->nom }} {{ $paiement->etudiant->prenom }}</p>
                    <p><strong>Email:</strong> {{ $paiement->etudiant->email }}</p>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Montant</th>
                            <th>Mode de paiement</th>
                            <th>Date de paiement</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Frais de scolarité</td>
                            <td>{{ number_format($paiement->montant, 2, ',', ' ') }} FCFA</td>
                            <td>{{ ucfirst($paiement->mode_paiement) }}</td>
                            <td>{{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="receipt-footer">
                    <p><strong>Total payé:</strong> {{ number_format($paiement->montant, 2, ',', ' ') }} FCFA</p>
                    <p><em>Merci pour votre confiance !</em></p>
                    <p>École Gesacadem - Tél: +33 1 23 45 67 89</p>
                </div>

            </div>
            </aside>
        </div>
    </div>
    

@endsection