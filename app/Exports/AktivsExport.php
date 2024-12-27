<?php

namespace App\Exports;

use App\Models\Aktiv;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AktivsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Get the authenticated user ID
        $userId = Auth::id();
        $userDistrictId = Auth::user()->district_id; // Assuming the user has a `district_id` property

        // Apply the logic for filtering aktivs based on user role
        if ($userId === 1) {
            // Super Admin: Get all aktivs
            $aktivs = Aktiv::with(['files', 'street.district', 'substreet'])->get();
        } else {
            // Regular users: Filter aktivs by district and exclude those created by Super Admin
            $aktivs = Aktiv::with(['files', 'street.district', 'substreet'])
                ->join('streets', 'aktivs.street_id', '=', 'streets.id') // Ensure street is joined correctly
                ->where('streets.district_id', $userDistrictId) // Filter by user's district
                ->where('user_id', '!=', 1) // Exclude aktivs created by Super Admin
                ->select('aktivs.*') // Avoid conflicts with joined tables
                ->get();
        }

        // Map the aktivs to the desired format for export
        return $aktivs->map(function ($aktiv) {
            return [
                'object_name' => $aktiv->object_name,
                'building_type' => $aktiv->building_type,
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
                'kadastr_raqami' => $aktiv->kadastr_raqami ?? '',
                'user_id' => $aktiv->user->email ?? '',
                'district_name' => $aktiv->street->district->name_uz ?? '', // District name
                'street_id' => $aktiv->street->name ?? '', // Street name
                'sub_street_id' => $aktiv->substreet->name ?? '', // Substreet name
                'kadastr_pdf_exists' => $aktiv->kadastr_pdf ? 1 : 0,
                'hokim_qarori_pdf_exists' => $aktiv->hokim_qarori_pdf ? 1 : 0,
                'transfer_basis_pdf_exists' => $aktiv->transfer_basis_pdf ? 1 : 0,
                'id' => "https://aktiv.toshkentinvest.uz/aktivs/" . $aktiv->id,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Object Name',
            'Bino Turi',
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
            'Kadastr PDF Exists',
            'Hokim Qarori PDF Exists',
            'Transfer Basis PDF Exists',
            'ID',
        ];
    }
}
