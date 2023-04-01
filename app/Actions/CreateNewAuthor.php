<?php

namespace App\Actions;

use Illuminate\Support\Facades\Validator;

class CreateNewAuthor
{

    private $role;

    /**
     * Create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
            Validator::make($input, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => $this->passwordRules(),
                'country_id' => ['required', 'max:5'],
                'state_id' => ['required', 'max:5'],
                'city_id' => ['nullable', 'max:5'],
                'phone' => ['required', 'integer'],
                'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
            ])->validate();

            $this->createauthor($input);
  
    }

    public function createauthor(array $input)
    {
        $this->role = $input['role'] ?? 'user';
        return DB::transaction(function () use ($input) {
            return tap(User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'country_id' => $input['country_id'],
                'state_id' => $input['state_id'],
                'city_id' => $input['city_id'],
                'phone' => $input['phone'],
            ]), function (User $user) {
                $user->assignRole($this->role);
                $this->createTeam($user);
            });
        });
    }
}
