<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubStreet extends Model
{
    use HasFactory;

    protected $table = 'sub_streets';
    protected $fillable = ['name', 'name_ru', 'type', 'comment', 'code', 'district_id'];
    public function district()
    {
        return $this->belongsTo(Districts::class, 'district_id');
    }

    public function banks()
    {
        return $this->hasMany(Bank::class);
    }
    public function clients()
    {
        return $this->hasMany(Client::class);
    }
    public function companies()
    {
        return $this->hasMany(Company::class);
    }
    public function ruxsatnomalar()
    {
        return $this->hasMany(Ruxsatnoma::class);
    }
}
