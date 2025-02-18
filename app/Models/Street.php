<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    use HasFactory;

    protected $table = 'streets';
    protected $fillable = ['name', 'name_ru', 'type', 'comment', 'code', 'district_id','user_id','created_from_outside'];

    public function aktivs()
    {
        return $this->hasMany(Aktiv::class, 'street_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function substreets()
    {
        return $this->hasMany(SubStreet::class, 'district_id', 'district_id');
    }
}
