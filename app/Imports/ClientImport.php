<?php

namespace App\Imports;

use App\Models\Client;
use App\Models\Company;
use App\Models\Shartnoma;
use App\Models\TolovGrafigi;
use App\Models\Branch;
use App\Models\District;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ClientImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Find or create the district
            $district = District::firstOrCreate(
                ['code' => $row['TUMAN_CODE']],
                ['name_uz' => $row['TUMAN'], 'name_ru' => $row['TUMAN']]
            );

            // Create the client
            $client = Client::create([
                'mijoz_turi' => $row['mijoz_turi'] == 1 ? 'yuridik' : 'fizik',
                'first_name' => $this->getFirstName($row['COMPANY_NAME']),
                'last_name' => $this->getLastName($row['COMPANY_NAME']),
                'contact' => '', // Assuming contact is not provided
                'stir' => $row['INN'] ?? $row['PINFL'],
                'unique_code' => $this->generateUniqueCode($row),
            ]);

            // Create the company if applicable
            if ($row['mijoz_turi'] == 1) {
                Company::create([
                    'client_id' => $client->id,
                    'company_name' => $row['COMPANY_NAME'],
                ]);
            }

            // Create the contract (shartnoma)
            $shartnoma = Shartnoma::create([
                'shartnoma_raqami' => $row['SHARTNOMA_RAQAMI'],
                'shartnoma_sanasi' => \Carbon\Carbon::parse($row['SHARTNOMA_SANASI']),
            ]);

            // Create the payment schedule (tolov_grafigi)
            TolovGrafigi::create([
                'shartnoma_id' => $shartnoma->id,
                'payment_type' => $row['TOLOV_SHARTI'],
                'percentage_input' => $row['AVANS'],
                'installment_quarterly' => $this->calculateQuarterlyPayment($row),
                'first_payment_percent' => 20, // Assuming 20% as per example
                'minimum_wage' => 0, // Assuming minimum wage is not provided
                'generate_price' => $row['SHARTNOMA_QIYMATI'],
                'payment_deadline' => \Carbon\Carbon::parse($row['TOLOV_MUDDATI'] ?? null),
            ]);

            // Create the branch
            Branch::create([
                'client_id' => $client->id,
            ]);
        }
    }

    private function getFirstName($name)
    {
        $parts = explode(' ', $name);
        return $parts[0] ?? null;
    }

    private function getLastName($name)
    {
        $parts = explode(' ', $name);
        return $parts[1] ?? null;
    }

    private function generateUniqueCode($row)
    {
        return substr(md5($row['INN'] ?? $row['PINFL']), 0, 10);
    }

    private function calculateQuarterlyPayment($row)
    {
        // Example logic to calculate quarterly payment
        return ($row['SHARTNOMA_QIYMATI'] * (1 - ($row['AVANS'] / 100))) / 4;
    }
}
