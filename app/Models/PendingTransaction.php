<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingTransaction extends Model
{
    protected $table = 'pending_transactions';
    #use HasFactory;
    protected $fillable = [
        'reference', 'type', 'compte', 'montant', 'etat', 'description', 'initiated_by','date_transaction',
    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'initiated_by');
    }
}
