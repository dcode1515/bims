<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseholdCrop extends Model
{
    use HasFactory;
       protected $table = 'household_crops_tbl';
      protected $fillable = [
        'household_id',
        'name',
        'type',
        'quantity',
        'unit',
    ];
    protected $casts = [
        'quantity' => 'decimal:2',
    ];
     public function household()
    {
        return $this->belongsTo(Household::class);
    }
}
