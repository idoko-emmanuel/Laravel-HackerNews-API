<?php 
namespace App\Services;

use CreateNewComment;
use App\Actions\CreateNewStory;
use App\Actions\CreateNewAuthor;
use Illuminate\Support\Facades\Http;

class HackernewsDataService 
{
    const LIMIT = 100;
    private $url, $successfulSpool;

    public function __construct()
    {
        $this->url = config('hackernews.url');
        $this->successfulSpool = 0;
    }

    protected function CreateComment($post_id) : bool
    {
        $comment_response = new CreateNewComment;
        $response = json_decode(file_get_contents($this->url."item/{$post_id}.json"));

        if (!is_null($response)) {
            $comment_ids = $response->kids;
            
            // save comments
            foreach ($comment_ids as $comment_id) {
                $comment_response = json_decode(file_get_contents($this->url."item/{$comment_id}.json"));
                if (!is_null($comment_response)) {
                    $comment_response = (array) $comment_response;
                    $createcomment->create($comment_response);
                }
            }

            return true;

        } else {
            return false;
        }
    }

    protected function CreateAuthor($authorid)
    {
        $createauthor = new CreateNewAuthor;
        // Make a request to the Hacker News API
        $response = json_decode(file_get_contents($this->url."user/{$authorid}.json"));
        if (!is_null($response)) {
            $response = (array) $response;
            $createauthor->create($response);
            return true;
        }

        return false;
    }

    public function spoolFromMaxItem(CreateNewStory $createstory)
    {
        $maxItemId = json_decode(file_get_contents($this->url.'maxitem.json?print=pretty'));

        for ($itemId = $maxItemId; $itemId > 0; $itemId--) {
            $itemDetails = json_decode(file_get_contents($this->url."item/{$itemId}.json?print=pretty"));

            if (!is_null($itemDetails)) {
                switch ($itemDetails->type) {
                    case 'story':
                        //save author
                        if(isset($itemDetails->by)) {
                            $this->CreateAuthor($itemDetails->by);

                            //save story if it doesn't
                            $itemDetails = (array) $itemDetails;
                            $itemDetails = array_merge($itemDetails, [
                                'category' => 'new',
                            ]);

                            $createstory = $createstory->create($itemDetails);

                            //save comments 
                            //$this->CreateComment($itemDetails->id);
                            if($createstory)
                                $this->successfulSpool++;
                        }
                        
                        break;

                    case 'poll':
                        //save poll if not already saved
                        //save author if not already saved
                        //save poll options if not already saved
                        //save comments if not already saved
                        dd($itemDetails);
                        break;

                    case 'job':
                        //save job if not already saved
                        //save author if not already saved
                        dd($itemDetails);
                        break;
                    
                    default:
                        # code...
                        break;
                }
                // Process the item details and save them to your database or do whatever you need to do with them.
                // For example, you can create a new Story or Comment model and fill its attributes with the item details.

               
            }else {
                return false;
            }

            if($this->successfulSpool === self::LIMIT)
                return true;
        }
    }

    public function spoolFromTopStories(Type $var = null)
    {
        $response = Http::get($this->url.'topstories.json');
        $topStoryIds = $response->json();

        $topStories = [];
        foreach ($topStoryIds as $storyId) {
            $response = Http::get($this->url."item/$storyId.json");
            $story = $response->json();
            if ($story && isset($story['title'], $story['url'])) {
                $topStories[] = [
                    'title' => $story['title'],
                    'url' => $story['url'],
                ];
            }
        }
    }

    public function spoolFromNewStories(Type $var = null)
    {
        $url = $this->url.'newstories.json';
        $response = file_get_contents($url);
        $stories = json_decode($response);

        foreach ($stories as $storyId) {
            $url = $this->url."item/$storyId.json";
            $response = file_get_contents($url);
            $story = json_decode($response);

            // echo "<h2>{$story->title}</h2>";
            // echo "<p>by {$story->by} | {$story->time}</p>";
            // echo "<p>{$story->score} points</p>";
            // echo "<a href='{$story->url}'>{$story->url}</a>";
        }
    }

    public function spoolFromShowStories(Type $var = null)
    {
        // Fetch Show HN stories
        $response = Http::get($this->url.'showstories.json');
        $showHnIds = $response->json();

        // Get the latest 10 Show HN stories
        $showHnStories = [];
        foreach (array_slice($showHnIds, 0, 10) as $storyId) {
            $response = Http::get($this->url."item/{$storyId}.json");
            $story = $response->json();
            if (isset($story['title'], $story['url'])) {
                $showHnStories[] = [
                    'title' => $story['title'],
                    'url' => $story['url'],
                ];
            }
        }

        // Print the latest Show HN stories
        foreach ($showHnStories as $story) {
            echo "<a href=\"{$story['url']}\">{$story['title']}</a><br>\n";
        }
    }

    public function spoolFromAskStories(Type $var = null)
    {
        $askStories = Http::get($this->url.'askstories.json')->json();

        $latestAskStories = array_slice(array_reverse($askStories), 0, 10);

        foreach ($latestAskStories as $storyId) {
            $story = Http::get($this->url.'item/'.$storyId.'.json')->json();
            echo $story['title']."\n";
            echo "By: ".$story['by']."\n";
            echo "Score: ".$story['score']."\n";
            echo "Url: ".$story['url']."\n";
        }
    }

    public function spoolFromJobs()
    {
        $url = $this->url.'jobstories.json';
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
        $jobIds = json_decode($response->getBody(), true);

        $jobs = [];

        foreach ($jobIds as $jobId) {
            $jobUrl = $this->url."item/{$jobId}.json";
            $jobResponse = $client->request('GET', $jobUrl);
            $job = json_decode($jobResponse->getBody(), true);

            if ($job && isset($job['title']) && isset($job['url'])) {
                $jobs[] = [
                    'title' => $job['title'],
                    'url' => $job['url'],
                    'author' => isset($job['by']) ? $job['by'] : '',
                    'created_at' => isset($job['time']) ? date('Y-m-d H:i:s', $job['time']) : '',
                    'points' => isset($job['score']) ? $job['score'] : 0,
                    'comments_count' => isset($job['descendants']) ? $job['descendants'] : 0
                ];
            }
        }

        return view('jobs', ['jobs' => $jobs]);
    }

    public function spoolFromBestStories(Type $var = null)
    {
        $bestStories = file_get_contents($this->url.'beststories.json');
        $bestStories = array_slice(json_decode($bestStories), 0, 10);

        $stories = [];
        foreach ($bestStories as $storyId) {
            $story = file_get_contents($this->url.'item/' . $storyId . '.json');
            $story = json_decode($story);
            if ($story->type === 'story') {
                $stories[] = $story;
            }
        }

        return view('best', ['stories' => $stories]);

    }

}