<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Branch;
use App\Models\Kt;
use App\Models\Kz;
use App\Models\Kj;
use App\Models\Ko;
use App\Models\Regions;
use App\Models\District;
use App\Models\RuxsatnomaBerilganIshTuri;
use App\Models\Street;
use App\Models\BranchHistory;
use App\Models\Ruxsatnoma;
use App\Models\LoyihaHajmiMalumotnoma;
use App\Models\LoyihaHujjatlari;
use App\Models\Order;
use App\Models\RuxsatnomaKimTamonidan;
use App\Models\RuxsatnomaTuri;
use App\Models\SubyektShakli;
use App\Models\Bank;
use App\Models\SubStreet;
use App\Rules\ZoneNameMatchesKzId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ObyektController extends Controller
{
    public function index()
    {
        // $branches = Branch::with(['client', 'ruxsatnoma', 'loyihaHajmiMalumotnoma', 'loyihaHujjatlari','substreet'])
        $branches = Branch::with(['client', 'ruxsatnoma', 'loyihaHajmiMalumotnoma', 'loyihaHujjatlari'])
            ->orderByDesc('updated_at')
            ->paginate(10);
        return view('pages.obyekt.index', compact('branches'));
    }
    public function show($id)
    {
        $branch = Branch::with([
            'client',
            'ruxsatnoma',
            'loyihaHajmiMalumotnoma',
            'loyihaHujjatlari',
            // 'subStreet'
        ])->findOrFail($id);

        return view('pages.obyekt.show', compact('branch'));
    }
    public function arxiv()
    {
        $branches = Branch::all();

        return view('pages.obyekt.history', compact('branches'));
    }


    public function add(Request $request)
    {
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
        return view('pages.obyekt.add', compact('clients', 'selectedClientId', 'branches', 'kts', 'kzs', 'kos', 'kjs', 'regions', 'bank', 'subyektShakli', 'ruxsatnoma_turi', 'ruxsatnoma_kim_tamonidan', 'ruxsatnoma_berilgan_ish_turi'));
    }

    public function getDistricts(Request $request)
    {
        $regionId = $request->region_id;
        $districts = District::where('region_id', $regionId)->pluck('name_uz', 'id')->toArray();

        return response()->json($districts);
    }

    public function getStreets(Request $request)
    {
        $districtId = $request->district_id;
        $streets = Street::where('district_id', $districtId)->pluck('name', 'id')->toArray();

        return response()->json($streets);
    }

    public function getSubStreets(Request $request)
    {
        $districtId = $request->input('district_id');
        if ($districtId) {
            $substreets = SubStreet::where('district_id', $districtId)->pluck('name', 'id');
            return response()->json($substreets);
        }
        return response()->json([]);
    }

    public function searchClient(Request $request)
    {
        try {
            $query = $request->get('query');

            if (!$query) {
                return response()->json(['error' => 'Query is required'], 400);
            }

            $clients = Client::select('clients.*', 'companies.company_name')
                ->leftJoin('companies', 'clients.id', '=', 'companies.client_id')
                ->whereRaw('LOWER(clients.unique_code) LIKE ?', ["%{$query}%"])
                ->orWhereRaw('LOWER(clients.first_name) LIKE ?', ["%{$query}%"])
                ->orWhereRaw('LOWER(clients.last_name) LIKE ?', ["%{$query}%"])
                ->orWhereRaw('LOWER(clients.stir) LIKE ?', ["%{$query}%"])
                ->orWhereRaw('LOWER(companies.company_name) LIKE ?', ["%{$query}%"])
                ->get();

            return response()->json($clients);
        } catch (\Exception $e) {
            \Log::error('Error in searchClient: ' . $e->getMessage());
            return response()->json(['error' => 'Server Error'], 500);
        }
    }

    public function getClientDetails($client_id)
    {
        \Log::info('getClientDetails called with client_id: ' . $client_id);
        $client = Client::with('company')->find($client_id);

        if (!$client) {
            \Log::error('Client not found: ' . $client_id);
            return response()->json(['error' => 'Client not found'], 404);
        }

        \Log::info('Client found: ', $client->toArray());
        return response()->json([
            'stir' => $client->stir,
            'company_name' => $client->company->company_name ?? null,
        ]);
    }

    // public function create_fizik_client(Request $request)
    // {
    //     // dd($request);
    //     DB::beginTransaction();
    //     $birthDate = Carbon::createFromFormat('d-M-Y', $request->get('birth_date'))->format('Y-m-d');

    //     try {
    //         $client = Client::create([
    //             'mijoz_turi' => $request->get('mijoz_turi'),
    //             'last_name' => $request->get('last_name'),
    //             'first_name' => $request->get('first_name'),
    //             'father_name' => $request->get('father_name'),
    //             'birth_date' => $birthDate,
    //             'contact' => $request->get('contact'),
    //             'email' => $request->get('email'),
    //             'stir' => $request->get('stir'),
    //             'client_description' => $request->get('client_description'),
    //             'category_id' => $request->get('category_id', 2),
    //             'created_by_client' => $request->get('created_by_client', 0),
    //             'sub_street_id' => $request->get('sub_street_id'),
    //             'xujjat_turi_id' => $request->get('xujjat_turi_id'),
    //             'xujjat_berilgan_joyi_id' => $request->get('xujjat_berilgan_joyi_id'),

    //         ]);

    //         $client->passport()->create([
    //             'passport_serial' => $request->get('passport_serial') ?? null,
    //             'passport_pinfl' => $request->get('passport_pinfl') ?? null,
    //             'passport_date' => $request->get('passport_date') ?? null,
    //             'passport_location' => $request->get('passport_location') ?? null,
    //             'passport_type' => $request->get('passport_type') ?? 0,
    //         ]);

    //         $client->address()->create([
    //             'home_address' => $request->get('home_address') ?? null,
    //         ]);


    //         DB::commit();

    //         // return redirect()->route('clientIndex')->with('success', 'Client created successfully');
    //         return redirect()->route('obyekt.add', ['client_id' => $client->id])->with('success', 'Jismoniy shaxs muvafaqqiyatli yaratildi');
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return redirect()->back()->with('error', 'An error occurred while creating the client: ' . $e->getMessage());
    //     }
    // }

    // public function create_yuridik_client(Request $request)
    // {
    //     // dd('dw');
    //     DB::beginTransaction();
    //     // $birthDate = Carbon::createFromFormat('d-M-Y', $request->get('birth_date'))->format('Y-m-d');

    //     try {
    //         $client = Client::create([
    //             'mijoz_turi' => $request->get('mijoz_turi'),
    //             'last_name' => $request->get('last_name'),
    //             'first_name' => $request->get('first_name'),
    //             'father_name' => $request->get('father_name'),
    //             'contact' => $request->get('contact'),
    //             'email' => $request->get('email'),
    //             'stir' => $request->get('stir'),
    //             'client_description' => $request->get('client_description'),
    //             'category_id' => $request->get('category_id', 2),
    //             'created_by_client' => $request->get('created_by_client', 0),
    //         ]);

    //         $client->company()->create([
    //             'client_id' => $client->id,
    //             'subyekt_shakli_id' => $request->get('subyekt_shakli_id'),
    //             'company_name' => $request->get('company_name'),
    //             'oked' => $request->get('oked'),
    //             'bank_id' => $request->get('bank_id'),
    //             'sub_street_id' => $request->get('sub_street_id'),

    //         ]);

    //         $client->passport()->create([
    //             'passport_serial' => $request->get('passport_serial') ?? null,
    //             'passport_pinfl' => $request->get('passport_pinfl') ?? null,
    //             'passport_date' => $request->get('passport_date') ?? null,
    //             'passport_location' => $request->get('passport_location') ?? null,
    //             'passport_type' => $request->get('passport_type') ?? 0,
    //         ]);

    //         $client->address()->create([
    //             'yuridik_address' => $request->get('yuridik_address') ?? null,
    //             'company_location' => $request->get('company_location') ?? null,
    //         ]);

    //         DB::commit();

    //         // return redirect()->route('clientIndex')->with('success', 'Client created successfully');
    //         return redirect()->route('obyekt.add', ['client_id' => $client->id])->with('success', 'Yuridik shaxs muvafaqqiyatli yaratildi');
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return redirect()->back()->with('error', 'An error occurred while creating the client: ' . $e->getMessage());
    //     }
    // }

    public function obyekt_create(Request $request)
    {

        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'stir' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'ruxsatnoma_turi_id' => 'required|exists:ruxsatnoma_turi,id',
            'ruxsat_raqami' => 'required|string|max:255',
            'ruxsat_sanasi' => 'required|date',
            'ruxsatnoma_kim_tamonidan_id' => 'required|exists:ruxsatnoma_kim_tamonidan,id',
            'kadastr_raqami' => 'required|string|max:255|regex:/^\d{2}:\d{2}:\d{2}:\d{2}:\d{2}:\d{4}$/',
            'ruxsatnoma_berilgan_ish_turi_id' => 'required|exists:ruxsatnoma_berilgan_ish_turi,id',
            'binoning_qurilish_hajmi' => 'required|numeric',
            'ruxsatdan_tashqari_yuqori_hajm' => 'required|numeric',
            'binoning_avtoturargoh_qismi_hajmi' => 'required|numeric',
            'binoning_texnik_qavatlar_xonalar_hajmi' => 'required|numeric',
            'turar_joy_binosining_umumiy_foydalanishdagi_qismi_hajmi' => 'required|numeric',
            'kt_id' => 'required|exists:kts,id',
            'ko_id' => 'required|exists:kos,id',
            'kz_id' => 'required|exists:kzs,id',
            'kj_id' => 'required|exists:kjs,id',
            'obyekt_nomi' => 'required|string|max:255',
            'qoshimcha_malumot' => 'required|string|max:255',
            'geolokatsiya' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'kompleks' => 'required|string|max:255',
            'loiyha_hajmi_haqida' => 'required|string|max:255',
            'coefficient' => 'required|numeric|min:0',
            'branch_kubmetr' => 'required|numeric',
            'minimum_wage' => 'required|numeric|min:0',
            'generate_price' => 'required|numeric|min:0',

            'sub_street_id' => 'required',

            'zone_name' => 'nullable|string|max:255',

        ]);

        $kzId = $validatedData['kz_id'];
        $request->validate([
            'zone_name' => ['nullable', 'string', 'max:255', new ZoneNameMatchesKzId($kzId)],
        ]);

        DB::beginTransaction();

        try {
            // Create Ruxsatnoma record
            $ruxsatnomalar = Ruxsatnoma::create([
                'ruxsatnoma_turi_id' => $validatedData['ruxsatnoma_turi_id'],
                'ruxsatnoma_berilgan_ish_turi_id' => $validatedData['ruxsatnoma_berilgan_ish_turi_id'],
                'ruxsatnoma_kim_tamonidan_id' => $validatedData['ruxsatnoma_kim_tamonidan_id'],
                'ruxsat_etuvchi_hujjat_sanasi' => $validatedData['ruxsat_sanasi'],
                'ruxsat_etuvchi_hujjat_raqami' => $validatedData['ruxsat_raqami'],
                'kadastr_raqami' => $validatedData['kadastr_raqami'],
            ]);

            // Create LoyihaHajmiMalumotnoma record
            $loyihaHajmi = LoyihaHajmiMalumotnoma::create([
                'binoning_qurilish_hajmi' => $validatedData['binoning_qurilish_hajmi'],
                'ruxsatdan_tashqari_yuqori_hajm' => $validatedData['ruxsatdan_tashqari_yuqori_hajm'],
                'binoning_avtoturargoh_qismi_hajmi' => $validatedData['binoning_avtoturargoh_qismi_hajmi'],
                'binoning_texnik_qavatlar_xonalar_hajmi' => $validatedData['binoning_texnik_qavatlar_xonalar_hajmi'],
                'turar_joy_binosining_umumiy_foydalanishdagi_qismi_hajmi' => $validatedData['turar_joy_binosining_umumiy_foydalanishdagi_qismi_hajmi'],
                'branch_kubmetr' => $validatedData['branch_kubmetr'],
                'qoshimcha_malumot' => $validatedData['qoshimcha_malumot'],
                'obyekt_nomi' => $validatedData['obyekt_nomi'],
                'geolokatsiya' => $validatedData['geolokatsiya'],
                'latitude' => $validatedData['latitude'],
                'longitude' => $validatedData['longitude'],
                'zone_name' => $validatedData['zone_name'] ?? null,
            ]);

            // Create LoyihaHujjatlari record
            $loyihaHujjatlari = LoyihaHujjatlari::create([
                'kompleks' => $validatedData['kompleks'],
                'loiyha_hajmi_haqida' => $validatedData['loiyha_hajmi_haqida'],
            ]);

            // Create Branch record
            $branch = Branch::create([
                'user_id' => Auth::id(),
                'client_id' => $validatedData['client_id'],
                'ruxsatnoma_id' => $ruxsatnomalar->id,
                'loyiha_hajmi_malumotnoma_id' => $loyihaHajmi->id,
                'loyiha_hujjatlari_id' => $loyihaHujjatlari->id,
                'sub_street_id' => $validatedData['sub_street_id'],
                'kj_id' => $validatedData['kj_id'],
                'kz_id' => $validatedData['kz_id'],
                'ko_id' => $validatedData['ko_id'],
                'kt_id' => $validatedData['kt_id'],

            ]);

            // Update Branch with action details
            $branch->update([
                'action' => 'created',
                'action_timestamp' => now(),
            ]);

            // Create Order record
            $order = Order::create([
                'client_id' => $validatedData['client_id'],
                'branch_id' => $branch->id,
            ]);

            DB::commit();

            // Redirect with success message
            return redirect()->route('obyekt.index')->with('success', 'Obyekt muvafaqqiyatli yaratildi');
        } catch (\Exception $e) {
            DB::rollback();

            // Redirect back with error message
            return redirect()->back()->with('error', 'Obyekt yaratishda xatolik yuz berdi: ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        $ruxsatnoma_turi = RuxsatnomaTuri::all();
        $ruxsatnoma_kim_tamonidan = RuxsatnomaKimTamonidan::all();
        $ruxsatnoma_berilgan_ish_turi = RuxsatnomaBerilganIshTuri::all();
        $bank = Bank::all();
        $clients = Client::all();
        $regions = Regions::all();
        $kts = Kt::all();
        $kjs = Kj::all();
        $kzs = Kz::all();
        $kos = Ko::all();
        $branch = Branch::with([
            'client',
            'ruxsatnoma',
            'loyihaHajmiMalumotnoma',
            'loyihaHujjatlari',
            'subStreet',
        ])->findOrFail($id);

        return view('pages.obyekt.edit', compact(
            'kts',
            'kos',
            'kzs',
            'kjs',
            'branch',
            'regions',
            'clients',
            'ruxsatnoma_turi',
            'ruxsatnoma_kim_tamonidan',
            'ruxsatnoma_berilgan_ish_turi'
        ));
    }
    public function obyekt_update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'ruxsatnoma_turi_id' => 'required|exists:ruxsatnoma_turi,id',
            'ruxsat_raqami' => 'required|string|max:255',
            'ruxsat_sanasi' => 'required|date',
            'ruxsatnoma_kim_tamonidan_id' => 'required|exists:ruxsatnoma_kim_tamonidan,id',
            'kadastr_raqami' => 'required|string|max:255|regex:/^\d{2}:\d{2}:\d{2}:\d{2}:\d{2}:\d{4}$/',
            'ruxsatnoma_berilgan_ish_turi_id' => 'required|exists:ruxsatnoma_berilgan_ish_turi,id',
            'binoning_qurilish_hajmi' => 'required|numeric',
            'ruxsatdan_tashqari_yuqori_hajm' => 'required|numeric',
            'binoning_avtoturargoh_qismi_hajmi' => 'required|numeric',
            'binoning_texnik_qavatlar_xonalar_hajmi' => 'required|numeric',
            'turar_joy_binosining_umumiy_foydalanishdagi_qismi_hajmi' => 'required|numeric',
            'kt_id' => 'required|exists:kts,id',
            'ko_id' => 'required|exists:kos,id',
            'kz_id' => 'required|exists:kzs,id',
            'kj_id' => 'required|exists:kjs,id',
            'obyekt_nomi' => 'required|string|max:255',
            'qoshimcha_malumot' => 'required|string|max:255',
            'geolokatsiya' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'coefficient' => 'required|numeric|min:0',
            'branch_kubmetr' => 'required|numeric',
            'minimum_wage' => 'required|numeric|min:0',
            'generate_price' => 'required|numeric|min:0',
            'sub_street_id' => 'required|exists:sub_streets,id',
            'zone_name' => 'nullable|string|max:255',
        ]);

        $kzId = $validatedData['kz_id'];
        $request->validate([
            'zone_name' => ['nullable', 'string', 'max:255', new ZoneNameMatchesKzId($kzId)],
        ]);

        DB::beginTransaction();
        try {
            $branch = Branch::findOrFail($id);
            $originalBranchData = $branch->getAttributes(); // Get all attributes of the branch

            Log::info("Starting update process for branch ID: $id");

            // Handle Ruxsatnoma
            $ruxsatnomalar = Ruxsatnoma::find($branch->ruxsatnoma_id);
            if (!$ruxsatnomalar) {
                $ruxsatnomalar = Ruxsatnoma::create([
                    'sub_street_id' => $validatedData['sub_street_id'],
                    'ruxsatnoma_turi_id' => $validatedData['ruxsatnoma_turi_id'],
                    'ruxsatnoma_berilgan_ish_turi_id' => $validatedData['ruxsatnoma_berilgan_ish_turi_id'],
                    'ruxsatnoma_kim_tamonidan_id' => $validatedData['ruxsatnoma_kim_tamonidan_id'],
                    'ruxsat_etuvchi_hujjat_sanasi' => $validatedData['ruxsat_sanasi'],
                    'ruxsat_etuvchi_hujjat_raqami' => $validatedData['ruxsat_raqami'],
                    'kadastr_raqami' => $validatedData['kadastr_raqami'],
                ]);
                Log::info("Created new Ruxsatnoma with ID: {$ruxsatnomalar->id}");
            } else {
                $ruxsatnomalar->update([
                    'sub_street_id' => $validatedData['sub_street_id'],
                    'ruxsatnoma_turi_id' => $validatedData['ruxsatnoma_turi_id'],
                    'ruxsatnoma_berilgan_ish_turi_id' => $validatedData['ruxsatnoma_berilgan_ish_turi_id'],
                    'ruxsatnoma_kim_tamonidan_id' => $validatedData['ruxsatnoma_kim_tamonidan_id'],
                    'ruxsat_etuvchi_hujjat_sanasi' => $validatedData['ruxsat_sanasi'],
                    'ruxsat_etuvchi_hujjat_raqami' => $validatedData['ruxsat_raqami'],
                    'kadastr_raqami' => $validatedData['kadastr_raqami'],
                ]);
                Log::info("Updated Ruxsatnoma with ID: {$ruxsatnomalar->id}");
            }

            // Handle LoyihaHajmiMalumotnoma
            $loyihaHajmi = LoyihaHajmiMalumotnoma::find($branch->loyiha_hajmi_malumotnoma_id);
            if (!$loyihaHajmi) {
                $loyihaHajmi = LoyihaHajmiMalumotnoma::create([
                    'binoning_qurilish_hajmi' => $validatedData['binoning_qurilish_hajmi'],
                    'ruxsatdan_tashqari_yuqori_hajm' => $validatedData['ruxsatdan_tashqari_yuqori_hajm'],
                    'binoning_avtoturargoh_qismi_hajmi' => $validatedData['binoning_avtoturargoh_qismi_hajmi'],
                    'binoning_texnik_qavatlar_xonalar_hajmi' => $validatedData['binoning_texnik_qavatlar_xonalar_hajmi'],
                    'turar_joy_binosining_umumiy_foydalanishdagi_qismi_hajmi' => $validatedData['turar_joy_binosining_umumiy_foydalanishdagi_qismi_hajmi'],
                    'branch_kubmetr' => $validatedData['branch_kubmetr'],
                    'qoshimcha_malumot' => $validatedData['qoshimcha_malumot'],
                    'obyekt_nomi' => $validatedData['obyekt_nomi'],
                    'geolokatsiya' => $validatedData['geolokatsiya'],
                ]);
                Log::info("Created new LoyihaHajmiMalumotnoma with ID: {$loyihaHajmi->id}");
            } else {
                $loyihaHajmi->update([
                    'binoning_qurilish_hajmi' => $validatedData['binoning_qurilish_hajmi'],
                    'ruxsatdan_tashqari_yuqori_hajm' => $validatedData['ruxsatdan_tashqari_yuqori_hajm'],
                    'binoning_avtoturargoh_qismi_hajmi' => $validatedData['binoning_avtoturargoh_qismi_hajmi'],
                    'binoning_texnik_qavatlar_xonalar_hajmi' => $validatedData['binoning_texnik_qavatlar_xonalar_hajmi'],
                    'turar_joy_binosining_umumiy_foydalanishdagi_qismi_hajmi' => $validatedData['turar_joy_binosining_umumiy_foydalanishdagi_qismi_hajmi'],
                    'branch_kubmetr' => $validatedData['branch_kubmetr'],
                    'qoshimcha_malumot' => $validatedData['qoshimcha_malumot'],
                    'obyekt_nomi' => $validatedData['obyekt_nomi'],
                    'geolokatsiya' => $validatedData['geolokatsiya'],
                    'latitude' => $validatedData['latitude'],
                    'longitude' => $validatedData['longitude'],
                    'zone_name' => $validatedData['zone_name'] ?? null,
                ]);
                Log::info("Updated LoyihaHajmiMalumotnoma with ID: {$loyihaHajmi->id}");
            }

            // Handle LoyihaHujjatlari
            $loyihaHujjatlari = LoyihaHujjatlari::find($branch->loyiha_hujjatlari_id);
            if (!$loyihaHujjatlari) {
                $loyihaHujjatlari = LoyihaHujjatlari::create([
                    'kompleks' => $validatedData['kompleks'] ?? null,
                    'loiyha_hajmi_haqida' => $validatedData['loiyha_hajmi_haqida'] ?? null,
                ]);
                Log::info("Created new LoyihaHujjatlari with ID: {$loyihaHujjatlari->id}");
            } else {
                $loyihaHujjatlari->update([
                    'kompleks' => $validatedData['kompleks'] ?? null,
                    'loiyha_hajmi_haqida' => $validatedData['loiyha_hajmi_haqida'] ?? null,
                ]);
                Log::info("Updated LoyihaHujjatlari with ID: {$loyihaHujjatlari->id}");
            }

            // Update the branch
            $branch->update([
                'user_id' => Auth::id(),
                'client_id' => $validatedData['client_id'],
                'sub_street_id' => $validatedData['sub_street_id'],
                'kj_id' => $validatedData['kj_id'],
                'kz_id' => $validatedData['kz_id'],
                'ko_id' => $validatedData['ko_id'],
                'kt_id' => $validatedData['kt_id'],
                'ruxsatnoma_id' => $ruxsatnomalar->id,
                'loyiha_hajmi_malumotnoma_id' => $loyihaHajmi->id,
                'loyiha_hujjatlari_id' => $loyihaHujjatlari->id,
                'action' => 'updated',
                'action_timestamp' => now(),
            ]);

            Log::info("Updated Branch ID: $id");

            // Create or update the associated order
            $order = Order::where('branch_id', $branch->id)->first();
            if (!$order) {
                $order = Order::create([
                    'client_id' => $validatedData['client_id'],
                    'branch_id' => $branch->id,
                ]);
                Log::info("Created new Order with ID: {$order->id}");
            } else {
                $order->update([
                    'client_id' => $validatedData['client_id'],
                ]);
                Log::info("Updated Order ID: {$order->id}");
            }

            // Record changes in branch_histories manually
            $this->recordBranchHistory($branch, $originalBranchData);

            DB::commit();

            return redirect()->route('obyekt.index')->with('success', 'Obyekt muvafaqqiyatli yangilandi');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error updating branch ID: $id, Message: " . $e->getMessage());
            return redirect()->back()->with('error', 'Obyekt yangilashda xatolik yuz berdi: ' . $e->getMessage());
        }
    }

    private function recordBranchHistory($branch, $originalData)
    {
        $user_id = Auth::id();
        $updatedAttributes = [
            'client_id',
            'sub_street_id',
            'kj_id',
            'kz_id',
            'ko_id',
            'kt_id',
            'ruxsatnoma_id',
            'loyiha_hajmi_malumotnoma_id',
            'loyiha_hujjatlari_id',
            'action',
            'action_timestamp'
        ];

        foreach ($updatedAttributes as $attribute) {
            $old_value = $originalData[$attribute] ?? 'not_exists';
            $new_value = $branch->$attribute;

            if ($old_value != $new_value) {
                try {
                    BranchHistory::create([
                        'branch_id' => $branch->id,
                        'field' => $attribute,  // Use 'field' here
                        'old_value' => $old_value,
                        'new_value' => $new_value,
                        'user_id' => $user_id,
                    ]);
                    Log::info("Saved history for branch ID: {$branch->id}, Field: {$attribute}");
                } catch (\Exception $e) {
                    Log::error("Failed to save history for branch ID: {$branch->id}, Field: {$attribute}, Error: " . $e->getMessage());
                }
            }
        }
    }





    // Test case for saving history




    public function delete($id)
    {
        try {
            $branch = Branch::findOrFail($id);

            $branch->update([
                'user_id' => Auth::id(),
                'action' => 'deleted',
                'action_timestamp' => now(),
            ]);

            $branch->delete();

            return redirect()->back()->with('success', 'branch marked as deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while marking the branch as deleted: ' . $e->getMessage());
        }
    }
}
