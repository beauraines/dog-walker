<?php

namespace App;

class Staff extends User
{
    use \Parental\HasParent;

    public function impersonate($user)
    {
        return null;
    }
}
