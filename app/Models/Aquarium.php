<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aquarium extends Model
{
    protected $table = 'aquariums';

    protected $fillable = [
        'name',
        'location',
        'description',
        'price',
        'image'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}