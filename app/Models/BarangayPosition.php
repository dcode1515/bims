<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class BarangayPosition extends Model
{
    use HasFactory;
      use SoftDeletes;
     protected $dates = ['deleted_at'];
     protected $table = 'barangay_position_tbl';
      protected $fillable = [
        'id',
        'barangay_info_id',
        'position',
        'status',
        'created_at',
        'updated_at',
      
      

      ];
}
