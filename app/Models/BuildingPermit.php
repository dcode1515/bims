<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingPermit extends Model
{
    use HasFactory;
     protected $table = 'building_permit_tbl';
      protected $fillable = [
        'id',
        'barangay_info_id',
        'purok_id',
        'name_requestor',
        'building_permit_no',
        'date_issued',
        'purpose',
        'case',
        'purpose',
        'requirements_building',
        'mode_of_payment',
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
