<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebetTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_number',
        'operation_code',
        'payer_name',
        'payer_inn',
        'payer_mfo',
        'payer_account',
        'payment_date',
        'operation_day',
        'payment_description',
        'debit',
        'credit',
        'recipient_name',
        'recipient_inn',
        'recipient_mfo',
        'recipient_bank',
        'recipient_account',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'debet_transaction_id');
    }
}
