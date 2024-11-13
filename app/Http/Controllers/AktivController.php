<?php

namespace App\Http\Controllers;

use App\Exports\AktivsExport;
use App\Models\Aktiv;
use App\Models\Regions;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AktivController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->input('user_id');
        $userRole = auth()->user()->roles->first()->name;

        if ($userRole == 'Super Admin' || $userRole == 'Manager') {
            if ($user_id) {
                // Show aktivs for the specified user
                $aktivs = Aktiv::where('user_id', $user_id)
                    ->orderBy('created_at', 'desc')
                    ->with('files')
                    ->paginate(10)
                    ->appends($request->query()); // Ensure query parameters are appended
            } else {
                // Show all aktivs
                $aktivs = Aktiv::orderBy('created_at', 'desc')
                    ->with('files')
                    ->paginate(10)
                    ->appends($request->query());
            }
        } else {
            // Show only the user's own aktivs
            $aktivs = Aktiv::where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->with('files')
                ->paginate(10)
                ->appends($request->query());
        }

        return view('pages.aktiv.index', compact('aktivs'));
    }


    // public function create()
    // {
    //     $regions = Regions::get();
    //     return view('pages.aktiv.create', compact('regions'));
    // }

    public function create()
    {
        $regions = Regions::get();
        $aktivs = Aktiv::with('files')->where('user_id', '!=', auth()->id())->get();

        $defaultImage = 'https://cdn.dribbble.com/users/1651691/screenshots/5336717/404_v2.png';

        $aktivs->map(function ($aktiv) use ($defaultImage) {
            $aktiv->main_image = $aktiv->files->first() ? asset('storage/' . $aktiv->files->first()->path) : $defaultImage;
            return $aktiv;
        });

        return view('pages.aktiv.create', compact('aktivs', 'regions'));
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
            'files' => 'required|array|min:4', // Enforces at least 4 files

            'sub_street_id'    => 'required',
            'street_id'    => 'required',
            'user_id'          => 'nullable'
        ]);
        // $request->validate([
        //     'files' => 'required|array|min:4', // Enforces at least 4 files
        //     'files.*' => 'required|file', // Ensures each file is valid
        //     // other validations
        // ]);

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
        // Check if the user can view this Aktiv (for authorization)
        $this->authorizeView($aktiv);

        // Load necessary relationships
        $aktiv->load('subStreet.district.region', 'files');

        $defaultImage = 'https://cdn.dribbble.com/users/1651691/screenshots/5336717/404_v2.png';

        // Add main_image attribute to the current Aktiv
        $aktiv->main_image = $aktiv->files->first() ? asset('storage/' . $aktiv->files->first()->path) : $defaultImage;

        // Check if the user is the Super Admin (user_id = 1)
        $isSuperAdmin = auth()->id() === 1;

        $userDistrictId = auth()->user()->district_id;  // Get the district ID of the authenticated user

        if (auth()->id() === 1) {
            $aktivs = Aktiv::with('files')->where('district_id', $userDistrictId)->get();
        } else {
            $aktivs = Aktiv::with('files')
                ->where('user_id', '!=', 1)
                . where('district_id', $userDistrictId)  // Filter by user's district
                ->get();
        }

        // Add main_image attribute to each Aktiv
        $aktivs->map(function ($a) use ($defaultImage) {
            $a->main_image = $a->files->first() ? asset('storage/' . $a->files->first()->path) : $defaultImage;
            return $a;
        });

        return view('pages.aktiv.show', compact('aktiv', 'aktivs'));
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
            'street_id'    => 'required',

            'user_id'          => 'nullable'
        ]);

        // $totalFiles = $aktiv->files()->count() - count($request->delete_files ?? []) + count($request->file('files') ?? []);
        // if ($totalFiles < 4) {
        //     return back()->withErrors(['files' => 'Камида 4 та файл бўлиши шарт.'])->withInput();
        // }

        if ($request->has('delete_files')) {
            foreach ($request->delete_files as $fileId) {
                $file = $aktiv->files()->find($fileId);
                if ($file) {
                    \Storage::disk('public')->delete($file->path);
                    $file->delete();
                }
            }
        }



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
        $userRole = auth()->user()->roles->first()->name;

        if ($userRole == 'Super Admin' || $userRole == 'Manager') {
            // Super Admins and Managers can access any Aktiv
            return;
        }

        if ($aktiv->user_id == auth()->id()) {
            // The Aktiv belongs to the authenticated user
            return;
        }

        // If none of the above, deny access
        abort(403, 'Unauthorized access.');
    }

    public function userAktivCounts()
    {
        $userRole = auth()->user()->roles->first()->name;

        // Only Super Admins and Managers can access this page
        if ($userRole != 'Super Admin' && $userRole != 'Manager') {
            abort(403, 'Unauthorized access.');
        }

        // Get users and their Aktiv counts
        $users = User::withCount('aktivs')->get();
        // dd('dwq');
        return view('pages.aktiv.user_counts', compact('users'));
    }

    public function export()
    {
        // dd('daw');
        return Excel::download(new AktivsExport, 'aktivs.xlsx');
    }

    public function myMap()
    {
        return view('pages.aktiv.map_orginal');
    }

    // map code with source data
    public function getLots()
    {
        // Check if the authenticated user is the Super Admin (user_id = 1)
        $isSuperAdmin = auth()->id() === 1;

        $userDistrictId = auth()->user()->district_id;  // Get the district ID of the authenticated user

        if ($isSuperAdmin) {
            $aktivs = Aktiv::with(['files', 'user'])->where('district_id', $userDistrictId)->get();
        } else {
            $aktivs = Aktiv::with(['files', 'user'])
                ->where('user_id', '!=', 1)
                . where('district_id', $userDistrictId)  // Filter by user's district
                ->get();
        }

        // Define the default image in case there is no image
        $defaultImage = 'https://cdn.dribbble.com/users/1651691/screenshots/5336717/404_v2.png';

        // Map the aktivs to the required format
        $lots = $aktivs->map(function ($aktiv) use ($defaultImage) {
            // Determine the main image URL
            $mainImagePath = $aktiv->files->first() ? 'storage/' . $aktiv->files->first()->path : null;
            $mainImageUrl = $mainImagePath && file_exists(public_path($mainImagePath))
                ? asset($mainImagePath)
                : $defaultImage;

            // Return the necessary data
            return [
                'lat' => $aktiv->latitude,
                'lng' => $aktiv->longitude,
                'property_name' => $aktiv->object_name,
                'main_image' => $mainImageUrl,
                'land_area' => $aktiv->land_area,
                'start_price' => $aktiv->start_price ?? 0,
                'lot_link' => route('aktivs.show', $aktiv->id),
                'lot_number' => $aktiv->id,
                'address' => $aktiv->location,
                'user_name' => $aktiv->user ? $aktiv->user->name : 'N/A',
                'user_email' => $aktiv->user ? $aktiv->user->email : 'N/A',
            ];
        });

        // Return the response as JSON
        return response()->json(['lots' => $lots]);
    }



    /**
     * Generate a QR code for the given lot's latitude and longitude
     *
     * @param string $lat Latitude of the lot
     * @param string $lng Longitude of the lot
     * @return \Illuminate\Http\Response
     */
    public function generateQRCode($lat, $lng)
    {
        $url = url("/?lat={$lat}&lng={$lng}");

        // Use the SVG format
        $qrCode = QrCode::format('svg')
            ->size(200)
            ->errorCorrection('H')
            ->generate($url);

        return response($qrCode, 200)->header('Content-Type', 'image/svg+xml');
    }
}
