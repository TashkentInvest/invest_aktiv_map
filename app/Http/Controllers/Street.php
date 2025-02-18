<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    use HasFactory;

    protected $table = 'streets';
    protected $fillable = ['name', 'yer_maydoni', 'latitude', 'longitude', 'district_id'];
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function aktivs()
    {
        return $this->hasMany(Aktiv::class, 'street_id');
    }
}
