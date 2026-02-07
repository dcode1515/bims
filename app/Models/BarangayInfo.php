<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class BarangayInfo extends Model
{
    use HasFactory;
  
    protected $dates = ['deleted_at'];
     protected $table = 'barangay_info_tbl';
      protected $fillable = [
        'id',
        'barangay_name',
        'province_id',
        'municipality_id',
        'barangay_id',
        'region_id',
        'barangay_code',
        'zip_code',
        'contact_number',
        'email',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',

      ];
       public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
     public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }
     public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'municipality_id');
    }
    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id');
    }

}
