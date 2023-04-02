<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Services\Facades\HackernewsData;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class FetchHackernewsData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct() 
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        match (config('hackernews.spooltype')) {
            'max' => HackernewsData::spoolFromMaxItem(),
            'top' => HackernewsData::spoolFromTopStories(),
            'new' => HackernewsData::spoolFromNewStories(),
            'show' => HackernewsData::spoolFromShowStories(),
            'ask' => HackernewsData::spoolFromAskStories(),
            'job' => HackernewsData::spoolFromJobs(),
            'best' => HackernewsData::spoolFromBestStories(),
        }; 
    }
}
