<?php

namespace App\Http\Controllers;

use App\Services\HackernewsDataService;

class HackernewsController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new HackernewsDataService;
    }
    public function spoolmax()
    {
        return $this->service->spoolFromMaxItem();
    }

    public function spooltop()
    {
        return $this->service->spoolFromTopStories();
    }

    public function spoolnew()
    {
        return $this->service->spoolFromNewStories();
    }

    public function spoolshow()
    {
        return $this->service->spoolFromShowStories();
    }

    public function spoolask()
    {
        return $this->service->spoolFromAskStories();
    }

    public function spooljob()
    {
        return $this->service->spoolFromJobs();
    }

    public function spoolbest()
    {
        return $this->service->spoolFromBestStories();
    }
}
