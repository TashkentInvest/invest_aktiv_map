<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Exports\ProductsExport;
use App\Models\Category;
use App\Models\Order;
use App\Models\Shartnoma;
use Carbon\Carbon;



class FileController extends Controller
{

    public function index()
    {
        return view("pages.shartnoma.word.fizik_full");
    }
    public function test($id)
    {

        $orders = Order::with(['client', 'branch'])->get();
        foreach ($orders as $order) {

            $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->generate_price;
            if ($this->isValidValue(number_format($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->generate_price, 0, '', ''))) {
                $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->generate_price_text = $this->transformToText(floor($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->generate_price));
            } else {
                $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->generate_price_text = $this->transformToText(floor($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->generate_price));
            }

            $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->percentage_input;
            if ($this->isValidValue(number_format($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->percentage_input, 0, '', ''))) {
                $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->percentage_input_text = $this->transformToText(floor($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->percentage_input));
            } else {
                $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->percentage_input_text = $this->transformToText(floor($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->percentage_input));
            }

            $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->first_payment_percent;
            if ($this->isValidValue(number_format($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->first_payment_percent, 0, '', ''))) {
                $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->first_payment_percent_text = $this->transformToText(floor($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->first_payment_percent));
            } else {
                $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->first_payment_percent_text = $this->transformToText(floor($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->first_payment_percent));
            }

            $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->qolgan_foiz = (100 - $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->percentage_input);
            if ($this->isValidValue(number_format($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->qolgan_foiz, 0, '', ''))) {
                $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->qolgan_foiz_text = $this->transformToText(floor($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->qolgan_foiz));
            } else {
                $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->qolgan_foiz_text = $this->transformToText(floor($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->qolgan_foiz));
            }

            $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->qolgan_tolov = ($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->generate_price - $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->first_payment_percent);
            if ($this->isValidValue(number_format($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->qolgan_tolov, 0, '', ''))) {
                $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->qolgan_tolov_text = $this->transformToText(floor($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->qolgan_tolov));
            } else {
                $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->qolgan_tolov_text = $this->transformToText(floor($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->qolgan_tolov));
            }

            $order->branch->loyihaHajmiMalumotnoma->branch_kubmetr;
            if ($this->isValidValue(number_format($order->branch->loyihaHajmiMalumotnoma->branch_kubmetr, 0, '', ''))) {
                $order->branch->loyihaHajmiMalumotnoma->branch_kubmetr_text = $this->transformToText(floor($order->branch->loyihaHajmiMalumotnoma->branch_kubmetr));
            } else {
                $order->branch->loyihaHajmiMalumotnoma->branch_kubmetr_text = $this->transformToText(floor($order->branch->loyihaHajmiMalumotnoma->branch_kubmetr));
            }

            $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->generate_price;
            if ($this->isValidValue(number_format($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->generate_price, 0, '', ''))) {
                $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->generate_price_text = $this->transformToText(floor($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->generate_price));
            } else {
                $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->generate_price_text = $this->transformToText(floor($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->generate_price));
            }
        }
        if ($order->client->mijoz_turi == 'fizik') {

            if ($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->payment_type == 'pay_bolib') {
                return view('pages.shartnoma.word.fizik_bolib', compact('order'));
            } else {
                return view('pages.shartnoma.word.fizik_full', compact('order'));
            }
        } else {

            if ($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->payment_type == 'pay_bolib') {
                return view('pages.shartnoma.word.yurik_bolib', compact('order'));
            } else {
                return view('pages.shartnoma.word.yurik_full', compact('order'));
            }
        }
    }

    public function downloadDocument()
    {

        $orders = Order::with(['client', 'branch'])->get();
        foreach ($orders as $order) {

            $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->generate_price;
            if ($this->isValidValue(number_format($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->generate_price, 0, '', ''))) {
                $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->generate_price_text = $this->transformToText(floor($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->generate_price));
            } else {
                $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->generate_price_text = $this->transformToText(floor($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->generate_price));
            }

            $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->percentage_input;
            if ($this->isValidValue(number_format($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->percentage_input, 0, '', ''))) {
                $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->percentage_input_text = $this->transformToText(floor($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->percentage_input));
            } else {
                $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->percentage_input_text = $this->transformToText(floor($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->percentage_input));
            }

            $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->first_payment_percent;
            if ($this->isValidValue(number_format($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->first_payment_percent, 0, '', ''))) {
                $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->first_payment_percent_text = $this->transformToText(floor($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->first_payment_percent));
            } else {
                $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->first_payment_percent_text = $this->transformToText(floor($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->first_payment_percent));
            }

            $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->qolgan_foiz = (100 - $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->percentage_input);
            if ($this->isValidValue(number_format($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->qolgan_foiz, 0, '', ''))) {
                $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->qolgan_foiz_text = $this->transformToText(floor($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->qolgan_foiz));
            } else {
                $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->qolgan_foiz_text = $this->transformToText(floor($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->qolgan_foiz));
            }

            $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->qolgan_tolov = ($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->generate_price - $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->first_payment_percent);
            if ($this->isValidValue(number_format($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->qolgan_tolov, 0, '', ''))) {
                $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->qolgan_tolov_text = $this->transformToText(floor($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->qolgan_tolov));
            } else {
                $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->qolgan_tolov_text = $this->transformToText(floor($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->qolgan_tolov));
            }

            $order->branch->loyihaHajmiMalumotnoma->branch_kubmetr;
            if ($this->isValidValue(number_format($order->branch->loyihaHajmiMalumotnoma->branch_kubmetr, 0, '', ''))) {
                $order->branch->loyihaHajmiMalumotnoma->branch_kubmetr_text = $this->transformToText(floor($order->branch->loyihaHajmiMalumotnoma->branch_kubmetr));
            } else {
                $order->branch->loyihaHajmiMalumotnoma->branch_kubmetr_text = $this->transformToText(floor($order->branch->loyihaHajmiMalumotnoma->branch_kubmetr));
            }

            $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->generate_price;
            if ($this->isValidValue(number_format($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->generate_price, 0, '', ''))) {
                $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->generate_price_text = $this->transformToText(floor($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->generate_price));
            } else {
                $order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->generate_price_text = $this->transformToText(floor($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->generate_price));
            }
        }

        // Prepare HTML content
        // $htmlContent = view('pages.docs.full_pay.fizik_full_new', compact('order'))->render();
        if ($order->client->mijoz_turi == 'fizik') {

            if ($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->payment_type == 'pay_bolib') {
                $htmlContent = view('pages.docs.bolib_pay.fizik_bolib_new', compact('order'))->render();
            } else {
                $htmlContent = view('pages.docs.full_pay.fizik_full_new', compact('order'))->render();
            }
        } else {

            if ($order->branch->shartnoma->shartnoma_rasmiylashtirish_uchun->tolovGrafigi->payment_type == 'pay_bolib') {
                $htmlContent = view('pages.docs.bolib_pay.yurik_bolib_new', compact('order'))->render();
            } else {
                $htmlContent = view('pages.docs.full_pay.yurik_full_new', compact('order'))->render();
            }
        }

        // Set headers to download the document
        $headers = [
            'Content-Type' => 'application/msword',
            'Content-Disposition' => 'attachment; filename="mydoc.doc"',
        ];

        // Return the response with the HTML content and headers
        return response()->stream(
            function () use ($htmlContent) {
                echo $htmlContent;
            },
            200,
            $headers
        );
    }

    public function downloadFullTableData($startDate = null, $endDate = null)
    {
        $fileName = 'АПЗ_РАҚАМ' . '_' . now()->format('Y-m-d') . '.xls';

        return Excel::download(new ProductsExport(null, $startDate, $endDate), $fileName);
    }
    public function downloadTableData($id, $startDate = null, $endDate = null)
    {
        $fileName = 'АПЗ_РАҚАМ' . '_' . now()->format('Y-m-d') . '.xls';

        return Excel::download(new ProductsExport($id, $startDate, $endDate), $fileName);
    }
    // public function downloadExcel(Request $request)
    // {
    //     $columns = $request->input('columns', []);

    //     return Excel::download(new ProductsExport(null, null, null, $columns), 'products.xlsx');
    // }


    public function downloadExcel(Request $request)
    {
        $columns = $request->input('columns', []);
        $id = $request->input('id', null);
        $startDate = $request->input('startDate', null);
        $endDate = $request->input('endDate', null);

        return Excel::download(new ProductsExport($id, $startDate, $endDate, $columns), 'products.xlsx');
    }

    // public function downloadExcel(Request $request)
    // {
    //     $columns = $request->input('columns', []);
    //     $id = $request->input('id', null);
    //     $startDate = $request->input('startDate', null);
    //     $endDate = $request->input('endDate', null);

    //     return (new ProductsExport($id, $startDate, $endDate, $columns))->download('products.xlsx');
    // }

    public function showColumnSelectionForm()
    {
        return view('pages.exel.select_columns');
    }

    public function dop($id)
    {
        $client = Client::with('branches')
            ->where('is_deleted', '!=', 1)
            ->find($id);


        foreach ($client->branches as $branch) {
            $branch->generate_price;
            $branch->branch_kubmetr;
            $branch->branch_type;
            $branch->branch_location;
        }
        return view('pages.docs.dop_saglashenya', compact('client', 'branch'));
    }

    public function gerb($id)
    {
        $headers = array(
            'Content-type' => 'text/html',
            'Content-Disposition' => 'attachement; Filename=mydoc.doc'
        );

        $client = Client::where('id', $id)
            ->with(['company', 'branches', 'address', 'passport'])
            ->first();



        return Response::make(view('pages.docs.mobile', compact('client')), 200, $headers);
    }
    // public function gerb($id){
    //       $client = Client::where('id', $id)
    //     ->with(['company', 'branches', 'address', 'passport'])
    //     ->first();


    //     return view('pages.docs.mobile', compact('client'));
    // }

    // Number to text start ---------------------------------------------------------------------------------


    public function show($id)
    {
        // Fetch the client along with branches if not deleted
        $client = Client::with('branches')
            ->where('is_deleted', '!=', 1)
            ->find($id);

        if (!$client) {
            return response()->view('errors.custom', ['status' => 404, 'message' => 'Client Not Found'], 404);
        }

        $clientAttributes = [
            'yuridik_rekvizid',
            'contact',
            'branch_type',
            'company_location',
            'bank_code',
            'stir',
            'oked',
            'birth_date'
        ];

        foreach ($clientAttributes as $attribute) {
            $client->$attribute;
        }

        $branchDocuments = [];

        // $fizikBolibView = 'pages.docs.bolib_pay.fizik_litso';
        // $fizikFullView = 'pages.docs.full_pay.fizik_litso';
        // $yurikBolibView = 'pages.docs.bolib_pay.yurik_l  itso';
        // $yurikFullView = 'pages.docs.full_pay.yurik_litso';

        $fizikBolibView = 'pages.docs.bolib_pay.fizik_bolib_new';
        $fizikFullView = 'pages.docs.full_pay.fizik_full_new';
        $yurikBolibView = 'pages.docs.bolib_pay.yurik_bolib_new';
        $yurikFullView = 'pages.docs.full_pay.yurik_full_new';

        foreach ($client->branches as $branch) {
            $branch->branch_kubmetr;
            if ($this->isValidValue(number_format($branch->branch_kubmetr, 0, '', ''))) {
                $branch->branch_kubmetr_text = $this->transformToText(floor($branch->branch_kubmetr));
            } else {
                $branch->branch_kubmetr_text = $this->transformToText(floor($branch->branch_kubmetr));
            }

            $branch->generate_price;
            if ($this->isValidValue(number_format($branch->generate_price, 0, '', ''))) {
                $branch->generate_price_text = $this->transformToText(floor($branch->generate_price));
            } else {
                $branch->generate_price_text = $this->transformToText(floor($branch->generate_price));
            }

            $branch->percentage_input;
            if ($this->isValidValue(number_format($branch->percentage_input, 0, '', ''))) {
                $branch->percentage_input_text = $this->transformToText(floor($branch->percentage_input));
            } else {
                $branch->percentage_input_text = $this->transformToText(floor($branch->percentage_input));
            }

            $branch->first_payment_percent;
            if ($this->isValidValue(number_format($branch->first_payment_percent, 0, '', ''))) {
                $branch->first_payment_percent_text = $this->transformToText(floor($branch->first_payment_percent));
            } else {
                $branch->first_payment_percent_text = $this->transformToText(floor($branch->first_payment_percent));
            }

            $branch->qolgan_foiz = (100 - $branch->percentage_input);
            if ($this->isValidValue(number_format($branch->qolgan_foiz, 0, '', ''))) {
                $branch->qolgan_foiz_text = $this->transformToText(floor($branch->qolgan_foiz));
            } else {
                $branch->qolgan_foiz_text = $this->transformToText(floor($branch->qolgan_foiz));
            }

            $branch->qolgan_tolov = ($branch->generate_price - $branch->first_payment_percent);
            if ($this->isValidValue(number_format($branch->qolgan_tolov, 0, '', ''))) {
                $branch->qolgan_tolov_text = $this->transformToText(floor($branch->qolgan_tolov));
            } else {
                $branch->qolgan_tolov_text = $this->transformToText(floor($branch->qolgan_tolov));
            }
            $branch->branch_type;
            $branch->branch_type_text;
            $branch->branch_location;

            // Ensure valid filenames with identifiers
            $fizikBolibFilename = 'fizik_bolib_' . preg_replace('/[<>:"\/\\|?*]+/', '_', $client->company_name . '_branch_' . $branch->id . '_name_' . $branch->contract_apt . '.doc');
            $fizikFullFilename = 'fizik_full_' . preg_replace('/[<>:"\/\\|?*]+/', '_', $client->company_name . '_branch_' . $branch->id . '_name_' . $branch->contract_apt . '.doc');
            $yurikBolibFilename = 'yurik_bolib_' . preg_replace('/[<>:"\/\\|?*]+/', '_', $client->company_name . '_branch_' . $branch->id . '_name_' . $branch->contract_apt . '.doc');
            $yurikFullFilename = 'yurik_full_' . preg_replace('/[<>:"\/\\|?*]+/', '_', $client->company_name . '_branch_' . $branch->id . '_name_' . $branch->contract_apt . '.doc');

            // Render documents for each branch and add them to the branchDocuments array
            $branchDocuments[] = ['document' => view($fizikBolibView, compact('client', 'branch'))->render(), 'filename' => $fizikBolibFilename];
            $branchDocuments[] = ['document' => view($fizikFullView, compact('client', 'branch'))->render(), 'filename' => $fizikFullFilename];
            $branchDocuments[] = ['document' => view($yurikBolibView, compact('client', 'branch'))->render(), 'filename' => $yurikBolibFilename];
            $branchDocuments[] = ['document' => view($yurikFullView, compact('client', 'branch'))->render(), 'filename' => $yurikFullFilename];
        }


        $zip = new \ZipArchive();
        $zipFileName = storage_path('app/АПЗ_' . \Carbon\Carbon::now()->format('Y-m-d') . '.zip');

        if ($zip->open($zipFileName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            // Log error if zip file cannot be opened
            \Log::error('Cannot create zip file at ' . $zipFileName);
            return response()->view('errors.custom', ['status' => 500, 'message' => 'Cannot create zip file'], 500);
        }

        foreach ($branchDocuments as $branchDoc) {
            $zip->addFromString($branchDoc['filename'], $branchDoc['document']);
        }
        $zip->close();

        return response()->download($zipFileName)->deleteFileAfterSend(true);
    }

    private $units = array("бир", "икки", "уч", "тўрт", "беш", "олти", "етти", "саккиз", "тўққиз");
    private $teens = array(
        "ўн", "ўн бир", "ўн икки", "ўн уч", "ўн тўрт", "ўн беш",
        "ўн олти", "ўн етти", "ўн саккиз", "ўн тўққиз"
    );
    private $tens = array("йигирма", "ўттиз", "қирқ", "эллик", "олтмиш", "етмиш", "саксон", "тўқсон");
    private $hundreds = array("бир юз", "икки юз", "уч юз", "тўрт юз", "беш юз", "олти юз", "етти юз", "саккиз юз", "тўққиз юз");
    private $thousands = array("минг", "минг", "минг");
    private $millions = array("миллион", "миллион", "миллион");
    private $milliards = array("миллиард", "миллиард", "миллиард");
    private $femailThousands = array("бир", "икки");


    public function convert(Request $request)
    {
        $value = $request->input('value');
        if ($this->isValidValue($value)) {
            $text = $this->transformToText($value);
        } else {
            $text = "Киритилган қиймат нотўғри ёки рухсат этилган диапазонга кирмайди";
        }

        return view('pages.number_to_text', compact('text'));
    }

    // private function isValidValue($value)
    // {
    //     if ($value == '0' || (preg_match("/^-{0,1}[1-9]{1,1}[0-9]{1,9}(?:\.\d{1,2})?$/", $value, $matcher) && abs($matcher[0]) <= 2147483647)) {
    //         return true;
    //     }
    //     return false;
    // }
    private function isValidValue($value)
    {
        if ($value == '0' || (preg_match("/^-{0,1}\d+(\.\d{1,2})?$/", $value, $matcher) && abs($matcher[0]) <= 2147483647)) {
            return true;
        }
        return false;
    }


    private function transformToText($value)
    {
        $parts = explode('.', $value);
        $integerPart = $parts[0];
        $decimalPart = isset($parts[1]) ? $parts[1] : null;

        $integerText = $this->convertIntegerToText($integerPart);
        if ($decimalPart !== null) {
            $decimalText = $this->convertIntegerToText($decimalPart);
            return $integerText . ' бутун ' . $decimalText;
        }
        return $integerText;
    }

    private function convertIntegerToText($value)
    {
        $tempValue = $this->prepareValue($value);
        if ($tempValue[1] == 0) {
            return "нол";
        }
        $text = "";
        $value = $tempValue[1];

        if ($value >= 1000000000) {
            $text .= $this->getTextByDigitClass($value, 1000000000);
        }
        if ($value >= 1000000) {
            $text .= $this->getTextByDigitClass($value, 1000000);
        }
        if ($value >= 1000) {
            $text .= $this->getTextByDigitClass($value, 1000);
        }
        if ($value >= 1) {
            $text .= $this->getTextByDigitClass($value, 1);
        }
        if ($tempValue[0]) {
            $text = $tempValue[0] . " " . $text;
        }
        return $text;
    }

    private function prepareValue($value)
    {
        $value = trim($value);
        $value = str_replace(" ", "", $value);
        $number = array();
        if ($value[0] == '-') {
            $number[] = 'минус';
            $number[] = intval(substr($value, 1));
        } else {
            $number[] = '';
            $number[] = intval(substr($value, 0));
        }
        return $number;
    }

    private function getTextByDigitClass($value, $digitClass)
    {
        $tempText = "";
        $temp = $value / $digitClass;
        $temp %= 1000;
        $triade = $temp;
        if ($triade >= 100) {
            $tempText .= $this->hundreds[$triade / 100 - 1] . " ";
            $triade %= 100;
        }
        if ($triade >= 10) {
            if (intval($triade / 10) == 1) {
                $tempText .= $this->teens[$triade - 10] . " ";
            } else {
                $tempText .= $this->tens[$triade / 10 - 2] . " ";
                $triade %= 10;
            }
        }
        if ($triade >= 1 && $triade < 10) {
            if ($digitClass == 1000 && ($triade == 1 || $triade == 2)) {
                $tempText .= $this->femailThousands[$triade - 1] . " ";
            } else {
                $tempText .= $this->units[$triade - 1] . " ";
            }
        }
        if ($temp) {
            switch ($digitClass) {
                case 1000:
                    $tempText .= $this->addDigitClassName($this->thousands, $triade);
                    break;
                case 1000000:
                    $tempText .= $this->addDigitClassName($this->millions, $triade);
                    break;
                case 1000000000:
                    $tempText .= $this->addDigitClassName($this->milliards, $triade);
                    break;
            }
        }
        return $tempText;
    }

    private function addDigitClassName($digitClassArr, $lastNumber)
    {
        $tempText = "";
        switch ($lastNumber) {
            case 1:
                $tempText .= $digitClassArr[0] . " ";
                break;
            case 2:
            case 3:
            case 4:
                $tempText .= $digitClassArr[1] . " ";
                break;
            default:
                $tempText .= $digitClassArr[2] . " ";
                break;
        }
        return $tempText;
    }
}
