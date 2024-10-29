<?php

namespace App\Models;

use App\Services\HistoryService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObyektBoyicha extends Model
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


    protected $fillable = [
        'ruhsatnoma_uchun_ariza',
        'ruhsatnoma',
        'art_uchun_ariza',
        'art',
        'kengash_xulosasi',
        'ekspertiza_xulosasi',
        'loyiha_hujjatlari',
        'dakn_gasn_qurilishi_uchun_ariza',
        'dakn_gasn_ko_chirma',
        'tolov_habarnomalari',
    ];
}
