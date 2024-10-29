<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aktiv extends Model
{
    use HasFactory;

    protected $fillable = [
        'object_name',
        'balance_keeper',
        'location',
        'land_area',
        'building_area',
        'gas',
        'water',
        'electricity',
        'additional_info',
        'zone_name',
        'geolokatsiya',
        'latitude',
        'longitude',
    ];

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
