<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
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
        $filePath = storage_path('app/references/APZ_STATUS_info.xlsx');
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        if (!$xlsx = SimpleXLSX::parse($filePath)) {
            Log::error("Failed to parse the Excel file.");
            return;
        }

        $rows = $xlsx->rows();
        if (count($rows) > 0) {
            $headers = $rows[0];
            foreach ($rows as $rowIndex => $row) {
                if ($rowIndex == 0) continue;

                $rowData = array_combine($headers, $row);

                $shartnomaSanasiCell = $sheet->getCellByColumnAndRow(5, $rowIndex + 1); // Column F (6th column)
                $shartnomaSanasiValue = $shartnomaSanasiCell->getCalculatedValue();

                if (Date::isDateTime($shartnomaSanasiCell)) {
                    $shartnomaSanasiDate = Date::excelToDateTimeObject($shartnomaSanasiValue)->format('Y-m-d');
                } else {
                    $shartnomaSanasiDate = $shartnomaSanasiValue; // Handle non-date values
                }
                $completionDateCell = $sheet->getCellByColumnAndRow(7, $rowIndex + 1); // Column G (7th column)
                $completionDateValue = $completionDateCell->getCalculatedValue();

                if (Date::isDateTime($completionDateCell)) {
                    $completionDateFormatted = Date::excelToDateTimeObject($completionDateValue)->format('Y-m-d');
                    Log::info('Completion Date:', ['row' => $rowIndex, 'value' => $completionDateFormatted]);
                } else {
                    $completionDateFormatted = $completionDateValue;
                    Log::info('Completion Date (non-date):', ['row' => $rowIndex, 'value' => $completionDateFormatted]);
                }

                $item = [
                    'inn' => $this->parseCell($rowData['ИНН']),
                    'company_name' => $this->parseCell($rowData['Корхона номи']),
                    'mijoz_turi' => $this->parseCell($rowData['Мижоз тури']) ?? null,
                    'shartnoma_raqami' => $this->parseCell($rowData['шарт. №']),
                    'shartnoma_sanasi' => $this->parseCell($rowData['шартнома санаси']),
                    'payment_deadline' => $completionDateFormatted ,
                    'tolov_sharti' => $this->parseCell($rowData['Тўлов муддати']),
                    'tolov_muddati' => $this->parseCell($rowData['Шартнома қиймати']),
                    'first_payment_percent' => $this->parseCell($rowData['Бўнак тўлов']),
                    'tuman_code' => $this->parseCell($rowData['Туман']),
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
        if ($mijoz_turi == 2) {
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
