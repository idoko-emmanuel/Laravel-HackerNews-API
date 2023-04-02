<?php

namespace App\Actions;

use App\Models\Pollopt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CreateNewPollopt
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
                'by' => ['required', 'string'],
                'poll_id' => ['required', 'integer'],
                'score' => ['required', 'integer'],
                'text' => ['nullable', 'string'],
                'time' => ['nullable', 'integer'],
                'deleted' => ['nullable', 'boolean'],
                'dead' => ['nullable', 'boolean'],
                'category' => ['required', 'string']
            ])->validate();

            $this->createpollopt($input, $id);
  
    }

    protected function createpollopt(array $input, $id)
    {
        return DB::transaction(function () use ($input, $id) {
            if (DB::table('pollopts')->where('id', $input['id'])->doesntExist()) {
                Pollopt::create([
                    'id' => $input['id'],
                    'by' => $input['by'],
                    'poll_id' => $id,
                    'score' => $input['score'],
                    'text' => isset($input['text']) ?? null,
                    'time' => $input['time'] ?? null,
                    'deleted' => $input['deleted'] ?? false,
                    'dead' => $input['dead'] ?? false,
                    'category' => $input['category'],
                ]);
            } 
        });
    }
}
