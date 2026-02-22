<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Household extends Model
{
   use HasFactory, SoftDeletes;
     protected $table = 'households_tbl';
    protected $fillable = [
        'barangay_info_id',
        'reference_id',
        'encoded_id',
        'status',
        'purok',
        'street',
        'household_number',
        'barangay',
        'municipality',
        'longitude',
        'latitude',
        'household_type',
        'housing_type',
        'housing_type_other',
        'house_materials',
        'house_materials_other',
        'water_source',
        'water_source_icws',
        'water_source_other',
        'power_supply',
        'power_supply_other',
        'waste_biodegradable',
        'waste_plastics',
        'waste_others',
        'internet_provider',
        'internet_provider_other',
        'garbage_disposal',
        'garbage_disposal_other',
        'fishing_vessel',
        'avg_fish_catch',
        'fishing_frequency',
    ];
      protected $casts = [
        'waste_biodegradable' => 'boolean',
        'waste_plastics' => 'boolean',
        'avg_fish_catch' => 'decimal:2',
    ];

    public function members()
    {
        return $this->hasMany(HouseholdMember::class);
    }
    
    public function crops()
    {
        return $this->hasMany(HouseholdCrop::class);
    }
    
    public function livestock()
    {
        return $this->hasMany(HouseholdLivestock::class);
    }

    public function headOfFamily()
    {
        return $this->hasOne(HouseholdMember::class)->where('is_head', true);
    }

    public function familyMembers()
    {
        return $this->hasMany(HouseholdMember::class)->where('is_head', false);
    }
        public function purok()
    {

        return $this->belongsTo(Purok::class, 'purok');
    }
     protected static function boot()
    {
        parent::boot();

        static::creating(function ($household) {
            $household->reference_id = 'HH-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
        });
    }



}
