<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangayOfficial extends Model
{
    use HasFactory;
      protected $table = 'barangay_official_tbl';
       protected $fillable = [
        'id',
        'position_id',
        'barangay_info_id',
        'committee_id',
        'first_name',
        'middle_initial',
        'last_name',
        'photo',
        'extension',
        'term_start',
        'term_end',
        'term_status',
        'contact_number',
        'email',
        'address',
        'status',
        'created_at',
        'updated_at',
   

      ];

      public function barangay()
    {

        return $this->belongsTo(BarangayInfo::class, 'barangay_info_id');
    }
    public function position()
    {

        return $this->belongsTo(BarangayPosition::class, 'position_id');
    }
    
     public function commitee()
    {

        return $this->belongsTo(BarangayCommitee::class, 'committee_id');
    }

}
