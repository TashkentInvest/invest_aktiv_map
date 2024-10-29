<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditTransaction extends Model
{
    use HasFactory;

    protected $table = 'credit_transactions';   

    protected $fillable = [
        'document_number',
        'operation_code',
        'recipient_name',
        'recipient_inn',
        'recipient_mfo',
        'recipient_account',
        'payment_date',
        'payment_description',
        'debit',
        'credit',
        'payer_name',
        'payer_inn',
        'payer_mfo',
        'payer_bank',
        'payer_account',
    ];
    public static function deepFilters()
    {

        $tiyin = [];

        $obj = new self();
        $request = request();

        $query = self::where('id', '!=', '0');

        foreach ($obj->fillable as $item) {
            //request operator key
            $operator = $item . '_operator';

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

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'debet_transaction_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'payer_inn', 'stir');
    }
}
