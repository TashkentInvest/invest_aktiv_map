<?php

namespace App\Models;

use App\Services\HistoryService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KengashXulosasi extends Model
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


    protected $table = 'kengash_xulosasi';

    protected $casts = [
        'bayon_sanasi' => 'date',
        'xulosa_sanasi' => 'date',
    ];

    protected $fillable = [
        'ariza_raqami',
        'bayon_raqami',
        'bayon_sanasi',
        'bayon_izoh',
        'xulosa_raqami',
        'xulosa_sanasi',
        'xulosa_izoh',
    ];

    public function shartnoma()
    {
        return $this->hasOne(Shartnoma::class);
    }
}