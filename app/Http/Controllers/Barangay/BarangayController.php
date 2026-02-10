<?php

namespace App\Http\Controllers\Barangay;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barangay;
use App\Models\Municipality;
use App\Models\Province;
use App\Models\BarangayInfo;
use App\Models\BarangayPosition;
use App\Models\Region;
use App\Models\Purok;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\BarangayCommitee;
use App\Models\BarangayOfficial;


class BarangayController extends Controller
{
    //

    public function dashboard_barangay()
    {
        return view('barangay.dashboard');
    }
      public function purok()
    {
        return view('barangay.purok');
    }
     public function barangay_position(){
            return view('admin.position');
    }
    public function store_position(Request $request){
         $validator = Validator::make($request->all(), [
           
            'position' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        if (BarangayPosition::where('position', $request->position)
        ->where('position', $request->position)
        ->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'The Barangay Position already exists under the selected.',
            ], 409); // 409 Conflict status code
            }
    
        try {
            $position = new BarangayPosition;
            $position->position = $request->position;
            $position->barangay_info_id = Auth::user()->barangay_info_id;
            $position->status = "Active";
        
            $position->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Position created successfully',
                'data' => $position
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the Position',
                'error' => $e->getMessage()
            ], 500);
        }
    }

     public function getDataPosition(Request $request){
         // Get the search query and per_page from the request
           // Get the search query and per_page from the request
          $search = $request->query('search');
          $perPage = $request->query('per_page', 10); // Default to 10 if per_page is not provided
      
          // Query certifications with optional search
          $positions = BarangayPosition::when($search, function ($query, $search) {
                  return $query->where('position', 'like', '%' . $search . '%');
                
          })
          ->where('barangay_info_id', Auth::user()->barangay_info_id)
          ->paginate($perPage);
      
          return response()->json([
              'success' => true,
              'data' => $positions
          ]);
    }

    public function update_position(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'position' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    // Find the existing record
    $position = BarangayPosition::find($id);

    if (!$position) {
        return response()->json([
            'success' => false,
            'message' => 'Position not found'
        ], 404);
    }

    // Only check for duplicates if the commitee value has changed
    if ($request->position !== $position->position) {
        if (BarangayPosition::where('position', $request->position)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'The Position already exists.',
            ], 409); // 409 Conflict
        }
    }

    try {
        $position->position = $request->position;
        $position->status = $request->status;
        $position->barangy_info_id = Auth::user()->barangay_info_id;
        $position->save();

        return response()->json([
            'success' => true,
            'message' => 'Position updated successfully',
            'data' => $position
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while updating the Commitee',
            'error' => $e->getMessage()
        ], 500);
    }
}
public function delete_position($id){
     try {
            $position = BarangayPosition::find($id);
            
            if (!$position) {
                return response()->json([
                    'success' => false,
                    'message' => 'Position not found'
                ], 404);
            }
            
            $position->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Position deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the Position',
                'error' => $e->getMessage()
            ], 500);
        }

}

public function getDataCommitee(Request $request){
         // Get the search query and per_page from the request
           // Get the search query and per_page from the request
          $search = $request->query('search');
          $perPage = $request->query('per_page', 10); // Default to 10 if per_page is not provided
      
          // Query certifications with optional search
          $commitees = BarangayCommitee::when($search, function ($query, $search) {
                  return $query->where('commitee', 'like', '%' . $search . '%');
                
          })
          ->where('barangay_info_id', Auth::user()->barangay_info_id)
          ->paginate($perPage);
      
          return response()->json([
              'success' => true,
              'data' => $commitees
          ]);
    }
     public function update_commitee(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'commitee' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    // Find the existing record
    $commitee = BarangayCommitee::find($id);

    if (!$commitee) {
        return response()->json([
            'success' => false,
            'message' => 'Commitee not found'
        ], 404);
    }

    // Only check for duplicates if the commitee value has changed
    if ($request->commitee !== $commitee->commitee) {
        if (BarangayCommitee::where('commitee', $request->commitee)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'The Barangay Commitee already exists.',
            ], 409); // 409 Conflict
        }
    }

    try {
        $commitee->commitee = $request->commitee;
        $commitee->status = $request->status;
        $commitee->save();

        return response()->json([
            'success' => true,
            'message' => 'Commitee updated successfully',
            'data' => $commitee
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while updating the Commitee',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function delete_commitee($id){
     try {
            $commitee = BarangayCommitee::find($id);
            
            if (!$commitee) {
                return response()->json([
                    'success' => false,
                    'message' => 'Office Head not found'
                ], 404);
            }
            
            $commitee->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Commitee deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the Commitee',
                'error' => $e->getMessage()
            ], 500);
        }

}

 

 public function barangay_commitee(){
        return view('admin.commitee');
    }
    
    public function store_commitee(Request $request){
        $validator = Validator::make($request->all(), [
           
            'commitee' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        if (BarangayCommitee::where('commitee', $request->commitee)
        ->where('commitee', $request->commitee)
        ->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'The Barangay Commitee already exists under the selected.',
            ], 409); // 409 Conflict status code
            }
    
        try {
            $commitee = new BarangayCommitee;
            $commitee->commitee = $request->commitee;
            $commitee->barangay_info_id = Auth::user()->barangay_info_id;
            $commitee->status = "Active";
        
            $commitee->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Commitee created successfully',
                'data' => $commitee
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the Commitee',
                'error' => $e->getMessage()
            ], 500);
        }

    }


     public function store_purok(Request $request){
        $validator = Validator::make($request->all(), [
           
            'purok_name' => 'required',
            'purok_incharge' => 'required',
              'status_term' => 'required',
                'term_start_date' => 'required',
                'term_end_date' => 'required',
            'contact_number' => 'required',
        ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
             if (Purok::where('purok_name', $request->purok_name)
        ->where('purok_name', $request->purok_name)
        ->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'The Purok already exists under the selected.',
            ], 409);
            }
        try {
            $purok = new Purok;
            $purok->purok_name = $request->purok_name;
            $purok->purok_incharge = $request->purok_incharge;
            $purok->contact_number = $request->contact_number;
            $purok->term_start_date = $request->term_start_date;
            $purok->term_end_date = $request->term_end_date;
            $purok->status_term = $request->status_term;
            $purok->barangay_info_id = Auth::user()->barangay_info_id;
            $purok->status = "Active";
            $purok->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Purok created successfully',
                'data' => $purok
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the Purok',
                'error' => $e->getMessage()
            ], 500);
        }

    }

    public function update_purok(Request $request){
        $validator = Validator::make($request->all(), [
           
            'purok_name' => 'required',
             'purok_incharge' => 'required',
            'contact_number' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
      

             $exists = Purok::where('purok_name', $request->purok_name)
            ->where('barangay_info_id', Auth::user()->barangay_info_id)
            ->where('id', '!=', $request->id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'The Purok already exists.',
            ], 409);
        }
    
        try {
            $purok =  Purok ::find($request->id);
            $purok->purok_name = $request->purok_name;
            $purok->purok_incharge = $request->purok_incharge;
            $purok->contact_number = $request->contact_number;
            $purok->term_start_date = $request->term_start_date;
            $purok->term_end_date = $request->term_end_date;
            $purok->status_term = $request->status_term;
            $purok->barangay_info_id = Auth::user()->barangay_info_id;
            $purok->status = $request->status;
            $purok->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Purok Updated successfully',
                'data' => $purok
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the Purok',
                'error' => $e->getMessage()
            ], 500);
        }

    }

    public function getDataPurok(Request $request){
          $search = $request->query('search');
          $perPage = $request->query('per_page', 10); // Default to 10 if per_page is not provided
      
          // Query certifications with optional search
          $puroks = Purok::when($search, function ($query, $search) {
                  return $query
                  ->where('purok_name', 'like', '%' . $search . '%')
                   ->OrWhere('purok_incharge', 'like', '%' . $search . '%')
                    ->OrWhere('contact_number', 'like', '%' . $search . '%')
                      ->OrWhere('term_start_date', 'like', '%' . $search . '%')
                      ->OrWhere('term_end_date', 'like', '%' . $search . '%')
                      ->OrWhere('status_term', 'like', '%' . $search . '%')

                     ->OrWhere('status', 'like', '%' . $search . '%');
                
          })
          ->where('barangay_info_id', Auth::user()->barangay_info_id)
          ->paginate($perPage);
          return response()->json([
              'success' => true,
              'data' => $puroks
          ]);
    }

    public function barangay_official(){
        return view('barangay.official');
    }

    
    public function getDatabrangayOfficial()
{
            $barangays = BarangayPosition::
            where('barangay_info_id', Auth::user()->barangay_info_id)
             ->orderBy('position', 'asc')->get();
            return response()->json($barangays);
        }
        public function getDataCommiteesDropdown()
{
            $commitees = BarangayCommitee::
            where('barangay_info_id', Auth::user()->barangay_info_id)
             ->orderBy('commitee', 'asc')->get();
            return response()->json($commitees);
        }
         public function store_barangay_official(Request $request)
{
    // Validate incoming request
    $validator = Validator::make($request->all(), [
        'position'    => 'required',
        'commitee'           => 'required',
        'first_name'         => 'required',
        'middle_initial'     => 'nullable',
        'last_name'         => 'required',
        'extension'    => 'nullable',
        'term_start'    => 'required',
        'term_end'    => 'required',
        'term_status'    => 'required',     
        'contact_number'   => 'required',
        'email'            => 'required|email|max:255',
        'address'            => 'required',    
        'photo'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // optional photo
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    
    try {
    $chairmanId = \App\Models\BarangayPosition::where('position', 'Barangay Chairman')->value('id');

            if (
                $request->term_status === 'Incumbent' &&
                $request->position == $chairmanId
            ) {
                $chairmanExists = BarangayOfficial::where(
                    'barangay_info_id',
                    Auth::user()->barangay_info_id
                )
                ->where('position_id', $chairmanId)
                ->where('term_status', 'Incumbent')
                ->exists();

                if ($chairmanExists) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Only one Incumbent Barangay Chairman is allowed.'
                    ], 409);
                }
            }


        $official = new BarangayOfficial();
        $official->position_id        = $request->position;
        $official->committee_id       = $request->commitee;
        $official->barangay_info_id   = Auth::user()->barangay_info_id;
        $official->first_name         = $request->first_name;
        $official->middle_initial     = $request->middle_initial;
        $official->last_name          = $request->last_name;
        $official->extension          = $request->extension;
        $official->term_start         = $request->term_start;
        $official->term_end           = $request->term_end;
        $official->term_status        = $request->term_status;
        $official->contact_number     = $request->contact_number;
        $official->email              = $request->email;
        $official->address            = $request->address;
        $official->status             = 'Active';

        // Handle photo upload if exists
       if ($request->hasFile('photo')) {

                $file = $request->file('photo');
                $ext  = $file->extension();

                // 🔹 Build filename parts
                $firstName = str_replace(' ', '_', strtoupper($official->first_name));
                $lastName  = str_replace(' ', '_', strtoupper($official->last_name));
                $contact   = $official->contact_number;

                $fileName = "{$firstName}_{$lastName}_{$contact}.{$ext}";

                // 🔹 Get location names
                $region       = str_replace(' ', ' ', $official->barangay->region->region_name);
                $province     = str_replace(' ', ' ', $official->barangay->province->province_name);
                $municipality = str_replace(' ', ' ', $official->barangay->municipality->municipality_name);
                $barangay     = str_replace(' ', ' ', $official->barangay->barangay->barangay_name);
                $position     = str_replace(' ', ' ', $official->position->position);

                // 🔹 Build directory path
                $directory = public_path(
                    "barangay/official/photo/{$region}/{$province}/{$municipality}/{$barangay}/{$position}"
                );

                // Ensure directory exists
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }

                // 🔹 Delete old photo if exists
                if ($official->photo && file_exists(public_path($official->photo))) {
                    unlink(public_path($official->photo));
                }

                // 🔹 Move uploaded file
                $file->move($directory, $fileName);

                // 🔹 Save relative path
                $official->photo =
                    "barangay/official/photo/{$region}/{$province}/{$municipality}/{$barangay}/{$position}/{$fileName}";
            }


        $official->save();

        return response()->json([
            'success' => true,
            'message' => 'Barangay Official created successfully',
            'data'    => $official
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while creating the Barangay Info',
            'error'   => $e->getMessage()
        ], 500);
    }
}

 public function update_barangay_official(Request $request,$id)
{
    // Validate incoming request
    $validator = Validator::make($request->all(), [
        'position'    => 'required',
        'commitee'           => 'required',
        'first_name'         => 'required',
        'middle_initial'     => 'nullable',
        'last_name'         => 'required',
        'extension'    => 'nullable',
        'term_start'    => 'required',
        'term_end'    => 'required',
        'term_status'    => 'required',     
        'contact_number'   => 'required',
        'email'            => 'required|email|max:255',
        'address'            => 'required',    
        'photo'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // optional photo
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    
    try {
    $chairmanId = \App\Models\BarangayPosition::where('position', 'Barangay Chairman')->value('id');

            if (
                $request->term_status === 'Incumbent' &&
                $request->position == $chairmanId
            ) {
                $chairmanExists = BarangayOfficial::where(
                    'barangay_info_id',
                    Auth::user()->barangay_info_id
                )
                ->where('position_id', $chairmanId)
                ->where('term_status', 'Incumbent')
                  ->where('id', '!=', $id) // 👈 EXCLUDE CURRENT RECORD
                ->exists();

                if ($chairmanExists) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Only one Incumbent Barangay Chairman is allowed.'
                    ], 409);
                }
            }


        $official =  BarangayOfficial::find($id);
        $official->position_id        = $request->position;
        $official->committee_id       = $request->commitee;
        $official->barangay_info_id   = Auth::user()->barangay_info_id;
        $official->first_name         = $request->first_name;
        $official->middle_initial     = $request->middle_initial;
        $official->last_name          = $request->last_name;
        $official->extension          = $request->extension;
        $official->term_start         = $request->term_start;
        $official->term_end           = $request->term_end;
        $official->term_status        = $request->term_status;
        $official->contact_number     = $request->contact_number;
        $official->email              = $request->email;
        $official->address            = $request->address;
     
        // Handle photo upload if exists
       if ($request->hasFile('photo')) {

                $file = $request->file('photo');
                $ext  = $file->extension();

                // 🔹 Build filename parts
                $firstName = str_replace(' ', '_', strtoupper($official->first_name));
                $lastName  = str_replace(' ', '_', strtoupper($official->last_name));
                $contact   = $official->contact_number;

                $fileName = "{$firstName}_{$lastName}_{$contact}.{$ext}";

                // 🔹 Get location names
                $region       = str_replace(' ', ' ', $official->barangay->region->region_name);
                $province     = str_replace(' ', ' ', $official->barangay->province->province_name);
                $municipality = str_replace(' ', ' ', $official->barangay->municipality->municipality_name);
                $barangay     = str_replace(' ', ' ', $official->barangay->barangay->barangay_name);
                $position     = str_replace(' ', ' ', $official->position->position);

                // 🔹 Build directory path
                $directory = public_path(
                    "barangay/official/photo/{$region}/{$province}/{$municipality}/{$barangay}/{$position}"
                );

                // Ensure directory exists
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }

                // 🔹 Delete old photo if exists
                if ($official->photo && file_exists(public_path($official->photo))) {
                    unlink(public_path($official->photo));
                }

                // 🔹 Move uploaded file
                $file->move($directory, $fileName);

                // 🔹 Save relative path
                $official->photo =
                    "barangay/official/photo/{$region}/{$province}/{$municipality}/{$barangay}/{$position}/{$fileName}";
            }


        $official->save();

        return response()->json([
            'success' => true,
            'message' => 'Barangay Official created successfully',
            'data'    => $official
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while creating the Barangay Info',
            'error'   => $e->getMessage()
        ], 500);
    }
}

public function getDataBarangayOfficial(Request $request){
          $search = $request->query('search');
          $perPage = $request->query('per_page', 10); // Default to 10 if per_page is not provided
      
          // Query certifications with optional search
        $officials = BarangayOfficial::with([
            'barangay.region',
            'barangay.province',
            'barangay.municipality',
            'barangay.barangay',
            'position',
            'commitee'
        ])->when($search, function ($query, $search) {
                  return $query
                  ->where('first_name', 'like', '%' . $search . '%')
                  ->OrWhere('middle_initial', 'like', '%' . $search . '%')
                  ->OrWhere('last_name', 'like', '%' . $search . '%')
                  ->OrWhere('term_start', 'like', '%' . $search . '%')
                  ->OrWhere('term_end', 'like', '%' . $search . '%')
                  ->OrWhere('term_status', 'like', '%' . $search . '%')
                  ->OrWhere('contact_number', 'like', '%' . $search . '%')
                  ->OrWhere('email', 'like', '%' . $search . '%')
                ->orWhereHas('commitee', function ($q) use ($search) {
                    $q->where('commitee', 'like', '%' . $search . '%');
                })
                  ->orWhereHas('position', function ($q) use ($search) {
                    $q->where('position', 'like', '%' . $search . '%');
                });
                
                
          })
          ->where('barangay_info_id', Auth::user()->barangay_info_id)
          ->orderByRaw("
                CASE 
                    WHEN position_id = (
                        SELECT id FROM barangay_position_tbl WHERE position = 'Barangay Chairman' LIMIT 1
                    ) THEN 0
                    ELSE 1
                END
            ")
          ->orderByRaw("CASE WHEN term_status = 'Incumbent' THEN 0 ELSE 1 END")
          ->paginate($perPage);
          return response()->json([
              'success' => true,
              'data' => $officials
          ]);
    }
     public function household(){
        return view('barangay.household');
     }

     public function create_member(){
        return view('barangay.create_member');
     }


}
