<?php

namespace App\Models;

use App\Services\HistoryService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    protected static function booted()
    {
        static::updated(function ($model) {
            $original = $model->getOriginal();
            $changes = $model->getChanges();

            HistoryService::record($model, $original, $changes);
        });

        static::deleted(function ($model) {
            History::create([
                'model_type' => get_class($model),
                'model_id' => $model->id,
                'field' => 'deleted',
                'old_value' => json_encode($model->getOriginal()), // Store old data as JSON
                'new_value' => null,
                'user_id' => auth()->id() ?? 1,
            ]);
        });
    }

    protected $table = 'companies'; 

    protected $fillable = [
        'client_id', 'subyekt_shakli_id', 'company_name', 'oked', 'bank_id','sub_street_id','home_number',' apartment_number'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
    public function substreet(){
        return $this->belongsTo(Substreet::class,'sub_street_id');
    }

    public function subyektShakli()
    {
        return $this->belongsTo(SubyektShakli::class, 'subyekt_shakli_id');
    }
}
