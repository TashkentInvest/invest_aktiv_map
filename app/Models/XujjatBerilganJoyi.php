<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XujjatBerilganJoyi extends Model
{
    use HasFactory;

    protected $table = 'xujjat_berilgan_joyi';



    protected $fillable = ['name', 'comment'];

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

}
