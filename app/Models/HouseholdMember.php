<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseholdMember extends Model
{
    use HasFactory;
     protected $table = 'household_members_tbl';
     protected $fillable = [
        'id',
        'household_id',
        'barangay_info_id',
        'is_head',
        'first_name',
        'middle_initial',
        'last_name',
        'extension',
        'sex',
        'birthdate',
        'civil_status',
        'relationship',
        'national_id',
        'voter_status',
        'is_4ps_member',
        'is_deceased',
        'highest_education',
        'educational_status',
        'employment_status',
        'occupation',
        'nature_of_employment',
        'monthly_income',
        'contact_number',
        'email',
    ];
     protected $casts = [
        'birthdate' => 'date',
        'monthly_income' => 'decimal:2',
        'is_head' => 'boolean',
    ];
     public function household()
    {
        return $this->belongsTo(Household::class);
    }
     public function getFullNameAttribute()
    {
        $name = $this->first_name;
        if ($this->middle_initial) {
            $name .= ' ' . $this->middle_initial;
        }
        $name .= ' ' . $this->last_name;
        if ($this->extension) {
            $name .= ' ' . $this->extension;
        }
        return $name;
    }
     public function getAgeAttribute()
    {
        return $this->birthdate->age;
    }
}
