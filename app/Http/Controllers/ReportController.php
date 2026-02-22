<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HouseholdMember;

use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    //
     public function reports(Request $request)
    {
        $query = HouseholdMember::where('barangay_info_id', auth()->user()->barangay_info_id)
            ->with('household');
        
        // Apply age category filter
        if ($request->filled('age_category') && $request->age_category != 'all') {
            $today = now();
            
            switch ($request->age_category) {
                case 'infant':
                    $query->whereRaw("TIMESTAMPDIFF(YEAR, birthdate, '{$today}') BETWEEN 0 AND 1");
                    break;
                case 'toddler':
                    $query->whereRaw("TIMESTAMPDIFF(YEAR, birthdate, '{$today}') BETWEEN 1 AND 3");
                    break;
                case 'preschool':
                    $query->whereRaw("TIMESTAMPDIFF(YEAR, birthdate, '{$today}') BETWEEN 3 AND 5");
                    break;
                case 'school_age':
                    $query->whereRaw("TIMESTAMPDIFF(YEAR, birthdate, '{$today}') BETWEEN 6 AND 12");
                    break;
                case 'teenager':
                    $query->whereRaw("TIMESTAMPDIFF(YEAR, birthdate, '{$today}') BETWEEN 13 AND 19");
                    break;
                case 'adult':
                    $query->whereRaw("TIMESTAMPDIFF(YEAR, birthdate, '{$today}') BETWEEN 20 AND 59");
                    break;
                case 'senior':
                    $query->whereRaw("TIMESTAMPDIFF(YEAR, birthdate, '{$today}') >= 60");
                    break;
            }
        }
        
        // Apply age range filter
        if ($request->filled('age_from')) {
            $query->whereRaw("TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) >= ?", [$request->age_from]);
        }
        
        if ($request->filled('age_to')) {
            $query->whereRaw("TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) <= ?", [$request->age_to]);
        }
        
        // Apply gender filter
        if ($request->filled('gender') && $request->gender != 'all') {
            $query->where('sex', $request->gender);
        }
        
        // Apply civil status filter
        if ($request->filled('civil_status') && $request->civil_status != 'all') {
            $query->where('civil_status', $request->civil_status);
        }
        
        // Apply employment status filter
        if ($request->filled('employment_status') && $request->employment_status != 'all') {
            $query->where('employment_status', $request->employment_status);
        }
        
        // Apply education filter
        if ($request->filled('education') && $request->education != 'all') {
            $query->where('highest_education', $request->education);
        }
        
        // Apply 4Ps membership filter
        if ($request->filled('is_4ps') && $request->is_4ps != 'all') {
            $query->where('is_4ps_member', $request->is_4ps === 'yes');
        }
        
        // Apply PWD filter
        if ($request->filled('is_pwd') && $request->is_pwd != 'all') {
            $query->where('isPWD', $request->is_pwd === 'yes');
        }
        
        // Apply PWD type filter
        if ($request->filled('pwd_type') && $request->pwd_type != 'all') {
            $query->where('pwd_type', $request->pwd_type);
        }
        
        // Apply voter status filter
        if ($request->filled('voter_status') && $request->voter_status != 'all') {
            $query->where('voter_status', $request->voter_status);
        }
        
        // Apply household head filter
        if ($request->filled('is_head') && $request->is_head != 'all') {
            $query->where('is_head', $request->is_head === 'yes');
        }
        
        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                  ->orWhere('middle_name', 'LIKE', "%{$search}%")
                  ->orWhere('last_name', 'LIKE', "%{$search}%")
                  ->orWhere('national_id', 'LIKE', "%{$search}%")
                  ->orWhere('contact_number', 'LIKE', "%{$search}%");
            });
        }
        
        // Get statistics for filtered data
        $filteredQuery = clone $query;
        $filteredMembers = $filteredQuery->get();
        
        $statistics = [
            'total' => HouseholdMember::where('barangay_info_id', auth()->user()->barangay_info_id)->count(),
            'filtered_total' => $filteredMembers->count(),
            'male' => $filteredMembers->where('sex', 'Male')->count(),
            'female' => $filteredMembers->where('sex', 'Female')->count(),
            'pwd' => $filteredMembers->where('isPWD', true)->count(),
            'senior' => $filteredMembers->filter(function($m) { 
                return $m->age >= 60; 
            })->count(),
            '4ps' => $filteredMembers->where('is_4ps_member', true)->count(),
            'voters' => $filteredMembers->where('voter_status', 'Registered')->count(),
            'heads' => $filteredMembers->where('is_head', true)->count(),
        ];
        
        // Get unique values for filter dropdowns
        $civilStatuses = HouseholdMember::where('barangay_info_id', auth()->user()->barangay_info_id)
            ->distinct()->pluck('civil_status')->filter();
        $employmentStatuses = HouseholdMember::where('barangay_info_id', auth()->user()->barangay_info_id)
            ->distinct()->pluck('employment_status')->filter();
        $educationLevels = HouseholdMember::where('barangay_info_id', auth()->user()->barangay_info_id)
            ->distinct()->pluck('highest_education')->filter();
        $pwdTypes = HouseholdMember::where('barangay_info_id', auth()->user()->barangay_info_id)
            ->whereNotNull('pwd_type')->distinct()->pluck('pwd_type')->filter();
        
        // Get members with pagination
        $members = $query->paginate(10)->withQueryString();
        
        return view('Report.reports', compact(
            'members', 
            'statistics', 
            'civilStatuses', 
            'employmentStatuses', 
            'educationLevels',
            'pwdTypes'
        ));
    }
    
  public function exportPdf(Request $request)
    {
        $query = HouseholdMember::where('barangay_info_id', auth()->user()->barangay_info_id)
            ->with('household');
        
        // Apply age category filter if selected
        if ($request->filled('age_category') && $request->age_category != 'all') {
            $today = now();
            
            switch ($request->age_category) {
                case 'infant':
                    $query->whereRaw("TIMESTAMPDIFF(YEAR, birthdate, '{$today}') BETWEEN 0 AND 1");
                    break;
                case 'toddler':
                    $query->whereRaw("TIMESTAMPDIFF(YEAR, birthdate, '{$today}') BETWEEN 1 AND 3");
                    break;
                case 'preschool':
                    $query->whereRaw("TIMESTAMPDIFF(YEAR, birthdate, '{$today}') BETWEEN 3 AND 5");
                    break;
                case 'school_age':
                    $query->whereRaw("TIMESTAMPDIFF(YEAR, birthdate, '{$today}') BETWEEN 6 AND 12");
                    break;
                case 'teenager':
                    $query->whereRaw("TIMESTAMPDIFF(YEAR, birthdate, '{$today}') BETWEEN 13 AND 19");
                    break;
                case 'adult':
                    $query->whereRaw("TIMESTAMPDIFF(YEAR, birthdate, '{$today}') BETWEEN 20 AND 59");
                    break;
                case 'senior':
                    $query->whereRaw("TIMESTAMPDIFF(YEAR, birthdate, '{$today}') >= 60");
                    break;
            }
        }
        
        $members = $query->get();
        $barangay = auth()->user()->barangay;
        $ageCategory = $request->age_category ?? 'all';
        
        $pdf = Pdf::loadView('Report.reports-pdf', compact('members', 'barangay', 'ageCategory'));
        
        return $pdf->download('barangay-reports-' . now()->format('Y-m-d') . '.pdf');
    }


}
