<?php

namespace App\Http\Controllers;

use App\Models\Aktiv;
use App\Models\Regions;
use Illuminate\Http\Request;

class AktivController extends Controller
{
    public function index()
    {
        $aktivs = Aktiv::with('files')->paginate(10);
        return view('pages.aktiv.index', compact('aktivs'));
    }

    public function create()
    {
        $regions = Regions::get();
        return view('pages.aktiv.create', compact('regions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'object_name'      => 'required|string|max:255',
            'balance_keeper'   => 'required|string|max:255',
            'location'         => 'required|string|max:255',
            'land_area'        => 'required|numeric',
            'building_area'    => 'required|numeric',
            'gas'              => 'required|string',
            'water'            => 'required|string',
            'electricity'      => 'required|string',
            'additional_info'  => 'nullable|string|max:255',
            'geolokatsiya'     => 'required|string',
            'latitude'         => 'required|numeric',
            'longitude'        => 'required|numeric',
            'kadastr_raqami'   => 'nullable|string|max:255',
            'files.*'          => 'nullable',
            'sub_street_id' => 'required',

        ]);

        $data = $request->except('files');

        $aktiv = Aktiv::create($data);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('assets', 'public');

                $aktiv->files()->create([
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('aktivs.index')->with('success', 'Aktiv created successfully.');
    }

    public function show(Aktiv $aktiv)
    {
        $aktiv->load('subStreet.district.region');

        return view('pages.aktiv.show', compact('aktiv'));
    }

    public function edit(Aktiv $aktiv)
    {
        $regions = Regions::get();
        return view('pages.aktiv.edit', compact('aktiv', 'regions'));
    }

    public function update(Request $request, Aktiv $aktiv)
    {
        $request->validate([
            'object_name'      => 'required|string|max:255',
            'balance_keeper'   => 'required|string|max:255',
            'location'         => 'required|string|max:255',
            'land_area'        => 'required|numeric',
            'building_area'    => 'required|numeric',
            'gas'              => 'required|string',
            'water'            => 'required|string',
            'electricity'      => 'required|string',
            'additional_info'  => 'nullable|string|max:255',
            'geolokatsiya'     => 'required|string',
            'latitude'         => 'required|numeric',
            'longitude'        => 'required|numeric',
            'kadastr_raqami'   => 'nullable|string|max:255',
            'files.*'          => 'nullable',
            'sub_street_id' => 'required',

        ]);

        $data = $request->except('files');

        $aktiv->update($data);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('assets', 'public');

                $aktiv->files()->create([
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('aktivs.index')->with('success', 'Aktiv updated successfully.');
    }

    public function destroy(Aktiv $aktiv)
    {
        // Delete associated files
        foreach ($aktiv->files as $file) {
            // Delete the file from storage
            \Storage::disk('public')->delete($file->path);
            // Delete the file record from the database
            $file->delete();
        }

        $aktiv->delete();

        return redirect()->route('aktivs.index')->with('success', 'Aktiv deleted successfully.');
    }
}
