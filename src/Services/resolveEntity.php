<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Session\Session;

class resolveEntity
{
    public function __construct()
    {
    }

    public function return_row($result)
    {
        foreach($result as $row)
        {
            return $row;
        }
    }
}
