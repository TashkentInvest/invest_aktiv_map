<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XujjatTuri extends Model
{
    use HasFactory;

    protected $table = 'xujjat_turi';


    protected $fillable = ['name', 'comment'];

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

}
