<?php

namespace App\Http\Controllers;

use App\Models\CreditTransaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = CreditTransaction::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('payer_inn', 'like', "%$search%")
                    ->orWhere('payer_mfo', 'like', "%$search%")
                    ->orWhere('payment_date', 'like', "%$search%")
                    ->orWhere('payer_account', 'like', "%$search%")
                    ->orWhere('document_number', 'like', "%$search%")
                    ->orWhere('payment_description', 'like', "%$search%");
            });
        }

        $transactions = $query->orderBy('payment_date', 'desc')->paginate(20);
        $creditSum = CreditTransaction::sum('credit');
        $transactionCount = CreditTransaction::get()->all();
        

        return view('pages.transactions.index', compact('transactions', 'creditSum','transactionCount'));
    }
    public function art(Request $request)
    {
        $query = CreditTransaction::deepFilters()
            ->where(function ($query) {
                $query->where('payment_description', 'like', '%APT%')
                    ->orWhere('payment_description', 'like', '%АПЗ%')
                    ->orWhere('payment_description', 'like', '%ART%')
                    ->orWhere('payment_description', 'like', '%шартнома%')
                    ->orWhere('payment_description', 'like', '%SHARTNOMA%');
            });

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('payer_inn', 'like', "%$search%")
                    ->orWhere('payer_mfo', 'like', "%$search%")
                    ->orWhere('payment_date', 'like', "%$search%")
                    ->orWhere('payer_account', 'like', "%$search%")
                    ->orWhere('document_number', 'like', "%$search%")
                    ->orWhere('payment_description', 'like', "%$search%");
            });
        }

        $transactions = $query->orderBy('payment_date', 'desc')->paginate(20);

        $creditSum = CreditTransaction::where('payment_description', 'like', '%APT%')
            ->orWhere('payment_description', 'like', '%АПЗ%')
            ->sum('credit');

        return view('pages.transactions.art', compact('transactions', 'creditSum'));
    }
    public function ads(Request $request)
    {
        $query = CreditTransaction::deepFilters()
            ->where('payment_description', 'like', '%ГОРОД ТАШКЕНТ%');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('payer_inn', 'like', "%$search%")
                    ->orWhere('payer_mfo', 'like', "%$search%")
                    ->orWhere('payment_date', 'like', "%$search%")
                    ->orWhere('payer_account', 'like', "%$search%")
                    ->orWhere('document_number', 'like', "%$search%")
                    ->orWhere('payment_description', 'like', "%$search%");
            });
        }

        $transactions = $query->orderBy('payment_date', 'desc')->paginate(20);

        $creditSum = CreditTransaction::where('payment_description', 'like', '%ГОРОД ТАШКЕНТ%')
            ->sum('credit');

        return view('pages.transactions.ads', compact('transactions', 'creditSum'));
    }
    public function show($id)
    {
        $transaction = CreditTransaction::find($id);

        if (!$transaction) {
            abort(404, 'Transaction not found');
        }

        // $payerUser = \DB::table('credit_transactions')
        // ->join('clients', 'clients.stir', 'like', \DB::raw("CONCAT('%', credit_transactions.payer_inn, '%')"))
        // ->join('branches', 'branches.client_id', '=', 'clients.id')
        // ->select('credit_transactions.*', 'clients.*', 'branches.*')
        // ->where('credit_transactions.id', $id)
        // ->get();

        return view('pages.transactions.show', compact('transaction'));
    }
   
    public function payers(Request $request)
    {
        $query = \DB::table('credit_transactions')
            ->leftJoin('companies', 'credit_transactions.payer_inn', '=', 'companies.stir')
            ->select(
                'credit_transactions.*',
                'companies.stir as company_stir',
                'companies.company_name' // Adjust based on actual columns in companies table
            )
            ->whereNotNull('credit_transactions.document_number');
            // ->whereColumn('credit_transactions.recipient_inn', '=', 'credit_transactions.payer_inn'); // Correct condition
        
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($query) use ($search) {
                $query->where('credit_transactions.payer_inn', 'like', "%$search%")
                    ->orWhere('credit_transactions.payer_mfo', 'like', "%$search%")
                    ->orWhere('credit_transactions.payment_date', 'like', "%$search%")
                    ->orWhere('credit_transactions.payer_account', 'like', "%$search%")
                    ->orWhere('companies.stir', 'like', "%$search%")
                    ->orWhere('companies.company_name', 'like', "%$search%")
                    ->orWhere('credit_transactions.document_number', 'like', "%$search%")
                    ->orWhere('credit_transactions.payment_description', 'like', "%$search%");
            });
        }
    
        // Execute the query with pagination
        $transactions = $query->orderBy('credit_transactions.payment_date', 'desc')->paginate(20);
    
        // Return the view with the paginated transactions
        return view('pages.transactions.payers', compact('transactions'));
    }
    
}    
