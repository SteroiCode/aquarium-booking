<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoralPlant extends Model
{
        protected $table = 'coral_plants';

    protected $fillable = [
        'name',
        'type',
        'description',
        'light_requirement',
        'water_flow',
        'compatibility',
        'image',
    ];
}
