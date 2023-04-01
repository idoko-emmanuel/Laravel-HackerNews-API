<?php

namespace App\Actions;

use App\Models\Author;
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
    public function create(array $input)
    {
            Validator::make($input, [
                'id' => ['required', 'max:255'],
                'created' => ['required', 'integer'],
                'karma' => ['required', 'integer'],
                'about' => ['nullable', 'string'],
                'submitted' => ['required'],
            ])->validate();

            $this->createauthor($input);
  
    }

    protected function createauthor(array $input)
    {
        return DB::transaction(function () use ($input) {
            if (DB::table('authors')->where('id', $input['id'])->doesntExist()) {
                Author::create([
                    'id' => $input['id'],
                    'created' => $input['created'],
                    'karma' => $input['karma'],
                    'about' => $input['about'] ?? null,
                    'submitted' => json_encode($input['submitted']),
                ]);
            }
        });
    }
}
