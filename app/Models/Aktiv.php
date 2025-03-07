<?php

namespace App\Models;

use App\Services\HistoryService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aktiv extends Model
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
    public static function deepFilters()
    {
        $obj = new self();
        $request = request();

        // Debugging: Dump and Die to see the request data
        // dd($request->all());

        $query = self::query();

        foreach ($obj->fillable as $item) {
            if ($request->filled($item)) {
                $operator = $request->input($item . '_operator', 'like');
                $value = $request->input($item);

                if ($operator == 'like') {
                    $value = '%' . $value . '%';
                }

                $query->where($item, $operator, $value);
            }
        }

        if ($request->filled('kadastr_raqami')) {
            $operator = $request->input('kadastr_raqami_operator', 'like');
            $value = $request->input('kadastr_raqami');

            if ($operator == 'like') {
                $value = '%' . $value . '%';
            }

            $query->where('kadastr_raqami', $operator, $value);
        }
        if ($request->filled('building_type')) {
            $query->where('building_type', $request->input('building_type'));
        }

        return $query;
    }
    protected $fillable = [
        'user_id',
        'action',
        'action_timestamp',
        'object_name',
        'balance_keeper',
        'location',
        'land_area',
        'building_area',
        'gas',
        'water',
        'electricity',
        'additional_info',
        'geolokatsiya',
        'latitude',
        'longitude',
        'kadastr_raqami',
        'sub_street_id',
        'street_id',
        'building_type',
        'kadastr_pdf',
        'hokim_qarori_pdf',
        'transfer_basis_pdf'
    ];

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function substreet()
    {
        return $this->belongsTo(SubStreet::class, 'sub_street_id', 'id');
    }

    public function street()
    {
        return $this->belongsTo(Street::class, 'street_id', 'id');
    }


    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
