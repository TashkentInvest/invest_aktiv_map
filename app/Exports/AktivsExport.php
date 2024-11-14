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
                // 'id' => $aktiv->id,
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
                'user_id' => $aktiv->user->email,
                'district_name' => $aktiv->street->district->name_uz ?? '',  // New district name column
                'street_id' => $aktiv->street->name ?? '',
                'sub_street_id' => $aktiv->substreet->name ?? '',
                'id' => "https://aktiv.toshkentinvest.uz/aktivs/" .$aktiv->id,

                // Add other fields as needed
            ];
        });
    }

    public function headings(): array
    {
        return [
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
            'Tuman', 
            'MFY',
            'Kocha',
            'ID',

            // Match the order of fields above
        ];
    }
}
