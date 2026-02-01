<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Region extends Model
{
    use HasFactory;
 
   
     protected $table = 'table_region';
      protected $fillable = [
        'id',
        'region_name',
        'region_description',
        'created_at',
        'updated_at',
    
      ];
       public function provinces(): HasMany
    {
        return $this->hasMany(Province::class);
    }
}
