<?php

namespace App\Actions;

use App\Models\Poll;
use App\Models\Story;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CreateNewComment
{

    /**
     * Create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input, $id)
    {
        Validator::make($input, [
            'id' => ['required', 'max:255'],
            'text' => ['required', 'string'],
            'by' => ['required', 'string'],
            'points' => ['nullable', 'integer'],
            'parent_id' => ['nullable', 'integer'],
            'source' => ['required', 'string'],
        ])->validate();

            $this->createcomment($input, $id);
  
    }


    protected function createcomment(array $input, $id)
    {
        return DB::transaction(function () use ($input, $id) {
            if (DB::table('comments')->where('id', $input['id'])->doesntExist()) {
                $comment = new Comment([
                    'id' => $input['id'],
                    'text' => $input['text'],
                    'by' => $input['by'],
                    'points' => $input['points'] ?? 0,
                    'parent_id' => $input['parent'],
                ]);
                if($input['source'] === "story")
                {
                    $story = Story::find($id);
                    $story->comments()->save($comment);

                }elseif($type === "poll")
                {
                    $poll = Poll::find($id);
                    $poll->comments()->save($comment);
                }
            }
        });
    }
}
