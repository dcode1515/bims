<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangayClearance extends Model
{
     protected $table = 'barangay_clearance_tbl';
      protected $fillable = [
        'id',
        'application_no',
        'barangay_info_id',
        'name_requestor',
        'birthdate',
        'native',
        'purok',
        'character_status',
        'purpose',
        'other_purpose',
        'date_issued',
        'payment_mode',
        'date_paid',
        'amount',
        'payment_status',
        'status',
        'created_at',
        'updated_at',
         'deleted_at',
    
      ];
     public function purok()
    {
        return $this->belongsTo(Purok::class, 'purok');
    }
     public function requestor()
    {
        return $this->belongsTo(HouseholdMember::class, 'name_requestor');
    }
      protected $casts = [
            'character_status' => 'array',
            'birthdate' => 'date',
            'date_issued' => 'date',
        ];

}
