<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Shuchkin\SimpleXLSX;
use App\Models\Client;
use App\Models\Shartnoma;
use App\Models\TolovGrafigi;
use App\Models\Branch;
use App\Models\Company;
use App\Models\District;
use App\Models\LoyihaHajmiMalumotnoma;
use App\Models\Ruxsatnoma;

class ExcelService
{
    public function parseDateCell($value)
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

    public function parseCell($value, $default = null)
    {
        return $value !== null && $value !== '' && !preg_match('/#REF!/', $value) ? $value : $default;
    }

    public function parseNumericCell($value)
    {
        if (is_string($value)) {
            $value = preg_replace('/[^\d.,]/', '', $value);
            return (float) str_replace(',', '.', $value);
        }
        return (float) $value;
    }

    public function getOrCreateDistrict($code, $name)
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

    public function createOrUpdateClient($mijoz_turi, $inn, $rowData, $district)
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

    public function processRow($rowData)
    {
        $item = [
            'inn' => $this->parseCell($rowData['INN']),
            'company_name' => $this->parseCell($rowData['COMPANY_NAME']),
            'mijoz_turi' => $this->parseCell($rowData['MIJOZ_TURI'], 2),
            'shartnoma_raqami' => $this->parseCell($rowData['SHARTNOMA_RAQAMI']),
            'shartnoma_sanasi' => $this->parseDateCell($rowData['SHARTNOMA_SANASI']),
            'payment_deadline' => $this->parseDateCell($rowData['PAYMENT_DEADLINE']),
            'tolov_sharti' => $this->parseCell($rowData['KVARTAL_SONI']),
            'tolov_muddati' => $this->parseCell($rowData['SHARTNOMA_QIYMATI']),
            'first_payment_percent' => $this->parseNumericCell($rowData['FIRST_PAYMENT_PERCENT']),
            'tuman_code' => $this->parseCell($rowData['TUMAN_CODE']),
            'tuman' => $this->parseCell($rowData['TUMAN'], 'Unknown District'),
            'generate_price' => $this->parseNumericCell($rowData['JAMI_TOLOV']),
            'minimum_wage' => $this->parseNumericCell($rowData['QOLDIQ']),
            'branch_kubmetr' => $this->parseNumericCell($rowData['UMUMIY_XAJM']),
        ];

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
                'generate_price' => $item['generate_price'],
                'payment_deadline' => $item['payment_deadline'] ?? null,
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
            return;
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
    }
}
