<?php

namespace App\Http\Controllers;

use App\Models\CreditTransaction;
use App\Models\DebetTransaction;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Shuchkin\SimpleXLSX;

class ImportController extends Controller
{
    public function index(){
        return view('pages.import.import2');
    }
    public function import_credit(Request $request){
        $path = $request->file('credit_excel_file')->getRealPath();
    
        try {
            if ($xlsx = SimpleXLSX::parse($path)) {
                $rows = $xlsx->rows(0);
    
                foreach ($rows as $key => $row) {
                    if ($key === 0) {
                        continue; // Skip the header row
                    }
    
                    // Preprocess and sanitize data before insertion
                    $rowData = [
                        'document_number' => $row[1] ?? null,
                        'operation_code' => $row[2] ?? null,
                        'recipient_name' => $row[3] ?? null,
                        'recipient_inn' => $row[4] ?? null,
                        'recipient_mfo' => $row[5] ?? null,
                        'recipient_account' => $row[6] ?? null,
                        'payment_date' => isset($row[7]) ? date('Y-m-d', strtotime($row[7])) : null,
                        'payment_description' => $row[8] ?? null,
                        'debit' => isset($row[9]) ? (float) str_replace(',', '', $row[9]) : 0, // Remove commas
                        'credit' => isset($row[10]) ? (float) str_replace(',', '', $row[10]) : 0, // Remove commas
                        'payer_name' => $row[11] ?? null,
                        'payer_inn' => $row[12] ?? null,
                        'payer_mfo' => $row[13] ?? null,
                        'payer_bank' => $row[14] ?? null,
                        'payer_account' => $row[15] ?? null,
                    ];
    
                    // Check if required fields are present
                    if (!isset($rowData['document_number']) || !isset($rowData['payment_date'])) {
                        throw new \Exception('credit number or payment date is missing.');
                    }
    
                    // Check if a record with the same document number and payment date exists
                    $creditTransaction = CreditTransaction::where('credit', $rowData['credit'])
                        ->where('payment_date', $rowData['payment_date'])
                        ->first();
    
                    if ($creditTransaction) {
                        // Update the existing record
                        $creditTransaction->update($rowData);
                    } else {
                        // Create a new record if it doesn't exist
                        $creditTransaction = CreditTransaction::create($rowData);
                    }
    
                    // Prepare transaction data
                    $transactionData = [
                        'credit_transaction_id' => $creditTransaction->id, // Ensure this field exists in the transactions table
                        'name' => $request->get('name'),
                        'description' => $request->get('description'),
                        'father_name' => $request->get('father_name'),
                        'start_date' => $request->get('start_date'),
                        'end_date' => $request->get('end_date'),
                    ];
    
                    // Update existing transaction or create a new one if it doesn't exist
                    $transaction = Transaction::updateOrCreate(
                        ['credit_transaction_id' => $creditTransaction->id], // unique identifier to find the record
                        $transactionData
                    );
                }
    
                return back()->with('success', 'Data imported successfully.');
            } else {
                return back()->with('error', SimpleXLSX::parseError());
            }
        } catch (\Exception $e) {
            // Log the exception
            \Log::error('Error importing credit data: ' . $e->getMessage());
            
            return back()->with('error', 'Error importing data. Please try again later.');
        }
    }
    
}
