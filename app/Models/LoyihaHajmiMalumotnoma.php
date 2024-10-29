<?php

namespace App\Models;

use App\Services\HistoryService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyihaHajmiMalumotnoma extends Model
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


    protected $table = 'loyiha_hajmi_malumotnoma';

    protected $fillable = [
        'binoning_qurilish_hajmi',
        'ruxsatdan_tashqari_yuqori_hajm',
        'binoning_avtoturargoh_qismi_hajmi',
        'binoning_texnik_qavatlar_xonalar_hajmi',
        'turar_joy_binosining_umumiy_foydalanishdagi_qismi_hajmi',
        'branch_kubmetr',
        'qoshimcha_malumot',
        'obyekt_nomi',
        'geolokatsiya',
        'latitude',
        'longitude',
        'zone_name'
    ];
}
