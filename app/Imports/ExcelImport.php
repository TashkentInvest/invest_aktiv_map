<?php

namespace App\Imports;

use App\Models\Client;
use App\Models\Shartnoma;
use App\Models\TolovGrafigi;
use App\Models\Branch;
use App\Models\Company;
use App\Models\District;
use App\Models\Ruxsatnoma;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class ExcelImport implements ToCollection, WithHeadingRow, WithBatchInserts, WithChunkReading, WithCalculatedFormulas, WithValidation
{
    use Importable, SkipsFailures;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Handle empty rows or rows with errors
            if (empty($row->filter()->toArray())) {
                continue;
            }

            // Convert row to an associative array
            $rowData = $row->toArray();

            $item = [
                'inn' => $this->parseCell($rowData['INN']),
                'company_name' => $this->parseCell($rowData['COMPANY_NAME']),
                'mijoz_turi' => $this->parseCell($rowData['Mijoz_Turi'], 'fizik'),
                'shartnoma_raqami' => $this->parseCell($rowData['SHARTNOMA_RAQAMI']),
                'shartnoma_sanasi' => $this->parseDateCell($rowData['SHARTNOMA_SANASI']),
                'yakunlash_sanasi' => $this->parseDateCell($rowData['YAKUNLASH_SANASI']),
                'tolov_sharti' => $this->parseCell($rowData['Kvartal Soni']),
                'tolov_muddati' => $this->parseCell($rowData['SHARTNOMA_QIYMATI']),
                'first_payment_percent' => $this->parseNumericCell($rowData['first_payment_percent']),
                'tuman_code' => $this->parseCell($rowData['TUMAN_CODE']),
                'tuman' => $this->parseCell($rowData['TUMAN'], 'Unknown District'),
                'generate_price' => $this->parseNumericCell($rowData['JAMI_TOLOV']),
                'minimum_wage' => $this->parseNumericCell($rowData['QOLDIQ']),
            ];

            Log::info('Processing row data:', ['data' => $item]);

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
                        'generate_price' => $item['generate_price'],
                        'payment_deadline' => $item['yakunlash_sanasi'],
                        'minimum_wage' => $item['minimum_wage'] ?? $item['generate_price'],
                        'installment_quarterly' => $item['tolov_muddati'],
                    ]
                );

                // Retrieve or create Ruxsatnoma
                $ruxsatnoma = Ruxsatnoma::first();

                // Create or update Branch
                $branch = Branch::updateOrCreate(
                    ['client_id' => $client->id, 'sub_street_id' => $district ? $district->id : null],
                    [
                        'ruxsatnoma_id' => $ruxsatnoma ? $ruxsatnoma->id : null,
                        'loyiha_hajmi_malumotnoma_id' => null,
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
        // Handle empty or formula cells
        if (empty($value) || is_string($value) && preg_match('/#REF!/', $value)) {
            return null;
        }

        try {
            // Handle numeric date values (Excel's serial date format)
            if (is_numeric($value)) {
                $date = Date::excelToDateTimeObject($value);
                return $date->format('Y-m-d');
            }

            // Handle string date values
            return Carbon::parse($value)->format('Y-m-d');
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

    public function rules(): array
    {
        return [
            'INN' => 'nullable|string',
            'COMPANY_NAME' => 'nullable|string',
            'Mijoz_Turi' => 'required|in:1,2',
            'SHARTNOMA_RAQAMI' => 'required|string',
            'SHARTNOMA_SANASI' => 'nullable|date',
            'YAKUNLASH_SANASI' => 'nullable|date',
            'Kvartal Soni' => 'nullable|string',
            'first_payment_percent' => 'nullable|numeric',
            'TUMAN_CODE' => 'nullable|numeric',
            'TUMAN' => 'nullable|string',
            'SHARTNOMA_QIYMATI' => 'nullable|numeric',
            'JAMI_TOLOV' => 'nullable|numeric',
            'QOLDIQ' => 'nullable|numeric',
        ];
    }

    public function batchSize(): int
    {
        return 1000; // Adjust batch size if necessary
    }

    public function chunkSize(): int
    {
        return 1000; // Adjust chunk size if necessary
    }
}
