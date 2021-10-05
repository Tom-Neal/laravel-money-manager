<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserPasswordRequest;

class UserProfileController extends Controller
{

    public function show()
    {
        /*
         * User profile for changing email & password
         * Redirects if attempt made to access someone else
         */
        return view('users.profile');
    }

    public function update(UserPasswordRequest $request)
    {
        /*
         * Updates a user's email and/or password
         */
        request()->validate([
            'email' => ['required', 'email', 'max:100', 'unique:users,email,' . auth()->user()->id],
        ]);
        auth()->user()->update([
            'email'    => request()['email'],
            'password' => bcrypt(request()['password'])
        ]);
        return back()->with('message', 'Profile Updated');
    }

}
