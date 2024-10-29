<?php

namespace App\Models;

use App\Services\HistoryService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
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


    protected $fillable = ['user_id', 'action','comment', 'action_timestamp', 'uniqe_code', 'status', 'client_id', 'branch_id', 'order_atkaz_id'];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $yearSuffix = date('y');

            $latestOrder = static::latest('id')->first();

            if ($latestOrder) {
                $latestCode = $latestOrder->unique_code;
                preg_match('/(\d+)-\d+$/', $latestCode, $matches);
                $lastNumber = (int) $matches[1];
            } else {
                $lastNumber = 0;
            }

            $model->unique_code = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT) . '-' . $yearSuffix;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function orderAtkaz()
    {
        return $this->belongsTo(Branch::class, 'order_atkaz_id');
    }
}
