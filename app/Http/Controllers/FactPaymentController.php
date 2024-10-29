<?php

namespace App\Http\Controllers;

use App\Models\FactPayment;
use App\Models\PaymentSchedule;
use App\Models\TolovGrafigi;
use Illuminate\Http\Request;

class FactPaymentController extends Controller
{
    public function create($shartnoma_id)
    {
        $paymentSchedules = PaymentSchedule::where('shartnoma_id', $shartnoma_id)->get();
        return view('pages.fact_payments.create', compact('shartnoma_id', 'paymentSchedules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_schedule_id' => 'required|exists:payment_schedules,id',
            'payment_amount' => 'required|numeric',
            'payment_date' => 'required|date',
            'comment' => 'nullable|string',
        ]);
    
        // Store the fact payment
        FactPayment::create($validated);
    
        // Redirect to the grafik page with the shartnoma_id
        return redirect()->route('grafik.show', ['id' => $request->shartnoma_id])->with('success', 'Payment added successfully.');
    }
    
}
