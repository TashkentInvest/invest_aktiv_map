<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\SubStreet;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class SubStreetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $importHandler = new class implements ToCollection, WithHeadingRow
        {
            public function collection(Collection $rows)
            {
                foreach ($rows as $row)
                {
                    $district = District::where('code', $row['district_code'])->first();

                    if ($district) {
                        SubStreet::create([
                            'district_id' => $district->id,
                            'name' => $row['name'] ?? null,
                            'name_ru' => $row['name_ru'] ?? null,
                            'type' => $row['type'] ?? null,
                            'code' => $row['code'] ?? null,
                            'comment' => $row['comment'] ?? null,
                        ]);
                    } else {
                        echo "District not found for code: " . $row['district_code'] . PHP_EOL;
                    }
                }
            }
        };

        $filePath = storage_path('app/references/_kochalar.xlsx');

        Excel::import($importHandler, $filePath);

        echo "Streets inserted".PHP_EOL;
    }
}
