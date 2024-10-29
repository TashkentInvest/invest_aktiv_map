<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\BankKafolati;
use App\Models\Branch;
use App\Models\Client;
use App\Models\Kj;
use App\Models\Ko;
use App\Models\Kt;
use App\Models\Kz;
use App\Models\OrderAtkaz;
use App\Models\Regions;
use App\Models\RuxsatnomaBerilganIshTuri;
use App\Models\RuxsatnomaKimTamonidan;
use App\Models\RuxsatnomaTuri;
use App\Models\Shartnoma;
use App\Models\ShartnomaRasmiylashtirishUchun;
use App\Models\SubyektShakli;
use App\Models\SugurtaPolisi;
use App\Models\TolovGrafigi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SubStreet;

class ShartnomaController extends Controller
{
    public function index()
    {
        $branches = Branch::with('client')->paginate(25);

        return view('pages.shartnoma.index', compact('branches'));
    }
    public function add(Request $request, $id)
    {
        $branch = Branch::with(['client', 'street', 'orders', 'ruxsatnoma', 'loyihaHajmiMalumotnoma', 'loyihaHujjatlari', 'kt', 'kj', 'ko', 'kz'])->find($id);
        $ruxsatnoma_turi = RuxsatnomaTuri::all();
        $ruxsatnoma_kim_tamonidan = RuxsatnomaKimTamonidan::all();
        $ruxsatnoma_berilgan_ish_turi = RuxsatnomaBerilganIshTuri::all();
        $subyektShakli = SubyektShakli::get()->all();

        $bank = Bank::all();
        $clients = Client::all();
        $branches = Branch::with(['kt', 'kj', 'ko', 'kz'])->get()->all();
        $regions = Regions::all();

        $kts = Kt::all();
        $kjs = Kj::all();
        $kzs = Kz::all();
        $kos = Ko::all();

        $selectedClientId = $request->query('client_id', null);
        return view('pages.shartnoma.add', compact('clients', 'selectedClientId', 'branches', 'kts', 'kzs', 'kos', 'kjs', 'regions', 'bank', 'subyektShakli', 'ruxsatnoma_turi', 'ruxsatnoma_kim_tamonidan', 'ruxsatnoma_berilgan_ish_turi', 'branch'));
    }
    public function shartnoma_create(Request $request)
    {
        // Log the request data
        \Log::info('Request data: ', $request->all());
    
        // Validate the request data
        $validated = $request->validate([
            'coefficient' => 'required|numeric',
            'branch_kubmetr' => 'required|numeric',
            'minimum_wage' => 'required|numeric',
            'generate_price' => 'required|numeric',
            'shartnoma_sanasi' => 'required|date',
            'payment_deadline' => 'nullable|date',
            'payment_type' => 'required|string',
            'percentage_input' => 'nullable|numeric',
            'installment_quarterly' => 'nullable|numeric',
            'first_payment_percent' => 'nullable',
            'calculated_quarterly_payment' => 'nullable',
            'branch_id' => 'required|exists:branches,id',
            'sugurta_polisi_id' => 'nullable|exists:sugurta_polisi,id',
            'bank_kafolati_id' => 'nullable|exists:bank_kafolati,id',
            'tolov_grafigi_id' => 'nullable|exists:tolov_grafigi,id',
        ]);
    
        try {
            $attributes = [
                'shartnoma_sanasi' => $request->shartnoma_sanasi,
                'branch_id' => $request->branch_id,
            ];
    
            if ($request->shartnoma_sanasi != null) {
                $attributes['status'] = 1;
            }
    
            // Create Shartnoma first
            $shartnoma = Shartnoma::create($attributes);
    
            // Create TolovGrafigi with shartnoma_id
            $tolovGrafigi = TolovGrafigi::create([
                'shartnoma_id' => $shartnoma->id, // Assign shartnoma_id here
                'payment_deadline' => $request->payment_deadline ?? null,
                'percentage_input' => $request->percentage_input,
                'installment_quarterly' => $request->input('installment_quarterly'),
                'calculated_quarterly_payment' => $request->input('calculated_quarterly_payment'),
                'payment_type' => $request->input('payment_type'),
                'generate_price' => $request->input('generate_price'),
                'minimum_wage' => $request->input('minimum_wage'),
                'first_payment_percent' => $request->input('first_payment_percent'),
            ]);
    
            // Calculate installments and save them
            $tolovGrafigi->calculateInstallments($shartnoma->id);
    
            if ($request->has('sugurta_polisi_id') && !SugurtaPolisi::find($request->sugurta_polisi_id)) {
                return redirect()->back()->with('error', 'Sugurta Polisi record not found.');
            }
    
            if ($request->has('bank_kafolati_id') && !BankKafolati::find($request->bank_kafolati_id)) {
                return redirect()->back()->with('error', 'Bank Kafolati record not found.');
            }
    
            if ($request->has('tolov_grafigi_id') && !TolovGrafigi::find($request->tolov_grafigi_id)) {
                return redirect()->route('shartnoma.index')->with('error', 'Tolov Grafigi record not found.');
            }
    
            ShartnomaRasmiylashtirishUchun::create([
                'shartnoma_id' => $shartnoma->id,
                'sugurta_polisi_id' => $request->input('sugurta_polisi_id', null),
                'bank_kafolati_id' => $request->input('bank_kafolati_id', null),
                'tolov_grafigi_id' => $tolovGrafigi->id,
            ]);
    
            return redirect()->route('shartnoma.index')->with('success', 'Record created successfully.');
        } catch (\Exception $e) {
            \Log::error('Error in shartnoma_create: ', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    public function show($id)
    {
        $orderAtkaz = OrderAtkaz::get()->all();
        $item = Branch::with([
            'client',
            'street',
            'ruxsatnoma',
            'loyihaHajmiMalumotnoma',
            'loyihaHujjatlari',
            'orders.orderAtkaz'
        ])
            ->findOrFail($id);



        return view('pages.shartnoma.show', compact('item', 'orderAtkaz'));
    }
    public function grafik($id)
    {
        $item = TolovGrafigi::findOrFail($id);

        $item->load('shartnoma');

        if ($item->shartnoma) {
            $installments = $item->calculateInstallments($item->shartnoma->id);
            $paymentSchedule = $installments['paymentSchedule'];
            $totalAmount = $installments['totalAmount'];

            return view('pages.shartnoma.grafik', compact('item', 'paymentSchedule', 'totalAmount'));
        } else {
            return redirect()->back()->with('error', 'Shartnoma not found for the given TolovGrafigi.');
        }
    }
    public function approve($id)
    {
        $item = ShartnomaRasmiylashtirishUchun::findOrFail($id);
        $item->user_id = Auth::id();
        $item->status = 3;
        
        \Log::info('dsdsdaa');
        $item->order_atkaz_id = null;

        $item->save();

        $item->update([
            'action' => 'updated',
            'action_timestamp' => now(),
        ]);

        return redirect()->route('shartnoma.index')->with('success', 'sharnoma approved successfully!');
    }
    public function reject(Request $request, $id)
    {
        $item = ShartnomaRasmiylashtirishUchun::findOrFail($id);

        $item->user_id = Auth::id();
        $item->status = 2;
        $item->order_atkaz_id = $request->input('order_atkaz_id');

        if ($request->filled('comment')) {
            $item->comment = $request->input('comment');
        }

        $item->save();

        $item->update([
            'action' => 'updated',
            'action_timestamp' => now(),
        ]); 


        return redirect()->route('shartnoma.index')->with('success', 'shartnoma rejected and soft-deleted successfully!');
    }
}
