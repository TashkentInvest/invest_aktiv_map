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
        // Path to your Excel file
        $filePath = public_path('assets/aktivs_mfy_codes.xlsx');

        if (!file_exists($filePath)) {
            $this->error("File not found at path: {$filePath}");
            return;
        }

        // Load the Excel data
        $data = Excel::toCollection(null, $filePath);

        // Assuming the data is in the first sheet
        $sheet = $data->first();

        if (!$sheet) {
            $this->error("No data found in the Excel file.");
            return;
        }

        // Get the header row
        $headerRow = $sheet->first()->toArray();

        // Ensure the header contains necessary columns
        if (!in_array('Object Name', $headerRow) || !in_array('Balance Keeper', $headerRow) || !in_array('MFY_CODE', $headerRow)) {
            $this->error("The Excel file must contain 'Object Name', 'Balance Keeper', and 'MFY_CODE' columns.");
            return;
        }

        // Get the data rows (skip the header)
        $rows = $sheet->skip(1);

        // Build a mapping of (object_name, balance_keeper) => MFY_CODE
        $excelData = [];

        foreach ($rows as $row) {
            $rowData = array_combine($headerRow, $row->toArray());

            $objectName = trim($rowData['Object Name'] ?? '');
            $balanceKeeper = trim($rowData['Balance Keeper'] ?? '');
            $mfyCode = trim($rowData['MFY_CODE'] ?? '');

            if ($objectName && $balanceKeeper && $mfyCode) {
                // Use a composite key (lowercased to ensure case-insensitive matching)
                $key = strtolower($objectName) . '|' . strtolower($balanceKeeper);
                $excelData[$key] = $mfyCode;
            } else {
                $this->warn("Incomplete data in Excel row. Skipping row with Object Name: '{$objectName}' and Balance Keeper: '{$balanceKeeper}'.");
            }
        }

        // Now, update aktivs where street_id is NULL
        $aktivs = Aktiv::whereNull('street_id')->get();

        $updatedCount = 0;
        $notFoundCount = 0;
        $streetNotFoundCount = 0;

        foreach ($aktivs as $aktiv) {
            $objectName = trim($aktiv->object_name);
            $balanceKeeper = trim($aktiv->balance_keeper);

            // Create the composite key
            $key = strtolower($objectName) . '|' . strtolower($balanceKeeper);

            if (isset($excelData[$key])) {
                $mfyCode = $excelData[$key];
                $street = Street::where('code', $mfyCode)->first();

                if ($street) {
                    $aktiv->street_id = $street->id;
                    $aktiv->save();

                    $this->info("Updated Aktiv ID {$aktiv->id} with street_id: {$street->id} (Street Code: {$mfyCode}).");
                    $updatedCount++;
                } else {
                    $this->warn("No matching street found for MFY_CODE: {$mfyCode} for Aktiv ID: {$aktiv->id}.");
                    $streetNotFoundCount++;
                }
            } else {
                $this->warn("No matching Excel data for Aktiv ID: {$aktiv->id} with Object Name: '{$objectName}' and Balance Keeper: '{$balanceKeeper}'.");
                $notFoundCount++;
            }
        }

        $this->info("Street IDs update process completed.");
        $this->info("Total aktivs updated: {$updatedCount}");
        $this->info("Total aktivs not found in Excel data: {$notFoundCount}");
        $this->info("Total aktivs with missing streets: {$streetNotFoundCount}");

        return 0;
    }
}
