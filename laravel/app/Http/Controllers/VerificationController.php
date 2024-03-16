<?php

namespace App\Http\Controllers;

use App\Models\User;

class VerificationController extends Controller
{
    public function verify(User $user)
    {
            $user->update(['verified' => true, 'verification_token' => null]);
            return redirect('/verification-success');
    }
}

