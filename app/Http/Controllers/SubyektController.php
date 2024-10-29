<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Client;
use App\Models\Regions;
use App\Models\SubyektShakli;
use App\Models\XujjatBerilganJoyi;
use App\Models\XujjatTuri;
use App\Rules\UzbekName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubyektController extends Controller
{
    public function index()
    {
        $categories = Category::get()->all();
        $clients = Client::deepFilters()
            ->with(['category', 'company', 'files'])
            ->where('is_deleted', '!=', 1)
            ->orderByDesc('id')
            ->paginate(25);


        return view('pages.subyekt.index', compact('clients', 'categories'));
    }




    public function add_fizik()
    {
        $xujjatTurlari = XujjatTuri::get()->all();
        $xujjatBerilganJoyi = XujjatBerilganJoyi::get()->all();
        $categories = Category::get()->all();
        $regions = Regions::get()->all();
        return view('pages.subyekt.add_fizik', compact('regions', 'categories', 'xujjatTurlari', 'xujjatBerilganJoyi'));
    }

    public function add_yuridik()
    {
        $subyektShakli = SubyektShakli::get()->all();
        $categories = Category::get()->all();
        $regions = Regions::get()->all();
        $bank = Bank::get()->all();

        return view('pages.subyekt.add_yuridik', compact('regions', 'categories', 'bank', 'subyektShakli'));
    }

    public function create_fizik_client(Request $request)
    {
        $validatedData = $request->validate([
            'mijoz_turi' => 'required|string',
            'sub_street_id' => 'required|integer|exists:sub_streets,id',
            'xujjat_turi_id' => 'required|integer|exists:xujjat_turi,id',
            'xujjat_berilgan_joyi_id' => 'required|integer|exists:xujjat_berilgan_joyi,id',

            'last_name' => ['required', 'string', 'max:255', new UzbekName],
            'first_name' => ['required', 'string', 'max:255', new UzbekName],
            'stir' => 'required|min:9|int',
            'father_name' => 'nullable|string|max:255',
            'birth_date' => 'required|date',
            'contact' => 'required|min:14|string',
            'email' => 'nullable|email|max:255',
            'contact2' => 'nullable',

            'client_description' => 'nullable|string',
            'category_id' => 'nullable|integer|exists:categories,id',
            'created_by_client' => 'nullable|boolean',

            'passport_pinfl' => 'required|min:14|numeric',
            'passport_serial' => 'required|min:2|max:2|max:255',
            'passport_raqami' => 'required|min:7|max:7|max:255',

            'passport_date' => 'required|date',
            'passport_location' => 'nullable|string|max:255',
            'passport_type' => 'nullable|integer',

            'home_address' => 'nullable|string|max:255',

        ]);

        DB::beginTransaction();

        try {

            $client = Client::create([
                'user_id' => Auth::id(),

                'mijoz_turi' => $request->get('mijoz_turi'),
                'sub_street_id' => $request->get('sub_street_id'),
                'xujjat_turi_id' => $request->get('xujjat_turi_id'),
                'xujjat_berilgan_joyi_id' => $request->get('xujjat_berilgan_joyi_id'),

                'last_name' => $request->get('last_name'),
                'first_name' => $request->get('first_name'),
                'father_name' => $request->get('father_name'),
                'birth_date' => $request->get('birth_date'),
                'contact' => $request->get('contact'),
                'contact2' => $request->get('contact2'),
                'email' => $request->get('email'),
                'stir' => $request->get('stir'),
                'client_description' => $request->get('client_description'),
                'category_id' => $request->get('category_id', 2),
                'created_by_client' => $request->get('created_by_client', 0),
                'home_number' => $request->get('home_number'),
                'apartment_number' => $request->get('apartment_number'),
            ]);

            $client->passport()->create([
                'passport_serial' => $request->get('passport_serial') ?? null,
                'passport_pinfl' => $request->get('passport_pinfl') ?? null,
                'passport_date' => $request->get('passport_date') ?? null,
                'passport_location' => $request->get('passport_location') ?? null,
                'passport_type' => $request->get('passport_type') ?? 0,
                'passport_raqami' => $request->get('passport_raqami') ?? 0,
            ]);


            $client->update([
                'action' => 'created',
                'action_timestamp' => now(),
            ]);

            DB::commit();

            return redirect()->route('clientIndex')->with('success', 'Client created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'An error occurred while creating the client: ' . $e->getMessage());
        }
    }
    public function create_yuridik_client(Request $request)
    {
        $request->validate([
            'mijoz_turi' => 'required',
            'last_name' => 'required',
            'first_name' => 'required',
            'father_name' => 'nullable',
            'birth_date' => 'nullable|date',
            'contact' => 'required|min:14',
            'contact2' => 'nullable',
            'email' => 'nullable|email',
            'stir' => 'required|min:9|numeric',
            'client_description' => 'nullable',
            'category_id' => 'nullable|integer',
            'created_by_client' => 'nullable|integer',
            'subyekt_shakli_id' => 'required',
            'company_name' => 'required',
            'oked' => 'required|min:5|numeric',
            'sub_street_id' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $client = Client::create([
                'user_id' => Auth::id(),
                'mijoz_turi' => $request->get('mijoz_turi'),
                'last_name' => $request->get('last_name'),
                'first_name' => $request->get('first_name'),
                'father_name' => $request->get('father_name'),

                'contact' => $request->get('contact'),
                'contact2' => $request->get('contact2'),
                'email' => $request->get('email'),
                'stir' => $request->get('stir'),
                'client_description' => $request->get('client_description'),
                'category_id' => $request->get('category_id', 2),
                'created_by_client' => $request->get('created_by_client', 0),
            ]);

            $client->company()->create([
                'client_id' => $client->id,
                'subyekt_shakli_id' => $request->get('subyekt_shakli_id'),
                'sub_street_id' => $request->get('sub_street_id'),

                'company_name' => $request->get('company_name'),
                'oked' => $request->get('oked'),
                'bank_id' => $request->get('bank_id') ?: null,
                'home_number' => $request->get('home_number'),
                'apartment_number' => $request->get('apartment_number'),
            ]);


            $client->update([
                'action' => 'created',
                'action_timestamp' => now(),
            ]);

            DB::commit();

            return redirect()->route('clientIndex')->with('success', 'Client created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'An error occurred while creating the client: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $client = Client::where('id', $id)
            ->with(['user', 'company', 'branches', 'passport', 'files'])
            ->where('is_deleted', '!=', 1)
            ->get()->first();

        $files = $client ? $client->files : collect();

        if ($client) {
            return view('pages.subyekt.show', compact('client', 'files'));
        } else {
            return response()->view('errors.404', ['status' => 404, 'message' => 'Applicant Not found'], 404);
        }
    }

    public function arxiv()
    {
        $clients = Client::all();

        return view('pages.subyekt.history', compact('clients'));
    }


    public function edit_fizik($id)
    {

        $xujjatTurlari = XujjatTuri::get()->all();
        $xujjatBerilganJoyi = XujjatBerilganJoyi::get()->all();
        $categories = Category::get()->all();
        $regions = Regions::get()->all();
        $client = Client::where('id', $id)
            ->with(['branches', 'files'])
            ->where('is_deleted', '!=', 1)
            ->firstOrFail();




        return view('pages.subyekt.edit_fizik', compact('client', 'regions', 'categories', 'xujjatTurlari', 'xujjatBerilganJoyi'));
    }

    public function edit_yuridik($id)
    {
        $xujjatTurlari = XujjatTuri::all();
        $xujjatBerilganJoyi = XujjatBerilganJoyi::all();
        $categories = Category::all();
        $regions = Regions::all();
        $subyektShakli = SubyektShakli::all();
        $banks = Bank::all(); // Assuming you have a Bank model

        $client = Client::with('company', 'company.subyektShakli')
            ->where('id', $id)
            ->where('is_deleted', '!=', 1)
            ->firstOrFail();


        return view('pages.subyekt.edit_yuridik', compact('client', 'regions', 'categories', 'xujjatTurlari', 'xujjatBerilganJoyi', 'subyektShakli', 'banks'));
    }

    public function update_fizik_client(Request $request, $id)
    {
        $validatedData = $request->validate([
            'mijoz_turi' => 'required|string',
            'sub_street_id' => 'required|integer|exists:sub_streets,id',
            'xujjat_turi_id' => 'required|integer|exists:xujjat_turi,id',
            'xujjat_berilgan_joyi_id' => 'required|integer|exists:xujjat_berilgan_joyi,id',

            'last_name' => ['required', 'string', 'max:255', new UzbekName],
            'first_name' => ['required', 'string', 'max:255', new UzbekName],
            'stir' => 'required|min:9|int',
            'passport_pinfl' => 'required|min:14|numeric',
            'father_name' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'contact' => 'required|min:14|string',
            'email' => 'nullable|email|max:255',
            'contact2' => 'nullable',

            'client_description' => 'nullable|string',
            'category_id' => 'nullable|integer|exists:categories,id',
            'created_by_client' => 'nullable|boolean',

            'passport_serial' => 'required|min:2|max:2|max:255',
            'passport_raqami' => 'required|min:7|max:7|max:255',

            'passport_date' => 'required|date',
            'passport_location' => 'nullable|string|max:255',
            'passport_type' => 'nullable|integer',
        ]);
        DB::beginTransaction();

        try {
            $client = Client::findOrFail($id);

            $client->update([
                'user_id' => Auth::id(),

                'mijoz_turi' => $request->get('mijoz_turi'),
                'last_name' => $request->get('last_name'),
                'first_name' => $request->get('first_name'),
                'father_name' => $request->get('father_name'),
                'birth_date' => $request->get('birth_date'),
                'contact' => $request->get('contact'),
                'contact2' => $request->get('contact2'),
                'email' => $request->get('email'),
                'stir' => $request->get('stir'),
                'client_description' => $request->get('client_description'),
                'category_id' => $request->get('category_id', 2),
                'created_by_client' => $request->get('created_by_client', 0),
                'sub_street_id' => $request->get('sub_street_id'),
                'xujjat_turi_id' => $request->get('xujjat_turi_id'),
                'xujjat_berilgan_joyi_id' => $request->get('xujjat_berilgan_joyi_id'),
                'home_number' => $request->get('home_number'),
                'apartment_number' => $request->get('apartment_number'),
            ]);


            $client->update([
                'action' => 'updated',
                'action_timestamp' => now(),
            ]);

            DB::commit();

            return redirect()->route('clientIndex')->with('success', 'Jismoniy shaxs muvafaqqiyatli yangilandi');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'An error occurred while updating the client: ' . $e->getMessage());
        }
    }

    public function update_yuridik_client(Request $request, $id)
    {
        $request->validate([
            'mijoz_turi' => 'required',
            'last_name' => 'required',
            'first_name' => 'required',
            'father_name' => 'nullable',
            'birth_date' => 'nullable|date',
            'contact' => 'required|min:14|max:14',
            'contact2' => 'nullable',
            'email' => 'nullable|email',
            'stir' => 'required|min:9|numeric',
            'client_description' => 'nullable',
            'category_id' => 'nullable|integer',
            'created_by_client' => 'nullable|integer',
            'subyekt_shakli_id' => 'required',
            'company_name' => 'required',
            'oked' => 'required|min:5|numeric',
            'yuridik_address' => 'nullable',
            'company_location' => 'nullable',
            'sub_street_id' => 'required',
        ]);
        DB::beginTransaction();

        try {
            $client = Client::findOrFail($id);

            $client->update([
                'user_id' => Auth::id(),

                'mijoz_turi' => $request->get('mijoz_turi'),
                'last_name' => $request->get('last_name'),
                'first_name' => $request->get('first_name'),
                'father_name' => $request->get('father_name'),
                'contact' => $request->get('contact'),
                'contact2' => $request->get('contact2'),
                'email' => $request->get('email'),
                'stir' => $request->get('stir'),
                'client_description' => $request->get('client_description'),
                'category_id' => $request->get('category_id', 2),
                'created_by_client' => $request->get('created_by_client', 0),
            ]);

            $client->company()->update([
                'subyekt_shakli_id' => $request->get('subyekt_shakli_id'),
                'company_name' => $request->get('company_name'),
                'oked' => $request->get('oked'),
                'bank_id' => $request->get('bank_id'),
                'sub_street_id' => $request->get('sub_street_id'),
                'home_number' => $request->get('home_number'),
                'apartment_number' => $request->get('apartment_number'),
            ]);

            $client->update([
                'action' => 'updated',
                'action_timestamp' => now(),
            ]);

            DB::commit();

            return redirect()->route('obyekt.add', ['client_id' => $client->id])->with('success', 'Yuridik shaxs muvafaqqiyatli yangilandi');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'An error occurred while updating the client: ' . $e->getMessage());
        }
    }

    public function toggleclientActivation($id)
    {
        $client = Client::findOrFail($id);
        $client->status = $client->status === 1 ? 2 : 1;
        $client->save();


        return [
            'is_active' => $client->status
        ];
    }
    public function delete($id)
    {
        try {
            $client = Client::findOrFail($id);

            $client->update([
                'user_id' => Auth::id(),
                'action' => 'deleted',
                'action_timestamp' => now(),
            ]);

            $client->delete();

            return redirect()->back()->with('success', 'Client marked as deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while marking the client as deleted: ' . $e->getMessage());
        }
    }
}
