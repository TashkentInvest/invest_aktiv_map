<?php

namespace App\Models;

use App\Services\HistoryService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Districts extends Model
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

    protected $table = 'districts';

    protected $fillable = [
        'code',          // Add this line
        'name_uz',       // Add this line
        'region_id',     // Add this line
        // Add other fillable fields here as necessary
    ];
    public function region()
    {
        return $this->hasOne(Regions::class, 'id', 'region_id');
    }

    public function street()
    {
        return $this->hasOne(Street::class, 'district_id');
    }
    // District Model
    public function streets()
    {
        return $this->hasMany(Street::class, 'district_id');
    }


    public function users()
    {
        return $this->hasMany(User::class, 'district_id');
    }
    // Accessor for 'name' attribute
    public function getNameAttribute()
    {
        // Adjust based on your preferred language or logic
        return $this->name_uz ?? $this->name_ru;
    }
}
