@extends('layouts.main')

    @section('content')
        <title>Reçu de Paiement #{{ str_pad($paiements->id, 6, '0', STR_PAD_LEFT) }}</title>
    
        <div class="header">
            <h1>REÇU DE PAIEMENT</h1>
            <h2>École Gesacadem</h2>
        </div>

        <div class="info">
            <p><strong>Numéro de reçu:</strong> #{{ str_pad($paiements->id, 6, '0', STR_PAD_LEFT) }}</p>
            <p><strong>Date d'émission:</strong> {{ now()->format('d/m/Y H:i') }}</p>
        </div>

        <div class="info">
            <h3>Informations de l'étudiant</h3>
            <p><strong>Nom:</strong> {{ $paiements->etudiant->nom }} {{ $paiements->etudiant->prenom }}</p>
            <p><strong>Email:</strong> {{ $paiements->etudiant->email }}</p>
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
                    <td>{{ number_format($paiements->montant, 2, ',', ' ') }} FCFA</td>
                    <td>{{ ucfirst($paiements->mode_paiement) }}</td>
                    <td>{{ \Carbon\Carbon::parse($paiements->date_paiement)->format('d/m/Y') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="total">
            <p>Total payé: {{ number_format($paiements->montant, 2, ',', ' ') }} FCFA</p>
        </div>

        <div class="footer">
            <p><em>Ce document fait foi de paiement</em></p>
            <p>École Gesacadem - Tél: +33 1 23 45 67 89</p>
            <p>Signature:</p>
            <br><br>
            <p>___________________________________</p>
        </div>
    @endsection

