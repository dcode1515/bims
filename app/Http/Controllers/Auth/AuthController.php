<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // ✅ Add this line
use Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    //
      public function login(){
        return view('auth.login');
    }
    public function post_login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email_address' => 'required|email',
        'password' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422); // Use 422 for validation errors
    }

    if (Auth::attempt(['email' => $request->input('email_address'), 'password' => $request->input('password')])) {
        $user = Auth::user();

        if ($user->role === "Super Admin") {
            return redirect()->route('admin.dashboard');
        }
         else if ($user->role === "Admin") {
            return redirect()->route('dashboard.admin');
        }
          else if ($user->role === "Secretary") {
            return redirect()->route('barangay.dashboard.sec');
        }
         else {
            Auth::logout();
            return response()->json([
                'error' => 'Your Email address or Password is incorrect. Please try again.'
            ], 401);
        }
    }

    return response()->json([
        'error' => 'Your Email address or Password is incorrect. Please try again.'
    ], 401);
}
public function logout(Request $request)
{
    Auth::logout();
   return redirect('/');
}
   public function showProfile($id)
{
                // Optional: make sure user can only view their own profile
                if (Auth::id() != $id) {
                    abort(403, 'Unauthorized access.');
                }

                // Get user with relationships (Auth::user() already gives current user)
             
                $user = Auth::user()->load(['barangay.region','barangay.province','barangay.municipality','barangay.barangay']);

                return view('Auth.show', compact('user'));
            }
              public function update_profile(Request $request, $id)
                {
                    $validator = Validator::make($request->all(), [
                        'firstname'        => 'required|string|max:255',
                        'middle_initial'   => 'nullable|string|max:1',
                        'lastname'         => 'required|string|max:255',
                        'extension'        => 'nullable|string|max:10',
                        'contact_number'   => ['required', 'regex:/^[0-9]{11}$/'],
                        'birthdate'         => 'required',
                           'sex'         => 'required',
                        'photo'            => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                    ], [
                        'contact_number.regex' => 'The contact number must be exactly 11 digits and contain numbers only.',
                        'contact_number.required' => 'The contact number is required.',
                        'photo.image'      => 'The uploaded file must be an image.',
                        'photo.mimes'      => 'The photo must be a file of type: jpeg, png, jpg.',
                        'photo.max'        => 'The photo must not be greater than 2MB.',
                        'firstname.required' => 'The first name is required.',
                        'lastname.required'  => 'The last name is required.',
                        'birthdate.required'  => 'The Birthdate is required.',
                         'sex.required'  => 'The Sex is required.',
                    ]);

                    // Check if validation fails
                    if ($validator->fails()) {
                        return response()->json(['errors' => $validator->errors()], 422);
                    }

                    try {
                        $user = User::findOrFail($id);
                        $user->firstname = $request->input('firstname');
                        $user->middle_initial = $request->input('middle_initial');
                        $user->lastname = $request->input('lastname');
                        $user->extension = $request->input('extension');
                        $user->contact_number = $request->input('contact_number');
                        $user->birthdate = $request->input('birthdate');
                        $user->sex = $request->input('sex');
                  
                        
                        if ($request->hasFile('photo')) {
                            $file = $request->file('photo');
                            $ext = $file->extension();
                            $now = Carbon::now();
                            $name = str_replace(' ', '_', strtoupper($user->firstname . '_' . $user->middle_initial . '_' . $user->lastname));
                            $contact = $user->contact_number;
                            $fileName = $now->year . '-' . $name . '-' . $contact . '.' . $ext;

                            // Ensure the directory exists
                            $directory = public_path('user/profile/' . $user->firstname . '_' . $user->lastname);
                            if (!file_exists($directory)) {
                                mkdir($directory, 0777, true);
                            }

                            // Delete old photo if exists
                            if ($user->photo && file_exists($directory . '/' . $user->photo)) {
                                unlink($directory . '/' . $user->photo);
                            }

                            // Move the file to the desired location
                            $file->move($directory, $fileName);
                            $user->photo = $fileName;
                        }
                        
                        $user->save();

                        return response()->json([
                            'success' => true,
                            'message' => 'Profile updated successfully',
                            'user' => $user
                        ], 200);
                    } catch (\Exception $e) {
                        return response()->json([
                            'success' => false,
                            'message' => 'An error occurred while updating the profile',
                            'error' => $e->getMessage()
                        ], 500);
                    }
                }
                 public function update_user_credentials(Request $request, $id)
{
    try {
        // Validate the incoming data
        $validated = $request->validate([
            'email' => 'nullable|email|max:255|unique:users,email,'.$id,
            'password' => [
                'required',
                'min:8',
                'same:confirm_password',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
            ],
            'confirm_password' => 'required|min:8',
        ], [
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, and one number.',
            'password.same' => 'The password and confirm password must match.',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        // Update email if provided
        if ($request->has('email')) {
            $user->email = $request->email;
        }

        // Update password if provided
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        // Save the updated user
        $user->save();

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'User credentials updated successfully!',
            'data' => $user
        ], 200);

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Format validation errors for frontend
        $errors = collect($e->errors())->map(function ($messages, $field) {
            return $messages[0]; // Get the first error message for each field
        })->all();

        return response()->json([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $errors
        ], 422);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while updating the account',
            'error' => $e->getMessage()
        ], 500);
    }
}

}
