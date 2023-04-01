<?php

namespace App\Actions;

use App\Models\Story;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CreateNewJob
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
                'title' => ['nullable', 'max:255'],
                'url' => ['nullable'],
                'text' => ['nullable', 'string'],
                'score' => ['required', 'integer'],
                'by' => ['required', 'string'],
                'time' => ['required', 'integer'],
                'descendants' => ['nullable', 'integer'],
                'deleted' => ['nullable', 'boolean'],
                'dead' => ['nullable', 'boolean'],
                'category' => ['required', 'string']
            ])->validate();

            $this->createstory($input);
  
    }

    protected function createstory(array $input)
    {
        return DB::transaction(function () use ($input) {
            if (DB::table('stories')->where('id', $input['id'])->doesntExist()) {
                Story::create([
                    'id' => $input['id'],
                    'title' => isset($input['title']) ?? null,
                    'url' => $input['url'] ?? null,
                    'text' => isset($input['text']) ?? null,
                    'score' => $input['score'],
                    'by' => $input['by'],
                    'time' => $input['time'],
                    'descendants' => $input['descendants'] ?? null,
                    'deleted' => $input['deleted'] ?? false,
                    'dead' => $input['dead'] ?? false,
                    'category' => $input['category'],
                ]);
            } else {
                return false;
            }
        });
    }
}
