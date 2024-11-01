<?php

namespace App\Exports;

use App\Models\Aktiv;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AktivsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Aktiv::with('files')->get()->map(function ($aktiv) {
            return [
                'id' => $aktiv->id,
                'object_name' => $aktiv->object_name,
                'balance_keeper' => $aktiv->balance_keeper,
                'location' => $aktiv->location,
                'land_area' => $aktiv->land_area,
                'building_area' => $aktiv->building_area,
                'gas' => $aktiv->gas,
                'water' => $aktiv->water,
                'electricity' => $aktiv->electricity,
                'additional_info' => $aktiv->additional_info,
                'geolokatsiya' => $aktiv->geolokatsiya,
                'latitude' => $aktiv->latitude,
                'longitude' => $aktiv->longitude,
                'kadastr_raqami' => $aktiv->kadastr_raqami,
                'user_id' => $aktiv->user_id,
                'street_id' => $aktiv->street_id,
                'sub_street_id' => $aktiv->sub_street_id,
                // Add other fields as needed
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Object Name',
            'Balance Keeper',
            'Location',
            'Land Area',
            'Building Area',
            'Gas',
            'Water',
            'Electricity',
            'Additional Info',
            'Geolocation',
            'Latitude',
            'Longitude',
            'Kadastr Raqami',
            'User ID',
            'MFY',
            'Kocha',
            // Match the order of fields above
        ];
    }
}
