<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Municipality;
use App\Models\Province;
use App\Models\Barangay;
use App\Models\BarangayInfo;
use Illuminate\Support\Facades\Validator; // ✅ Add this line
use Carbon\Carbon;



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

    public function store_barangay_info(Request $request){
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
        if (BarangayInfo::where('barangay', $request->barangay)
      
        ->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'The Barangay already exists under the selected.',
            ], 409); // 409 Conflict status code
            }
    
        try {
            $barangay = new BarangayInfo;
            $barangay->barangay_name = $request->barangay_name;
            $barangay->province = $request->province;
            $barangay->municipality = $request->municipality;
            $barangay->barangay = $request->barangay;
            $barangay->region = $request->region;
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
            $barangay->province = $request->province;
            $barangay->municipality = $request->municipality;
            $barangay->barangay = $request->barangay;
            $barangay->region = $request->region;
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
    
}
