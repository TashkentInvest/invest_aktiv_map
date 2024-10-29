<?php

namespace App\Models;

use App\Services\HistoryService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruxsatnoma extends Model
{
    use HasFactory;

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

    protected $table = 'ruxsatnomalar';


    protected $fillable = [
        'sub_street_id',
        'ruxsatnoma_turi_id',
        'ruxsatnoma_kim_tamonidan_id',
        'ruxsatnoma_berilgan_ish_turi_id',
        'ruxsat_etuvchi_hujjat_sanasi',
        'ruxsat_etuvchi_hujjat_raqami',
        'kadastr_raqami'
    ];

    public function substreet(){
        return $this->belongsTo(Substreet::class,'sub_street_id');
    }

    public function ruxsatnomaTuri(){
        return $this->belongsTo(RuxsatnomaTuri::class,'ruxsatnoma_turi_id');
    }

    public function ruxsatnomaBerilganIshTuri(){
        return $this->belongsTo(RuxsatnomaBerilganIshTuri::class,'ruxsatnoma_berilgan_ish_turi_id');
    }

    public function ruxsatnomaKimTamonidan(){
        return $this->belongsTo(RuxsatnomaKimTamonidan::class,'ruxsatnoma_kim_tamonidan_id');
    }


}
