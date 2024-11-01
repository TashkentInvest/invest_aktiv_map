<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Aktiv;
use App\Models\Street;
use Maatwebsite\Excel\Facades\Excel;

class UpdateStreetIdFromExcel extends Command
{
    protected $signature = 'aktiv:update-street-id';
    protected $description = 'Update street_id in aktivs based on MFY_CODE from an Excel file';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $filePath = public_path('assets/aktivs_mfy_codes.xlsx');

        // Load the Excel data
        $data = Excel::toCollection(null, $filePath)->first();

        // Skip the header row
        $rows = $data->skip(1);

        foreach ($rows as $row) {
            // Access MFY_CODE by index 16
            $mfyCode = $row[16] ?? null;

            if ($mfyCode) {
                $street = Street::where('code', $mfyCode)->first();

                if ($street) {
                    // Update aktivs with the specific MFY_CODE and where street_id is currently NULL
                    $updatedAktivs = Aktiv::where('street_id', 88)
                        ->update(['street_id' => $street->id]);

                    $this->info("Updated aktivs with MFY_CODE: {$mfyCode} to street_id: {$street->id}");
                } else {
                    // If no matching street found, set street_id to 88 where it is null
                    Aktiv::where('street_id', 88)
                        ->update(['street_id' => $street->id ?? null]);

                    $this->info("No matching street found for MFY_CODE: {$mfyCode}, set street_id to 1.");
                }
            }
        }

        $this->info('Street IDs update process completed.');
        return 0;
    }
}
