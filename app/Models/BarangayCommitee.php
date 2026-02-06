<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BarangayCommitee extends Model
{
    use HasFactory;
     use SoftDeletes;
     protected $dates = ['deleted_at'];
     protected $table = 'barangay_commitee_tbl';
      protected $fillable = [
        'id',
        'barangay_info_id',
        'commitee',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
      

      ];
}
