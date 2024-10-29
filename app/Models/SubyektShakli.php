<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubyektShakli extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'name_ru',
        'description',
        'description_ru',
        'code',
    ];

    public function companies(){
        return $this->hasMany(Company::class,'subyekt_shakli_id');
    }
}
