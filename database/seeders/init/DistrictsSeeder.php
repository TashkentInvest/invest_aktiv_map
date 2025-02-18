<?php
namespace Database\Seeders\init;

use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use App\Models\District;

class DistrictsSeeder extends Seeder
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
                    District::create([
                        'code' => $row['code'],
                        'region_id' => 1,
                        'name_ru' => $row['name_ru'],
                        'name_uz' => $row['name_uz'],
                    ]);
                }
            }
        };
        $filePath = storage_path('app/references/_tumanlar.xlsx'); // Correct path to the file

        Excel::import($importHandler, $filePath);

        echo "Districts inserted".PHP_EOL;
    }
}
