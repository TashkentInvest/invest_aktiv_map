<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Shartnoma;
use App\Models\TolovGrafigi;
use App\Models\Branch;
use App\Models\Company;
use App\Models\District;
use App\Models\Ruxsatnoma;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ClientDataSeeder extends Seeder
{
    public function run()
    {
        // Define the import handler with proper interfaces
        $importHandler = new class implements ToCollection, WithHeadingRow
        {
            public function collection(Collection $rows)
            {
                foreach ($rows as $row) {
                    // Clean and evaluate row data
                    $row = $this->cleanRow($row);

                    // Log the row data for debugging
                    Log::info('Row Data:', $row);

                    // Extract necessary fields from the row
                    $tuman_code = $row['tuman_code'] ?? null;
                    $inn = $row['inn'] ?? '';
                    $mijoz_turi = $row['mijoz_turi'] ?? 0;
                    $shartnoma_raqami = $row['shartnoma_raqami'] ?? '';
                    $shartnoma_sanasi = $row['shartnoma_sanasi'] ?? null;
                    $payment_deadline = $row['yakunlash_sanasi'] ?? null;
                    $installement_quarterly = $row['tolov_muddati'] ?? null;
                    $first_payment_percent = $row['avans'] ?? 0;
                    $payment_type = $row['tolov_sharti'] ?? '';
                    $generate_price = $row['shartnoma_qiymati'] ?? 0;
                    $total_payment = $row['jami_tolov'] ?? 340000;

                    // Handle district lookup and creation
                    if ($tuman_code) {
                        $district = District::firstOrCreate(
                            ['code' => $tuman_code],
                            ['name_uz' => $row['tuman'] ?? 'Unknown District', 'region_id' => 1]
                        );

                        // Handle client creation or update
                        $client = $this->createOrUpdateClient($mijoz_turi, $inn, $row, $district);

                        // Create or update Shartnoma (Contract)
                        $shartnoma = Shartnoma::updateOrCreate(
                            ['shartnoma_raqami' => $shartnoma_raqami],
                            [
                                'shartnoma_sanasi' => $this->parseExcelDate($shartnoma_sanasi),
                                'branch_id' => null, // Updated after creating the Branch
                            ]
                        );

                        // Create or update TolovGrafigi (Payment Schedule)
                        TolovGrafigi::updateOrCreate(
                            ['shartnoma_id' => $shartnoma->id, 'payment_type' => $payment_type],
                            [
                                'first_payment_percent' => filter_var($first_payment_percent, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                                'generate_price' => filter_var($generate_price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                                'payment_deadline' => $payment_deadline,
                                'minimum_wage' => filter_var($total_payment, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                                'installment_quarterly' => $installement_quarterly,
                            ]
                        );

                        // Handle Ruxsatnoma (Permission Document)
                        $ruxsatnoma = Ruxsatnoma::first(); // Adjust as needed for your logic

                        // Create or update Branch
                        $branch = Branch::updateOrCreate(
                            ['client_id' => $client->id, 'sub_street_id' => $district->id],
                            [
                                'ruxsatnoma_id' => $ruxsatnoma ? $ruxsatnoma->id : null,
                                'loyiha_hajmi_malumotnoma_id' => null,
                                'loyiha_hujjatlari_id' => null,
                            ]
                        );

                        // Update Shartnoma with the branch_id
                        $shartnoma->update(['branch_id' => $branch->id]);
                    } else {
                        Log::error("Missing TUMAN_CODE in row: ", $row);
                    }
                }
            }

            private function cleanRow($row)
            {
                $cleanedRow = [];
                foreach ($row as $key => $value) {
                    $cleanedRow[$key] = $this->evaluateCell($value);
                }
                return $cleanedRow;
            }

            private function evaluateCell($value)
            {
                // Evaluate formulas and return calculated values
                if ($value instanceof Cell) {
                    return $value->getCalculatedValue();
                }
                return $value;
            }

            private function parseExcelDate($excelDate)
            {
                if (is_numeric($excelDate)) {
                    try {
                        // Excel stores dates as number of days since 1900-01-01
                        $date = Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($excelDate - 2);
                        return $date->format('Y-m-d');
                    } catch (\Exception $e) {
                        Log::error("Error parsing Excel date: {$excelDate}", ['exception' => $e]);
                        return null;
                    }
                }

                if (!empty($excelDate)) {
                    try {
                        return Carbon::createFromFormat('m/d/Y', $excelDate)->format('Y-m-d');
                    } catch (\Exception $e) {
                        Log::error("Invalid date format for Excel date: {$excelDate}", ['exception' => $e]);
                        return null;
                    }
                }

                return null;
            }

            private function createOrUpdateClient($mijoz_turi, $inn, $row, $district)
            {
                if ($mijoz_turi == 1) { // Legal client
                    $client = Client::updateOrCreate(
                        ['stir' => $inn],
                        [
                            'mijoz_turi' => 'yuridik',
                            'contact' => $row['contact'] ?? 'default_contact',
                            'first_name' => $row['company_name'] ?? '',
                        ]
                    );

                    Company::updateOrCreate(
                        ['client_id' => $client->id],
                        [
                            'company_name' => $row['company_name'] ?? '',
                            'sub_street_id' => $district->id,
                        ]
                    );

                    return $client;
                } else { // Individual client
                    return Client::updateOrCreate(
                        ['stir' => $inn],
                        [
                            'mijoz_turi' => 'fizik',
                            'first_name' => $row['first_name'] ?? '',
                            'last_name' => $row['last_name'] ?? '',
                            'father_name' => $row['father_name'] ?? '',
                            'contact' => $row['contact'] ?? 'default_contact',
                        ]
                    );
                }
            }
        };

        // File path to the Excel file
        $filePath = storage_path('app/references/cleaned_dataOfApz.xlsx');

        // Execute the import using the import handler
        Excel::import($importHandler, $filePath);

        echo "Data inserted successfully." . PHP_EOL;
    }
}
