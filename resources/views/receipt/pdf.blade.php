<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recu de paiement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        .header-pdf {
            text-align: center;
            margin-bottom: 20px;
        }
        .info {
            margin-bottom: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #014e30;
            color: white;
        }
        .total {
            text-align: right;
            font-size: 1.2em;
            margin-top: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>
<body>
        <div class="pdf-paiement">
            <title>Reçu de Paiement #{{ str_pad($paiements->id, 6, '0', STR_PAD_LEFT) }}</title>
    
            <div class="header-pdf">
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
                <p><em>Merci pour votre paiement !!!</em></p>
                <p>École Gesacadem - Tél: +228 70 09 3359</p>
                <p>Signature:</p>
                <br><br>
                <p>___________________________________</p>
            </div>
        </div>
</body>
</html>

