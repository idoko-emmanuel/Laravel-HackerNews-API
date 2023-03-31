<?php 
namespace App\Services;

class SpoolDataService 
{
    public function spoolFromMaxItem(Type $var = null)
    {
        # code...
    }

    public function spoolFromTopStories(Type $var = null)
    {
        $response = Http::get('https://hacker-news.firebaseio.com/v0/topstories.json');
        $topStoryIds = $response->json();

        $topStories = [];
        foreach ($topStoryIds as $storyId) {
            $response = Http::get("https://hacker-news.firebaseio.com/v0/item/$storyId.json");
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
        $url = 'https://hacker-news.firebaseio.com/v0/newstories.json';
        $response = file_get_contents($url);
        $stories = json_decode($response);

        foreach ($stories as $storyId) {
            $url = "https://hacker-news.firebaseio.com/v0/item/$storyId.json";
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
        $response = Http::get('https://hacker-news.firebaseio.com/v0/showstories.json');
        $showHnIds = $response->json();

        // Get the latest 10 Show HN stories
        $showHnStories = [];
        foreach (array_slice($showHnIds, 0, 10) as $storyId) {
            $response = Http::get("https://hacker-news.firebaseio.com/v0/item/{$storyId}.json");
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
        $askStories = Http::get('https://hacker-news.firebaseio.com/v0/askstories.json')->json();

        $latestAskStories = array_slice(array_reverse($askStories), 0, 10);

        foreach ($latestAskStories as $storyId) {
            $story = Http::get('https://hacker-news.firebaseio.com/v0/item/'.$storyId.'.json')->json();
            echo $story['title']."\n";
            echo "By: ".$story['by']."\n";
            echo "Score: ".$story['score']."\n";
            echo "Url: ".$story['url']."\n";
        }
    }

    public function spoolFromJobs()
    {
        $url = 'https://hacker-news.firebaseio.com/v0/jobstories.json';
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
        $jobIds = json_decode($response->getBody(), true);

        $jobs = [];

        foreach ($jobIds as $jobId) {
            $jobUrl = "https://hacker-news.firebaseio.com/v0/item/{$jobId}.json";
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
        $bestStories = file_get_contents('https://hacker-news.firebaseio.com/v0/beststories.json');
        $bestStories = array_slice(json_decode($bestStories), 0, 10);

        $stories = [];
        foreach ($bestStories as $storyId) {
            $story = file_get_contents('https://hacker-news.firebaseio.com/v0/item/' . $storyId . '.json');
            $story = json_decode($story);
            if ($story->type === 'story') {
                $stories[] = $story;
            }
        }

        return view('best', ['stories' => $stories]);

    }

    protected function getComment(Type $var = null)
    {
        $post_id = 123456; // replace with the ID of the post you want to get the comments for

        $response = Http::get("https://hacker-news.firebaseio.com/v0/item/{$post_id}.json");

        if ($response->successful()) {
            $post = $response->json();
            $comment_ids = $post['kids'];
            
            // get comments
            $comments = [];
            foreach ($comment_ids as $comment_id) {
                $comment_response = Http::get("https://hacker-news.firebaseio.com/v0/item/{$comment_id}.json");
                if ($comment_response->successful()) {
                    $comment = $comment_response->json();
                    if (isset($comment['text'])) {
                        $comments[] = $comment;
                    }
                }
            }
            
            // print comments
            foreach ($comments as $comment) {
                echo "{$comment['by']} said: {$comment['text']}<br><br>";
            }
        } else {
            // handle error
        }
    }

    protected function getAuthor(Type $var = null)
    {
        $storyId = 12345; // Replace with the ID of the story or comment
        // Make a request to the Hacker News API
        $response = Http::get("https://hacker-news.firebaseio.com/v0/item/{$storyId}.json");

        // Get the author of the story or comment
        $author = $response['by'];
    }

}