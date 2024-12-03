<?php

namespace App\Http\Controllers;

use App\Exports\AktivsExport;
use App\Models\Aktiv;
use App\Models\Districts;
use App\Models\Regions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class AktivController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->input('user_id');
        $district_id = $request->input('district_id');  // Fixed typo here
        $userRole = auth()->user()->roles[0]->name ?? '';

        // Check if the user is a Manager and district_id is not already in the query string
        if ($userRole == 'Manager' && !$request->has('district_id')) {
            return redirect()->route('aktivs.index', [
                'district_id' => auth()->user()->district_id, // Appends district_id as query parameter
            ]);
        }

        $yerCount = Aktiv::where('building_type', 'yer')->count();
        $noturarBinoCount = Aktiv::where('building_type', 'NoturarBino')->count();
        $turarBinoCount = Aktiv::where('building_type', 'TurarBino')->count();

        // Initialize the query builder for Aktivs
        $query = Aktiv::query();

        // Only Super Admins and Managers can filter by user_id
        if ($userRole == 'Super Admin') {
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
        } elseif ($userRole == 'Manager') {
            $user_district_id = auth()->user()->district_id;
            if ($district_id == $user_district_id) {
                $query->whereHas('user', function ($q) use ($district_id) {
                    $q->where('district_id', $district_id);
                });
            } else {
                $query->where('user_id', auth()->id());
            }
        } else {
            $query->where('user_id', auth()->id());
        }

        // Order the results by created_at and paginate
        $aktivs = $query->orderBy('created_at', 'desc')
            ->with('files') // eager load the files relationship
            ->paginate(10)
            ->appends($request->query()); // Keep query parameters in pagination links

        return view('pages.aktiv.index', compact('aktivs', 'yerCount', 'noturarBinoCount', 'turarBinoCount'));
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
            'user_id'          => 'nullable',
            'building_type' => 'nullable|in:yer,TurarBino,NoturarBino',

            'kadastr_pdf'      => 'nullable|file',
            'hokim_qarori_pdf' => 'nullable|file',
            'transfer_basis_pdf' => 'nullable|file',
        ]);
        // $request->validate([
        //     'files' => 'required|array|min:4', // Enforces at least 4 files
        //     'files.*' => 'required|file', // Ensures each file is valid
        //     // other validations
        // ]);

        $data = $request->except('files', 'kadastr_pdf', 'hokim_qarori_pdf', 'transfer_basis_pdf');
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

        if ($request->hasFile('kadastr_pdf')) {
            $kadastrPath = $request->file('kadastr_pdf')->move(public_path('uploads/aktivs'), 'kadastr_' . time() . '.' . $request->file('kadastr_pdf')->getClientOriginalExtension());
            $aktiv->kadastr_pdf = 'uploads/aktivs/' . basename($kadastrPath); // Store the file path in the 'kadastr_pdf' column
        }
        
        if ($request->hasFile('hokim_qarori_pdf')) {
            $hokimPath = $request->file('hokim_qarori_pdf')->move(public_path('uploads/aktivs'), 'hokim_' . time() . '.' . $request->file('hokim_qarori_pdf')->getClientOriginalExtension());
            $aktiv->hokim_qarori_pdf = 'uploads/aktivs/' . basename($hokimPath); // Store the file path in the 'hokim_qarori_pdf' column
        }
        
        if ($request->hasFile('transfer_basis_pdf')) {
            $transferPath = $request->file('transfer_basis_pdf')->move(public_path('uploads/aktivs'), 'transfer_' . time() . '.' . $request->file('transfer_basis_pdf')->getClientOriginalExtension());
            $aktiv->transfer_basis_pdf = 'uploads/aktivs/' . basename($transferPath); // Store the file path in the 'transfer_basis_pdf' column
        }
        
        // Save the 'aktiv' model after all file paths are set
        $aktiv->save();
        
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

            'user_id'          => 'nullable',
            'building_type' => 'nullable|in:yer,TurarBino,NoturarBino',

            'kadastr_pdf'      => 'nullable|file',
            'hokim_qarori_pdf' => 'nullable|file',
            'transfer_basis_pdf' => 'nullable|file',
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



        $data = $request->except('files', 'kadastr_pdf', 'hokim_qarori_pdf', 'transfer_basis_pdf');
        $aktiv->update($data);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('assets', 'public');
                $aktiv->files()->create([
                    'path' => $path,
                ]);
            }
        }

        if ($request->hasFile('kadastr_pdf')) {
            $kadastrPath = $request->file('kadastr_pdf')->move(public_path('uploads/aktivs'), 'kadastr_' . time() . '.' . $request->file('kadastr_pdf')->getClientOriginalExtension());
            $aktiv->kadastr_pdf = 'uploads/aktivs/' . basename($kadastrPath);
        }
        
        if ($request->hasFile('hokim_qarori_pdf')) {
            $hokimPath = $request->file('hokim_qarori_pdf')->move(public_path('uploads/aktivs'), 'hokim_' . time() . '.' . $request->file('hokim_qarori_pdf')->getClientOriginalExtension());
            $aktiv->hokim_qarori_pdf = 'uploads/aktivs/' . basename($hokimPath);
        }
        
        if ($request->hasFile('transfer_basis_pdf')) {
            $transferPath = $request->file('transfer_basis_pdf')->move(public_path('uploads/aktivs'), 'transfer_' . time() . '.' . $request->file('transfer_basis_pdf')->getClientOriginalExtension());
            $aktiv->transfer_basis_pdf = 'uploads/aktivs/' . basename($transferPath);
        }
        
        // Save the updated model
        $aktiv->save();
        

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

        // if ($userRole == 'Super Admin') {
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

    

    public function kadastrBorlar(Request $request)
    {
        $aktiv_kadastr = Aktiv::whereNotNull('kadastr_raqami')
                              ->where('kadastr_raqami', '!=', '00:00:00:00:00:0000') 
                              ->where('kadastr_raqami', 'not like', '00%')  
                              ->with('user')  
                              ->get();
    
        return view('pages.aktiv.kadastr_borlar', compact('aktiv_kadastr'));
    }
    
    
    public function userAktivCounts(Request $request)
    {
        // Get the user's role and district from the authenticated user
        $userRole = auth()->user()->roles->first()->name;
        $user_id = auth()->user()->id;
        $district_id = auth()->user()->district_id; // Assuming district_id is a property on the user model

        // Only Super Admins and Managers can access this page
        if ($userRole != 'Super Admin' && $userRole != 'Manager') {
            abort(403, 'Unauthorized access.');
        }

        // Initialize the query with the User model
        $query = User::query();

        // If a district_id is provided in the request, use it, otherwise use the authenticated user's district_id
        $requestDistrictId = $request->input('district_id');
        if ($requestDistrictId) {
            // Apply the district filter from the request
            $query->whereHas('user', function ($q) use ($requestDistrictId) {
                $q->where('district_id', $requestDistrictId);
            });
        } else {
            // If no district_id is provided in the request, we should check whether the user is assigned to a district directly
            if ($district_id) {
                // Filter by the district_id of the authenticated user
                $query->where('district_id', $district_id);
                // dd($district_id);
            } else {
                // If the user doesn't have a direct district_id, filter by the district related to the user's aktiv
                $query->whereHas('aktivs', function ($q) {
                    // Check if the associated aktiv has a related street and district
                    $q->whereHas('street', function ($q) {
                        $q->whereHas('district');
                    });
                });
            }
        }

        // Get users with their associated aktiv counts
        $users = $query->withCount('aktivs')->get();



        // Return the view with the users data
        return view('pages.aktiv.user_counts', compact('users'));
    }


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

    public function kadastr_index(Aktiv $aktiv)
    {
        $this->authorizeView($aktiv);

        // dd('aktivs.kadastr_index');
        return view('pages.aktiv.kadastr_index');
    }

    /**
     * Handle the cadastral number submission and fetch data.
     */
    public function kadastr(Request $request)
    {
        $validated = $request->validate([
            'cadastre_numbers' => 'required|string', // Expect multi-line input
        ]);

        // Process input into an array
        $cadastreNumbers = array_filter(array_map('trim', explode("\n", $validated['cadastre_numbers'])));

        $results = [];

        foreach ($cadastreNumbers as $number) {
            // Updated regex to cover more formats, including `/` and extended segments
            if (!preg_match('/^\d{2}:\d{2}:\d{2}:\d{2}(:\d+(:\d+)?|\/\d+)?(:\d+(:\d+)?)?$/', $number)) {
                $results[] = [
                    'cad_number' => $number,
                    'error' => "Invalid format for cadastral number: $number",
                ];
                continue;
            }

            try {
                // Make API request
                $response = Http::get("http://otchet.davbaho.uz/api/get_cadastre_second/1", [
                    'num' => $number,
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    // Log::info($data);
                    if (isset($data['documents'])) {
                        Log::info($data['documents']);

                        $documents = $data['documents'];
                    } else {
                        Log::warning("No documents found for cadastral number: $number");
                        $documents = [];
                    }


                    $results[] = [
                        'cad_number' => $data['cad_number'] ?? $number,
                        'region' => $data['region'] ?? 'Unknown',
                        'district' => $data['district'] ?? 'Unknown',
                        'address' => $data['address'] ?? 'Unknown',
                        'land_area' => ($data['land_area'] ?? '0') . ' m²',
                        'bans' => $data['bans'] ?? [],
                        'documents' => $data['documents'] ?? [],
                        'tipText' => $data['tipText'] ?? 'Unknown',
                        'vidText' => $data['vidText'] ?? 'Unknown',
                        'error' => null,
                    ];
                } else {
                    // Handle unsuccessful HTTP responses
                    $results[] = [
                        'cad_number' => $number,
                        'error' => "Failed to fetch data for cadastral number: $number (HTTP {$response->status()})",
                    ];
                }
            } catch (\Exception $e) {
                // Log and handle exceptions
                \Log::error("Error fetching data for cadastral number $number: " . $e->getMessage());
                $results[] = [
                    'cad_number' => $number,
                    'error' => "An error occurred: " . $e->getMessage(),
                ];
            }
        }

        return view('pages.aktiv.kadastr_results', ['results' => $results]);
    }
}
