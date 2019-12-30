<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name', 'description', 'base_price', 'incremental_pet_price',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
