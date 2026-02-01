<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Municipality extends Model
{
    use HasFactory;
  
   
     protected $table = 'table_municipality';
      protected $fillable = [
        'id',
        'province_id',
        'municipality_name',
        'created_at',
        'updated_at',
    
      ];
        public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }
    
    public function barangays(): HasMany
    {
        return $this->hasMany(Barangay::class);
    }
}
