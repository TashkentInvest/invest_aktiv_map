<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Shuchkin\SimpleXLSX;
use App\Models\Client;
use App\Models\Shartnoma;
use App\Models\TolovGrafigi;
use App\Models\Branch;
use App\Models\Company;
use App\Models\District;
use App\Models\LoyihaHajmiMalumotnoma;
use App\Models\Ruxsatnoma;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Shuchkin\SimpleXLSXGen;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExcelController extends Controller
{
    public function index()
    {
        $branches = Branch::with(['client', 'shartnoma.tolovGrafigi', 'substreet', 'ruxsatnoma.shartnoma'])
            ->paginate(25);

        $branches->getCollection()->transform(function ($branch) {
            $shartnomaSanasi = $branch->shartnoma->shartnoma_sanasi ?? null;
            $shartnomaQiymati = $branch->shartnoma->tolovGrafigi->generate_price ?? 0;
            $installmentQuarterly = $branch->shartnoma->tolovGrafigi->installment_quarterly ?? 0;
            $paymentDeadline = $branch->shartnoma->tolovGrafigi->payment_deadline ?? null;
            $advanceAndBalanceSum = $branch->shartnoma->tolovGrafigi->advance_and_balance_sum ?? 0; // Assuming you have this value

            if (!$shartnomaSanasi || !$paymentDeadline || $installmentQuarterly <= 0) {
                $branch->payment_dates = [];
                $branch->payment_amount = 0;
                $branch->payment_status = [];
                return $branch;
            }

            // Calculate the payment schedule
            $paymentDates = [];
            $currentDate = $shartnomaSanasi;
            while ($currentDate <= $paymentDeadline) {
                $paymentDates[] = $currentDate->format('d/m/y');
                $currentDate->addMonths(3); // Add 3 months for quarterly payments
            }

            $branch->payment_dates = $paymentDates;
            $branch->payment_amount = $shartnomaQiymati / count($paymentDates); // Assuming equal distribution

            // Determine payment status
            $paymentStatus = [];
            $today = \Carbon\Carbon::today();
            foreach ($paymentDates as $index => $date) {
                $status = 'not-paid'; // Default status
                $dateObj = \Carbon\Carbon::createFromFormat('d/m/y', $date);

                if ($today->gt($dateObj)) {
                    $status = 'paid';
                } elseif ($today->eq($dateObj)) {
                    $status = 'due';
                } elseif ($today->lt($dateObj)) {
                    $status = 'not-paid';
                }

                $paymentStatus[] = $status;
            }

            // Additional payment calculation logic
            $paymentLeft = 0;
            $todayPayment = \Carbon\Carbon::today()->format('d/m/y');

            if ($paymentDeadline < $todayPayment) {
                $paymentLeft = 0;
            } elseif ($paymentDeadline->copy()->addDays(5)->eq($todayPayment) && $advanceAndBalanceSum == 0) {
                $paymentLeft = $shartnomaQiymati;
            } elseif ($paymentDeadline->copy()->addDays(5)->lt($todayPayment) && $advanceAndBalanceSum < $shartnomaQiymati) {
                $paymentLeft = $shartnomaQiymati - $advanceAndBalanceSum;
            } elseif ($shartnomaSanasi <= $paymentDeadline && $shartnomaSanasi->eq($todayPayment->copy()->addDays(90 * (1 + $installmentQuarterly))) && $advanceAndBalanceSum >= $shartnomaQiymati) {
                $paymentLeft = $installmentQuarterly;
            } elseif ($shartnomaSanasi <= $paymentDeadline && $shartnomaSanasi->eq($todayPayment->copy()->addDays(90 * (1 + $installmentQuarterly))) && $advanceAndBalanceSum > $shartnomaQiymati) {
                $paymentLeft = $shartnomaQiymati - $advanceAndBalanceSum;
            }

            $branch->payment_left = $paymentLeft;
            $branch->payment_status = $paymentStatus;

            return $branch;
        });

        return view('pages.subyekt.exel_index', compact('branches'));
    }

    // -----------------------------------------------------------------------------
    public function index_imp_exp()
    {
        return view('excel.excel');
    }

    public function import(Request $request)
    {
        $filePath = $request->file('file')->store('imports');

        try {
            $spreadsheet = IOFactory::load(storage_path('app/' . $filePath));
        } catch (\Exception $e) {
            Log::error('Failed to load Excel file', ['exception' => $e]);
            return redirect()->back()->withErrors(['file' => 'Failed to load the Excel file.']);
        }

        $sheet = $spreadsheet->getActiveSheet();
        $xlsx = SimpleXLSX::parse(storage_path('app/' . $filePath));

        if (!$xlsx) {
            Log::error("Failed to parse the Excel file.");
            return redirect()->back()->withErrors(['file' => 'Failed to parse the Excel file.']);
        }

        $rows = $xlsx->rows();
        if (count($rows) > 0) {
            $headers = array_map('strtoupper', $rows[0]); // Ensure headers are uppercase for consistency

            foreach ($rows as $rowIndex => $row) {
                if ($rowIndex == 0) continue; // Skip header row

                $rowData = array_combine($headers, $row);

                // Process PAYMENT_DEADLINE
                $paymentDeadlineCell = $sheet->getCellByColumnAndRow(9, $rowIndex + 1);
                $paymentDeadlineValue = $paymentDeadlineCell->getCalculatedValue();

                $avansCell = $sheet->getCellByColumnAndRow(12, $rowIndex + 1);
                $avansValue = $avansCell->getCalculatedValue();

                Log::info('Avans:', ['row' => $rowIndex, 'value' => $avansValue]);

                // Convert payment deadline date
                $paymentDeadlineDate = $this->parseDateCell($paymentDeadlineValue);
                Log::info('PAYMENT_DEADLINE:', ['row' => $rowIndex, 'value' => $paymentDeadlineDate]);

                $tumanCode = $this->parseCell($rowData['Туман']);
                if (empty($tumanCode)) {
                    Log::error("Invalid or missing TUMAN_CODE for row", ['row' => $rowIndex]);
                    continue; // Skip this row
                }


                $item = [
                    'inn' => $this->parseCell($rowData['ИНН']),
                    'company_name' => $this->parseCell($rowData['Корхона номи']),
                    'mijoz_turi' => $this->parseCell($rowData['Мижоз тури']) ?? null,
                    'shartnoma_raqami' => $this->parseCell($rowData['шарт. №']),
                    'shartnoma_sanasi' => $this->parseDateCell($rowData['шартнома санаси']),
                    'payment_deadline' => $paymentDeadlineDate,
                    'tolov_sharti' => $this->parseCell($rowData['Тўлов муддати']),
                    'tolov_muddati' => $this->parseCell($rowData['Шартнома қиймати']),
                    'first_payment_percent' => $this->parseCell($rowData['Бўнак тўлов']),
                    'tuman_code' => $tumanCode,
                    'tuman' => $this->parseCell($rowData['Туман'], 'Unknown District'),
                    'generate_price' => $this->parseCell($rowData['Жами тўлов']),
                    'minimum_wage' => $this->parseNumericCell($rowData['Қолдиқ']),
                    'branch_kubmetr' => $this->parseNumericCell($rowData['Умумий ҳажм']),
                ];

                try {
                    $district = $this->getOrCreateDistrict($item['tuman_code'], $item['tuman']);
                    $client = $this->createOrUpdateClient($item['mijoz_turi'], $item['inn'], $item, $district);
                    $shartnoma = Shartnoma::updateOrCreate(
                        ['shartnoma_raqami' => $item['shartnoma_raqami']],
                        ['shartnoma_sanasi' => $item['shartnoma_sanasi'], 'branch_id' => null]
                    );

                    TolovGrafigi::updateOrCreate(
                        ['shartnoma_id' => $shartnoma->id, 'payment_type' => $item['tolov_sharti']],
                        [
                            'first_payment_percent' => $item['first_payment_percent'],
                            'generate_price' => $item['tolov_muddati'],
                            'payment_deadline' => $item['payment_deadline'],
                            'minimum_wage' => $item['minimum_wage'] ?? $item['generate_price'],
                            'installment_quarterly' => $item['tolov_sharti'],
                        ]
                    );

                    if ($item['branch_kubmetr'] !== null) {
                        $loyihaHajmi = LoyihaHajmiMalumotnoma::updateOrCreate(
                            ['branch_kubmetr' => $item['branch_kubmetr']],
                            []
                        );
                    } else {
                        Log::error("branch_kubmetr is null or missing for row", ['rowData' => $item]);
                        continue;
                    }

                    $ruxsatnoma = Ruxsatnoma::first();

                    $branch = Branch::updateOrCreate(
                        ['client_id' => $client->id, 'sub_street_id' => $district ? $district->id : null],
                        [
                            'ruxsatnoma_id' => $ruxsatnoma ? $ruxsatnoma->id : null,
                            'loyiha_hajmi_malumotnoma_id' => $loyihaHajmi->id,
                            'loyiha_hujjatlari_id' => null,
                        ]
                    );

                    $shartnoma->update(['branch_id' => $branch->id]);
                } catch (\Exception $e) {
                    Log::error('Error processing row', ['exception' => $e, 'row' => $rowIndex, 'item' => $item]);
                }
            }
        }

        return redirect()->back()->with('success', 'Data imported successfully.');
    }

    private function getOrCreateDistrict($code, $name)
    {
        if ($code && is_numeric($code)) {
            return District::firstOrCreate(
                ['code' => $code],
                ['name_uz' => $name, 'region_id' => 1]
            );
        }

        Log::error("Invalid or missing TUMAN_CODE: {$code}");
        return null;
    }

    private function parseDateCell($value)
    {
        Log::info('Original Value:', ['value' => $value]);

        if (empty($value) || (is_string($value) && preg_match('/#REF!/', $value))) {
            return null;
        }

        try {
            if (is_numeric($value)) {
                $date = Carbon::instance(Date::excelToDateTimeObject($value));
                return $date->format('d-m-Y');
            }

            $date = Carbon::parse($value);
            return $date->format('d-m-Y');
        } catch (\Exception $e) {
            Log::error("Invalid date format: {$value}", ['exception' => $e]);
            return null;
        }
    }

    private function parseCell($value, $default = null)
    {
        return ($value !== null && $value !== '' && !preg_match('/#REF!/', $value)) ? $value : $default;
    }

    private function parseNumericCell($value)
    {
        if (is_string($value)) {
            $value = preg_replace('/[^\d.,]/', '', $value);
            return (float) str_replace(',', '.', $value);
        }
        return (float) $value;
    }
    private function createOrUpdateClient($mijoz_turi, $inn, $rowData, $district)
    {
        if ($mijoz_turi == 2) {
            $client = Client::updateOrCreate(
                ['stir' => $inn],
                [
                    'mijoz_turi' => 'yuridik',
                    'contact' => $rowData['contact'] ?? 'default_contact',
                    'first_name' => $rowData['first_name'] ?? '',
                    'last_name' => null,
                    'father_name' => null,
                ]
            );

            Company::updateOrCreate(
                ['client_id' => $client->id],
                [
                    'company_name' => $rowData['company_name'] ?? '',
                    'sub_street_id' => $district->id,
                ]
            );
        } else {
            $client = Client::updateOrCreate(
                ['stir' => $inn],
                [
                    'mijoz_turi' => 'fizik',
                    'first_name' => $rowData['company_name'] ?? '',
                    'contact' => $rowData['contact'] ?? 'default_contact',
                ]
            );
        }

        return $client;
    }

    public function export(Request $request)
    {
        // Define the columns to be selected and their display names
        $columns = $request->input('columns', []);

        // Define column mapping to database fields and their display names
        $columnMapping = [
            'inn' => 'inn',
            'company_name' => 'company_name',
            'mijoz_turi' => 'mijoz_turi',
            'shartnoma_raqami' => 'shartnoma_raqami',
            'shartnoma_sanasi' => 'shartnoma_sanasi',
            'payment_deadline' => 'payment_deadline',
            'tolov_sharti' => 'tolov_sharti',
            'tolov_muddati' => 'tolov_muddati',
            'first_payment_percent' => 'first_payment_percent',
            'tuman_code' => 'tuman_code',
            'tuman' => 'tuman',
            'generate_price' => 'generate_price',
            'minimum_wage' => 'minimum_wage',
            'branch_kubmetr' => 'branch_kubmetr',
        ];

        // Map selected columns to database fields and display names
        $selectedColumns = array_intersect_key($columnMapping, array_flip($columns));

        if (empty($selectedColumns)) {
            return redirect()->back()->withErrors(['columns' => 'No valid columns selected for export.']);
        }

        // Build the query to join tables and select columns with correct aliasing
        $data = DB::table('branches as b')
            ->join('clients as c', 'b.client_id', '=', 'c.id')
            ->join('companies as co', 'c.id', '=', 'co.client_id')
            ->join('shartnoma as s', 'b.id', '=', 's.branch_id')
            ->join('tolov_grafigi as tg', 's.id', '=', 'tg.shartnoma_id')
            ->join('districts as d', 'b.sub_street_id', '=', 'd.id')
            ->join('loyiha_hajmi_malumotnoma as lhm', 'b.loyiha_hajmi_malumotnoma_id', '=', 'lhm.id')
            ->select(
                'c.stir as inn',
                'co.company_name',
                'c.mijoz_turi',
                's.shartnoma_raqami',
                's.shartnoma_sanasi',
                'tg.payment_deadline',
                'tg.installment_quarterly',
                'tg.first_payment_percent',
                'd.code as tuman_code',
                'd.name_uz as tuman',
                'tg.generate_price',
                'tg.minimum_wage',
                'lhm.branch_kubmetr'
            )
            ->whereNull('c.deleted_at')
            ->get()
            ->map(function ($item) use ($selectedColumns) {
                return array_map(function ($field) use ($item) {
                    return $item->{$field};
                }, array_keys($selectedColumns));
            })->toArray();

        // Add headers to the data
        array_unshift($data, array_values($selectedColumns));

        // Generate the Excel file
        $xlsx = SimpleXLSXGen::fromArray($data);

        // File name
        $fileName = 'export_' . date('Y-m-d_H-i-s') . '.xlsx';

        // Return the file for download
        return $xlsx->download($fileName);
    }





    // public function export(Request $request)
    // {
    //     $columns = $request->input('columns', []);

    //     // Define column mapping to database fields and their display names
    //     $columnMapping = [
    //         'inn' => 'ИНН',
    //         'company_name' => 'Корхона номи',
    //         'mijoz_turi' => 'Мижоз тури',
    //         'shartnoma_raqami' => 'шарт. №',
    //         'shartnoma_sanasi' => 'шартнома санаси',
    //         'payment_deadline' => 'Тўлов муддати',
    //         'tolov_sharti' => 'Шартнома қиймати',
    //         'tolov_muddati' => 'Жами тўлов',
    //         'first_payment_percent' => 'Бўнак тўлов',
    //         'tuman_code' => 'Туман коди',
    //         'tuman' => 'Туман',
    //         'generate_price' => 'Жами тўлов',
    //         'minimum_wage' => 'Қолдиқ',
    //         'branch_kubmetr' => 'Умумий ҳажм',
    //     ];

    //     // Map selected columns to database fields and display names
    //     $selectedColumns = array_intersect_key($columnMapping, array_flip($columns));

    //     if (empty($selectedColumns)) {
    //         return redirect()->back()->withErrors(['columns' => 'No valid columns selected for export.']);
    //     }

    //     // Build the query with selected columns
    //     $data = Client::select(array_keys($selectedColumns))
    //         ->join('branches', 'clients.id', '=', 'branches.client_id')
    //         ->join('shartnoma', 'branches.id', '=', 'shartnoma.branch_id')
    //         ->join('tolov_grafigi', 'shartnoma.id', '=', 'tolov_grafigi.shartnoma_id')
    //         ->join('districts', 'districts.id', '=', 'branches.sub_street_id')
    //         ->whereNull('clients.deleted_at')
    //         ->get()
    //         ->map(function ($item) use ($selectedColumns) {
    //             return array_map(function ($field) use ($item) {
    //                 return $item->{$field};
    //             }, array_keys($selectedColumns));
    //         })->toArray();

    //     // Add headers to the data
    //     array_unshift($data, array_values($selectedColumns));

    //     // Generate the Excel file
    //     $xlsx = SimpleXLSXGen::fromArray($data);

    //     // File name
    //     $fileName = 'export_' . date('Y-m-d_H-i-s') . '.xlsx';

    //     // Return the file for download
    //     return $xlsx->download($fileName);
    // }
}
