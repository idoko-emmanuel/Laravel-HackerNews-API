<?php 
namespace App\Services;

use App\Services\Traits\DataService;
use App\Services\Abstracts\DataServiceAbstract;

class HackernewsDataService extends DataServiceAbstract
{
    use DataService;
    
    const LIMIT = 100;
    private $url, $successfulSpool;

    public function __construct()
    {
        $this->url = config('hackernews.url');
        $this->successfulSpool = 0;
    }

    public function spoolFromMaxItem():mixed
    {
        $maxItemId = json_decode(file_get_contents($this->url.'maxitem.json?print=pretty'));

        for ($itemId = $maxItemId; $itemId > 0; $itemId--) {
            $this->CreateStory($itemId);

            if($this->successfulSpool === self::LIMIT)
                return true;
        }
    }

    public function spoolFromTopStories():mixed
    {
        $topStoryIds = json_decode(file_get_contents($this->url.'topstories.json'));

        foreach ($topStoryIds as $storyId) {
            $this->CreateStory($storyId);

            if($this->successfulSpool === self::LIMIT)
                return true;
        }
    }

    public function spoolFromNewStories():mixed
    {
        $stories = json_decode(file_get_contents($this->url.'newstories.json'));

        foreach ($stories as $storyId) {
            $this->CreateStory($storyId);

            if($this->successfulSpool === self::LIMIT)
                return true;
        }
    }

    public function spoolFromShowStories():mixed
    {
        $stories = json_decode(file_get_contents($this->url.'showstories.json'));

        foreach ($stories as $storyId) {
            $this->CreateStory($storyId, 'show');

            if($this->successfulSpool === self::LIMIT)
                return true;
        }
    }

    public function spoolFromAskStories():mixed
    {
        $stories = json_decode(file_get_contents($this->url.'askstories.json'));

        foreach ($stories as $storyId) {
            $this->CreateStory($storyId, 'ask');

            if($this->successfulSpool === self::LIMIT)
                return true;
        }
    }

    public function spoolFromJobs():mixed
    {
        $stories = json_decode(file_get_contents($this->url.'jobstories.json'));

        foreach ($stories as $storyId) {
            $this->CreateStory($storyId, 'job');

            if($this->successfulSpool === self::LIMIT)
                return true;
        }
    }

    public function spoolFromBestStories():mixed
    {
        $stories = json_decode(file_get_contents($this->url.'beststories.json'));

        foreach ($stories as $storyId) {
            $this->CreateStory($storyId, 'best');

            if($this->successfulSpool === self::LIMIT)
                return true;
        }

    }

}