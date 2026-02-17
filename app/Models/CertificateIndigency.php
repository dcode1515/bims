<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateIndigency extends Model
{
   use HasFactory;
     protected $table = 'certificate_indigency_tbl';
      protected $fillable = [
        'id',
        'application_no',
        'name_requestor',
        'barangay_info_id',
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
        'deleted_at',
    
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
