<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register (Request $request)
    {   

        //Validate
        $fields = $request->validate([  
            'avatar' => ['file', 'nullable', 'max:5074'],
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],   
        ]);

        if ($request->hasFile('avatar')){
           $fields['avatar'] = Storage::disk('public')->put('avatars', $request->avatar);
        }


        //Register
        $user = User::create($fields);   

        //Login
        Auth::login($user);

        //Redirect
        // return redirect('/dashboard')->with ('success', 'Registration Successful!');
        // return redirect()->route('dashboard')->with('success', 'Registration Successful!');
    }

    public function login (Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
 
            // return redirect()->intended('/dashboard')->with('refresh', true);
            return redirect()->intended('/dashboard');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout (Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
     
        // return redirect()->route('login');
    }


}
