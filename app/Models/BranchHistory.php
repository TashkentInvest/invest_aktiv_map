<?php

namespace App\Models;

use App\Services\HistoryService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class BranchHistory extends Model
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


    protected $table = 'branch_histories';

    protected $fillable = [
        'user_id', 'branch_id', 'field', 'old_value', 'new_value',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public static function saveHistory($branch_id, $field, $old_value, $new_value, $user_id)
    {
        Log::info("Attempting to save history for branch ID: $branch_id");
        Log::info("Field: $field, Old Value: $old_value, New Value: $new_value, User ID: $user_id");

        return self::create([
            'branch_id' => $branch_id,
            'field' => $field,
            'old_value' => $old_value,
            'new_value' => $new_value,
            'user_id' => $user_id,
        ]);
    }
}
