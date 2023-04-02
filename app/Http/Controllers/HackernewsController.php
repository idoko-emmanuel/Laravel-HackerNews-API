<?php

namespace App\Http\Controllers;

use App\Services\HackernewsDataService;

class HackernewsController extends Controller
{
    public function test(HackernewsDataService $service)
    {
        return $service->spoolFromMaxItem();
    }
}
