<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;

class UserConfirmationController extends Controller
{
    // retrieve the users

    public function index()
    {
        // Fetch all users from the database
        $users = User::all();

        // Pass the users to an Inertia view
        return inertia('UserConfirmation/View', [
            'users' => $users,
        ]);
    }
}
