<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
     use HasFactory;
    
     protected $table = 'table_barangay';
      protected $fillable = [
        'id',
        'municipality_id',
        'barangay_name',
        'created_at',
        'updated_at',
    
      ];
        public function municipality(): BelongsTo
    {
        return $this->belongsTo(Municipality::class);
    }
}
