<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function edit (Request $request)
    {
        return Inertia::render('Profile/Edit', [
            'user' => $request->user()
        ]);

    }

    public function updateInfo (Request $request) {
        
        $fields = $request->validate([
            'avatar' => ['image', 'nullable', 'max:3072'],
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'lowercase', 'unique:users,email,'.$request->user()->id],
        ]);

         if ($request->hasFile('avatar')) {
            $fields['avatar'] = Storage::disk('public')->put('avatars', $request->avatar);
        }

        $request->user()->fill($fields);

        $request->user()->save();

        return redirect()->route('profile.edit');
    }

    public function updatePassword (Request $request) {
        $fields = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $request->user()->fill($fields);

        $request->user()->save();

        return redirect()->route('profile.edit');
    }
}
