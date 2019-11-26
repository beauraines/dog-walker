<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = [
        'name', 'pet_type_id', 'special_instructions'
    ];

    public function petType()
    {
        return $this->belongsTo(PetType::class);
    }
}
