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
use App\Models\Household;
use App\Models\HouseholdMember;
use App\Models\HouseholdCrop;
use App\Models\HouseholdLivestock;
use App\Models\Blotter;
use App\Models\BuildingPermit;
use App\Models\BarangayClearance;
use App\Models\CertificateIndigency;
use App\Models\DeathCertification;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ResidencyCertificate;





class BarangayController extends Controller
{
    //

   public function dashboard_barangay()
{
    $members = HouseholdMember::all();
    
    // Basic counts
    $totalMembers = $members->count();
    $totalHeads = $members->where('is_head', true)->count();
    $total4ps = $members->where('is_4ps_member', true)->count();
    $totalVoters = $members->where('voter_status', true)->count();
    
    // Demographics
    $maleCount = $members->where('sex', 'Male')->count();
    $femaleCount = $members->where('sex', 'Female')->count();
    
    // Basic Age groups
    $minors = $members->filter(function($member) {
        return $member->age < 18;
    })->count();
    
    $adults = $members->filter(function($member) {
        return $member->age >= 18 && $member->age < 60;
    })->count();
    
    $seniors = $members->filter(function($member) {
        return $member->age >= 60;
    })->count();
    
    // DETAILED AGE GROUPS
    // Infants (0-2 years)
    $infants = $members->filter(function($member) {
        return $member->age >= 0 && $member->age <= 2;
    })->count();
    
    // Preschool (3-5 years)
    $preschool = $members->filter(function($member) {
        return $member->age >= 3 && $member->age <= 5;
    })->count();
    
    // School Age (6-12 years)
    $schoolAge = $members->filter(function($member) {
        return $member->age >= 6 && $member->age <= 12;
    })->count();
    
    // Adolescents (13-17 years)
    $adolescents = $members->filter(function($member) {
        return $member->age >= 13 && $member->age <= 17;
    })->count();
    
    // Young Adults (18-25 years)
    $youngAdults = $members->filter(function($member) {
        return $member->age >= 18 && $member->age <= 25;
    })->count();
    
    // Adults (26-39 years)
    $adultsMid = $members->filter(function($member) {
        return $member->age >= 26 && $member->age <= 39;
    })->count();
    
    // Middle Age (40-59 years)
    $middleAge = $members->filter(function($member) {
        return $member->age >= 40 && $member->age <= 59;
    })->count();
    
    // Senior Citizens - Early (60-74 years)
    $seniorEarly = $members->filter(function($member) {
        return $member->age >= 60 && $member->age <= 74;
    })->count();
    
    // Elderly (75+ years)
    $elderly = $members->filter(function($member) {
        return $member->age >= 75;
    })->count();
    
    // Civil status
    $civilStatus = [
        'Single' => $members->where('civil_status', 'Single')->count(),
        'Married' => $members->where('civil_status', 'Married')->count(),
        'Widowed' => $members->where('civil_status', 'Widowed')->count(),
        'Divorced' => $members->where('civil_status', 'Divorced')->count(),
        'Separated' => $members->where('civil_status', 'Separated')->count(),
    ];
    
    // Employment status
    $employed = $members->where('employment_status', 'Employed')->count();
    $unemployed = $members->where('employment_status', 'Unemployed')->count();
    $selfEmployed = $members->where('employment_status', 'Self-Employed')->count();
    $student = $members->where('employment_status', 'Student')->count();
    
    // Education levels
    $education = [
        'Elementary' => $members->where('highest_education', 'Elementary')->count(),
        'High School' => $members->where('highest_education', 'High School')->count(),
        'College' => $members->where('highest_education', 'College')->count(),
        'Vocational' => $members->where('highest_education', 'Vocational')->count(),
        'Post Graduate' => $members->where('highest_education', 'Post Graduate')->count(),
    ];
    
    // Monthly income brackets
    $incomeBrackets = [
        'Below 5,000' => $members->filter(function($member) {
            return $member->monthly_income < 5000;
        })->count(),
        '5,000 - 10,000' => $members->filter(function($member) {
            return $member->monthly_income >= 5000 && $member->monthly_income <= 10000;
        })->count(),
        '10,001 - 20,000' => $members->filter(function($member) {
            return $member->monthly_income > 10000 && $member->monthly_income <= 20000;
        })->count(),
        '20,001 - 30,000' => $members->filter(function($member) {
            return $member->monthly_income > 20000 && $member->monthly_income <= 30000;
        })->count(),
        'Above 30,000' => $members->filter(function($member) {
            return $member->monthly_income > 30000;
        })->count(),
    ];
    
    return view('barangay.dashboard', compact(
        'totalMembers',
        'totalHeads',
        'total4ps',
        'totalVoters',
        'maleCount',
        'femaleCount',
        'minors',
        'adults',
        'seniors',
        // New detailed age groups
        'infants',
        'preschool',
        'schoolAge',
        'adolescents',
        'youngAdults',
        'adultsMid',
        'middleAge',
        'seniorEarly',
        'elderly',
        // Other data
        'civilStatus',
        'employed',
        'unemployed',
        'selfEmployed',
        'student',
        'education',
        'incomeBrackets'
    ));
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
        'commitee'           => 'nullable',
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

    
      public function store_household(Request $request){
             DB::beginTransaction();
        
        try {
            // Validate the request
            // $validator = Validator::make($request->all(), [
            //     'address.purok' => 'required|string|max:50',
            //     'address.street' => 'required|string|max:255',
            //     'address.household_number' => 'nullable|string|max:50',
            //     'address.longitude' => 'nullable|string|max:20',
            //     'address.latitude' => 'nullable|string|max:20',
                
            //     'headOfFamily.firstName' => 'required|string|max:100',
            //     'headOfFamily.middleInitial' => 'nullable|string|max:3',
            //     'headOfFamily.lastName' => 'required|string|max:100',
            //     'headOfFamily.extension' => 'nullable|in:Jr,Sr,II,III,IV',
            //     'headOfFamily.sex' => 'required|in:Male,Female',
            //     'headOfFamily.birthdate' => 'required|date|before:today',
            //     'headOfFamily.civilStatus' => 'required|in:Single,Married,Widowed,Separated,Divorced',
            //     'headOfFamily.contactNumber' => 'required|string|max:20',
            //     'headOfFamily.email' => 'nullable|email|max:100',
            //     'headOfFamily.nationalId' => 'nullable|string|max:50',
            //     'headOfFamily.highestEducation' => 'required|string|max:100',
            //     'headOfFamily.educationalStatus' => 'required|string|max:50',
            //     'headOfFamily.employmentStatus' => 'required|in:Employed,Unemployed',
            //     'headOfFamily.voterStatus' => 'required|in:Voter,Non-Voter',
            //     'headOfFamily.is4psMember' => 'required|in:Yes,No',
            //     'headOfFamily.isDeceased' => 'required|in:Yes,No',
                
            //     'householdInfo.type' => 'nullable|string|max:50',
            //     'householdInfo.housingType' => 'nullable|string|max:50',
            //     'householdInfo.housingTypeOther' => 'nullable|string|max:100',
            //     'householdInfo.houseMaterials' => 'nullable|string|max:50',
            //     'householdInfo.houseMaterialsOther' => 'nullable|string|max:100',
            //     'householdInfo.waterSource' => 'nullable|string|max:50',
            //     'householdInfo.waterSourceICWS' => 'nullable|string|max:50',
            //     'householdInfo.waterSourceOther' => 'nullable|string|max:100',
            //     'householdInfo.powerSupply' => 'nullable|string|max:50',
            //     'householdInfo.powerSupplyOther' => 'nullable|string|max:100',
            //     'householdInfo.internetProvider' => 'nullable|string|max:50',
            //     'householdInfo.internetProviderOther' => 'nullable|string|max:100',
            //     'householdInfo.garbageDisposal' => 'nullable|string|max:50',
            //     'householdInfo.garbageDisposalOther' => 'nullable|string|max:100',
            //     'householdInfo.fishingVessel' => 'nullable|string|max:50',
            //     'householdInfo.avgFishCatch' => 'nullable|numeric|min:0',
            //     'householdInfo.fishingFrequency' => 'nullable|string|max:50',
            //     'householdInfo.longitude' => 'nullable|string|max:20',
            //     'householdInfo.latitude' => 'nullable|string|max:20',
            //     'householdInfo.notes' => 'nullable|string',
                
            //     'members' => 'nullable|array',
            //     'members.*.firstName' => 'required|string|max:100',
            //     'members.*.lastName' => 'required|string|max:100',
            //     'members.*.middleInitial' => 'nullable|string|max:3',
            //     'members.*.extension' => 'nullable|in:Jr,Sr,II,III,IV',
            //     'members.*.sex' => 'required|in:Male,Female',
            //     'members.*.birthdate' => 'required|date|before:today',
            //     'members.*.civilStatus' => 'required|in:Single,Married,Widowed,Separated,Divorced',
            //     'members.*.relationship' => 'required|string|max:50',
            //     'members.*.voterStatus' => 'required|in:Voter,Non-Voter',
            //     'members.*.is4psMember' => 'required|in:Yes,No',
            //     'members.*.isDeceased' => 'required|in:Yes,No',
            //     'members.*.highestEducation' => 'required|string|max:100',
            //     'members.*.educationalStatus' => 'required|string|max:50',
            //     'members.*.employmentStatus' => 'required|in:Employed,Unemployed',
            //     'members.*.contactNumber' => 'nullable|string|max:20',
            //     'members.*.email' => 'nullable|email|max:100',
                
            //     'cropsPlanted' => 'nullable|array',
            //     'livestockRaised' => 'nullable|array',
            // ]);

            // if ($validator->fails()) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Validation errors',
            //         'errors' => $validator->errors()
            //     ], 422);
            // }

            // Create household
            $household = Household::create([
                'barangay_info_id' => Auth::user()->barangay_info_id,
                'purok' => $request->input('address.purok'),
                'street' => $request->input('address.street'),
                'household_number' => $request->input('address.householdNumber'),
                'longitude' => $request->input('address.longitude') ?? $request->input('householdInfo.longitude'),
                'latitude' => $request->input('address.latitude') ?? $request->input('householdInfo.latitude'),
                
                'household_type' => $request->input('householdInfo.type'),
                'housing_type' => $request->input('householdInfo.housingType'),
                'housing_type_other' => $request->input('householdInfo.housingTypeOther'),
                'house_materials' => $request->input('householdInfo.houseMaterials'),
                'house_materials_other' => $request->input('householdInfo.houseMaterialsOther'),
                'water_source' => $request->input('householdInfo.waterSource'),
                'water_source_icws' => $request->input('householdInfo.waterSourceICWS'),
                'water_source_other' => $request->input('householdInfo.waterSourceOther'),
                'power_supply' => $request->input('householdInfo.powerSupply'),
                'power_supply_other' => $request->input('householdInfo.powerSupplyOther'),
                'waste_biodegradable' => $request->input('householdInfo.wasteBiodegradable', false),
                'waste_plastics' => $request->input('householdInfo.wastePlastics', false),
                'waste_others' => $request->input('householdInfo.wasteOthers'),
                'internet_provider' => $request->input('householdInfo.internetProvider'),
                'internet_provider_other' => $request->input('householdInfo.internetProviderOther'),
                'garbage_disposal' => $request->input('householdInfo.garbageDisposal'),
                'garbage_disposal_other' => $request->input('householdInfo.garbageDisposalOther'),
                
                'fishing_vessel' => $request->input('householdInfo.fishingVessel'),
                'avg_fish_catch' => $request->input('householdInfo.avgFishCatch'),
                'fishing_frequency' => $request->input('householdInfo.fishingFrequency'),
                'notes' => $request->input('householdInfo.notes'),
                'status' => 'Active',
            ]);

            // Create head of family
            $headData = $request->input('headOfFamily');
            $household->members()->create([
                'is_head' => true,
                'barangay_info_id' => Auth::user()->barangay_info_id,
                'first_name' => $headData['firstName'],
                'middle_initial' => $headData['middleInitial'] ?? null,
                'last_name' => $headData['lastName'],
                'extension' => $headData['extension'] ?? null,
                'sex' => $headData['sex'],
                'birthdate' => $headData['birthdate'],
                'civil_status' => $headData['civilStatus'],
                'relationship' => 'Head',
                'national_id' => $headData['nationalId'] ?? null,
                'voter_status' => $headData['voterStatus'],
                'is_4ps_member' => $headData['is4psMember'],
                'is_deceased' => $headData['isDeceased'],
                'highest_education' => $headData['highestEducation'],
                'educational_status' => $headData['educationalStatus'],
                'employment_status' => $headData['employmentStatus'],
                'occupation' => $headData['occupation'] ?? null,
                'nature_of_employment' => $headData['natureOfEmployment'] ?? null,
                'monthly_income' => $headData['monthlyIncome'] ?? null,
                'contact_number' => $headData['contactNumber'],
                'email' => $headData['email'] ?? null,
            ]);

            // Create family members
            if ($request->has('members')) {
                foreach ($request->input('members') as $memberData) {
                    $household->members()->create([
                        'is_head' => false,
                          'barangay_info_id' => Auth::user()->barangay_info_id,
                        'first_name' => $memberData['firstName'],
                        'middle_initial' => $memberData['middleInitial'] ?? null,
                        'last_name' => $memberData['lastName'],
                        'extension' => $memberData['extension'] ?? null,
                        'sex' => $memberData['sex'],
                        'birthdate' => $memberData['birthdate'],
                        'civil_status' => $memberData['civilStatus'],
                        'relationship' => $memberData['relationship'],
                        'national_id' => $memberData['nationalId'] ?? null,
                        'voter_status' => $memberData['voterStatus'],
                        'is_4ps_member' => $memberData['is4psMember'],
                        'is_deceased' => $memberData['isDeceased'],
                        'highest_education' => $memberData['highestEducation'],
                        'educational_status' => $memberData['educationalStatus'],
                        'employment_status' => $memberData['employmentStatus'],
                        'occupation' => $memberData['occupation'] ?? null,
                        'nature_of_employment' => $memberData['natureOfEmployment'] ?? null,
                        'monthly_income' => $memberData['monthlyIncome'] ?? null,
                        'contact_number' => $memberData['contactNumber'] ?? null,
                        'email' => $memberData['email'] ?? null,
                    ]);
                }
            }

            // Create crops
            if ($request->has('cropsPlanted')) {
                foreach ($request->input('cropsPlanted') as $cropData) {
                    $household->crops()->create([
                        'name' => $cropData['name'],
                        'type' => $cropData['type'],
                        'quantity' => $cropData['quantity'],
                        'unit' => $cropData['unit'],
                    ]);
                }
            }

            // Create livestock
            if ($request->has('livestockRaised')) {
                foreach ($request->input('livestockRaised') as $livestockData) {
                    $household->livestock()->create([
                        'type' => $livestockData['type'],
                          'barangay_info_id' => Auth::user()->barangay_info_id,
                        'category' => $livestockData['category'],
                        'quantity' => $livestockData['quantity'] ?? 0,
                        'unit' => $livestockData['unit'],
                        'details' => $livestockData['details'] ?? null,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Household registration submitted successfully',
                'data' => [
                    'reference_id' => $household->reference_id,
                    'household_id' => $household->id,
                    'total_members' => $household->members()->count(),
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit household registration',
                'error' => $e->getMessage()
            ], 500);
        }
      }

   public function update_household(Request $request, $id)
{
    try {
        DB::beginTransaction();
        
        // Find the existing household
        $household = Household::findOrFail($id);
        
        // Update household main information
        $household->update([
            'purok' => $request->input('address.purok'),
            'street' => $request->input('address.street'),
            'household_number' => $request->input('address.household_number'),
            'longitude' => $request->input('householdInfo.longitude'),
            'latitude' => $request->input('householdInfo.latitude'),
            
            'household_type' => $request->input('householdInfo.type'),
            'housing_type' => $request->input('householdInfo.housing_type'),
            'housing_type_other' => $request->input('householdInfo.housing_type_other'),
            'house_materials' => $request->input('householdInfo.house_materials'),
            'house_materials_other' => $request->input('householdInfo.house_materials_other'),
            'water_source' => $request->input('householdInfo.water_source'),
            'water_source_icws' => $request->input('householdInfo.water_source_icws'),
            'water_source_other' => $request->input('householdInfo.water_source_other'),
            'power_supply' => $request->input('householdInfo.power_supply'),
            'power_supply_other' => $request->input('householdInfo.power_supply_other'),
            'waste_biodegradable' => $request->input('householdInfo.waste_biodegradable', false),
            'waste_plastics' => $request->input('householdInfo.waste_plastics', false),
            'waste_others' => $request->input('householdInfo.waste_others'),
            'internet_provider' => $request->input('householdInfo.internet_provider'),
            'internet_provider_other' => $request->input('householdInfo.internet_provider_other'),
            'garbage_disposal' => $request->input('householdInfo.garbage_disposal'),
            'garbage_disposal_other' => $request->input('householdInfo.garbage_disposal_other'),
            
            'fishing_vessel' => $request->input('householdInfo.fishing_vessel'),
            'avg_fish_catch' => $request->input('householdInfo.avg_fish_catch'),
            'fishing_frequency' => $request->input('householdInfo.fishing_frequency'),
            'notes' => $request->input('householdInfo.notes'),
            'status' => $request->input('status', 'Active'),
        ]);

        // Update or create head of family
        $headData = $request->input('headOfFamily');
        
        // Check if head of family exists
        $existingHead = $household->headOfFamily;
        
        if ($existingHead) {
            // Update existing head
            $existingHead->update([
                'first_name' => $headData['first_name'],
                'middle_initial' => $headData['middle_initial'] ?? null,
                'last_name' => $headData['last_name'],
                'extension' => $headData['extension'] ?? null,
                'sex' => $headData['sex'],
                'birthdate' => $headData['birthdate'],
                'civil_status' => $headData['civil_status'],
                'relationship' => 'Head',
                'national_id' => $headData['national_id'] ?? null,
                'voter_status' => $headData['voter_status'],
                'is_4ps_member' => $headData['is_4ps_member'],
                'is_deceased' => $headData['is_deceased'],
                'highest_education' => $headData['highest_education'],
                'educational_status' => $headData['educational_status'],
                'employment_status' => $headData['employment_status'],
                'occupation' => $headData['occupation'] ?? null,
                'nature_of_employment' => $headData['nature_of_employment'] ?? null,
                'monthly_income' => $headData['monthly_income'] ?? null,
                'contact_number' => $headData['contact_number'],
                'email' => $headData['email'] ?? null,
            ]);
        } else {
            // Create new head if doesn't exist
            $household->members()->create([
                'is_head' => true,
                'barangay_info_id' => Auth::user()->barangay_info_id,
                'first_name' => $headData['first_name'],
                'middle_initial' => $headData['middle_initial'] ?? null,
                'last_name' => $headData['last_name'],
                'extension' => $headData['extension'] ?? null,
                'sex' => $headData['sex'],
                'birthdate' => $headData['birthdate'],
                'civil_status' => $headData['civil_status'],
                'relationship' => 'Head',
                'national_id' => $headData['national_id'] ?? null,
                'voter_status' => $headData['voter_status'],
                'is_4ps_member' => $headData['is_4ps_member'],
                'is_deceased' => $headData['is_deceased'],
                'highest_education' => $headData['highest_education'],
                'educational_status' => $headData['educational_status'],
                'employment_status' => $headData['employment_status'],
                'occupation' => $headData['occupation'] ?? null,
                'nature_of_employment' => $headData['nature_of_employment'] ?? null,
                'monthly_income' => $headData['monthly_income'] ?? null,
                'contact_number' => $headData['contact_number'],
                'email' => $headData['email'] ?? null,
            ]);
        }

        // Handle family members - sync approach
        if ($request->has('members')) {
            // Get existing member IDs
            $existingMemberIds = $household->familyMembers->pluck('id')->toArray();
            $updatedMemberIds = [];
            
            foreach ($request->input('members') as $memberData) {
                // Check if member has ID (existing)
                if (isset($memberData['id'])) {
                    // Update existing member
                    $member = $household->familyMembers()->find($memberData['id']);
                    if ($member) {
                        $member->update([
                            'first_name' => $memberData['first_name'],
                            'middle_initial' => $memberData['middle_initial'] ?? null,
                            'last_name' => $memberData['last_name'],
                            'extension' => $memberData['extension'] ?? null,
                            'sex' => $memberData['sex'],
                            'birthdate' => $memberData['birthdate'],
                            'civil_status' => $memberData['civil_status'],
                            'relationship' => $memberData['relationship'],
                            'national_id' => $memberData['national_id'] ?? null,
                            'voter_status' => $memberData['voter_status'],
                            'is_4ps_member' => $memberData['is_4ps_member'],
                            'is_deceased' => $memberData['is_deceased'],
                            'highest_education' => $memberData['highest_education'],
                            'educational_status' => $memberData['educational_status'],
                            'employment_status' => $memberData['employment_status'],
                            'occupation' => $memberData['occupation'] ?? null,
                            'nature_of_employment' => $memberData['nature_of_employment'] ?? null,
                            'monthly_income' => $memberData['monthly_income'] ?? null,
                            'contact_number' => $memberData['contact_number'] ?? null,
                            'email' => $memberData['email'] ?? null,
                        ]);
                        $updatedMemberIds[] = $member->id;
                    }
                } else {
                    // Create new member
                    $newMember = $household->members()->create([
                        'is_head' => false,
                        'barangay_info_id' => Auth::user()->barangay_info_id,
                        'first_name' => $memberData['first_name'],
                        'middle_initial' => $memberData['middle_initial'] ?? null,
                        'last_name' => $memberData['last_name'],
                        'extension' => $memberData['extension'] ?? null,
                        'sex' => $memberData['sex'],
                        'birthdate' => $memberData['birthdate'],
                        'civil_status' => $memberData['civil_status'],
                        'relationship' => $memberData['relationship'],
                        'national_id' => $memberData['national_id'] ?? null,
                        'voter_status' => $memberData['voter_status'],
                        'is_4ps_member' => $memberData['is_4ps_member'],
                        'is_deceased' => $memberData['is_deceased'],
                        'highest_education' => $memberData['highest_education'],
                        'educational_status' => $memberData['educational_status'],
                        'employment_status' => $memberData['employment_status'],
                        'occupation' => $memberData['occupation'] ?? null,
                        'nature_of_employment' => $memberData['nature_of_employment'] ?? null,
                        'monthly_income' => $memberData['monthly_income'] ?? null,
                        'contact_number' => $memberData['contact_number'] ?? null,
                        'email' => $memberData['email'] ?? null,
                    ]);
                    $updatedMemberIds[] = $newMember->id;
                }
            }
            
            // Delete members that are no longer in the list
            $membersToDelete = array_diff($existingMemberIds, $updatedMemberIds);
            if (!empty($membersToDelete)) {
                $household->familyMembers()->whereIn('id', $membersToDelete)->delete();
            }
        } else {
            // If no members provided, delete all family members (keep head only)
            $household->familyMembers()->delete();
        }

        // Handle crops - sync approach
        if ($request->has('crops_planted')) {
            // Delete existing crops
            $household->crops()->delete();
            
            // Create new crops
            foreach ($request->input('crops_planted') as $cropData) {
                $household->crops()->create([
                    'name' => $cropData['name'],
                    'type' => $cropData['type'] ?? 'Other',
                    'quantity' => $cropData['quantity'],
                    'unit' => $cropData['unit'],
                ]);
            }
        } else {
            $household->crops()->delete();
        }

        // Handle livestock - sync approach
        if ($request->has('livestock_raised')) {
            // Delete existing livestock
            $household->livestock()->delete();
            
            // Create new livestock
            foreach ($request->input('livestock_raised') as $livestockData) {
                $livestock = $household->livestock()->create([
                    'type' => $livestockData['type'],
                       'barangay_info_id' => Auth::user()->barangay_info_id,
                    'category' => $livestockData['category'] ?? 'Other',
                    'quantity' => $livestockData['quantity'] ?? 0,
                    'unit' => $livestockData['unit'] ?? 'head',
                    'details' => isset($livestockData['details']) ? json_encode($livestockData['details']) : null,
                ]);
            }
        } else {
            $household->livestock()->delete();
        }

        DB::commit();

        // Load relationships for response
        $household->load(['crops', 'livestock', 'headOfFamily', 'familyMembers', 'purok']);

        return response()->json([
            'success' => true,
            'message' => 'Household information updated successfully',
            'data' => [
                'id' => $household->id,
                'reference_id' => $household->reference_id,
                'total_members' => $household->members()->count(),
                'household' => $household
            ]
        ], 200);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Household not found'
        ], 404);
        
    } catch (\Exception $e) {
        DB::rollBack();
        
        return response()->json([
            'success' => false,
            'message' => 'Failed to update household information',
            'error' => $e->getMessage()
        ], 500);
    }
}

      public function getDataPurokPerHousehold()
    {
        $purok = Purok::where('barangay_info_id', Auth::user()->barangay_info_id)->orderBy('purok_name')->get();
        return response()->json($purok);
    }
    public function getDataHousehold(Request $request){
          $search = $request->query('search');
          $perPage = $request->query('per_page', 10); // Default to 10 if per_page is not provided
         $barangayInfoId = Auth::user()->barangay_info_id;
          // Query certifications with optional search
          $household = Household::with(['crops','livestock','headOfFamily','familyMembers','purok'])->when($search, function ($query, $search) {
                  return $query
                    ->where('reference_id', 'like', '%' . $search . '%')
                    ->OrWhere('street', 'like', '%' . $search . '%')
                    ->OrWhere('household_number', 'like', '%' . $search . '%')
                 
                    ->OrWhere('longitude', 'like', '%' . $search . '%')
                    ->OrWhere('latitude', 'like', '%' . $search . '%')
                    ->OrWhere('household_type', 'like', '%' . $search . '%')
                    ->OrWhere('housing_type', 'like', '%' . $search . '%')
                    ->OrWhere('house_materials', 'like', '%' . $search . '%')
                    ->OrWhere('water_source', 'like', '%' . $search . '%')
                    ->OrWhere('power_supply', 'like', '%' . $search . '%')
                    ->OrWhere('internet_provider', 'like', '%' . $search . '%')
                    ->OrWhere('garbage_disposal', 'like', '%' . $search . '%')

                  ->orWhereHas('purok', function ($q) use ($search) {
                    $q->where('purok_name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('headOfFamily', function ($q) use ($search) {
                    $q->where('first_name', 'like', '%' . $search . '%')
                      ->orWhere('middle_initial', 'like', '%' . $search . '%')
                      ->orWhere('last_name', 'like', '%' . $search . '%');
                })
                 ->orWhereHas('familyMembers', function ($q) use ($search) {
                    $q->where('first_name', 'like', '%' . $search . '%')
                      ->orWhere('middle_initial', 'like', '%' . $search . '%')
                      ->orWhere('last_name', 'like', '%' . $search . '%');
                })
                  ->orWhereHas('crops', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                     ->orWhere('type', 'like', '%' . $search . '%')
                    ->orWhere('quantity', 'like', '%' . $search . '%')
                    ->orWhere('unit', 'like', '%' . $search . '%');
                })
                 ->orWhereHas('livestock', function ($q) use ($search) {
                    $q->where('type', 'like', '%' . $search . '%')
                     ->orWhere('category', 'like', '%' . $search . '%')
                    ->orWhere('quantity', 'like', '%' . $search . '%');
                  
                });
          })
          ->where('barangay_info_id', $barangayInfoId)
          ->paginate($perPage);

              // Get total count of all households in this barangay
    $totalCount = Household::where('barangay_info_id', $barangayInfoId)->count();
    
    // Get count of active households
    $activeCount = Household::where('barangay_info_id', $barangayInfoId)
        ->where('status', 'Active') // Adjust field name if different (e.g., 'is_active', 'status')
        ->count();

    $InactiveCount = Household::where('barangay_info_id', $barangayInfoId)
        ->where('status', 'Inactive') // Adjust field name if different (e.g., 'is_active', 'status')
        ->count();
    
    // Get count of households created this month
    $createdThisMonthCount = Household::where('barangay_info_id', $barangayInfoId)
        ->whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->count();
    
    // Get count of households by status (if you have multiple statuses)
    $statusCounts = Household::where('barangay_info_id', $barangayInfoId)
        ->selectRaw('status, count(*) as count')
        ->groupBy('status')
        ->pluck('count', 'status');
      
          return response()->json([
        'success' => true,
        'data' => $household,
        'total_count' => $totalCount,
        'active_count' => $activeCount,
        'inactive_count' => $InactiveCount,
        'created_this_month_count' => $createdThisMonthCount,
        'status_counts' => $statusCounts // Optional: counts by all statuses
    ]);
    }

    public function edit_household($id){
        $household = Household::with(['crops','livestock','headOfFamily','familyMembers','purok'])->findOrFail($id);
       return view('barangay.edit_household', compact('household'));
    }
    public function view_household($id){
        $household = Household::with(['crops','livestock','headOfFamily','familyMembers','purok'])->findOrFail($id);
       return view('barangay.view_household', compact('household'));
    }
    public function blotter(){
        return view('barangay.blotter');
    }
     public function store_blotter(Request $request)
{
    // Validate incoming request
    $validator = Validator::make($request->all(), [
        'case_number'    => 'required',
        'case_type'           => 'required',
        'complainant_name'         => 'required',
        'complainant_contact'     => 'required',
        'complainant_address'         => 'required',
        'respondent_name'    => 'required',
        'respondent_contact'         => 'required',
        'respondent_address'   => 'required',
     
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    // Check if barangay already exists
    if (Blotter::where('case_number', $request->case_number)->exists()) {
        return response()->json([
            'success' => false,
            'message' => 'The Case Number exists under the selected.',
        ], 409); // 409 Conflict
    }

    try {
        $blotter = new Blotter();
        $blotter->case_number     = $request->case_number;
        $blotter->case_type       = $request->case_type;
        $blotter->complainant_name         = $request->complainant_name;
        $blotter->complainant_contact       = $request->complainant_contact;
        $blotter->complainant_address   = $request->complainant_address;
        $blotter->respondent_name     = $request->respondent_name;
        $blotter->respondent_contact          = $request->respondent_contact;
        $blotter->respondent_address    = $request->respondent_address;
        $blotter->status    = $request->status;
        $blotter->barangay_info_id    = Auth::user()->barangay_info_id;
        $blotter->date_filed             = Carbon::now();
       
        $blotter->save();

        return response()->json([
            'success' => true,
            'message' => 'Blotter created successfully',
            'data'    => $blotter
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while creating the Blotter Info',
            'error'   => $e->getMessage()
        ], 500);
    }
}

public function getDataBlotter(Request $request){
         // Get the search query and per_page from the request
           // Get the search query and per_page from the request
          $search = $request->query('search');
          $perPage = $request->query('per_page', 10); // Default to 10 if per_page is not provided
      
          // Query certifications with optional search
          $blotters = Blotter::when($search, function ($query, $search) {
                  return $query
                  ->where('case_number', 'like', '%' . $search . '%')
                  ->OrWhere('respondent_name', 'like', '%' . $search . '%') 
                  ->OrWhere('case_type', 'like', '%' . $search . '%')
                  ->OrWhere('complainant_name', 'like', '%' . $search . '%')
                  ->OrWhere('complainant_contact', 'like', '%' . $search . '%')
                  ->OrWhere('complainant_address', 'like', '%' . $search . '%')
                  ->OrWhere('respondent_contact', 'like', '%' . $search . '%')
                  ->OrWhere('respondent_address', 'like', '%' . $search . '%')
                  ->OrWhere('case_type', 'like', '%' . $search . '%')
                  ->OrWhere('date_filed', 'like', '%' . $search . '%')
                  ->OrWhere('status', 'like', '%' . $search . '%');
                
          })
          ->where('barangay_info_id', Auth::user()->barangay_info_id)
          ->paginate($perPage);
      
          return response()->json([
              'success' => true,
              'data' => $blotters
          ]);
    }

     public function update_blotter(Request $request,$id)
{
    // Validate incoming request
    $validator = Validator::make($request->all(), [
        'case_number'    => 'required',
        'case_type'           => 'required',
        'complainant_name'         => 'required',
        'complainant_contact'     => 'required',
        'complainant_address'         => 'required',
        'respondent_name'    => 'required',
        'respondent_contact'         => 'required',
        'respondent_address'   => 'required',
         'actions_taken'   => 'required',
        'hearing_date'   => 'required',
        'hearing_location'   => 'required',
     
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    // Check if barangay already exists
    if (Blotter::where('case_number', $request->case_number)
          ->where('id', '!=', $request->id)
        ->exists()) {
        return response()->json([
            'success' => false,
            'message' => 'The Case Number exists under the selected.',
        ], 409); // 409 Conflict
    }

    try {
        $blotter = Blotter::find($id);
        $blotter->case_number     = $request->case_number;
        $blotter->case_type       = $request->case_type;
        $blotter->complainant_name         = $request->complainant_name;
        $blotter->complainant_contact       = $request->complainant_contact;
        $blotter->complainant_address   = $request->complainant_address;
        $blotter->respondent_name     = $request->respondent_name;
        $blotter->respondent_contact          = $request->respondent_contact;
        $blotter->respondent_address    = $request->respondent_address;
        $blotter->barangay_info_id    = Auth::user()->barangay_info_id;
        $blotter->actions_taken    = $request->actions_taken;
        $blotter->actions_taken    = $request->actions_taken;
        $blotter->hearing_date    = $request->hearing_date;
        $blotter->hearing_time    = $request->hearing_time;
        $blotter->hearing_location    = $request->hearing_location;
        $blotter->status    = $request->status;
        $blotter->save();

        return response()->json([
            'success' => true,
            'message' => 'Blotter Updated successfully',
            'data'    => $blotter
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while creating the Blotter Info',
            'error'   => $e->getMessage()
        ], 500);
    }
}

  public function certification (){
    return view('barangay.certification');
  }

  public function manage_barangay_clearance (){
   
    return view('barangay.manage_barangay_clearance');

  }
  
   public function store_barangay_clearance(Request $request)
{
    // ✅ Validation (matches Vue form)
    $request->validate([
            'name_requestor' => 'required',
            'native' => 'nullable|string|max:255',
            'purok' => 'required',
            'character_status' => 'nullable|array',
            'character_status.*' => 'string',
            'purpose' => 'required|string|max:255',
            'other_purpose' => 'required_if:purpose,Others|nullable|string|max:255',
            'date_issued' => 'required|date',
    ]);

    DB::beginTransaction();

    try {
        // ✅ Generate Application Number (BC-2026-00001)
       $latest = BarangayClearance::latest()->lockForUpdate()->first();
            $nextId = $latest ? $latest->id + 1 : 1;
            $applicationNo = 'BC-' . Carbon::now()->year . '-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);


        // ✅ Save Record
        BarangayClearance::create([
            'application_no' => $applicationNo,
             'barangay_info_id' => Auth::user()->barangay_info_id,
            'name_requestor' => $request->name_requestor,
          
            'native' => $request->native,
            'purok' => $request->purok,
            'payment_mode' => $request->payment_mode,
            'date_paid' => $request->date_paid,
            'amount' => $request->amount,
            'payment_status' => $request->payment_status,

            // Store checkbox array directly as JSON (Laravel casts automatically)
            'character_status' => $request->input('character_status', []),

            'purpose' => $request->purpose,
            'purpose' => $request->purpose, 
                'other_purpose' => $request->purpose === 'Others' ? $request->other_purpose : null,

            'date_issued' => $request->date_issued,
            'status' => 'Approved Certificate',
        ]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Barangay Clearance successfully created.'
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Something went wrong.',
            'error' => $e->getMessage()
        ], 500);
    }
}
public function update_barangay_clearance(Request $request, $id)
{
    // ✅ Validation (matches Vue form)
    $request->validate([
        'name_requestor' => 'required',
        'native' => 'nullable|string|max:255',
        'purok' => 'required',
        'character_status' => 'nullable|array',
        'character_status.*' => 'string',
        'purpose' => 'required|string|max:255',
        'other_purpose' => 'required_if:purpose,Others|nullable|string|max:255',
        'date_issued' => 'required|date',
    ]);

    DB::beginTransaction();

    try {
        // ✅ Find the record to update
        $clearance = BarangayClearance::findOrFail($id);

        // ✅ Update fields
        $clearance->update([
            'name_requestor' => $request->name_requestor,
            'native' => $request->native,
            'purok' => $request->purok,
            'payment_mode' => $request->payment_mode,
            'date_paid' => $request->date_paid,
            'amount' => $request->amount,
            'payment_status' => $request->payment_status,
            'character_status' => $request->input('character_status', []),
            'purpose' => $request->purpose,
            'other_purpose' => $request->purpose === 'Others' ? $request->other_purpose : null,
            'date_issued' => $request->date_issued,
            'status' => 'Approved Certificate',
        ]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Barangay Clearance successfully updated.'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Something went wrong.',
            'error' => $e->getMessage()
        ], 500);
    }
}

 public function getDataBarangayClearance(Request $request){
         // Get the search query and per_page from the request
           // Get the search query and per_page from the request
          $search = $request->query('search');
          $perPage = $request->query('per_page', 10); // Default to 10 if per_page is not provided
      
          // Query certifications with optional search
          $clearances = BarangayClearance::with('purok')->with('requestor')->when($search, function ($query, $search) {
                  return $query->where('purpose', 'like', '%' . $search . '%')
                   ->orWhere('name_requestor', 'like', '%' . $search . '%')
                    ->orWhere('application_no', 'like', '%' . $search . '%')
                  
                    ->orWhere('native', 'like', '%' . $search . '%')

                    ->orWhereHas('purok', function ($q) use ($search) {
                    $q->where('purok_name', 'like', '%' . $search . '%');
                    
                })
                 ->orWhereHas('requestor', function ($q) use ($search) {
                    $q->where('first_name', 'like', '%' . $search . '%')
                     ->orWhere('middle_initial', 'like', '%' . $search . '%')
                      ->orWhere('last_name', 'like', '%' . $search . '%');
                });
                
          })
          ->where('barangay_info_id', Auth::user()->barangay_info_id)
          ->paginate($perPage);
      
          return response()->json([
              'success' => true,
              'data' => $clearances
          ]);
    }

     public function getDataInhabitansCertification()
    {
        $inhabitants = HouseholdMember::where('barangay_info_id', Auth::user()->barangay_info_id)->orderBy('first_name')->get();
        return response()->json($inhabitants);
    }
       public function getDataDeceased()
    {
        $deceased = HouseholdMember::where('is_deceased','=',"No")->where('barangay_info_id', Auth::user()->barangay_info_id)->orderBy('first_name')->get();
        return response()->json($deceased);
    }
    public function print_barangay_clearance($id)
{
    $barangay_clearance = BarangayClearance::with(['requestor','purok'])
        ->findOrFail($id);

    $barangayId = Auth::user()->barangay_info_id;

    // Barangay Chairman
    $chairman = BarangayOfficial::with('position','commitee')
        ->where('barangay_info_id', $barangayId)
        ->whereHas('position', function($q) {
            $q->where('position', 'Barangay Chairman');
        })
       
        ->where('term_status', 'Incumbent')
        ->first();

    // All Barangay Councilors
  $councilors = BarangayOfficial::with('position','commitee')
    ->where('barangay_info_id', $barangayId)
    ->whereHas('position', function($q) {
        $q->where('position', 'Barangay Councilor');
    })
    ->whereHas('commitee', function($q) {
        $q->where('status', 'Active');
    })
    ->where('term_status', 'Incumbent')
    ->get();


    // Secretary
    $secretary = BarangayOfficial::with('position','commitee')
        ->where('barangay_info_id', $barangayId)
        ->whereHas('position', function($q) {
            $q->where('position', 'Barangay Secretary');
        })
        ->where('term_status', 'Incumbent')
        ->first();

    // Treasurer
    $treasurer = BarangayOfficial::with('position','commitee')
        ->where('barangay_info_id', $barangayId)
        ->whereHas('position', function($q) {
            $q->where('position', 'Barangay Treasurer');
        })
      
        ->where('term_status', 'Incumbent')
        ->first();

    // SK Chairman
         $sk_chairman = BarangayOfficial::with('position','commitee')
        ->where('barangay_info_id', $barangayId)
        ->whereHas('position', function($q) {
            $q->where('position', 'SK Chairman');
        })
        ->whereHas('commitee', function($q) {
        $q->where('status', 'Active');
    })
        ->where('term_status', 'Incumbent')
        ->first();

         $barangay_administrator = BarangayOfficial::with('position','commitee')
        ->where('barangay_info_id', $barangayId)
        ->whereHas('position', function($q) {
            $q->where('position', 'Barangay Administrator');
        })
       
        ->where('term_status', 'Incumbent')
        ->first();

    $pdf = Pdf::loadView('pdf.barangay_clearance', compact(
        'barangay_clearance',
        'chairman',
        'councilors',
        'secretary',
        'treasurer',
        'sk_chairman',
        'barangay_administrator'
    ))->setPaper('a4', 'portrait');

    return $pdf->stream('barangay_clearance.pdf');
}

public function print_building_permit($id)
{
    $building_permit = BuildingPermit::with(['requestor','purok'])
        ->findOrFail($id);

    $barangayId = Auth::user()->barangay_info_id;

    // Barangay Chairman
    $chairman = BarangayOfficial::with('position','commitee')
        ->where('barangay_info_id', $barangayId)
        ->whereHas('position', function($q) {
            $q->where('position', 'Barangay Chairman');
        })
       
        ->where('term_status', 'Incumbent')
        ->first();

    // All Barangay Councilors
  $councilors = BarangayOfficial::with('position','commitee')
    ->where('barangay_info_id', $barangayId)
    ->whereHas('position', function($q) {
        $q->where('position', 'Barangay Councilor');
    })
    ->whereHas('commitee', function($q) {
        $q->where('status', 'Active');
    })
    ->where('term_status', 'Incumbent')
    ->get();


    // Secretary
    $secretary = BarangayOfficial::with('position','commitee')
        ->where('barangay_info_id', $barangayId)
        ->whereHas('position', function($q) {
            $q->where('position', 'Barangay Secretary');
        })
        ->where('term_status', 'Incumbent')
        ->first();

    // Treasurer
    $treasurer = BarangayOfficial::with('position','commitee')
        ->where('barangay_info_id', $barangayId)
        ->whereHas('position', function($q) {
            $q->where('position', 'Barangay Treasurer');
        })
      
        ->where('term_status', 'Incumbent')
        ->first();

    // SK Chairman
         $sk_chairman = BarangayOfficial::with('position','commitee')
        ->where('barangay_info_id', $barangayId)
        ->whereHas('position', function($q) {
            $q->where('position', 'SK Chairman');
        })
        ->whereHas('commitee', function($q) {
        $q->where('status', 'Active');
    })
        ->where('term_status', 'Incumbent')
        ->first();

         $barangay_administrator = BarangayOfficial::with('position','commitee')
        ->where('barangay_info_id', $barangayId)
        ->whereHas('position', function($q) {
            $q->where('position', 'Barangay Administrator');
        })
       
        ->where('term_status', 'Incumbent')
        ->first();

    $pdf = Pdf::loadView('pdf.building_permit', compact(
        'building_permit',
        'chairman',
        'councilors',
        'secretary',
        'treasurer',
        'sk_chairman',
        'barangay_administrator'
    ))->setPaper('a4', 'portrait');

    return $pdf->stream('building_permit.pdf');
}
public function print_certificate_indigency($id)
{
    $indigency_permit = CertificateIndigency::with(['requestor','purok'])
        ->findOrFail($id);

    $barangayId = Auth::user()->barangay_info_id;

    // Barangay Chairman
    $chairman = BarangayOfficial::with('position','commitee')
        ->where('barangay_info_id', $barangayId)
        ->whereHas('position', function($q) {
            $q->where('position', 'Barangay Chairman');
        })
       
        ->where('term_status', 'Incumbent')
        ->first();

    // All Barangay Councilors
  $councilors = BarangayOfficial::with('position','commitee')
    ->where('barangay_info_id', $barangayId)
    ->whereHas('position', function($q) {
        $q->where('position', 'Barangay Councilor');
    })
    ->whereHas('commitee', function($q) {
        $q->where('status', 'Active');
    })
    ->where('term_status', 'Incumbent')
    ->get();


    // Secretary
    $secretary = BarangayOfficial::with('position','commitee')
        ->where('barangay_info_id', $barangayId)
        ->whereHas('position', function($q) {
            $q->where('position', 'Barangay Secretary');
        })
        ->where('term_status', 'Incumbent')
        ->first();

    // Treasurer
    $treasurer = BarangayOfficial::with('position','commitee')
        ->where('barangay_info_id', $barangayId)
        ->whereHas('position', function($q) {
            $q->where('position', 'Barangay Treasurer');
        })
      
        ->where('term_status', 'Incumbent')
        ->first();

    // SK Chairman
         $sk_chairman = BarangayOfficial::with('position','commitee')
        ->where('barangay_info_id', $barangayId)
        ->whereHas('position', function($q) {
            $q->where('position', 'SK Chairman');
        })
        ->whereHas('commitee', function($q) {
        $q->where('status', 'Active');
    })
        ->where('term_status', 'Incumbent')
        ->first();

         $barangay_administrator = BarangayOfficial::with('position','commitee')
        ->where('barangay_info_id', $barangayId)
        ->whereHas('position', function($q) {
            $q->where('position', 'Barangay Administrator');
        })
       
        ->where('term_status', 'Incumbent')
        ->first();

    $pdf = Pdf::loadView('pdf.certificate_indigency', compact(
        'indigency_permit',
        'chairman',
        'councilors',
        'secretary',
        'treasurer',
        'sk_chairman',
        'barangay_administrator'
    ))->setPaper('a4', 'portrait');

    return $pdf->stream('certificate_indigency.pdf');
}
public function print_death_certification($id)
{
    $death_certificate = DeathCertification::with(['requestor','purok.households','deceased'])
        ->findOrFail($id);

    $barangayId = Auth::user()->barangay_info_id;

    // Barangay Chairman
    $chairman = BarangayOfficial::with('position','commitee')
        ->where('barangay_info_id', $barangayId)
        ->whereHas('position', function($q) {
            $q->where('position', 'Barangay Chairman');
        })
       
        ->where('term_status', 'Incumbent')
        ->first();

    // All Barangay Councilors
  $councilors = BarangayOfficial::with('position','commitee')
    ->where('barangay_info_id', $barangayId)
    ->whereHas('position', function($q) {
        $q->where('position', 'Barangay Councilor');
    })
    ->whereHas('commitee', function($q) {
        $q->where('status', 'Active');
    })
    ->where('term_status', 'Incumbent')
    ->get();


    // Secretary
    $secretary = BarangayOfficial::with('position','commitee')
        ->where('barangay_info_id', $barangayId)
        ->whereHas('position', function($q) {
            $q->where('position', 'Barangay Secretary');
        })
        ->where('term_status', 'Incumbent')
        ->first();

    // Treasurer
    $treasurer = BarangayOfficial::with('position','commitee')
        ->where('barangay_info_id', $barangayId)
        ->whereHas('position', function($q) {
            $q->where('position', 'Barangay Treasurer');
        })
      
        ->where('term_status', 'Incumbent')
        ->first();

    // SK Chairman
         $sk_chairman = BarangayOfficial::with('position','commitee')
        ->where('barangay_info_id', $barangayId)
        ->whereHas('position', function($q) {
            $q->where('position', 'SK Chairman');
        })
        ->whereHas('commitee', function($q) {
        $q->where('status', 'Active');
    })
        ->where('term_status', 'Incumbent')
        ->first();

         $barangay_administrator = BarangayOfficial::with('position','commitee')
        ->where('barangay_info_id', $barangayId)
        ->whereHas('position', function($q) {
            $q->where('position', 'Barangay Administrator');
        })
       
        ->where('term_status', 'Incumbent')
        ->first();

    $pdf = Pdf::loadView('pdf.death_certificate', compact(
        'death_certificate',
        'chairman',
        'councilors',
        'secretary',
        'treasurer',
        'sk_chairman',
        'barangay_administrator'
    ))->setPaper('a4', 'portrait');

    return $pdf->stream('certificate_indigency.pdf');
}
  public function manage_building_permit (){
    return view('barangay.manage_building_permit');
  }

   public function store_building_permit(Request $request)
{
    // ✅ Validation (matches Vue form)
    $request->validate([
            'name_requestor' => 'required',
            'purok' => 'required',
            'date_issued' => 'required',
            'purpose' => 'required',
            'case' => 'required',
            'requirements_building' => 'required',
            'payment_mode' => 'required',
            'amount' => 'required',
            'payment_status' => 'required',
           
            
    ]);

  

    try {

        $barangay = Auth::user()->barangay;
        $prefix = 'BP';
        $barangayCode = strtoupper(substr($barangay->barangay->barangay_name, 0, 3));
        $dateCode = now()->format('Ymd'); // e.g., 20260217

        // Get last permit for this Barangay and today
        $lastPermit = BuildingPermit::where('barangay_info_id', $barangay->id)
                        ->whereDate('created_at', now()->toDateString())
                        ->orderBy('id', 'desc')
                        ->first();

        $runningNumber = $lastPermit 
            ? str_pad((int)substr($lastPermit->building_permit_no, -4) + 1, 4, '0', STR_PAD_LEFT)
            : '0001';

        $buildingPermitNo = $prefix . $barangayCode . $dateCode . $runningNumber;

        
        BuildingPermit::create([
            'building_permit_no' => $buildingPermitNo,
            'barangay_info_id' => Auth::user()->barangay_info_id,
            'name_requestor' => $request->name_requestor,
            'purok_id' => $request->purok,
            'date_issued' => $request->date_issued,
            'purpose' => $request->purpose,
            'case' => $request->case,
            'requirements_building' => $request->requirements_building,
            'mode_of_payment' => $request->payment_mode,
            'payment_status' => $request->payment_status,
            'amount' => $request->amount,
            'date_paid' => $request->date_paid,
            'status' => 'Approved Certificate',
        ]);

       

        return response()->json([
            'success' => true,
            'message' => 'Building Permit successfully created.'
        ]);

    } catch (\Exception $e) {

  
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong.',
            'error' => $e->getMessage()
        ], 500);
    }
}
public function store_death_cert(Request $request)
{
    // ✅ Validation (matches Vue form)
    $request->validate([
            'name_requestor' => 'required',
             'name_deceased' => 'required',
            'purok' => 'required',
            'date_issued' => 'required',
            'date_of_death' => 'required',
            'place_of_death' => 'required',
            'fathers_name' => 'required',
            'mothers_name' => 'required',
            'reason' => 'required',
            'date_paid' => 'required',
            'payment_mode' => 'required',
            'amount' => 'required',
            'payment_status' => 'required',
           
            
    ]);

  

    try {

       $barangay = Auth::user()->barangay;

        // Prefix: DC + first 3 letters of barangay + YYYYMMDD
        $prefix = 'DC';
        $barangayCode = strtoupper(substr($barangay->barangay_name, 0, 3));
        $dateCode = now()->format('Ymd'); // e.g., 20260218

        // Get last application number for this barangay and today
        $lastPermit = DeathCertification::where('barangay_info_id', $barangay->id)
            ->whereDate('created_at', now()->toDateString())
            ->orderBy('id', 'desc')
            ->lockForUpdate() // prevents race conditions
            ->first();

        // Generate running number
        $runningNumber = $lastPermit
            ? str_pad((int)substr($lastPermit->application_no, -4) + 1, 4, '0', STR_PAD_LEFT)
            : '0001';

        $applicationNo = $prefix . $barangayCode . $dateCode . $runningNumber;
                
        DeathCertification::create([
            'application_no' => $applicationNo,
            'barangay_info_id' => Auth::user()->barangay_info_id,
            'name_requestor' => $request->name_requestor,
             'name_deceased' => $request->name_deceased,
            'purok_id' => $request->purok,
            'date_issued' => $request->date_issued,
            'date_of_death' => $request->date_of_death,
            'place_of_death' => $request->place_of_death,
            'fathers_name' => $request->fathers_name,
            'mothers_name' => $request->mothers_name,
            'reason' => $request->reason,
           
            'payment_mode' => $request->payment_mode,
            'payment_status' => $request->payment_status,
            'amount' => $request->amount,
            'date_paid' => $request->date_paid,
            'status' => 'Approved Certificate',
        ]);

       

        return response()->json([
            'success' => true,
            'message' => 'Death Certificate successfully created.'
        ]);

    } catch (\Exception $e) {

  
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong.',
            'error' => $e->getMessage()
        ], 500);
    }
}
public function update_death_certificate(Request $request, $id)
{
    // ✅ Validation (matches Vue form)
    $request->validate([
            'name_requestor' => 'required',
            'name_deceased' => 'required',
            'purok' => 'required',
            'date_issued' => 'required',
            'date_of_death' => 'required',
            'place_of_death' => 'required',
            'fathers_name' => 'required',
            'mothers_name' => 'required',
            'reason' => 'required',
            'date_paid' => 'required',
            'payment_mode' => 'required',
            'amount' => 'required',
            'payment_status' => 'required',
    ]);

   

    try {
        // ✅ Find the record to update
        $deathCert = DeathCertification::findOrFail($id);

        // ✅ Update fields
        $deathCert->update([
            'name_requestor' => $request->name_requestor,
            'name_deceased' => $request->name_deceased,
            'purok_id' => $request->purok,
            'date_issued' => $request->date_issued,
            'date_of_death' => $request->date_of_death,
            'place_of_death' => $request->place_of_death,
            'fathers_name' => $request->fathers_name,
            'mothers_name' => $request->mothers_name,
            'reason' => $request->reason,
          
            'payment_mode' => $request->payment_mode,
            'payment_status' => $request->payment_status,
            'amount' => $request->amount,
            'date_paid' => $request->date_paid,
        ]);

      

        return response()->json([
            'success' => true,
            'message' => 'Building Permit successfully updated.'
        ]);

    } catch (\Exception $e) {
     

        return response()->json([
            'success' => false,
            'message' => 'Something went wrong.',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function update_buildingy_permit(Request $request, $id)
{
    // ✅ Validation (matches Vue form)
    $request->validate([
           'name_requestor' => 'required',
            'purok' => 'required',
            'date_issued' => 'required',
            'purpose' => 'required',
            'case' => 'required',
            'requirements_building' => 'required',
            'payment_mode' => 'required',
            'amount' => 'required',
            'payment_status' => 'required',
    ]);

   

    try {
        // ✅ Find the record to update
        $building = BuildingPermit::findOrFail($id);

        // ✅ Update fields
        $building->update([
            'name_requestor' => $request->name_requestor,
            'purok_id' => $request->purok,
            'date_issued' => $request->date_issued,
            'purpose' => $request->purpose,
            'case' => $request->case,
            'requirements_building' => $request->requirements_building,
            'mode_of_payment' => $request->payment_mode,
            'payment_status' => $request->payment_status,
            'amount' => $request->amount,
            'date_paid' => $request->date_paid,
        ]);

      

        return response()->json([
            'success' => true,
            'message' => 'Building Permit successfully updated.'
        ]);

    } catch (\Exception $e) {
     

        return response()->json([
            'success' => false,
            'message' => 'Something went wrong.',
            'error' => $e->getMessage()
        ], 500);
    }
}
    public function getDataBuildingPermit(Request $request){
         // Get the search query and per_page from the request
           // Get the search query and per_page from the request
          $search = $request->query('search');
          $perPage = $request->query('per_page', 10); // Default to 10 if per_page is not provided
      
          // Query certifications with optional search
          $buildings = BuildingPermit::with('purok')->with('requestor')->when($search, function ($query, $search) {
                  return $query->where('building_permit_no', 'like', '%' . $search . '%')
                   ->orWhere('date_issued', 'like', '%' . $search . '%')
                    ->orWhere('purpose', 'like', '%' . $search . '%')
                  
                    ->orWhere('case', 'like', '%' . $search . '%')
                    ->orWhere('requirements_building', 'like', '%' . $search . '%')
                    ->orWhere('mode_of_payment', 'like', '%' . $search . '%')
                    ->orWhere('date_paid', 'like', '%' . $search . '%')
                    ->orWhere('amount', 'like', '%' . $search . '%')
                    ->orWhere('payment_status', 'like', '%' . $search . '%')
                    ->orWhereHas('purok', function ($q) use ($search) {
                    $q->where('purok_name', 'like', '%' . $search . '%');
                    
                })
                 ->orWhereHas('requestor', function ($q) use ($search) {
                    $q->where('first_name', 'like', '%' . $search . '%')
                     ->orWhere('middle_initial', 'like', '%' . $search . '%')
                      ->orWhere('last_name', 'like', '%' . $search . '%');
                });
                
          })
          ->where('barangay_info_id', Auth::user()->barangay_info_id)
          ->paginate($perPage);
      
          return response()->json([
              'success' => true,
              'data' => $buildings
          ]);
    }

    public function manage_certificate_indigency(){
        return view('barangay.manage_certificate_indigency');
    }
    public function store_certificate_indigency(Request $request)
{
    // ✅ Validation (matches Vue form)
    $request->validate([
            'name_requestor' => 'required',
            'purok' => 'required',
            'date_issued' => 'required',
            'purpose' => 'required',
            'payment_mode' => 'required',
            'date_paid' => 'required',
            'amount' => 'required',
            'payment_status' => 'required',
           
            
    ]);

    try {

        $barangay = Auth::user()->barangay;
        $prefix = 'APL';
        $barangayCode = strtoupper(substr($barangay->barangay->barangay_name, 0, 3));
        $dateCode = now()->format('Ymd'); // e.g., 20260217

        // Get last permit for this Barangay and today
        $lastPermit = CertificateIndigency::where('barangay_info_id', $barangay->id)
                        ->whereDate('created_at', now()->toDateString())
                        ->orderBy('id', 'desc')
                        ->first();

        $runningNumber = $lastPermit 
            ? str_pad((int)substr($lastPermit->application_no, -4) + 1, 4, '0', STR_PAD_LEFT)
            : '0001';

        $buildingPermitNo = $prefix . $barangayCode . $dateCode . $runningNumber;

        
        CertificateIndigency::create([
            'application_no' => $buildingPermitNo,
            'barangay_info_id' => Auth::user()->barangay_info_id,
            'name_requestor' => $request->name_requestor,
            'purok_id' => $request->purok,
            'date_issued' => $request->date_issued,
            'purpose' => $request->purpose,
            'payment_mode' => $request->payment_mode,
            'payment_status' => $request->payment_status,
            'amount' => $request->amount,
            'date_paid' => $request->date_paid,
            'status' => 'Approved Certificate',
        ]);

       

        return response()->json([
            'success' => true,
            'message' => 'Ceritifate of Indigency Permit successfully created.'
        ]);

    } catch (\Exception $e) {

  
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong.',
            'error' => $e->getMessage()
        ], 500);
    }
}
public function update_certificate_indigency(Request $request, $id)
{
    // ✅ Validation (matches Vue form)
    $request->validate([
           'name_requestor' => 'required',
            'purok' => 'required',
            'date_issued' => 'required',
            'purpose' => 'required',
            'payment_mode' => 'required',
            'amount' => 'required',
            'payment_status' => 'required',
    ]);

   

    try {
        // ✅ Find the record to update
        $indigency = CertificateIndigency::findOrFail($id);

        // ✅ Update fields
        $indigency->update([
            'name_requestor' => $request->name_requestor,
            'purok_id' => $request->purok,
            'date_issued' => $request->date_issued,
            'purpose' => $request->purpose,
            'payment_mode' => $request->payment_mode,
            'payment_status' => $request->payment_status,
            'amount' => $request->amount,
            'date_paid' => $request->date_paid,
        ]);

      

        return response()->json([
            'success' => true,
            'message' => 'Certificate Indigency successfully updated.'
        ]);

    } catch (\Exception $e) {
     

        return response()->json([
            'success' => false,
            'message' => 'Something went wrong.',
            'error' => $e->getMessage()
        ], 500);
    }
}
public function getDataIndigency(Request $request){
         // Get the search query and per_page from the request
           // Get the search query and per_page from the request
          $search = $request->query('search');
          $perPage = $request->query('per_page', 10); // Default to 10 if per_page is not provided
      
          // Query certifications with optional search
          $indigency = CertificateIndigency::with('purok')->with('requestor')->when($search, function ($query, $search) {
                  return $query->where('application_no', 'like', '%' . $search . '%')
                   ->orWhere('date_issued', 'like', '%' . $search . '%')
                    ->orWhere('purpose', 'like', '%' . $search . '%')
                    ->orWhere('payment_mode', 'like', '%' . $search . '%')
                    ->orWhere('date_paid', 'like', '%' . $search . '%')
                    ->orWhere('amount', 'like', '%' . $search . '%')
                    ->orWhere('payment_status', 'like', '%' . $search . '%')
                    ->orWhereHas('purok', function ($q) use ($search) {
                    $q->where('purok_name', 'like', '%' . $search . '%');
                    
                })
                 ->orWhereHas('requestor', function ($q) use ($search) {
                    $q->where('first_name', 'like', '%' . $search . '%')
                     ->orWhere('middle_initial', 'like', '%' . $search . '%')
                      ->orWhere('last_name', 'like', '%' . $search . '%');
                });
                
          })
          ->where('barangay_info_id', Auth::user()->barangay_info_id)
          ->paginate($perPage);
      
          return response()->json([
              'success' => true,
              'data' => $indigency
          ]);
    }

    public function getDataDeathCertificate(Request $request){
         // Get the search query and per_page from the request
           // Get the search query and per_page from the request
          $search = $request->query('search');
          $perPage = $request->query('per_page', 10); // Default to 10 if per_page is not provided
      
          // Query certifications with optional search
          $deathCert = DeathCertification::with('purok')->with('requestor')->with('deceased')->when($search, function ($query, $search) {
                  return $query->where('application_no', 'like', '%' . $search . '%')
                   ->orWhere('date_issued', 'like', '%' . $search . '%')
                    ->orWhere('reason', 'like', '%' . $search . '%')
                    ->orWhere('date_of_death', 'like', '%' . $search . '%')
                    ->orWhere('place_of_death', 'like', '%' . $search . '%')
                    ->orWhere('mothers_name', 'like', '%' . $search . '%')
                     ->orWhere('fathers_name', 'like', '%' . $search . '%')
                    ->orWhere('payment_mode', 'like', '%' . $search . '%')
                    ->orWhere('date_paid', 'like', '%' . $search . '%')
                    ->orWhere('amount', 'like', '%' . $search . '%')
                    ->orWhere('payment_status', 'like', '%' . $search . '%')
                    ->orWhereHas('purok', function ($q) use ($search) {
                    $q->where('purok_name', 'like', '%' . $search . '%');
                    
                })
                 ->orWhereHas('requestor', function ($q) use ($search) {
                    $q->where('first_name', 'like', '%' . $search . '%')
                     ->orWhere('middle_initial', 'like', '%' . $search . '%')
                      ->orWhere('last_name', 'like', '%' . $search . '%');
                })
                 ->orWhereHas('deceased', function ($q) use ($search) {
                    $q->where('first_name', 'like', '%' . $search . '%')
                     ->orWhere('middle_initial', 'like', '%' . $search . '%')
                      ->orWhere('last_name', 'like', '%' . $search . '%');
                });
               
                
          })
          ->where('barangay_info_id', Auth::user()->barangay_info_id)
          ->paginate($perPage);
      
          return response()->json([
              'success' => true,
              'data' => $deathCert
          ]);
    }

    public function manage_death_certificate(){
        return view('barangay.manage_death_certificate');
    }
    public function manage_residency_certificate(){
          return view('barangay.manage_residency_certificate');
    }

     public function store_residency_certificate(Request $request)
{
    // ✅ Validation (matches Vue form)
    $request->validate([
            'name_requestor' => 'required',
            'purok' => 'required',
            'date_issued' => 'required',
            'purpose' => 'required',
            'payment_mode' => 'required',
            'date_paid' => 'required',
            'amount' => 'required',
            'payment_status' => 'required',
           
            
    ]);

    try {

        $barangay = Auth::user()->barangay;
        $prefix = 'RC';
        $barangayCode = strtoupper(substr($barangay->barangay->barangay_name, 0, 3));
        $dateCode = now()->format('Ymd'); // e.g., 20260217

        // Get last permit for this Barangay and today
        $lastPermit = ResidencyCertificate::where('barangay_info_id', $barangay->id)
                        ->whereDate('created_at', now()->toDateString())
                        ->orderBy('id', 'desc')
                        ->first();

        $runningNumber = $lastPermit 
            ? str_pad((int)substr($lastPermit->application_no, -4) + 1, 4, '0', STR_PAD_LEFT)
            : '0001';

        $buildingPermitNo = $prefix . $barangayCode . $dateCode . $runningNumber;

        
        ResidencyCertificate::create([
            'application_no' => $buildingPermitNo,
            'barangay_info_id' => Auth::user()->barangay_info_id,
            'name_requestor' => $request->name_requestor,
            'purok_id' => $request->purok,
            
            'date_issued' => $request->date_issued,
            'resident_type' => $request->resident_type,
            'purpose' => $request->purpose,
            'payment_mode' => $request->payment_mode,
            'payment_status' => $request->payment_status,
            'amount' => $request->amount,
            'date_paid' => $request->date_paid,
            'status' => 'Approved Certificate',
        ]);

       

        return response()->json([
            'success' => true,
            'message' => 'Residency Certificate  successfully created.'
        ]);

    } catch (\Exception $e) {

  
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong.',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function getDataResidency(Request $request){
     // Get the search query and per_page from the request
           // Get the search query and per_page from the request
          $search = $request->query('search');
          $perPage = $request->query('per_page', 10); // Default to 10 if per_page is not provided
      
          // Query certifications with optional search
          $residency = ResidencyCertificate::with('purok')->with('requestor')->when($search, function ($query, $search) {
                  return $query->where('application_no', 'like', '%' . $search . '%')
                   ->orWhere('date_issued', 'like', '%' . $search . '%')
                    ->orWhere('resident_type', 'like', '%' . $search . '%')
                    ->orWhere('payment_mode', 'like', '%' . $search . '%')
                    ->orWhere('date_paid', 'like', '%' . $search . '%')
                    ->orWhere('amount', 'like', '%' . $search . '%')
                    ->orWhere('payment_status', 'like', '%' . $search . '%')
                    ->orWhereHas('purok', function ($q) use ($search) {
                    $q->where('purok_name', 'like', '%' . $search . '%');
                    
                })
                 ->orWhereHas('requestor', function ($q) use ($search) {
                    $q->where('first_name', 'like', '%' . $search . '%')
                     ->orWhere('middle_initial', 'like', '%' . $search . '%')
                      ->orWhere('last_name', 'like', '%' . $search . '%');
                });
                
               
                
          })
          ->where('barangay_info_id', Auth::user()->barangay_info_id)
          ->paginate($perPage);
      
          return response()->json([
              'success' => true,
              'data' => $residency
          ]);
}

public function update_residency_certificate(Request $request, $id)
{
    // ✅ Validation (matches Vue form)
    $request->validate([
           'name_requestor' => 'required',
            'purok' => 'required',
            'date_issued' => 'required',
            'purpose' => 'required',
            'payment_mode' => 'required',
            'date_paid' => 'required',
            'amount' => 'required',
            'payment_status' => 'required',
    ]);

   

    try {
        // ✅ Find the record to update
        $indigency = ResidencyCertificate::findOrFail($id);

        // ✅ Update fields
        $indigency->update([
           'name_requestor' => $request->name_requestor,
            'purok_id' => $request->purok,
            'date_issued' => $request->date_issued,
            'resident_type' => $request->resident_type,
            'purpose' => $request->purpose,
            'payment_mode' => $request->payment_mode,
            'payment_status' => $request->payment_status,
            'amount' => $request->amount,
            'date_paid' => $request->date_paid,
        ]);

      

        return response()->json([
            'success' => true,
            'message' => 'Resident Certificate  successfully updated.'
        ]);

    } catch (\Exception $e) {
     

        return response()->json([
            'success' => false,
            'message' => 'Something went wrong.',
            'error' => $e->getMessage()
        ], 500);
    }
}


public function print_residency_certificate($id){
  $residency_certificate = ResidencyCertificate::with(['requestor','purok'])
        ->findOrFail($id);

    $barangayId = Auth::user()->barangay_info_id;

    // Barangay Chairman
    $chairman = BarangayOfficial::with('position','commitee')
        ->where('barangay_info_id', $barangayId)
        ->whereHas('position', function($q) {
            $q->where('position', 'Barangay Chairman');
        })
       
        ->where('term_status', 'Incumbent')
        ->first();

    // All Barangay Councilors
  $councilors = BarangayOfficial::with('position','commitee')
    ->where('barangay_info_id', $barangayId)
    ->whereHas('position', function($q) {
        $q->where('position', 'Barangay Councilor');
    })
    ->whereHas('commitee', function($q) {
        $q->where('status', 'Active');
    })
    ->where('term_status', 'Incumbent')
    ->get();


    // Secretary
    $secretary = BarangayOfficial::with('position','commitee')
        ->where('barangay_info_id', $barangayId)
        ->whereHas('position', function($q) {
            $q->where('position', 'Barangay Secretary');
        })
        ->where('term_status', 'Incumbent')
        ->first();

    // Treasurer
    $treasurer = BarangayOfficial::with('position','commitee')
        ->where('barangay_info_id', $barangayId)
        ->whereHas('position', function($q) {
            $q->where('position', 'Barangay Treasurer');
        })
      
        ->where('term_status', 'Incumbent')
        ->first();

    // SK Chairman
         $sk_chairman = BarangayOfficial::with('position','commitee')
        ->where('barangay_info_id', $barangayId)
        ->whereHas('position', function($q) {
            $q->where('position', 'SK Chairman');
        })
        ->whereHas('commitee', function($q) {
        $q->where('status', 'Active');
    })
        ->where('term_status', 'Incumbent')
        ->first();

         $barangay_administrator = BarangayOfficial::with('position','commitee')
        ->where('barangay_info_id', $barangayId)
        ->whereHas('position', function($q) {
            $q->where('position', 'Barangay Administrator');
        })
       
        ->where('term_status', 'Incumbent')
        ->first();

    $pdf = Pdf::loadView('pdf.residency_certificate', compact(
        'residency_certificate',
        'chairman',
        'councilors',
        'secretary',
        'treasurer',
        'sk_chairman',
        'barangay_administrator'
    ))->setPaper('a4', 'portrait');

    return $pdf->stream('residency_certificate.pdf');
}

public function inhabitants(){
    return view('barangay.inhabitants');
}
public function getDataInhabitants(Request $request)
{
    $search = $request->query('search');
    $perPage = $request->query('per_page', 10);

    $inhabitants = HouseholdMember::with('household.purok')
        // General search
        ->when($search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('middle_initial', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('extension', 'like', "%$search%")
                  ->orWhere('birthdate', 'like', "%$search%")
                  ->orWhere('contact_number', 'like', "%$search%")
                
                  ->orWhereHas('household', function ($q2) use ($search) {
                      $q2->where('street', 'like', "%$search%")
                         ->orWhere('household_number', 'like', "%$search%");
                  })
                  ->orWhereHas('household.purok', function ($q3) use ($search) {
                      $q3->where('purok_name', 'like', "%$search%");
                  });
            });
        })
        // Filter: Purok
        ->when($request->purok, function ($query, $purok) {
            $query->whereHas('household.purok', function ($q) use ($purok) {
                $q->where('id', $purok);
            });
        })
        // Filter: Role (Head/Member)
        ->when($request->role, function ($query, $role) {
            if ($role === 'head') {
                $query->where('is_head', 1);
            } elseif ($role === 'member') {
                $query->where('is_head', 0);
            }
        })
        // Filter: Sex
        ->when($request->sex, function ($query, $sex) {
            $query->where('sex', $sex);
        })
        // Filter: Civil Status
        ->when($request->civil_status, function ($query, $status) {
            $query->where('civil_status', $status);
        })
        // Filter: Voter Status
        ->when($request->voter_status, function ($query, $voter) {
            $query->where('voter_status', $voter);
        })
        // Filter: Living Status (Deceased / Alive)
        ->when($request->living_status, function ($query, $living) {
            if ($living === 'alive') {
                $query->where('is_deceased', 0);
            } elseif ($living === 'deceased') {
                $query->where('is_deceased', 1);
            }
        })
        ->where('barangay_info_id', Auth::user()->barangay_info_id)
        ->orderBy('first_name', 'asc')
        ->paginate($perPage);

    return response()->json([
        'success' => true,
        'data' => $inhabitants
    ]);
}

public function barangay_history(){
    return view('barangay.barangay_history');
}




}
