<?php

namespace App\Http\Controllers\Barangay;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barangay;
use App\Models\Municipality;
use App\Models\Province;
use App\Models\BarangayInfo;
use App\Models\Region;
use App\Models\Purok;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


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
                     ->OrWhere('status', 'like', '%' . $search . '%');
                
          })
          ->where('barangay_info_id', Auth::user()->barangay_info_id)
          ->paginate($perPage);
          return response()->json([
              'success' => true,
              'data' => $puroks
          ]);
    }
}
