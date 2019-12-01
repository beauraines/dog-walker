<?php

namespace App;

class Staff extends User
{
    use \Parental\HasParent;

    public function impersonate($user)
    {
        return null;
    }

    public function unavailabilities()
    {
        return $this->hasMany(Unavailability::class);
    }

    public function available($date)
    {
        if ($this->unavailabilities->where('unavailable_date', $date)->count() > 0) {
            return false;
        }
        return true;
    }
}
