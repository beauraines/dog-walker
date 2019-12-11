<?php

namespace App;

use Carbon\Carbon;
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
        if ($petCount == 0) {
            return 0;
        }
        $service = $this->service;
        $computedPrice = $service->base_price + ($petCount - 1) * $service->incremental_pet_price;
        return $computedPrice;
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFuture($query)
    {
        return $query->where('date', '>', Carbon::today('America/Vancouver'));
    }

    public function scopeToday($query)
    {
        return $query->where('date', '=', Carbon::today('America/Vancouver'));
    }

    public function scopeHistory($query)
    {
        return $query->where('date', '<', Carbon::today('America/Vancouver'));
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
