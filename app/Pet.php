<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = [
        'name', 'pet_type_id', 'special_instructions', 'user_id',
    ];

    public function petType()
    {
        return $this->belongsTo(PetType::class);
    }

    public function owner()
    {
        return $this->belongsTo(\App\Client::class, 'user_id', 'id');
    }
}
