<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'date', 'user_id',
    ];

    public function client()
    {
        return $this->belongsTo('App\Client', 'id', 'user_id');
    }

    // /**
    //  * The attributes that should be cast to native types.
    //  *
    //  * @var array
    //  */
    // protected $casts = [
    //     'date' => 'date',
    // ];
}
