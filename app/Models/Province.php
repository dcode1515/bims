<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Province extends Model
{
   use HasFactory;
   

     protected $table = 'table_province';
      protected $fillable = [
        'id',
        'region_id',
        'province_name',
        'created_at',
        'updated_at',
    
      ];
       public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
      public function municipalities(): HasMany
    {
        return $this->hasMany(Municipality::class);
    }

}
