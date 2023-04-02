<?php

namespace App\Services\Facades;

use Illuminate\Support\Facades\Facade;

 class HackernewsData extends Facade 
{
    protected static function getFacadeAccessor()
    {
        return 'hackernews';
    }
}