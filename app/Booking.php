<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'date', 'user_id', 'service_id',
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
        if (0 == $petCount) {
            return 0;
        }
        $service = $this->service;
        $computedPrice = $service->base_price + ($petCount - 1) * $service->incremental_pet_price;

        return $computedPrice;
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFuture($query)
    {
        return $query->where('date', '>', Carbon::today('America/Vancouver'))
            ->orderBy('date');
    }

    public function scopeToday($query)
    {
        return $query->where('date', '=', Carbon::today('America/Vancouver'))
            ->orderBy('date');
    }

    public function scopeHistory($query)
    {
        return $query->where('date', '<', Carbon::today('America/Vancouver'))
            ->orderBy('date');
    }

    public function scopeIncludeCancelled($query)
    {
        return $query->withTrashed();
    }

    public function scopeCancelled($query)
    {
        return $query->withTrashed()->whereNotNull('deleted_at');
    }

    /*
     * Date Ranqe Query Scope
     *
     * Takes one or two parameters. If a single number is passed, limits the query by date to today and the number of days.
     * If a date and a number are passed, returns that many days data, starting from the date
     * If a date and a date are passed, returns the data between those two dates.
     *
     * @param  Builder $query
     * @param String|Number|Date $p1
     * @param String|Number|Date Number $p2
     * @return Builder
     *
     */
    public function scopeDateRange($query, $p1, $p2 = null)
    {
        if (is_numeric($p1)) {
            return $query->whereBetween('date', [Carbon::today('America/Vancouver'), Carbon::today('America/Vancouver')->addDays($p1)])
                ->orderBy('date');
        }

        if ($this->validator(['date_value' => $p1])->validate() && is_numeric($p2)) {
            return $query->whereBetween('date', [Carbon::parse($p1), Carbon::parse($p1)->addDays($p2)])
                ->orderBy('date');
        }

        if ($this->validator(['date_value' => $p1])->validate() && $this->validator(['date_value' => $p2])->validate()) {
            return $query->whereBetween('date', [Carbon::parse($p1), Carbon::parse($p2)])
                ->orderBy('date');
        }
    }

    protected function validator(array $data)
    {
        //$data would be an associative array like ['date_value' => '15.15.2015']
        $message = [
            'date_value.date' => 'invalid date, enduser understands the error message',
        ];

        return Validator::make($data, [
            'date_value' => 'date',
        ], $message);
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
