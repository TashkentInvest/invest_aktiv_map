<?php

namespace App\Models;

use App\Services\HistoryService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TolovGrafigi extends Model
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
    protected $table = 'tolov_grafigi';
    protected $fillable = [
        'generate_price',
        'percentage_input',
        'first_payment_percent',
        'installment_quarterly',
        'shartnoma_id',
        'payment_type',
        'minimum_wage',
        'payment_deadline',
        'calculated_quarterly_payment',
    ];
    protected $casts = [
        'payment_deadline' => 'date',
    ];
    public function shartnoma()
    {
        return $this->belongsTo(Shartnoma::class, 'shartnoma_id');
    }
    public function calculateInstallments($shartnoma_id)
    {
        $generatePrice = $this->generate_price ?? 0;
        $percentageInput = $this->percentage_input ?? 0;
        $installmentQuarterly = $this->installment_quarterly ?? 4;

        $firstPaymentAmount = ($percentageInput / 100) * $generatePrice;
        $amountToDivide = $generatePrice - $firstPaymentAmount;
        $installmentAmount = $installmentQuarterly > 0 ? $amountToDivide / $installmentQuarterly : 0;

        $startDate = $this->shartnoma && $this->shartnoma->shartnoma_sanasi
            ? Carbon::parse($this->shartnoma->shartnoma_sanasi)
            : Carbon::now();

        $paymentSchedule = [];
        $totalInstallmentsAmount = 0;

        if ($installmentAmount > 0) {
            for ($i = 0; $i < $installmentQuarterly; $i++) {
                $paymentDate = $startDate->copy()->addMonths(3 * $i);
                $quarterLabel = $this->getQuarterLabel($i + 1);

                $paymentSchedule[] = [
                    'shartnoma_id' => $shartnoma_id,
                    'quarter' => $quarterLabel,
                    'payment_date' => $paymentDate->format('Y-m-d'),
                    'payment_amount' => $installmentAmount
                ];
                $totalInstallmentsAmount += $installmentAmount;
            }
        }

        $totalAmount = $totalInstallmentsAmount;

        // Save payment schedule to the database
        foreach ($paymentSchedule as $schedule) {
            PaymentSchedule::create($schedule);
        }

        return [
            'paymentSchedule' => $paymentSchedule,
            'totalAmount' => number_format($totalAmount, 2, ',', ' ')
        ];
    }
    private function getQuarterLabel($index)
    {
        $quarters = ['I - квартал', 'II - квартал', 'III - квартал', 'IV - квартал'];
        return $quarters[($index - 1) % 4];
    }
}
