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
                'score' => ['nullable', 'integer'],
                'title' => ['nullable', 'max:255'],
                'text' => ['nullable', 'string'],
                'time' => ['nullable', 'integer'],
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
                'by' => isset($input['by']),
                'descendants' => $input['descendants'] ?? null,
                'score' => $input['score'] ?? null,
                'title' => $input['title'] ?? null,
                'text' => isset($input['text']) ?? null,
                'time' => $input['time'] ?? null,
                'deleted' => $input['deleted'] ?? false,
                'dead' => $input['dead'] ?? false,
            ]);
            return true;
        } 

        return false;
    }
}
