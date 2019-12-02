<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name', 'description', 'base_price', 'incremental_pet_price',
    ];

    public function booking()
    {
        $this->hasMany('\App\Booking::class');
    }
}
