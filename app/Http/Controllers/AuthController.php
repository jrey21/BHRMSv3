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
            'position'=>['required', 'max:255'],
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],   
        ]);

        if ($request->hasFile('avatar')){
           $fields['avatar'] = Storage::disk('public')->put('avatars', $request->avatar);
        }

        // Set default approval status
        $fields['is_approved'] = false;

         // Hash the password before saving
        $fields['password'] = Hash::make($fields['password']);


        //Register
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
            'position' => $fields['position'],
            'avatar' => $fields['avatar'] ?? null,
            'is_approved' => false, 
        ]);

        // Redirect
        return redirect()->route('login')->with('success', 'Registration successful! Please wait for admin approval.');


        //Login
        // Auth::login($user);

        //Redirect
        // return redirect('/dashboard')->with ('success', 'Registration Successful!');
        // return redirect()->route('dashboard')->with('success', 'Registration Successful!');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if ($user && !$user->is_approved) {
            return back()->withErrors([
                'email' => 'Your account is not approved yet. Please wait for admin approval.',
            ]);
        }
    
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
    
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
     
        return redirect()->route('login');
    }


    //retrive the users
    public function retrieve()
    {
        $users = User::all();
        return response()->json($users);
    }


}
