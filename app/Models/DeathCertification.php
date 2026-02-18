<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeathCertification extends Model
{
    use HasFactory;
    protected $table = 'death_cert_tbl';
      protected $fillable = [
        'id',
        'application_no',
        'barangay_info_id',
        'purok_id',
        'name_requestor',
        'name_deceased',
        'date_issued',
        'date_of_death',
        'place_of_death',
        'fathers_name',
        'mothers_name',
        'reason',
        'date_paid',
        'payment_mode',
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
     public function deceased()
    {
        return $this->belongsTo(HouseholdMember::class, 'name_deceased');
    }
}
