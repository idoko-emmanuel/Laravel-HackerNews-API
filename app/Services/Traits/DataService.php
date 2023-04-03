<?php 
namespace App\Services\Traits;

use App\Actions\CreateNewJob;
use App\Actions\CreateNewPoll;
use App\Actions\CreateNewStory;
use App\Actions\CreateNewAuthor;
use App\Actions\CreateNewComment;
use App\Actions\CreateNewPollopt;
use Illuminate\Support\Facades\App;

trait DataService 
{
    protected function CreateComment($post_id, $source) : bool
    {
        
        $response = $this->getItemDetails($post_id);
        if (!is_null($response) && isset($response->kids)) {
            
            $comment_ids = $response->kids;
            
            // Loop through comment IDs
            foreach ($comment_ids as $comment_id) {
                $this->newComment($comment_id, $post_id, $source);
            }

            return true;

        } else {
            return false;
        }
    }

    protected function CreatePollopt($post_id) : bool
    {
        $createoption = new CreateNewPollopt;
        $response = $this->getItemDetails($post_id);
        if (!is_null($response) && isset($response->parts)) {
            
            $options_ids = $response->parts;
            
            // Loop through polls
            foreach ($options_ids as $option_id) {
                $option_response = $this->getItemDetails($comment_id);
                if (!is_null($option_response)) {
                    $option_response = (array) $comment_response;
                    //create poll option if author is available
                    if(isset($option_response['by']))
                        $createoption->create($option_response, $post_id);
                }
            }

            return true;

        } else {
            return false;
        }
    }

    protected function getItemDetails($itemId) : mixed
    {
        return  $itemDetails = json_decode(file_get_contents($this->url."item/{$itemId}.json?print=pretty"));
    }

    protected function newComment($comment_id, $post_id, $source) : bool
    {
        $createcomment = new CreateNewComment;
        $comment_response = $this->getItemDetails($comment_id);
        if (!is_null($comment_response)) {
            $comment_response = (array) $comment_response;
            $comment_response = array_merge($comment_response, [
                'source' => $source,
            ]);
            //create comment if author is available
            if(isset($comment_response['by']))
                $createcomment->createnew($comment_response, $post_id);
        }
        return true;
    }

    protected function story($itemDetails, $category) : mixed
    {
        $createstory = new CreateNewStory;
        //create author, story and comment if author is available
        if(isset($itemDetails->by)) {
            if($this->successfulSpool === self::LIMIT)
                return true;
            //create author
            $this->CreateAuthor($itemDetails->by);

            //create story if it doesn't
            $itemDetails = (array) $itemDetails;

            $itemDetails = array_merge($itemDetails, [
                'category' => $category,
            ]);

            if($createstory->create($itemDetails))
                $this->successfulSpool++;

            //create comments 
            $this->CreateComment($itemDetails['id'], 'story');
        }

        return true;
    }

    protected function poll($itemDetails) : mixed
    {
        $createpoll = new CreateNewPoll;
        if(isset($itemDetails->by)) {
            if($this->successfulSpool === self::LIMIT)
                return true;
            //create author
            $this->CreateAuthor($itemDetails->by);

            //create poll if it doesn't
            $itemDetails = (array) $itemDetails;

            if($createpoll->create($itemDetails))
                $this->successfulSpool++;

            //create poll option
            $this->CreatePollopt($itemDetails['id']);

            //create comments 
            $this->CreateComment($itemDetails['id'], 'poll');
        }
        return true;
    }

    protected function job($itemDetails) : mixed
    {
        $createjob = new CreateNewJob;
        if(isset($itemDetails->by) && isset($itemDetails->id)) {
            if($this->successfulSpool === self::LIMIT)
                return true;
            //create author
            $this->CreateAuthor($itemDetails->by);

            //create job 
            $itemDetails = (array) $itemDetails;

            if($createjob->create($itemDetails) && App::environment('testing'))
                $this->successfulSpool++;

        }

        return true;
    }

    public function getItemType($itemId):string
    {
        $item = $this->getItemDetails($itemId);
        if (!is_null($item)) 
            return $item->type;
    }


    public function CreateAuthor($authorid) : bool
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

    public function CreateStory($itemId, $category = 'new'): bool
    {
        $itemDetails = $this->getItemDetails($itemId);
        if (!is_null($itemDetails)) {
            match ($itemDetails->type) {
                'story' => $this->story($itemDetails, $category),
                'poll' => $this->poll($itemDetails),
                'job' => $this->job($itemDetails),
                'comment' => $this->CreateComment($itemDetails->id, 'comment'),
            };   
        }else {
            return false;
        }
        return true;
    }
}