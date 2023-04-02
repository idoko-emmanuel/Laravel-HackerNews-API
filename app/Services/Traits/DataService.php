<?php 
namespace App\Services\Traits;

use App\Actions\CreateNewJob;
use App\Actions\CreateNewPoll;
use App\Actions\CreateNewStory;
use App\Actions\CreateNewAuthor;
use App\Actions\CreateNewComment;
use App\Actions\CreateNewPollopt;

trait DataService 
{
    protected function CreateComment($post_id, $source) : bool
    {
        
        $response = $this->getItemDetails($post_id);
        if (!is_null($response) && isset($response->kids)) {
            
            $comment_ids = $response->kids;
            
            // save comments
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
            
            // save comments
            foreach ($options_ids as $option_id) {
                $option_response = $this->getItemDetails($comment_id);
                if (!is_null($option_response)) {
                    $option_response = (array) $comment_response;
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
            $createcomment->create($comment_response, $post_id);
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
            switch ($itemDetails->type) {
                case 'story':
                    $createstory = new CreateNewStory;
                    if(isset($itemDetails->by)) {
                        //create author
                        $this->CreateAuthor($itemDetails->by);

                        //create story if it doesn't
                        $itemDetails = (array) $itemDetails;

                        $itemDetails = array_merge($itemDetails, [
                            'category' => $category,
                        ]);

                        $storycreated = $createstory->create($itemDetails);

                        //create comments 
                        $this->CreateComment($itemDetails['id'], 'story');

                        if($storycreated)
                            $this->successfulSpool++;
                    }
                    
                    break;

                case 'poll':
                    if(isset($itemDetails->by)) {
                        $createpoll = new CreateNewPoll;
                        //create author
                        $this->CreateAuthor($itemDetails->by);

                        //create poll if it doesn't
                        $itemDetails = (array) $itemDetails;

                        $pollcreated = $createpoll->create($itemDetails);

                        //create poll option
                        $this->CreatePollopt($itemDetails['id']);

                        //create comments 
                        $this->CreateComment($itemDetails['id'], 'poll');

                        if($pollcreated)
                            $this->successfulSpool++;
                    }
                    break;

                case 'job':
                    if(isset($itemDetails->by)) {
                        $createjob = new CreateNewJob;
                        //create author
                        $this->CreateAuthor($itemDetails->by);

                        //create job 
                        $jobcreated = $createjob->create($itemDetails);

                        if($jobcreated)
                            $this->successfulSpool++;
                    }
                    break;
                
                default:
                    # code...
                    break;
            }

            
        }else {
            return false;
        }
        return true;
    }
}