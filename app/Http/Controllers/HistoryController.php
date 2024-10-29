<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientHistory;
use App\Models\FileHistory;
use App\Models\AddressHistory;
use App\Models\PassportHistory;
use App\Models\CompanyHistory;
use App\Models\BranchHistory;
use App\Models\Confirm;
use App\Models\History;
use App\Models\User;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve filter and search inputs from the request
        $modelType = $request->input('model_type');
        $userId = $request->input('user_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $search = $request->input('search');

        // Build the query with filters and search
        $query = History::query();

        if ($modelType) {
            $query->where('model_type', $modelType);
        }

        if ($userId) {
            $query->where('user_id', $userId);
        }

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        if ($search) {
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('field', 'like', "%$search%")
                    ->orWhere('old_value', 'like', "%$search%")
                    ->orWhere('new_value', 'like', "%$search%");
            });
        }

        $histories = $query->with('user')->paginate(10);

        // Fetch unique model types and users for the filters
        $modelTypes = History::select('model_type')->distinct()->pluck('model_type');
        $users = User::all();

        return view('histories.index', compact('histories', 'modelTypes', 'users'));
    }
    // public function index()
    // {
    //     // Subquery to get the latest history timestamp for each client
    //     $latestHistorySubquery = \DB::table('clients')
    //         ->leftJoin('branch_histories', 'clients.id', '=', 'branch_histories.client_id')
    //         ->leftJoin('address_histories', 'clients.id', '=', 'address_histories.client_id')
    //         ->leftJoin('company_histories', 'clients.id', '=', 'company_histories.client_id')
    //         ->leftJoin('passport_histories', 'clients.id', '=', 'passport_histories.client_id')
    //         ->leftJoin('file_histories', 'clients.id', '=', 'file_histories.client_id')
    //         ->select('clients.id')
    //         ->selectRaw('MAX(COALESCE(
    //             GREATEST(
    //                 COALESCE(branch_histories.created_at, 0),
    //                 COALESCE(address_histories.created_at, 0),
    //                 COALESCE(company_histories.created_at, 0),
    //                 COALESCE(passport_histories.created_at, 0),
    //                 COALESCE(file_histories.created_at, 0)
    //             ), 0)) as latest_history_timestamp')
    //         ->groupBy('clients.id');

    //     // Query to fetch clients with latest history timestamp
    //     $clients = Client::leftJoinSub($latestHistorySubquery, 'latest_history', function ($join) {
    //             $join->on('clients.id', '=', 'latest_history.id');
    //         })
    //         ->orderByDesc('clients.updated_at')
    //         ->select('clients.*', 'latest_history.latest_history_timestamp')
    //         ->paginate(25);

    //     // Eager load the latest history record for each type
    //     $clients->load([
    //         'branchHistory' => function ($query) {
    //             $query->orderByDesc('created_at')->take(1);
    //         },
    //         'addressHistory' => function ($query) {
    //             $query->orderByDesc('created_at')->take(1);
    //         },
    //         'companyHistory' => function ($query) {
    //             $query->orderByDesc('created_at')->take(1);
    //         },
    //         'passportHistory' => function ($query) {
    //             $query->orderByDesc('created_at')->take(1);
    //         },
    //         'fileHistory' => function ($query) {
    //             $query->orderByDesc('created_at')->take(1);
    //         },
    //     ]);

    //     return view('pages.history.index', compact('clients'));
    // }

    // public function index()
    // {
    //     // Fetch clients along with their related histories
    //     $clientHistories = Client::with([
    //         'passportHistories',
    //         'fileHistories',
    //         'companyHistories',
    //         'branchHistories',
    //         'addressHistories'
    //     ])
    //     // ->where('is_deleted', '!=', 1)
    //     ->where(function ($query) {
    //         $query->whereHas('passportHistories')
    //             ->orWhereHas('fileHistories')
    //             ->orWhereHas('companyHistories')
    //             ->orWhereHas('branchHistories')
    //             ->orWhereHas('addressHistories');
    //     })
    //     ->orderBy('created_at', 'desc')
    //     ->paginate(10); 

    //     return view('pages.history.index', compact('clientHistories'));
    // }
    // public function confirm()
    // {
    //     $confirmations = Confirm::with('client', 'user')->orderBy('created_at', 'desc')->paginate(10);
    //     return view('pages.history.confirm', ['confirmations' => $confirmations]);
    // }


    // public function showHistory($id)
    // {
    //     $client = Client::findOrFail($id);

    //     $clientHistories = $client->clientHistories()->orderBy('created_at', 'desc')->paginate(10);
    //     $fileHistories = $client->fileHistories()->orderBy('created_at', 'desc')->paginate(10);
    //     $addressHistories = $client->addressHistories()->orderBy('created_at', 'desc')->paginate(10);
    //     $passportHistories = $client->passportHistories()->orderBy('created_at', 'desc')->paginate(10);
    //     $companyHistories = $client->companyHistories()->orderBy('created_at', 'desc')->paginate(10);
    //     $branchHistories = $client->branchHistories()->orderBy('created_at', 'desc')->paginate(10);

    //     return view('pages.history.show', compact(
    //         'client',
    //         'clientHistories',
    //         'fileHistories',
    //         'addressHistories',
    //         'passportHistories',
    //         'companyHistories',
    //         'branchHistories'
    //     ));
    // }


    // public function showHistory($id)
    // {
    //     $client = Client::findOrFail($id);

    //     $clientHistories = $client->clientHistories()->orderBy('created_at', 'desc')->paginate(10);
    //     $fileHistories = $client->fileHistories()->orderBy('created_at', 'desc')->paginate(10);
    //     $addressHistories = $client->addressHistories()->orderBy('created_at', 'desc')->paginate(10);
    //     $passportHistories = $client->passportHistories()->orderBy('created_at', 'desc')->paginate(10);
    //     $companyHistories = $client->companyHistories()->orderBy('created_at', 'desc')->paginate(10);
    //     $branchHistories = $client->branchHistories()->orderBy('created_at', 'desc')->paginate(10);

    //     $historyTypes = [
    //         'client' => $clientHistories,
    //         'file' => $fileHistories,
    //         'address' => $addressHistories,
    //         'passport' => $passportHistories,
    //         'company' => $companyHistories,
    //         'branch' => $branchHistories,
    //     ];

    //     return view('pages.history.show', compact('client', 'historyTypes'));
    // }


}
