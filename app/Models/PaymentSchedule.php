<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'shartnoma_id',
        'quarter',
        'payment_date',
        'payment_amount',
    ];

    
    protected $casts = [
        'payment_date' => 'date',
    ];

    public function shartnoma()
    {
        return $this->belongsTo(Shartnoma::class, 'shartnoma_id');
    }

    public function factPayments()
    {
        return $this->hasMany(FactPayment::class);
    }
}
