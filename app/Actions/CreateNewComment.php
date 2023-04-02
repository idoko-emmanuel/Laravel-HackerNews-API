<?php

namespace App\Actions;

use App\Models\Poll;
use App\Models\Story;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use App\Services\HackernewsDataService;
use Illuminate\Support\Facades\Validator;

class CreateNewComment
{

    /**
     * Create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function createnew(array $input, $id)
    {
        Validator::make($input, [
            'id' => ['required', 'max:255'],
            'text' => ['nullable', 'string'],
            'by' => ['required', 'string'],
            'points' => ['nullable', 'integer'],
            'source' => ['required', 'string'],
        ])->validate();

        return $this->createcomment($input, $id);
  
    }


    protected function createcomment(array $input, $id)
    {
        //check if comment already exists
        if (DB::table('comments')->where('id', $input['id'])->doesntExist()) {
            
            //check if the author of the comment already exists
            if(DB::table('authors')->where('id', $input['by'])->doesntExist()){
                $author = new HackernewsDataService;
                $author->CreateAuthor($input['by']);
            }

            //check if the parent item exists on the comment, story or poll table
            if(DB::table('comments')->where('id', $input['parent'])->exists())
            {
                $input['source'] = 'comment';
                
            } elseif(DB::table('stories')->where('id', $input['parent'])->exists())
            {
                $input['source'] = 'story';
            } elseif(DB::table('polls')->where('id', $input['parent'])->exists())
            {
                $input['source'] = 'poll';
            }else{
                //if parent item doesn't exist, create new item as story, poll comment
                $comment = new HackernewsDataService;
                $type = $comment->getItemType($input['parent']);
                switch ($type) {
                    case 'story':
                        $comment->CreateStory($input['parent']);
                        DB::table('comments')->insert([
                            'id' => $input['id'],
                            'text' => $input['text'] ?? null,
                            'by' => $input['by'],
                            'points' => $input['points'] ?? 0,
                            'commentable_type' => 'App\Models\Story',
                            'commentable_id' => $input['parent'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        return true;
                        break;

                    case 'poll':
                        $comment->CreateStory($input['parent']);
                        DB::table('comments')->insert([
                            'id' => $input['id'],
                            'text' => $input['text'] ?? null,
                            'by' => $input['by'],
                            'points' => $input['points'] ?? 0,
                            'commentable_type' => 'App\Models\Poll',
                            'commentable_id' => $input['parent'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        return true;
                        break;

                    case 'comment':
                        DB::table('comments')->insert([
                            'id' => $input['id'],
                            'text' => $input['text'] ?? null,
                            'by' => $input['by'],
                            'points' => $input['points'] ?? 0,
                            'commentable_type' => 'App\Models\Comment',
                            'commentable_id' => $input['parent'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        return true;
                        break;
                    
                    default:
                        # code...
                        break;
                }
            } 

            //create child comment since parent item exists
            $comment = new Comment([
                'id' => $input['id'],
                'text' => $input['text'] ?? null,
                'by' => $input['by'],
                'points' => $input['points'] ?? 0,
            ]);
            if($input['source'] === "comment")
            {
                $comment = Comment::find($id);
                $comment->comments()->save($comment);
            }elseif($input['source'] === "story")
            {
                $story = Story::find($id);
                $story->comments()->save($comment);

            }elseif($input['source'] === "poll")
            {
                $poll = Poll::find($id);
                $poll->comments()->save($comment);
            }

            return true;
        }
        return false;
    }
}
