<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaterQuality extends Model
{
        protected $table = 'water_qualities';

    protected $fillable = [
        'aquarium_id',
        'ph_level',
        'temperature',
        'ammonia',
        'nitrite',
        'nitrate',
        'salinity',
        'tested_at',
    ];

    protected $casts = [
        'tested_at' => 'datetime',
    ];

    public function aquarium()
    {
        return $this->belongsTo(Aquarium::class);
    }
}
