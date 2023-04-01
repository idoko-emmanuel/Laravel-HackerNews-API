<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HackernewsDataService;

class HackernewsController extends Controller
{
    public function test(HackernewsDataService $service)
    {
        $service->spoolFromMaxItem();
    }
}
