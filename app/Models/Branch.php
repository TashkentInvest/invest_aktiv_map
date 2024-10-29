<?php

namespace App\Models;

use App\Services\HistoryService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SubStreet;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

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
        'user_id',
        'action',
        'action_timestamp',
        'client_id',
        'ruxsatnoma_id',
        'loyiha_hajmi_malumotnoma_id',
        'loyiha_hujjatlari_id',
        'sub_street_id',
        'kj_id',
        'kt_id',
        'kz_id',
        'ko_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function street()
    {
        return $this->belongsTo(Street::class);
    }

    public function orders()
    {
        return $this->hasOne(Order::class, 'branch_id','id');
    }


    // public function substreet()
    // {
    //     return $this->belongsTo(Substreet::class);
    // }

    public function substreet()
    {
        return $this->belongsTo(SubStreet::class, 'sub_street_id','id');
    }
    
    public function ruxsatnoma()
    {
        return $this->belongsTo(Ruxsatnoma::class);
    }

    public function loyihaHajmiMalumotnoma()
    {
        return $this->belongsTo(LoyihaHajmiMalumotnoma::class);
    }

    public function loyihaHujjatlari()
    {
        return $this->belongsTo(LoyihaHujjatlari::class);
    }
    public function kj()
    {
        return $this->belongsTo(Kj::class, 'kj_id');
    }

    public function kt()
    {
        return $this->belongsTo(Kt::class, 'kt_id');
    }

    public function ko()
    {
        return $this->belongsTo(Ko::class, 'ko_id');
    }

    public function kz()
    {
        return $this->belongsTo(Kz::class, 'kz_id');
    }

    public function shartnoma()
    {
        return $this->hasOne(Shartnoma::class, 'branch_id');
    }


    public function branchHistories()
    {
        return $this->hasMany(BranchHistory::class);
    }
}
