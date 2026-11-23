<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
        protected $fillable = [
        'user_id',
        'aquarium_id',
        'customer_name',
        'customer_email',
        'visit_date',
        'tickets',
        'total_price',
        'status',
        'payment_method',
        'payment_status',
        'transaction_id',
        'paid_at',
        'payment_proof'
    ];

    public function aquarium()
    {
        return $this->belongsTo(Aquarium::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
