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
        return $this->belongsTo('App\Client', 'user_id', 'id');
    }

    public function availableStaff()
    {
        $date = $this->date;
        $staffs = Staff::all();
        $availableStaff = $staffs->map(function ($staff) use ($date) {
            return $staff->available($date) ? $staff : null;
        });
        return $availableStaff;
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
