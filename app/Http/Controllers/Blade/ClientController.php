<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Client;
use App\Models\Company;
use App\Models\Confirm;
use App\Models\File;
use Illuminate\Http\Request;
use App\Models\Regions;
use App\Models\SubyektShakli;
use App\Models\XujjatBerilganJoyi;
use App\Models\XujjatTuri;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function index()
    {
        $categories = Category::get()->all();
        $clients = Client::deepFilters()
            ->with(['category', 'company', 'address', 'passport', 'files'])
            ->where('is_deleted', '!=', 1)
            ->orderByDesc('id')
            ->paginate(25);
            
    
        return view('pages.products.index', compact('clients','categories'));
    }



    // public function index()
    // {
    //     $categories = Category::all();
    
    //     $clients = Client::query()
    //         ->select('clients.*')
    //         ->leftJoin('companies AS c2', function ($join) {
    //             $join->on('clients.id', '=', 'c2.client_id')
    //                  ->whereRaw('c2.id = (SELECT id FROM companies WHERE client_id = clients.id LIMIT 1)');
    //         })
    //         ->where('clients.is_deleted', '!=', 1)
    //         ->orderByRaw('CASE WHEN c2.id IS NOT NULL THEN 1 ELSE 0 END DESC')
    //         ->orderByDesc('clients.id')
    //         ->with(['category', 'company', 'branches', 'address', 'passport', 'files'])
    //         ->paginate(25);
    
    //     return view('pages.products.index', compact('clients', 'categories'));
    // }
    public function apz_second()
    {
        $categories = Category::get()->all();
        $clients = Client::deepFilters()
            ->with(['category', 'company', 'branches', 'address', 'passport', 'files'])
            ->where('is_deleted', '!=', 1)
            ->where('is_qonuniy', '=', 0)
            ->orderBy('status', 'asc')

            ->paginate(25);
    
        return view('pages.products.apz_second', compact('clients','categories'));
    }

    public function client_confirm()
    {
        try {
            $categories = Category::all();
            $clients = Client::deepFilters()
                ->with(['category', 'company', 'branches', 'address', 'passport', 'files'])
                ->where('is_deleted', '!=', 1)
                ->where('created_by_client', '=', 1)
                ->orderBy('id', 'desc')
                ->paginate(25);
    
            // Calculate Ti for each client's branches
            foreach ($clients as $client) {
                foreach ($client->branches as $branch) {
                    // Step 1: Retrieve and set default values
                    $Bh = (float)($client->company->minimum_wage ?? 340000); // Default to 340,000
                    $Hb = (float)($branch->shaxarsozlik_umumiy_xajmi ?? 0);
                    $Hyu = (float)($branch->qavatlar_soni_xajmi ?? 0);
                    $Ha = (float)($branch->avtoturargoh_xajmi ?? 0);
                    $Ht = (float)($branch->qavat_xona_xajmi ?? 0);
                    $Hu = (float)($branch->umumiy_foydalanishdagi_xajmi ?? 0); 
                    $coefficient = (float)($branch->coefficient ?? 1);
            
                  
                    $Ti = $Bh * (($Hb + $Hyu) - ($Ha + $Ht + $Hu)) * $coefficient;
            
                 
                    Log::info('Intermediate values for client ' . $client->id . ', branch ' . $branch->id . ':');
                    Log::info('Bh * (Hb + Hyu): ' . ($Bh * ($Hb + $Hyu)));
                    Log::info('Ha + Ht + Hu: ' . ($Ha + $Ht + $Hu));
                    Log::info('Calculated Ti: ' . $Ti);
                    Log::info('----------------------------- ');
            
                    $branch->calculated_Ti = $Ti;
                }
            }
            
    
            return view('pages.products.apz_second', compact('clients', 'categories'));
        } catch (\Exception $e) {
            Log::error('Error in client_confirm: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching clients: ' . $e->getMessage());
        }
    }
    

    
    public function show($id)
    {
        $client = Client::where('id', $id)
            ->with(['company','branches','address','passport','files'])
            ->where('is_deleted', '!=', 1)
            ->get()->first();

        $files = $client ? $client->files : collect();

        if ($client) {
            return view('pages.products.show', compact('client', 'files'));
        } else {
            return response()->view('errors.404', ['status' => 404, 'message' => 'Applicant Not found'], 404);
        }
    }

    public function add_fizik()
    {
        $xujjatTurlari = XujjatTuri::get()->all();
        $xujjatBerilganJoyi = XujjatBerilganJoyi::get()->all();
        $categories = Category::get()->all();
        $regions = Regions::get()->all();
        return view('pages.products.add_fizik', compact('regions','categories','xujjatTurlari','xujjatBerilganJoyi'));
    }

    public function add_yuridik()
    {
        $subyektShakli = SubyektShakli::get()->all();
        $categories = Category::get()->all();
        $regions = Regions::get()->all();
        $bank = Bank::get()->all();

        return view('pages.products.add_yuridik', compact('regions','categories','bank','subyektShakli'));
    }


    public function client_create()
    {
        $categories = Category::get()->all();
        $regions = Regions::get()->all();
        return view('pages.products.client_create', compact('regions','categories'));
    }

    public function create(Request $request)
    {
        dd($request);
        $request->validate([
            'stir' => 'nullable|string|max:9|min:9|unique:companies,stir',
            'oked' => 'nullable|string|max:5|min:5',
            'bank_code' => 'nullable|string|max:5|min:5',
            'bank_account' => 'nullable|string|max:20|min:20',
            'passport_serial' => 'nullable|string|max:10|min:9',
            'passport_pinfl' => 'nullable|string|max:14|min:14',
        ]);
        // dd($request);   
        

        DB::beginTransaction();

        try {
            $client = Client::create([
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'father_name' => $request->get('father_name'),
                'mijoz_turi' => $request->get('mijoz_turi'),
                'contact' => $request->get('contact'),
                'client_description' => $request->get('client_description'),
                'category_id' => $request->get('category_id',2),
                'created_by_client' => $request->get('created_by_client', 0),
            ]);

            $client->company()->create([
                'client_id' => $client->id,
                'subyekt_shakli_id' => $request->get('subyekt_shakli_id'),
                'company_name' => $request->get('company_name'),
                'oked' => $request->get('oked'),
                'bank_id' => $request->get('bank_id') ?? null,
            ]);

            $client->passport()->create([
                'passport_serial' => $request->get('passport_serial') ?? null,
                'passport_pinfl' => $request->get('passport_pinfl') ?? null,
                'passport_date' => $request->get('passport_date') ?? null,
                'passport_location' => $request->get('passport_location') ?? null,
                'passport_type' => $request->get('passport_type') ?? 0,
            ]);

            $client->address()->create([
                'yuridik_address' => $request->get('yuridik_address') ?? null,
                'home_address' => $request->get('home_address') ?? null,
                'company_location' => $request->get('company_location') ?? null,
            ]);
    
            function handleFileUploadProduct($files, $client, $folder)
            {
                foreach ($files as $file) {
                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $date = date('Ymd_His');
                    $fileName = $originalName . '_' . $date . '.' . $extension;
                    $file->move(public_path('assets/' . $folder), $fileName);

                    $fileModel = new File();
                    $fileModel->client_id = $client->id;
                    $fileModel->path = 'assets/' . $folder . '/' . $fileName;
                    $fileModel->save();
                }
            }

            if ($request->hasFile('document')) {
                handleFileUploadProduct($request->file('document'), $client, 'documents');
            }

            if ($request->hasFile('document_payment')) {
                handleFileUploadProduct($request->file('document_payment'), $client, 'payment');
            }

            if ($request->hasFile('document_ruxsatnoma')) {
                handleFileUploadProduct($request->file('document_ruxsatnoma'), $client, 'ruxsatnoma');
            }

            if ($request->hasFile('document_kengash')) {
                handleFileUploadProduct($request->file('document_kengash'), $client, 'kengash');
            }
            if ($request->hasFile('loyiha_xujjati')) {
                handleFileUploadProduct($request->file('loyiha_xujjati'), $client, 'loyiha_xujjati');
            }

            if ($request->hasFile('qurilish_xajmi')) {
                handleFileUploadProduct($request->file('qurilish_xajmi'), $client, 'qurilish_xajmi');
            }




            foreach ($request->accordions as $accordion) {
                Branch::create([
                    'client_id' => $client->id,
                    'contract_apt' => $accordion['contract_apt'] ?? null,
                    'contract_date' => $accordion['contract_date'] ?? null,
                    'branch_kubmetr' => $accordion['branch_kubmetr'] ?? null,
                    'branch_type' => $accordion['branch_type'] ?? null,
                    'branch_type_text' => $accordion['branch_type_text'] ?? null,
                    'branch_location' => $accordion['branch_location'] ?? null,
                    'obyekt_joylashuvi' => $accordion['obyekt_joylashuvi'] ?? null,
                    'branch_name' => $accordion['branch_name'] ?? null,
                    'generate_price' => $accordion['generate_price'] ?? null,
                    'payment_type' => $accordion['payment_type'] ?? null,
                    'percentage_input' => $accordion['percentage_input'] ?? null,
                    'installment_quarterly' => $accordion['installment_quarterly'] ?? null,
                    'notification_num' => $accordion['notification_num'] ?? null,
                    'notification_date' => $accordion['notification_date'] ?? null,
                    'insurance_policy' => $accordion['insurance_policy'] ?? null,
                    'bank_guarantee' => $accordion['bank_guarantee'] ?? null,
                    'application_number' => $accordion['application_number'] ?? null,
                    'payed_sum' => $accordion['payed_sum'] ?? null,
                    'payed_date' => $accordion['payed_date'] ?? null,
                    'first_payment_percent' => $accordion['first_payment_percent'] ?? null,
                    

                    'shaxarsozlik_umumiy_xajmi' => $accordion['shaxarsozlik_umumiy_xajmi'] ?? null,
                    'qavatlar_soni_xajmi' => $accordion['qavatlar_soni_xajmi'] ?? null,
                    'avtoturargoh_xajmi' => $accordion['avtoturargoh_xajmi'] ?? null,
                    'qavat_xona_xajmi' => $accordion['qavat_xona_xajmi'] ?? null,
                    'umumiy_foydalanishdagi_xajmi' => $accordion['umumiy_foydalanishdagi_xajmi'] ?? null,
                    'qurilish_turi' => $accordion['qurilish_turi'] ?? null,
                    'coefficient' => $accordion['coefficient'] ?? null,
                    'zona' => $accordion['zona'] ?? null,
                    'created_by_client' => $accordion['created_by_client'] ?? null,
                    'confirmed_for_client' => $accordion['confirmed_for_client'] ?? null,
                ]);
            }

            DB::commit();

        return redirect()->route('clientIndex')->with('success', 'Client created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'An error occurred while creating the client: ' . $e->getMessage());
        }
    }

   

    public function edit($id)
    {

        $categories = Category::get()->all();
        $client = Client::where('id', $id)
            ->with(['branches', 'files'])
            ->where('is_deleted', '!=', 1)
            ->firstOrFail();

        $files = $client ? $client->files : collect();

        return view('pages.products.edit', compact('client', 'files','categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'stir' => 'nullable|string|max:9|min:9',
            'oked' => 'nullable|string|max:5|min:5',
            'bank_code' => 'nullable|string|max:5|min:5',
            'bank_account' => 'nullable|string|max:20|min:20',
            'passport_serial' => 'nullable|string|max:10|min:9',
            'passport_pinfl' => 'nullable|string|max:14|min:14',
        ]);
    
        DB::beginTransaction();
    
        try {
            $client = Client::findOrFail($id);
    
            // Ensure client and associated company exist
            if (!$client || !$client->company) {
                throw new \Exception('Client or associated company not found.');
            }
    
            $client->update([
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'father_name' => $request->get('father_name'),
                'mijoz_turi' => $request->get('mijoz_turi'),
                'contact' => $request->get('contact'),
                'client_description' => $request->get('client_description'),
                'category_id' => $request->get('category_id', 2)
            ]);
    
            $client->company->update([
                'company_name' => $request->get('company_name') ?? null,
                'raxbar' => $request->get('raxbar') ?? null,
                'bank_code' => $request->get('bank_code') ?? null,
                'bank_service' => $request->get('bank_service') ?? null,
                'bank_account' => $request->get('bank_account') ?? null,
                'stir' => $request->get('stir') ?? null,
                'oked' => $request->get('oked') ?? null,
                'minimum_wage' => $request->get('minimum_wage') ?? null,
            ]);
    
            // Update passport details
            if ($client->passport) {
                $client->passport->update([
                    'passport_serial' => $request->get('passport_serial') ?? null,
                    'passport_pinfl' => $request->get('passport_pinfl') ?? null,
                    'passport_date' => $request->get('passport_date') ?? null,
                    'passport_location' => $request->get('passport_location') ?? null,
                    'passport_type' => $request->get('passport_type') ?? 0,
                ]);
            }
    
            // Update address details
            if ($client->address) {
                $client->address->update([
                    'yuridik_address' => $request->get('yuridik_address') ?? null,
                    'home_address' => $request->get('home_address') ?? null,
                    'company_location' => $request->get('company_location') ?? null,
                ]);
            }
    
            // Update or create branches
            foreach ($request->accordions as $accordionData) {
                $branch = Branch::find($accordionData['id']);
    
                if ($branch) {
                    $branch->update($accordionData);
                } else {
                    $branch = new Branch($accordionData);
                    $branch->client_id = $client->id;
                    $branch->save();
                }
            }
    
            // Handle file uploads
            function handleFileUpload($files, $client, $folder)
            {
                foreach ($files as $file) {
                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $date = date('Ymd_His');
                    $fileName = $originalName . '_' . $date . '.' . $extension;
                    $file->move(public_path('assets/' . $folder), $fileName);
    
                    $fileModel = new File();
                    $fileModel->client_id = $client->id;
                    $fileModel->path = 'assets/' . $folder . '/' . $fileName;
                    $fileModel->save();
                }
            }
    
            if ($request->hasFile('document')) {
                handleFileUpload($request->file('document'), $client, 'documents');
            }
    
            if ($request->hasFile('document_payment')) {
                handleFileUpload($request->file('document_payment'), $client, 'payment');
            }
    
            if ($request->hasFile('document_ruxsatnoma')) {
                handleFileUpload($request->file('document_ruxsatnoma'), $client, 'ruxsatnoma');
            }
    
            if ($request->hasFile('document_kengash')) {
                handleFileUpload($request->file('document_kengash'), $client, 'kengash');
            }
            if ($request->hasFile('loyiha_xujjati')) {
                handleFileUpload($request->file('loyiha_xujjati'), $client, 'loyiha_xujjati');
            }

            if ($request->hasFile('qurilish_xajmi')) {
                handleFileUpload($request->file('qurilish_xajmi'), $client, 'qurilish_xajmi');
            }

    
            // Delete files if requested
            if ($request->has('delete_files')) {
                foreach ($request->input('delete_files') as $fileId) {
                    $file = File::find($fileId);
                    if ($file) {
                        if (Storage::exists($file->path)) {
                            Storage::delete($file->path);
                        }
                        $file->delete();
                    }
                }
            }
    
            DB::commit();
    
            $currentPage = $request->input('page', 1);
    
            // return redirect()->back()->with('success', 'Product updated successfully');
            return redirect()->route('clientIndex', ['page' => $currentPage])->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
    
            return redirect()->back()->with('error', 'An error occurred while updating the product: ' . $e->getMessage());
        }
    }
    


        public function delete($id)
        {
            try {
                // $client = Client::where('id', $id)->firstOrFail();

                // $client->update([
                //     'is_deleted' => 1,
                //     'stir'=>null
                // ]);
                $client = Client::find($id);
                $client->delete();  

                return redirect()->back()->with('success', 'Client marked as deleted successfully');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'An error occurred while marking the client as deleted: ' . $e->getMessage());
            }
        }

    public function toggleclientActivation($id)
    {
        $client = Client::findOrFail($id);
        $client->status = $client->status === 1 ? 2 : 1;
        $client->save();
    
        // Log the change to the confirms table
        Confirm::create([
            'user_id' => auth()->user()->id,
            'client_id' => $client->id,
            'status' => $client->status
        ]);
    
        return [
            'is_active' => $client->status
        ];
    }
}
