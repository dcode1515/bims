<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blotter extends Model
{
   use HasFactory;
     use SoftDeletes;
  
    protected $dates = ['deleted_at'];
     protected $table = 'blotter_case_records';
      protected $fillable = [
        'id',
        'barangay_info_id',
        'case_number',
        'case_type',
        'complainant_name',
        'complainant_contact',
        'complainant_address',
        'respondent_name',
        'respondent_address',
        'date_filed',
        'status',
        'actions_taken',
        'hearing_date',
        'hearing_time',
        'hearing_location',           
        'status',
        'created_at',
        'updated_at',
        'deleted_at',

      ];
}
