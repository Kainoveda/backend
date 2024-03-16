<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;

class ConfirmationController extends Controller
{
    public function confirm(User $user)
    {
        // Update user's confirmation status, e.g., set 'confirmed' field to true
        $user->update(['confirmed' => true]);

        // Redirect to a confirmation success page
        return redirect('/confirmation-success');
    }
}