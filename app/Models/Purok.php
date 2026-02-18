<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purok extends Model
{
    use HasFactory;
     use SoftDeletes;
     protected $dates = ['deleted_at'];
     protected $table = 'purok_tbl';
      protected $fillable = [
        'id',
        'barangay_info_id',
        'purok_name',
        'purok_incharge',
        'contact_number',
        'term_start_date',
        'term_end_date',
        'status_term',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
      

      ];
      public function households()
    {
        return $this->hasMany(Household::class, 'purok');
    }

}
