<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PetType extends Model
{
    protected $fillable = [
        'pet_type',
    ];

    public function pets()
    {
        return $this->hasMany(\App\Pet::class);
    }
}
