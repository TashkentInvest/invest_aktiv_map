<?php

namespace App\Http\Controllers;

use App\Models\Aktiv;
use App\Models\Regions;
use Illuminate\Http\Request;

class AktivController extends Controller
{
    public function index()
    {
        // Check if the user is Super Admin
        if (auth()->user()->roles->first()->name == 'Super Admin' || auth()->user()->roles->first()->name == 'Manager') {
            // Show all Aktiv records for Super Admin
            $aktivs = Aktiv::orderBy('created_at', 'desc')->with('files')->paginate(10);
        } else {
            // Show only the user's own Aktiv records
            $aktivs = Aktiv::orderBy('created_at', 'desc')->where('user_id', auth()->id())->with('files')->paginate(10);
        }

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
            'building_area'    => 'nullable',
            'gas'              => 'required|string',
            'water'            => 'required|string',
            'electricity'      => 'required|string',
            'additional_info'  => 'nullable|string|max:255',
            'geolokatsiya'     => 'required|string',
            'latitude'         => 'required|numeric',
            'longitude'        => 'required|numeric',
            'kadastr_raqami'   => 'nullable|string|max:255',
            'files.*'          => 'required',
            'sub_street_id'    => 'required',
            'user_id'          => 'nullable'
        ]);

        $data = $request->except('files');
        $data['user_id'] = auth()->id(); // Automatically set the authenticated user's ID

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
        $this->authorizeView($aktiv); // Check if the user can view this Aktiv

        $aktiv->load('subStreet.district.region');
        return view('pages.aktiv.show', compact('aktiv'));
    }

    public function edit(Aktiv $aktiv)
    {
        $this->authorizeView($aktiv); // Check if the user can edit this Aktiv

        $regions = Regions::get();
        return view('pages.aktiv.edit', compact('aktiv', 'regions'));
    }

    public function update(Request $request, Aktiv $aktiv)
    {
        $this->authorizeView($aktiv); // Check if the user can update this Aktiv

        $request->validate([
            'object_name'      => 'required|string|max:255',
            'balance_keeper'   => 'required|string|max:255',
            'location'         => 'required|string|max:255',
            'land_area'        => 'required|numeric',
            'building_area'    => 'nullable',
            'gas'              => 'required|string',
            'water'            => 'required|string',
            'electricity'      => 'required|string',
            'additional_info'  => 'nullable|string|max:255',
            'geolokatsiya'     => 'required|string',
            'latitude'         => 'required|numeric',
            'longitude'        => 'required|numeric',
            'kadastr_raqami'   => 'nullable|string|max:255',
            'files.*'          => 'required',
            'sub_street_id'    => 'required',
            'user_id'          => 'nullable'
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
        $this->authorizeView($aktiv); // Check if the user can delete this Aktiv

        foreach ($aktiv->files as $file) {
            \Storage::disk('public')->delete($file->path);
            $file->delete();
        }

        $aktiv->delete();

        return redirect()->route('aktivs.index')->with('success', 'Aktiv deleted successfully.');
    }

    /**
     * Check if the authenticated user is authorized to view, edit, or delete an Aktiv.
     *
     * @param Aktiv $aktiv
     * @return void
     */
    private function authorizeView(Aktiv $aktiv)
    {
        if (auth()->user()->roles->first()->name != 'Super Admin' || auth()->user()->roles->first()->name != 'Manager' && $aktiv->user_id != auth()->id()) {
            abort(403, 'Unauthorized access.');
        }
    }
}
