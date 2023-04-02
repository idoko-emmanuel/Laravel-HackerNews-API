<?php

namespace App\Actions;

use App\Models\Poll;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CreateNewPoll
{

    /**
     * Create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
            Validator::make($input, [
                'id' => ['required', 'max:255'],
                'by' => ['required', 'string'],
                'descendants' => ['nullable', 'integer'],
                'score' => ['required', 'integer'],
                'title' => ['nullable', 'max:255'],
                'text' => ['nullable', 'string'],
                'time' => ['required', 'integer'],
                'deleted' => ['nullable', 'boolean'],
                'dead' => ['nullable', 'boolean']
            ])->validate();

            return $this->createpoll($input);
  
    }

    protected function createpoll(array $input)
    {
        if (DB::table('polls')->where('id', $input['id'])->doesntExist()) {
            Poll::create([
                'id' => $input['id'],
                'by' => isset($input['by']) ?? null,
                'descendants' => $input['descendants'] ?? null,
                'score' => $input['score'],
                'title' => $input['title'],
                'text' => isset($input['text']) ?? null,
                'by' => $input['by'],
                'time' => $input['time'],
                'deleted' => $input['deleted'] ?? false,
                'dead' => $input['dead'] ?? false,
            ]);
            return true;
        } 

        return false;
    }
}
