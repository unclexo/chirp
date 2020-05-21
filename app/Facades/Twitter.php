<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Twitter extends Facade
{
    protected static function getFacadeAccessor() : string
    {
        return 'twitter';
    }
}
