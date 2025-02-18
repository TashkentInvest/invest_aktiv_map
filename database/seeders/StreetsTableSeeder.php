<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use App\Models\District;
use App\Models\Street;
class StreetsTableSeeder extends Seeder

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
                    // Find the district ID based on the district_code
                    $district = District::where('code', $row['district_code'])->first();

                    if ($district) {
                        // Create new Street entry
                        Street::create([
                            'district_id' => $district->id, // Use the found district_id
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

        $filePath = storage_path('app/references/_mahallalar.xlsx'); // Path to the Excel file

        Excel::import($importHandler, $filePath);

        echo "Streets inserted".PHP_EOL;
    }
}
