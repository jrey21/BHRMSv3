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
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'lowercase', 'unique:users,email,'.$request->user()->id],
            'avatar' => ['file', 'nullable', 'max:5074'],
        ]);

        $user = $request->user();
        $user->name = $fields['name'];
        $user->email = $fields['email'];

        if ($request->hasFile('avatar')) {
            $user->avatar = Storage::disk('public')->put('avatars', $request->avatar);
        }

        $user->save();

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
