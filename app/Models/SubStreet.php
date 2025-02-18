<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubStreet extends Model
{
    use HasFactory;

    protected $table = 'sub_streets';
    protected $fillable = ['name', 'name_ru', 'type', 'comment', 'code', 'district_id', 'street_id', 'user_id', 'created_from_outside'];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id','id');
    }

    public function street()
    {
        return $this->belongsTo(Street::class, 'street_id', 'id');
    }
}
