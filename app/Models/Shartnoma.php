<?php

namespace App\Models;

use App\Services\HistoryService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shartnoma extends Model
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


    protected $table = 'shartnoma';

    protected $fillable = [
        'shartnoma_raqami',
        'shartnoma_sanasi',
        'branch_id',
        'status',
        'art_ma_lumotlari_id',
        'kengash_xulosasi_id',
        'ekspertiza_xulosasi_id',
        'dakn_gasn_inspection_id',
    ];

    protected $casts = [
        'shartnoma_sanasi' => 'date',
    ];

    // old boot 1/24 like this format
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $yearSuffix = date('y');

    //         // Get the latest record with the same year suffix
    //         $latestOrder = static::where('shartnoma_raqami', 'like', '%/' . $yearSuffix)->latest('id')->first();

    //         if ($latestOrder) {
    //             $latestCode = $latestOrder->shartnoma_raqami;
    //             preg_match('/(\d+)\/' . $yearSuffix . '$/', $latestCode, $matches);
    //             $lastNumber = (int) $matches[1];
    //         } else {
    //             $lastNumber = 0;
    //         }

    //         // Generate the new unique code
    //         $model->shartnoma_raqami = ($lastNumber + 1) . '/' . $yearSuffix;
    //     });
    // }


    // NEW BOOOT FORMAT
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $year = date('Y');
    //         $branch = $model->branch;

    //         if ($branch && $branch->substreet && $branch->substreet->district) {
    //             $districtCode = $branch->substreet->district->code;
    //         } else {
    //             $districtCode = 'UNK';
    //         }

    //         $latestOrder = static::where('shartnoma_raqami', 'like', "$year-%-$districtCode-%")
    //                             ->latest('id')
    //                             ->first();

    //         if ($latestOrder) {
    //             $latestCode = $latestOrder->shartnoma_raqami;
    //             preg_match('/(\d+)-' . $year . '-(' . $districtCode . ')-(\d+)$/', $latestCode, $matches);
    //             $lastNumber = (int) $matches[3];
    //         } else {
    //             $lastNumber = 0;
    //         }

    //         // Generate the new unique code
    //         $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
    //         $model->shartnoma_raqami = "$year-A-$districtCode-$newNumber";
    //     });
    // }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $year = date('Y');
            $branch = $model->branch;

            if ($branch && $branch->substreet && $branch->substreet->district) {
                $districtCode = $branch->substreet->district->code;
            } else {
                $districtCode = 'UNK';
            }

            // Fetch the latest order
            $latestOrder = static::where('shartnoma_raqami', 'like', "$year-%-$districtCode-%")
                ->latest('id')
                ->first();

            // Initialize lastNumber to 0
            $lastNumber = 0;

            if ($latestOrder) {
                $latestCode = $latestOrder->shartnoma_raqami;
                // Perform regex match
                if (preg_match('/(\d+)-' . $year . '-(' . $districtCode . ')-(\d+)$/', $latestCode, $matches)) {
                    // Check if the expected match groups are available
                    if (isset($matches[3])) {
                        $lastNumber = (int) $matches[3];
                    }
                }
            }

            // Generate the new unique code
            $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
            $model->shartnoma_raqami = "$year-A-$districtCode-$newNumber";
        });
    }


    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function shartnoma_rasmiylashtirish_uchun()
    {
        return $this->hasOne(ShartnomaRasmiylashtirishUchun::class);
    }


    public function artMaLumotlari()
    {
        return $this->belongsTo(ArtMaLumotlari::class);
    }

    public function kengashXulosasi()
    {
        return $this->belongsTo(KengashXulosasi::class);
    }

    public function ekspertizaXulosasi()
    {
        return $this->belongsTo(EkspertizaXulosasi::class);
    }

    public function daknGasnInspection()
    {
        return $this->belongsTo(DaknGasnInspection::class);
    }

    public function tolovGrafigi()
    {
        return $this->hasOne(TolovGrafigi::class);
    }
}
