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
                    <h1>REÇU DE PAIEMENT</h1>
                    <h3>École Gesacadem</h3>
                </div>

                <!-- Informations du reçu -->
                <div class="info">
                    <p><strong>Numéro de reçu:</strong> #{{ str_pad($paiements->id, 6, '0', STR_PAD_LEFT) }}</p>
                    <p><strong>Date d'émission:</strong> {{ now()->format('d/m/Y H:i') }}</p>
                    
                    {{-- AFFICHAGE DU STATUT --}}
                    <p><strong>Statut:</strong> 
                        <span class="statut-{{ $paiements->statut }}">
                            {{ $paiements->statut == 'soldé' ? ' Paiement soldé' : ' Paiement partiel' }}
                        </span>
                    </p>
                </div>

                <!-- Informations de l'étudiant -->
                <div class="info">
                    <h3>Informations de l'étudiant</h3>
                    <p><strong>Nom:</strong> {{ $paiements->etudiant->nom }} {{ $paiements->etudiant->prenom }}</p>
                    <p><strong>Email:</strong> {{ $paiements->etudiant->email }}</p>
                </div>


                <!-- Détails financiers -->
                <table class="table">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Montant</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Montant total à payer</td>
                            <td>{{ number_format($paiements->montant_total, 2, ',', ' ') }} FCFA</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>Montant déjà payé</td>
                            <td>{{ number_format($paiements->montant, 2, ',', ' ') }} FCFA</td>
                            <td><i class="fa-solid fa-square-check"></i> Payé</td>
                        </tr>
                        <tr>
                            <td><strong>Reste à payer</strong></td>
                            <td><strong>{{ number_format($paiements->montant_total - $paiements->montant, 2, ',', ' ') }} FCFA</strong></td>
                            <td>
                                @if($paiements->reste_a_payer < $paiements->montant_total)
                                    <span class="statut-partiel"> En attente</span>
                                @else
                                    <span class="statut-solde"><i class="fa-solid fa-square-check"></i> Soldé</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Détails du dernier paiement -->
                <div class="info">
                    <h3>Dernier paiement effectué</h3>
                    <p><strong>Montant:</strong> {{ number_format($paiements->montant, 2, ',', ' ') }} FCFA</p>
                    <p><strong>Mode:</strong> {{ ucfirst($paiements->mode_paiement) }}</p>
                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($paiements->date_paiement)->format('d/m/Y') }}</p>
                </div>

                <div class="actions">
                    <a href="{{ route('receipt.download', $paiements->id) }}" class="btn btn-primary" id="download-btn">
                        <i class="fa-solid fa-download"></i> Télécharger le PDF
                    </a>
                    <a href="{{ route('receipt.print', $paiements->id) }}" class="btn btn-success" id="print-btn">
                        <i class="fa-solid fa-print"></i> Imprimer le reçu
                    </a>
                    <a href="{{ route('paiements.create') }}" class="btn btn-primary" id="new-payment-btn">
                        <i class="fa-solid fa-plus"></i> Nouveau paiement
                    </a>
                </div>

            </aside>
        </div>
    </div>
<div class="receipt-content">
    
</div>
@endsection

