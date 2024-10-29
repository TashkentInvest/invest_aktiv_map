<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ko extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'coefficient'];

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

}
