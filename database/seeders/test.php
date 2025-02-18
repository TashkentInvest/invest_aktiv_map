<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Client;
use App\Models\Shartnoma;
use App\Models\TolovGrafigi;
use App\Models\Branch;
use App\Models\Company;
use App\Models\District;
use App\Models\LoyihaHajmiMalumotnoma;
use App\Models\Ruxsatnoma;
use Shuchkin\SimpleXLSX;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExcelToDatabaseSeeder extends Seeder
{
    public function run()
    {
        $filePath = storage_path('app/references/cleaned_dataOfApz.xlsx');
        $spreadsheet = IOFactory::load($filePath);
        // Get the active sheet
        $sheet = $spreadsheet->getActiveSheet();
        // Load the Excel file
        if (!$xlsx = SimpleXLSX::parse($filePath)) {
            Log::error("Failed to parse the Excel file.");
            return;
        }


        // ---------------------------
        $rows = $xlsx->rows();
        if (count($rows) > 0) {
            // Get headers from the first row
            $headers = $rows[0];
            // Iterate through each row
            foreach ($rows as $rowIndex => $row) {
                // Skip the header row
                if ($rowIndex == 0) continue;

                // Convert row to an associative array
                $rowData = array_combine($headers, $row);
                Log::info('--------------------------------------------------------------');
                Log::info('rowData:', ['PAYMENT_DEADLINE' => $rowData]);
                Log::info('--------------------------------------------------------------');

                // Get PAYMENT_DEADLINE by index (9th column, index 8)
                $indexedValue = $row[8]; // Index 8 for PAYMENT_DEADLINE

                $paymentDeadlineCell = $sheet->getCellByColumnAndRow(9, $rowIndex + 1); // Column I (9th column)
                $paymentDeadlineValue = $paymentDeadlineCell->getCalculatedValue();

                // $avansCell = $sheet->getCellByColumnAndRow(11, $rowIndex + 1); // Column I (9th column)
                // $avansValue = $avansCell->getCalculatedValue();
                // Log::info('Avans:', ['row' => $rowIndex, 'value' => $avansValue]);

                if (Date::isDateTime($paymentDeadlineCell)) {
                    $paymentDeadlineDate = Date::excelToDateTimeObject($paymentDeadlineValue)->format('Y-m-d');
                } else {
                    $paymentDeadlineDate = $paymentDeadlineValue; // Handle non-date values
                }

                // Log the value
                Log::info('PAYMENT_DEADLINE:', ['row' => $rowIndex, 'value' => $paymentDeadlineDate]);

                // Process PAYMENT_DEADLINE
                $originalValue = $rowData['PAYMENT_DEADLINE'];
                Log::info('rowData:', ['PAYMENT_DEADLINE' => $rowData['PAYMENT_DEADLINE']]);
                $processedValue = $this->parseDateCell($rowData['PAYMENT_DEADLINE']);

                // Log the PAYMENT_DEADLINE values
                Log::info('Original PAYMENT_DEADLINE Value:', ['PAYMENT_DEADLINE' => date('Y-m-d', strtotime($originalValue))]);
                Log::info('Processed PAYMENT_DEADLINE Value:', ['PAYMENT_DEADLINE' => $processedValue]);
                Log::info('Indexed PAYMENT_DEADLINE Value:', ['PAYMENT_DEADLINE' => $indexedValue]);

                $item = [
                    'inn' => $this->parseCell($rowData['INN']),
                    'company_name' => $this->parseCell($rowData['COMPANY_NAME']),
                    'mijoz_turi' => $this->parseCell($rowData['MIJOZ_TURI'], 2),
                    'shartnoma_raqami' => $this->parseCell($rowData['SHARTNOMA_RAQAMI']),
                    'shartnoma_sanasi' => $this->parseDateCell($rowData['SHARTNOMA_SANASI']),
                    'payment_deadline' => $paymentDeadlineDate,
                    'tolov_sharti' => $this->parseCell($rowData['KVARTAL_SONI']),
                    'tolov_muddati' => $this->parseCell($rowData['SHARTNOMA_QIYMATI']),
                    'first_payment_percent' => $avansValue ?? 1,
                    'tuman_code' => $this->parseCell($rowData['TUMAN_CODE']),
                    'tuman' => $this->parseCell($rowData['TUMAN'], 'Unknown District'),
                    'generate_price' => $this->parseNumericCell($rowData['JAMI_TOLOV']),
                    'minimum_wage' => $this->parseNumericCell($rowData['QOLDIQ']),
                    'branch_kubmetr' => $this->parseNumericCell($rowData['UMUMIY_XAJM']),
                ];

                try {
                    // Handle District creation or retrieval
                    $district = $this->getOrCreateDistrict($item['tuman_code'], $item['tuman']);

                    // Create or update Client
                    $client = $this->createOrUpdateClient($item['mijoz_turi'], $item['inn'], $item, $district);

                    // Create or update Shartnoma
                    $shartnoma = Shartnoma::updateOrCreate(
                        ['shartnoma_raqami' => $item['shartnoma_raqami']],
                        ['shartnoma_sanasi' => $item['shartnoma_sanasi'], 'branch_id' => null]
                    );

                    // Create or update TolovGrafigi
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

                    // Ensure branch_kubmetr is not null
                    if ($item['branch_kubmetr'] !== null) {
                        $loyihaHajmi = LoyihaHajmiMalumotnoma::updateOrCreate(
                            ['branch_kubmetr' => $item['branch_kubmetr']],
                            [] // Fill in other fields if necessary
                        );
                    } else {
                        Log::error("branch_kubmetr is null or missing for row", ['rowData' => $item]);
                        continue; // Skip processing for this row
                    }

                    // Retrieve or create Ruxsatnoma
                    $ruxsatnoma = Ruxsatnoma::first();

                    // Create or update Branch
                    $branch = Branch::updateOrCreate(
                        ['client_id' => $client->id, 'sub_street_id' => $district ? $district->id : null],
                        [
                            'ruxsatnoma_id' => $ruxsatnoma ? $ruxsatnoma->id : null,
                            'loyiha_hajmi_malumotnoma_id' => $loyihaHajmi->id,
                            'loyiha_hujjatlari_id' => null,
                        ]
                    );

                    // Update Shartnoma with branch_id
                    $shartnoma->update(['branch_id' => $branch->id]);
                } catch (\Exception $e) {
                    Log::error('Error processing row', ['exception' => $e]);
                }
            }
        }
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
        return $value !== null && $value !== '' && !preg_match('/#REF!/', $value) ? $value : $default;
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
        if ($mijoz_turi == 1) {
            $client = Client::updateOrCreate(
                ['stir' => $inn],
                [
                    'mijoz_turi' => 'yuridik',
                    'contact' => $rowData['contact'] ?? 'default_contact',
                    'first_name' => $rowData['company_name'] ?? '',
                    'last_name' => null,
                    'father_name' => null,
                ]
            );

            Company::updateOrCreate(
                ['client_id' => $client->id],
                [
                    'company_name' => $rowData['company_name'] ?? '',
                    'sub_street_id' => $district ? $district->id : null,
                ]
            );
        } else {
            $client = Client::updateOrCreate(
                ['stir' => $inn],
                [
                    'mijoz_turi' => 'fizik',
                    'first_name' => $rowData['company_name'] ?? '',
                    'last_name' => $rowData['last_name'] ?? '',
                    'father_name' => $rowData['father_name'] ?? '',
                    'contact' => $rowData['contact'] ?? 'default_contact',
                ]
            );
        }

        return $client;
    }
}
