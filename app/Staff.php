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
}
