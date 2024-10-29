<?php

namespace App\Models;

use App\Services\HistoryService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EkspertizaXulosasi extends Model
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


    protected $table = 'ekspertiza_xulosasi';

    
    protected $casts = [
        'ekspertiza_xulosa_sanasi' => 'date',
    ];

    protected $fillable = [
        'tashkilot_nomi',
        'ekspertiza_xulosa_raqami',
        'ekspertiza_xulosa_sanasi',
        'shaffofdan_at_raqami',
        'shaffofdan_at_sanasi',
        'xulosa_izoh'

    ];

    public function shartnoma()
    {
        return $this->hasOne(Shartnoma::class);
    }
}
