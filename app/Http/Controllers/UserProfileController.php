<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserPasswordRequest;

class UserProfileController extends Controller
{

    public function show(User $user)
    {
        /*
         * User profile for changing email & password
         * Redirects if attempt made to access someone else
         */
        if ((int)auth()->user()->id === (int)$user->id) {
            return view('users.profile');
        }
        return redirect()->route('users/profile', auth()->user()->id());
    }

    public function update(UserPasswordRequest $request, User $user)
    {
        /*
         * Updates a user's email and/or password
         */
        request()->validate([
            'email' => ['required', 'email', 'max:100', 'unique:users,email,' . $user->id],
        ]);
        $user->update([
            'email'    => request()['email'],
            'password' => bcrypt(request()['password'])
        ]);
        return back()->with('message', 'Profile Updated');
    }

}
