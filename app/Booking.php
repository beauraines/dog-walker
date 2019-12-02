<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'date', 'user_id', 'service_id'
    ];

    public function client()
    {
        return $this->belongsTo('App\Client', 'user_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function availableStaff()
    {
        $date = $this->date;
        $staffs = Staff::all();
        $availableStaff = $staffs->map(function ($staff) use ($date) {
            return $staff->available($date) ? $staff->fresh() : null;
        });
        return $availableStaff;
    }

    public function computedPrice()
    {
        $petCount = $this->client->pets->count();
        $service = $this->service;
        $computedPrice = $service->base_price + ($petCount - 1) * $service->incremental_pet_price;
        return $computedPrice;
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
