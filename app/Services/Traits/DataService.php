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
    /**
     * spool check.
     *
     * @return bool
     */

    protected function spoolcheck(): bool 
    {
        if($this->successfulSpool === self::LIMIT)
                return true;
    }

    /**
     * creates a comment.
     *
     * @param $post_id
     * @param $source
     * @return bool
     */

    protected function CreateComment($post_id, $source) : bool
    {
        //fetch data from item and loop through the kids to get the comments
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

    /**
     * creates a poll option.
     *
     * @param $post_id
     * @return bool
     */

    protected function CreatePollopt($post_id) : bool
    {
        $createoption = new CreateNewPollopt;

        //fetch data from item and loop through the parts to create poll option
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

    /**
     * fetch data from endpoint.
     *
     * @param $itemid
     * @return mixed
     */

    protected function getItemDetails($itemId) : mixed
    {
        return  $itemDetails = json_decode(file_get_contents($this->url."item/{$itemId}.json?print=pretty"));
    }

    /**
     * create new comment.
     *
     * @param $comment_id
     * @param $post_id
     * @param $source
     * @return bool
     */

    protected function newComment($comment_id, $post_id, $source) : bool
    {
        $createcomment = new CreateNewComment;
        //fetch item data and create new comment
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

    /**
     * create a story.
     *
     * @param $itemDetails
     * @param $category
     * @return mixed
     */

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

    /**
     * creates a poll.
     *
     * @param $itemDetails
     * @return mixed
     */

    protected function poll($itemDetails) : mixed
    {
        $this->spoolcheck();

        $createpoll = new CreateNewPoll;
        if(isset($itemDetails->by)) {
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

    /**
     * creates job.
     *
     * @param $itemDetails
     * @return mixed
     */

    protected function job($itemDetails) : mixed
    {
        $this->spoolcheck();

        $createjob = new CreateNewJob;
        if(isset($itemDetails->by) && isset($itemDetails->id)) {
            //create author
            $this->CreateAuthor($itemDetails->by);

            //create job 
            $itemDetails = (array) $itemDetails;

            if($createjob->create($itemDetails) && App::environment('testing'))
                $this->successfulSpool++;

        }

        return true;
    }

    /**
     * get item type.
     *
     * @param $itemId
     * @return string
     */

    public function getItemType($itemId):string
    {
        $item = $this->getItemDetails($itemId);
        if (!is_null($item)) 
            return $item->type;
    }

    /**
     * create author.
     *
     * @param $authorid
     * @return bool
     */

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

    /**
     * create a story, poll, job or comment.
     *
     * @param $itemId
     * @param $category
     * @return bool
     */
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