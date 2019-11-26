<?php

namespace App;

class Client extends User
{
    use \Parental\HasParent;

    public function pets()
    {
        return $this->hasMany(\App\Pet::class);
    }
}
