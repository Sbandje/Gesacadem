<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $table = 'receipts';

    protected $fillable = [
        'paiement_id',
        'etudiant_id',
        'date_issued',
        'amount',
        'payment_method',
    ];

    public function paiement()
    {
        return $this->belongsTo(Paiement::class, 'paiement_id');
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_id');
    }
}
