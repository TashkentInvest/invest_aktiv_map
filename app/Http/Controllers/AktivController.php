<?php

namespace App\Http\Controllers;

use App\Exports\AktivsExport;
use App\Models\Aktiv;
use App\Models\Districts;
use App\Models\Regions;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class AktivController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->input('user_id');
        $district_id = $request->input('district_id');  // Fixed typo here
        $userRole = auth()->user()->roles->first()->name;

        // Initialize the query builder for Aktivs
        $query = Aktiv::query();

        // Only Super Admins and Managers can filter by user_id
        if ($userRole == 'Super Admin' || $userRole == 'Manager') {
            if ($user_id) {
                // Show aktivs for the specified user
                $query->where('user_id', $user_id);
            }

            // Apply district filter if provided
            if ($district_id) {
                $query->whereHas('user', function ($q) use ($district_id) {
                    $q->where('district_id', $district_id);
                });
            }
        } else {
            // If not Super Admin or Manager, show only the logged-in user's aktivs
            $query->where('user_id', auth()->id());
        }

        // Order the results by created_at and paginate
        $aktivs = $query->orderBy('created_at', 'desc')
            ->with('files') // eager load the files relationship
            ->paginate(10)
            ->appends($request->query()); // Keep query parameters in pagination links

        return view('pages.aktiv.index', compact('aktivs'));
    }

    public function userTumanlarCounts(Request $request)
    {
        $user_id = $request->input('user_id');
        $district_id = $request->input('district_id');
        $userRole = auth()->user()->roles->first()->name;
    
        // Only Super Admins and Managers can filter by user_id or district_id
        if ($userRole != 'Super Admin' && $userRole != 'Manager') {
            abort(403, 'Unauthorized access.');
        }
    
        // Initialize the query builder for Aktivs
        $query = Aktiv::query();
    
        // Only Super Admins and Managers can filter by user_id
        if ($userRole == 'Super Admin' || $userRole == 'Manager') {
            if ($user_id) {
                // Filter aktivs by the specified user_id
                $query->where('user_id', $user_id);
            }
    
            // Apply district filter if provided
            if ($district_id) {
                $query->whereHas('user', function ($q) use ($district_id) {
                    $q->where('district_id', $district_id);
                });
            }
        } else {
            // If not Super Admin or Manager, show only the logged-in user's aktivs
            $query->where('user_id', auth()->id());
        }
    
        // Get distinct districts by joining with users and selecting the distinct district_id
        $districts = Districts::select('districts.id', 'districts.name_uz') // select relevant columns
            ->distinct()
            ->join('users', 'districts.id', '=', 'users.district_id') // join with users table
            ->join('aktivs', 'users.id', '=', 'aktivs.user_id') // join with aktivs table
            ->whereIn('aktivs.id', $query->pluck('id')) // filter the aktivs based on the query
            ->get();
    
        // Manually count aktivs for each district
        foreach ($districts as $district) {
            $aktivCount = Aktiv::query()
                ->whereHas('user', function ($q) use ($district, $user_id) {
                    // Apply district filter if needed
                    $q->where('district_id', $district->id);
    
                    // Apply user_id filter if provided
                    if ($user_id) {
                        $q->where('user_id', $user_id);
                    }
                })
                ->count(); // Get the count of aktivs for the current district
    
            // Add the count to the district object
            $district->aktiv_count = $aktivCount;
        }
    
        // Return the view with districts data
        return view('pages.aktiv.tuman_counts', compact('districts'));
    }
    
    
    // public function create()
    // {
    //     $regions = Regions::get();
    //     return view('pages.aktiv.create', compact('regions'));
    // }

    public function create()
    {
        $regions = Regions::get();  // Assuming this needs no filtering
        $isSuperAdmin = auth()->id() === 1;  // Check if the user is the Super Admin
        $userDistrictId = auth()->user()->district_id;  // Get the district ID of the authenticated user

        if ($isSuperAdmin) {
            // Super Admin gets to see all Aktivs except their own creations
            $aktivs = Aktiv::with('files')->where('user_id', '!=', auth()->id())->get();
        } else {
            // Regular users see only Aktivs from their district and not created by themselves
            $aktivs = Aktiv::with('files')
                ->join('streets', 'aktivs.street_id', '=', 'streets.id')  // Join the streets table
                ->where('streets.district_id', $userDistrictId)  // Filter by user's district
                ->where('aktivs.user_id', '!=', auth()->id())  // Exclude their own Aktivs
                ->get();
        }

        $defaultImage = 'https://cdn.dribbble.com/users/1651691/screenshots/5336717/404_v2.png';

        // Assign a default image if no files are associated with an Aktiv
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

        // Load necessary relationships including the street to district relationship
        // It's crucial that subStreet is correctly mapped to district in your Aktiv model
        $aktiv->load('subStreet.district.region', 'files');

        $defaultImage = 'https://cdn.dribbble.com/users/1651691/screenshots/5336717/404_v2.png';

        // Add main_image attribute to the current Aktiv
        $aktiv->main_image = $aktiv->files->first() ? asset('storage/' . $aktiv->files->first()->path) : $defaultImage;

        // Retrieve user district ID from the authenticated user's associated street
        $userDistrictId = auth()->user()->district_id;  // Get the district ID of the authenticated user

        if (auth()->id() === 1) {
            // Super Admin can see all aktivs
            $aktivs = Aktiv::with('files')->get();
        } else {
            // Regular users see only aktivs from their district and not created by Super Admin
            $aktivs = Aktiv::with('files')
                ->join('streets', 'aktivs.street_id', '=', 'streets.id')  // Ensure street is joined correctly
                ->where('streets.district_id', $userDistrictId)  // Filter by user's district from street relationship
                ->where('user_id', '!=', 1)  // Exclude aktivs created by Super Admin
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

    // public function userTumanlarCounts(Request $request)
    // {
    //     $userRole = auth()->user()->roles->first()->name;
    //     $district_id = $request->input('district_id');
    //     $user_id = $request->input('user_id');

    //     // Only Super Admins and Managers can filter by user_id or district_id
    //     if ($userRole != 'Super Admin' && $userRole != 'Manager') {
    //         abort(403, 'Unauthorized access.');
    //     }

    //     // Initialize the query builder for Districts
    //     $districtsQuery = Districts::query(); // Assuming you have a District model

    //     // Apply district filter if provided
    //     if ($district_id) {
    //         $districtsQuery->where('id', $district_id);
    //     }

    //     // Get distinct districts
    //     $districts = $districtsQuery->distinct()->get();

    //     // Manually count aktivs for each district
    //     foreach ($districts as $district) {
    //         // Apply the filters and count aktivs for the current district
    //         $aktivCount = Aktiv::query()
    //             ->whereHas('user', function ($query) use ($district, $user_id) {
    //                 // Apply the district filter if needed
    //                 $query->where('district_id', $district->id);

    //                 // Apply the user_id filter if provided
    //                 if ($user_id) {
    //                     $query->where('user_id', $user_id);
    //                 }
    //             })
    //             ->count();

    //         // Add the count to the district object
    //         $district->aktiv_count = $aktivCount;
    //     }

    //     // Return the view with districts data
    //     return view('pages.aktiv.tuman_counts', compact('districts'));
    // }



    public function export()
    {
        // dd('daw');
        return Excel::download(new AktivsExport, 'aktivs.xlsx');
    }

    public function myMap()
    {
        $userRole = auth()->user()->roles->first()->name;

        if ($userRole == 'Super Admin') {
            return view('pages.aktiv.map_orginal');
        } else {
            abort(403, 'Unauthorized access.');
        }
    }

    // map code with source data





    public function getLots()
    {
        // Check if the authenticated user is the Super Admin (user_id = 1)
        $isSuperAdmin = auth()->id() === 1;

        if ($isSuperAdmin) {
            // Super Admin sees all aktivs
            $aktivs = Aktiv::with(['files', 'user'])->get();
        } else {
            // Other users should not see aktivs created by the Super Admin (user_id = 1)
            $aktivs = Aktiv::with(['files', 'user'])
                ->where('user_id', '!=', 1)  // Exclude records created by the Super Admin
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
