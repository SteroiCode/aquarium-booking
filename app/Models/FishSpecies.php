<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FishSpecies extends Model
{
        protected $fillable = [
        'name',
        'scientific_name',
        'description',
        'tank_size',
        'temperature',
        'ph_level',
        'image',
    ];
}
