<?php

namespace App\Models;

use App\Services\HistoryService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtMaLumotlari extends Model
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


    protected $table = 'art_ma_lumotlari';

    protected $casts = [
        'art_sanasi' => 'date',
        'ariza_sanasi' => 'date',
    ];


    protected $fillable = [
        'ariza_raqami',
        'ariza_sanasi',
        'art_raqami',
        'art_sanasi',
        'xulosa_izoh'
    ];

    public function shartnoma()
    {
        return $this->hasOne(Shartnoma::class);
    }
}
