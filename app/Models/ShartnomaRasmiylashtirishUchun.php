<?php

namespace App\Models;

use App\Services\HistoryService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class ShartnomaRasmiylashtirishUchun extends Model
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

    protected $table = 'shartnoma_rasmiylashtirish_uchun';
    protected $fillable = [
        'user_id',
        'shartnoma_id',
        'sugurta_polisi_id',
        'bank_kafolati_id',
        'tolov_grafigi_id',
        'order_atkaz_id',
        'comment',
        'status'
    ];

    public function orderAtkaz()
    {
        return $this->belongsTo(OrderAtkaz::class, 'order_atkaz_id');
    }
    public function shartnoma()
    {
        return $this->belongsTo(Shartnoma::class);
    }

    public function sugurtaPolisi()
    {
        return $this->belongsTo(SugurtaPolisi::class);
    }

    public function bankKafolati()
    {
        return $this->belongsTo(BankKafolati::class);
    }

    public function tolovGrafigi()
    {
        return $this->belongsTo(TolovGrafigi::class);
    }
}
