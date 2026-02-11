<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseholdLivestock extends Model
{
    use HasFactory;
    protected $table = 'household_livestocks_tbl';
      protected $fillable = [
        'household_id',
        'barangay_info_id',
        'type',
        'category',
        'quantity',
        'unit',
        'details',
    ];
    protected $casts = [
        'details' => 'array',
        'quantity' => 'integer',
    ];

    public function household()
    {
        return $this->belongsTo(Household::class);
    }
}
