<?php

namespace App\Actions;

use App\Models\HackerJob;
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
                'by' => ['required', 'string'],
                'score' => ['required', 'integer'],
                'text' => ['nullable', 'string'],
                'time' => ['required', 'integer'],
                'title' => ['nullable', 'max:255'],
                'url' => ['nullable'],
                'deleted' => ['nullable', 'boolean'],
                'dead' => ['nullable', 'boolean'],
                'category' => ['required', 'string'] 
            ])->validate();

            $this->createjob($input);
  
    }

    protected function createjob(array $input)
    {
        return DB::transaction(function () use ($input) {
            if (DB::table('hacker_jobs')->where('id', $input['id'])->doesntExist()) {
                HackerJob::create([
                    'id' => $input['id'],
                    'by' => $input['by'],
                    'score' => $input['score'],
                    'text' => isset($input['text']) ?? null,
                    'time' => $input['time'],
                    'title' => isset($input['title']) ?? null,
                    'url' => $input['url'] ?? null,
                    'deleted' => $input['deleted'] ?? false,
                    'dead' => $input['dead'] ?? false,
                    'category' => $input['category'],
                ]);
            } 
        });
    }
}
