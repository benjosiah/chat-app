<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
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
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        $user = new User;
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = Hash::make($input['password']);
        $user->save();
        $member = new Member;
        $member->team_id = 1;
        $member->user_id = $user->id;
        $member->save();

        return $user;
    }
}
