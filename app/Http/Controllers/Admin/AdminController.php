<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Municipality;
use App\Models\Province;
use App\Models\Barangay;
use App\Models\BarangayInfo;
use App\Models\BarangayCommitee;
use App\Models\BarangayPosition;
use Illuminate\Support\Facades\Validator; // ✅ Add this line
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;




class AdminController extends Controller
{
    //
     public function admin(){
        return view('admin.dashboard');
    }
     public function barangay_info(){
        return view('admin.barangay_info');
    }

     public function index()
    {
        $regions = Region::orderBy('region_name')->get();
        return $regions;
        return view('address', compact('regions'));
    }

    public function getProvinces($region_id)
    {
        $provinces = Province::where('region_id', $region_id)->orderBy('province_name')->get();
        return response()->json($provinces);
    }

    public function getMunicipalities($province_id)
    {
        $municipalities = Municipality::where('province_id', $province_id)->orderBy('municipality_name')->get();
        return response()->json($municipalities);
    }

    public function getBarangays($municipality_id)
    {
        $barangays = Barangay::where('municipality_id', $municipality_id)->orderBy('barangay_name')->get();
        return response()->json($barangays);
    }

    public function store_barangay_info(Request $request)
{
    // Validate incoming request
    $validator = Validator::make($request->all(), [
        'barangay_name'    => 'required|string|max:255',
        'region'           => 'required|integer',
        'province'         => 'required|integer',
        'municipality'     => 'required|integer',
        'barangay'         => 'required|integer',
        'barangay_code'    => 'required|string|max:50',
        'zip_code'         => 'required|string|max:20',
        'contact_number'   => 'required|string|max:50',
        'email'            => 'required|email|max:255',
        'status'           => 'nullable|string|in:Active,Inactive',
        'photo'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // optional photo
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    // Check if barangay already exists
    if (BarangayInfo::where('barangay_id', $request->barangay)->exists()) {
        return response()->json([
            'success' => false,
            'message' => 'The Barangay already exists under the selected.',
        ], 409); // 409 Conflict
    }

    try {
        $barangay = new BarangayInfo();
        $barangay->barangay_name     = $request->barangay_name;
        $barangay->barangay_id       = $request->barangay;
        $barangay->region_id         = $request->region;
        $barangay->province_id       = $request->province;
        $barangay->municipality_id   = $request->municipality;
        $barangay->barangay_code     = $request->barangay_code;
        $barangay->zip_code          = $request->zip_code;
        $barangay->contact_number    = $request->contact_number;
        $barangay->email             = $request->email;
        $barangay->status            = $request->status ?? 'Active';

        // Handle photo upload if exists
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $ext = $file->extension();
            $now = \Carbon\Carbon::now();
            $name = str_replace(' ', '_', strtoupper($barangay->barangay_name));
            $contact = $barangay->contact_number;
            $fileName = $now->year . '-' . $name . '-' . $contact . '.' . $ext;

            // Ensure directory exists
            $directory = public_path('barangay/logo/' . $barangay->barangay_name);
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            // Delete old photo if exists
            if ($barangay->photo && file_exists($directory . '/' . $barangay->photo)) {
                unlink($directory . '/' . $barangay->photo);
            }

            // Move uploaded file
            $file->move($directory, $fileName);
            $barangay->photo = $fileName;
        }

        $barangay->save();

        return response()->json([
            'success' => true,
            'message' => 'Barangay Info created successfully',
            'data'    => $barangay
        ], 201);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while creating the Barangay Info',
            'error'   => $e->getMessage()
        ], 500);
    }
}

     public function update_barangay_info(Request $request,$id){
         $validator = Validator::make($request->all(), [
            'barangay_name' => 'required',
            'region' => 'required',
            'province' => 'required',
            'municipality' => 'required',
            'barangay' => 'required',
            'barangay_code' => 'required',
            'zip_code' => 'required',
            'contact_number' => 'required',
            'email' => 'required',
           
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
    
        try {
            $barangay =  BarangayInfo::find($id);
            $barangay->barangay_name = $request->barangay_name;
            $barangay->province_id = $request->province;
            $barangay->municipality_id = $request->municipality;
            $barangay->barangay_id = $request->barangay;
            $barangay->region_id = $request->region;
            $barangay->barangay_code = $request->barangay_code;
            $barangay->zip_code = $request->zip_code;
            $barangay->contact_number = $request->contact_number;
            $barangay->email = $request->email;
            $barangay->status = "Active";
             if ($request->hasFile('photo')) {
                            $file = $request->file('photo');
                            $ext = $file->extension();
                            $now = Carbon::now();
                            $name = str_replace(' ', '_', strtoupper($barangay->barangay_name));
                            $contact = $barangay->contact_number;
                            $fileName = $now->year . '-' . $name . '-' . $contact . '.' . $ext;

                            // Ensure the directory exists
                            $directory = public_path('barangay/logo/' . $barangay->barangay_name);
                            if (!file_exists($directory)) {
                                mkdir($directory, 0777, true);
                            }

                            // Delete old photo if exists
                            if ($barangay->photo && file_exists($directory . '/' . $barangay->photo)) {
                                unlink($directory . '/' . $barangay->photo);
                            }

                            // Move the file to the desired location
                            $file->move($directory, $fileName);
                            $barangay->photo = $fileName;
                        }
                        
                $barangay->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Barangay Info created successfully',
                'data' => $barangay
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the Office Head',
                'error' => $e->getMessage()
            ], 500);
        }


    }
    public function getBarangayInfo(Request $request){
          $search = $request->query('search');
          $perPage = $request->query('per_page', 10); // Default to 10 if per_page is not provided
      
          // Query certifications with optional search
          $barangay_info = BarangayInfo::with(['region','province','municipality','barangay'])->when($search, function ($query, $search) {
                  return $query
                    ->where('barangay_name', 'like', '%' . $search . '%')
                    ->OrWhere('email', 'like', '%' . $search . '%')
                    ->OrWhere('contact_number', 'like', '%' . $search . '%')

                  ->orWhereHas('region', function ($q) use ($search) {
                    $q->where('region_name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('province', function ($q) use ($search) {
                    $q->where('province_name', 'like', '%' . $search . '%');
                })
                 ->orWhereHas('municipality', function ($q) use ($search) {
                    $q->where('municipality_name', 'like', '%' . $search . '%');
                })
                  ->orWhereHas('barangay', function ($q) use ($search) {
                    $q->where('barangay_name', 'like', '%' . $search . '%');
                });
          })
          ->paginate($perPage);
      
          return response()->json([
              'success' => true,
              'data' => $barangay_info
          ]);
    }

   
    

     

   

  


   
    

    public function user_management(){
        return view('admin.user_management');
    }
     public function getDataBarangay()
    {
        $barangays = BarangayInfo::orderBy('barangay_name', 'asc')->get();
        return response()->json($barangays);
        
    }
    public function store_barangay_user(Request $request){
  
            $validator = Validator::make($request->all(), [

                'firstname' => ['required', 'string', 'max:100'],
                'lastname'  => ['required', 'string', 'max:100'],

                'sex' => ['required', 'in:Male,Female'],

                'birthdate' => ['required', 'date', 'before:today'],

                'contact_number' => [
                    'required',
                    'string',
                    'max:20',
                    'regex:/^(09|\+639)\d{9}$/'
                ],

                'barangay' => ['required'],

                'role' => ['required'],

                'email' => [
                    'required',
                    'email:rfc,dns',
                    'max:255',
                    'unique:users,email'
                ],

                // PASSWORD + CONFIRM PASSWORD
                  'password'  => 'required|string|min:8|confirmed',

              

            ], [
                // CUSTOM ERROR MESSAGES
                'sex.in' => 'Sex must be Male or Female.',
                'birthdate.before' => 'Birthdate must be a valid past date.',
                'contact_number.regex' => 'Contact number must be a valid Philippine mobile number.',
               
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

      
    
        try {
            $user = new User;
            $user->firstname = $request->firstname;
            $user->middle_initial = $request->middle_initial;
            $user->lastname = $request->lastname;
            $user->extension = $request->extension;   
            $user->barangay_info_id = $request->barangay;
            $user->email = $request->email;
            $user->sex = $request->sex;
            $user->contact_number = $request->contact_number;
            $user->birthdate = $request->birthdate;
            $user->role = $request->role;
            $user->password = Hash::make($request->password);
            $user->save();
    
            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the user',
                'error' => $e->getMessage()
            ], 500);
        }


    }
     public function update_barangay_user(Request $request, $id){
  
           $validator = Validator::make($request->all(), [

            'firstname' => ['required', 'string', 'max:100'],
            'lastname'  => ['required', 'string', 'max:100'],

            'sex' => ['required', 'in:Male,Female'],
            'birthdate' => ['required', 'date', 'before:today'],

            'contact_number' => [
                'required',
                'string',
                'max:20',
                'regex:/^(09|\+639)\d{9}$/'
            ],

            'barangay' => ['required'],
            'role' => ['required'],

            // ✅ EMAIL — ignore current user
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255',
                Rule::unique('users', 'email')->ignore($id)
            ],

            // ✅ PASSWORD — optional on update
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],

        ], [
            'sex.in' => 'Sex must be Male or Female.',
            'birthdate.before' => 'Birthdate must be a valid past date.',
            'contact_number.regex' => 'Contact number must be a valid Philippine mobile number.',
        ]);


      
    
        try {
            $user =  User::find($id);
            $user->firstname = $request->firstname;
            $user->middle_initial = $request->middle_initial;
            $user->lastname = $request->lastname;
            $user->extension = $request->extension;   
            $user->barangay_info_id = $request->barangay;
            $user->email = $request->email;
            $user->sex = $request->sex;
            $user->contact_number = $request->contact_number;
            $user->birthdate = $request->birthdate;
            $user->role = $request->role;
              $user->status = $request->status;
         if ($request->filled('password')) {
    $user->password = Hash::make($request->password);
}
            $user->save();
    
            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'data' => $user
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the user',
                'error' => $e->getMessage()
            ], 500);
        }


    }

    public function getDataUserActive(Request $request){
            // Get the search query and per_page from the request
          $search = $request->query('search');
          $perPage = $request->query('per_page', 10); // Default to 10 if per_page is not provided
      
          // Query certifications with optional search
          $users = User::with('barangay')->when($search, function ($query, $search) {
          
                  
          return $query
                    ->where('firstname', 'like', '%' . $search . '%')
                    ->OrWhere('middle_initial', 'like', '%' . $search . '%')
                    ->OrWhere('lastname', 'like', '%' . $search . '%')
                    ->OrWhere('extension', 'like', '%' . $search . '%')
                    ->OrWhere('email', 'like', '%' . $search . '%')
                    ->OrWhere('sex', 'like', '%' . $search . '%')
                    ->OrWhere('contact_number', 'like', '%' . $search . '%')
                    ->OrWhere('birthdate', 'like', '%' . $search . '%')
                    ->OrWhere('role', 'like', '%' . $search . '%')
                      ->OrWhere('status', 'like', '%' . $search . '%')
                  ->orWhereHas('barangay', function ($q) use ($search) {
                    $q->where('barangay_name', 'like', '%' . $search . '%');
                });
          })
        ->where('role', '!=', 'Super Admin') // Exclude Admin users
          ->paginate($perPage);
      
          return response()->json([
              'success' => true,
              'data' => $users
          ]);
    }


    public function purok(){
        return view('barangay.purok');
    }


}
