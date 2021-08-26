<?php

namespace App\Http\Controllers;

use App\Models\User;

class User2FAController extends Controller
{

    public function destroy(User $user)
    {
        $user->update([
            'two_factor_secret'         => NULL,
            'two_factor_recovery_codes' => NULL,
        ]);
        return back()->with([
            'message' => 'User 2FA Removed',
            'type'    => 'danger',
        ]);
    }

}
