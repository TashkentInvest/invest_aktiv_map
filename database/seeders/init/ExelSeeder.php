<?php
namespace Database\Seeders\init;

use App\Models\Branch;
use App\Models\Client;
use App\Models\Company;
use App\Models\Products;
use Illuminate\Database\Seeder;
use App\Models\Regions;

class ExelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exelData = json_decode(file_get_contents(__DIR__ . "/../references/noqonuniy_75.json"));
        // $exelData = json_decode(file_get_contents(__DIR__ . "/../references/exel.json"));
        echo "Noqonuniy 75 Exel::inserting" . PHP_EOL;
        
        foreach ($exelData as $item) {
            $clientData = [
                'is_qonuniy' => $item->is_qonuniy ?? null,
                'client_description' => $item->client_description ?? null,            
            ];

            $client = Client::create($clientData);

            $companyData = [
                'client_id' => $client->id ?? null,
                'company_name' => $item->company_name ?? null,
            ];

            $company = Company::create($companyData);

            
            $branchData = [
                'client_id' => $client->id ?? null,
                'application_number' => $item->application_number ?? null,
                'branch_location' => $item->branch_location ?? null,
                'notification_num' => $item->notification_num ?? null,
            ];

            $branch = Branch::create($branchData);

        }
    }

    
}
