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
                    // Update aktivs with the found street_id
                    $updatedAktivs = Aktiv::whereNull('street_id')
                        ->update(['street_id' => $street->id]);
    
                    $this->info("Updated aktivs with MFY_CODE: {$mfyCode} to street_id: {$street->id}");
                } else {
                    // If no matching street found, set street_id to 1
                    Aktiv::whereNull('street_id')
                        ->update(['street_id' => 1]);
    
                    $this->info("No matching street found for MFY_CODE: {$mfyCode}, set street_id to 1.");
                }
            }
        }
    
        $this->info('Street IDs update process completed.');
        return 0;
    }
    
    
}
