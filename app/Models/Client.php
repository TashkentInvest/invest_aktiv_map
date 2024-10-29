<?php

namespace App\Models;

use App\Services\HistoryService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SubStreet;


class Client extends Model
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

    protected $table = 'clients';

    protected $casts = [
        'birth_date' => 'date'
    ];
    protected $fillable = [
        'user_id', 'action', 'action_timestamp', 'mijoz_turi', 'last_name', 'first_name', 'father_name', 'birth_date', 'contact','contact2',
        'email', 'stir', 'client_description', 'category_id', 'created_by_client', 'confirmed_for_client',
        'uniqe_code', 'sub_street_id', 'xujjat_berilgan_joyi_id', 'xujjat_turi_id','home_number',' apartment_number'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $latestOrder = static::latest()->first();

            if ($latestOrder) {
                $latestCode = $latestOrder->unique_code;
                preg_match('/\d+$/', $latestCode, $matches);
                $lastNumber = (int) $matches[0];
            } else {
                $lastNumber = -1;
            }

            $model->unique_code = 'Subyekt_' . str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
        });
    }

    public function xujjatTuri()
    {
        return $this->belongsTo(XujjatTuri::class, 'xujjat_turi_id');
    }

    public function xujjatBerilganJoy()
    {
        return $this->belongsTo(XujjatBerilganJoyi::class, 'xujjat_berilgan_joyi_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function substreet()
    {
        return $this->belongsTo(Substreet::class, 'sub_street_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function confirmations()
    {
        return $this->hasMany(Confirm::class);
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function passport()
    {
        return $this->hasOne(Passport::class);
    }


    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function passportHistories()
    {
        return $this->hasMany(PassportHistory::class);
    }

    public function fileHistories()
    {
        return $this->hasMany(FileHistory::class);
    }

    public function companyHistories()
    {
        return $this->hasMany(CompanyHistory::class);
    }

    public function branchHistories()
    {
        return $this->hasMany(BranchHistory::class, 'client_id');
    }

    public function addressHistories()
    {
        return $this->hasMany(AddressHistory::class);
    }

    public function clientHistories()
    {
        return $this->hasMany(ClientHistory::class);
    }
    public static function deepFilters()
    {

        $tiyin = [];

        $obj = new self();
        $request = request();

        $query = self::where('id', '!=', '0');

        foreach ($obj->fillable as $item) {

            // dump($item);


            $operator = $item . '_operator';

            // Search relationed company ***********************************************

            if ($request->filled('company_name')) {
                $operator = $request->input('company_operator', 'like');
                $value = '%' . $request->input('company_name') . '%';

                $query->whereHas('company', function ($query) use ($operator, $value) {
                    $query->where('company_name', $operator, $value);
                });

                // Continue with other filters...
            }


            // END Search relationed company ***********************************************

            // Search relationed category ***********************************************
            if ($request->filled('stir')) {
                $operator = $request->input('stir_operator', 'like');
                $value = '%' . $request->input('stir') . '%';

                $query->whereHas('company', function ($q) use ($operator, $value) {
                    $q->where('stir', $operator, $value);
                });

                continue;
            }

            // Passport serial
            if ($request->filled('passport_serial')) {
                $operator = $request->input('passport_operator', 'like');
                $value = '%' . $request->input('passport_serial') . '%';

                $query->whereHas('passport', function ($query) use ($operator, $value) {
                    $query->where('passport_serial', $operator, $value);
                });

                continue;
            }


            // Passport pinfl
            if ($request->filled('passport_pinfl')) {
                $operator = $request->input('passport_operator', 'like');
                $value = '%' . $request->input('passport_pinfl') . '%';

                $query->whereHas('passport', function ($query) use ($operator, $value) {
                    $query->where('passport_pinfl', $operator, $value);
                });

                continue;
            }



            // END Search relationed category ***********************************************



            if ($request->has($item) && $request->$item != '') {


                if (isset($tiyin[$item])) {
                    $select = $request->$item * 100;
                    $select_pair = $request->{$item . '_pair'} * 100;
                } else {
                    $select = $request->$item;
                    $select_pair = $request->{$item . '_pair'};
                }
                //set value for query
                if ($request->has($operator) && $request->$operator != '') {
                    if (strtolower($request->$operator) == 'between' && $request->has($item . '_pair') && $request->{$item . '_pair'} != '') {
                        $value = [
                            $select,
                            $select_pair
                        ];

                        $query->whereBetween($item, $value);
                    } elseif (strtolower($request->$operator) == 'wherein') {
                        $value = explode(',', str_replace(' ', '', $select));
                        $query->whereIn($item, $value);
                    } elseif (strtolower($request->$operator) == 'like') {
                        if (strpos($select, '%') === false)
                            $query->where($item, 'like', '%' . $select . '%');
                        else
                            $query->where($item, 'like', $select);
                    } else {
                        $query->where($item, $request->$operator, $select);
                    }
                } else {
                    $query->where($item, $select);
                }
            }
        }

        return $query;
    }

    public function orders()
    {
        return $this->hasOne(Order::class, 'client_id');
    }



    public function creditTransactions()
    {
        return $this->hasMany(CreditTransaction::class, 'payer_inn', 'stir');
    }
}
