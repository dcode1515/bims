<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResidencyCertificate extends Model
{
    protected $table = 'residency_certificate_tbl';
      protected $fillable = [
        'id',
        'application_no',
        'barangay_info_id',
        'name_requestor',
        'resident_type',
        'purok_id',
        'date_issued',
        'purpose',
        'payment_mode',
        'date_paid',
        'amount',
        'payment_status',
        'status',
        'created_at',
        'updated_at',
      
    
      ];
         public function purok()
    {
        return $this->belongsTo(Purok::class, 'purok_id');
    }
     public function requestor()
    {
        return $this->belongsTo(HouseholdMember::class, 'name_requestor');
    }
}
