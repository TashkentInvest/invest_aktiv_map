<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passport extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'passports';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'passport_serial',
        'passport_pinfl',
        'passport_raqami',
        'passport_date',
        'passport_location',
        'passport_type',
    ];

    /**
     * Get the client that owns the passport.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'passport_date' => 'date',
        'passport_type' => 'boolean',
    ];
}
