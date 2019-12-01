<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unavailability extends Model
{
    protected $fillable = [
        'unavailable_date',
        'user_id',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'user_id', 'id');
    }
}
