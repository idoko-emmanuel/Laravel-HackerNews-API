<?php 
namespace App\Services;

use App\Services\Traits\DataService;
use App\Services\Abstracts\DataServiceAbstract;

class HackernewsDataService extends DataServiceAbstract
{
    use DataService;
    
    const LIMIT = 100;
    private $url, $successfulSpool, $message;//, $limit;

    public function __construct()
    {
        $this->url = config('hackernews.url');
        $this->successfulSpool = 0;
        $this->message = ": stories spooled successfully";
        //$this->limit = config('hackernews.limit');
    }

    /***
     * Spool from maximum item and iterate backwards to create create each story/poll/job.
     *
     * @return mixed
     */

    public function spoolFromMaxItem():mixed
    {
        //get maximum item ID
        $maxItemId = json_decode(file_get_contents($this->url.'maxitem.json?print=pretty'));

        //iterate backwards from maximum item and create story
        for ($itemId = $maxItemId; $itemId > 0; $itemId--) {
            $this->CreateStory($itemId);

            //return response once limit is reached
            if($this->successfulSpool === self::LIMIT)
                return  $this->successfulSpool.''.$this->message;
        }
        //if maximum limit is less than 100, return response of successful spool
        return  $this->successfulSpool.''.$this->message;
    }

    /***
     * Spool from top stories, loop through to create create each story/poll/job.
     *
     * @return mixed
     */
    public function spoolFromTopStories():mixed
    {
        //fetch top stories
        $topStoryIds = json_decode(file_get_contents($this->url.'topstories.json'));

        //loop through stories to create each story
        foreach ($topStoryIds as $storyId) {
            $this->CreateStory($storyId, 'top');

             //return response once limit is reached
            if($this->successfulSpool === self::LIMIT)
                return  $this->successfulSpool.''.$this->message;
        }
        //if maximum limit is less than 100, return response of successful spool
        return  $this->successfulSpool.''.$this->message;
    }

    /***
     * Spool from new stories, loop through to create create each story/poll/job.
     *
     * @return mixed
     */

    public function spoolFromNewStories():mixed
    {
        //fetch new stories
        $stories = json_decode(file_get_contents($this->url.'newstories.json'));

        //loop through stories to create each story
        foreach ($stories as $storyId) {
            $this->CreateStory($storyId, 'new');

            //return response once limit is reached
            if($this->successfulSpool === self::LIMIT)
                return  $this->successfulSpool.''.$this->message;
        }
         //if maximum limit is less than 100, return response of successful spool
        return  $this->successfulSpool.''.$this->message;
    }

    /***
     * Spool from show stories, loop through to create create each story/poll/job.
     *
     * @return mixed
     */

    public function spoolFromShowStories():mixed
    {
        //fetch show stories
        $stories = json_decode(file_get_contents($this->url.'showstories.json'));

         //loop through stories to create each story
        foreach ($stories as $storyId) {
            $this->CreateStory($storyId, 'show');

            //return response once limit is reached
            if($this->successfulSpool === self::LIMIT)
                return  $this->successfulSpool.''.$this->message;
        }
        //if maximum limit is less than 100, return response of successful spool
        return  $this->successfulSpool.''.$this->message;
    }

    /***
     * Spool from ask stories, loop through to create create each story/poll/job.
     *
     * @return mixed
     */

    public function spoolFromAskStories():mixed
    {
        //fetch ask stories
        $stories = json_decode(file_get_contents($this->url.'askstories.json'));

        //loop through stories to create each story
        foreach ($stories as $storyId) {
            $this->CreateStory($storyId, 'ask');

            //return response once limit is reached
            if($this->successfulSpool === self::LIMIT)
                return  $this->successfulSpool.''.$this->message;
        }
        //if maximum limit is less than 100, return response of successful spool
        return  $this->successfulSpool.''.$this->message;
    }

    /***
     * Spool from new jobs, loop through to create create each job.
     *
     * @return mixed
     */

    public function spoolFromJobs():mixed
    {
        //fetch jobs
        $jobs = json_decode(file_get_contents($this->url.'jobstories.json'));

        //loop through jobs to create each story
        foreach ($jobs as $jobId) {
            $this->CreateStory($jobId, 'job');

            //return response once limit is reached
            if($this->successfulSpool === self::LIMIT)
                return  $this->successfulSpool.''.$this->message;
        }
        //if maximum limit is less than 100, return response of successful spool
        return  $this->successfulSpool.''.$this->message;
    }

    /***
     * Spool from best stories, loop through to create create each story/poll/job.
     *
     * @return mixed
     */

    public function spoolFromBestStories():mixed
    {
        //fetch best stories
        $stories = json_decode(file_get_contents($this->url.'beststories.json'));

        //loop through stories to create each story
        foreach ($stories as $storyId) {
            $this->CreateStory($storyId, 'best');

            //return response once limit is reached
            if($this->successfulSpool === self::LIMIT)
                return  $this->successfulSpool.''.$this->message;
        }
        //if maximum limit is less than 100, return response of successful spool
        return  $this->successfulSpool.''.$this->message;

    }

}