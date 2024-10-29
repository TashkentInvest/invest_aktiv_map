<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aktiv extends Model
{
    use HasFactory;


    protected $fillable = [
        'address',
        'object_name',
        'balance_keeper',
        'location',
        'land_area',
        'building_area',
        'gas',
        'water',
        'electricity',
        'additional_info',
        'location_info',
    ];

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
