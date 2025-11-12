<?php


namespace App\Http\Controllers;
use App\Models\Etudiant;
use App\Models\Paiement;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptController extends Controller
{
    public function show($id)
    {
        $paiements = Paiement::with('etudiant')->findOrFail($id);
        return view('receipt.show', compact('paiements'));
    }

    public function download($id)
    {
        $paiements = Paiement::with('etudiant')->findOrFail($id);
        
        $pdf = Pdf::loadView('receipt.pdf', compact('paiements'));
        
        return $pdf->download('receipt-paiement-' . $paiements->id . '.pdf');
    }

    public function print($id)
    {
        $paiements = Paiement::with('etudiant')->findOrFail($id);
        
        $pdf = Pdf::loadView('receipt.pdf', compact('paiements'));
        
        return $pdf->stream('receipt-paiement-' . $paiements->id . '.pdf');
    }
}