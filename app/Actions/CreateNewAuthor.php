<?php

namespace App\Actions;

use App\Models\Author;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CreateNewAuthor
{

    /**
     * Create a new author.
     *
     * @param  array  $input
     * @return bool
     */
    public function create(array $input)
    {
            Validator::make($input, [
                'id' => ['required', 'max:255'],
                'created' => ['required', 'integer'],
                'karma' => ['required', 'integer'],
                'about' => ['nullable', 'string'],
                'submitted' => ['nullable'],
            ])->validate();

            return $this->createauthor($input);
  
    }

    protected function createauthor(array $input)
    {
        if (DB::table('authors')->where('id', $input['id'])->doesntExist()) {
            Author::create([
                'id' => $input['id'],
                'created' => $input['created'],
                'karma' => $input['karma'],
                'about' => $input['about'] ?? null,
                'submitted' => json_encode($input['submitted'] ?? null),
            ]);
            return true;
        } else {
            return false;
        }
    }
}
