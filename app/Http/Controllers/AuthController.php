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


        //Register
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
            'position' => $fields['position'],
            'avatar' => $fields['avatar'] ?? null,

            // additional field for admin approval
            'is_approved' => false, 
        ]);
        
        // Add flash message for pending approval
        return redirect()->route('login')->with('success', 'Your account is pending waiting for approval by the admin.');

        //Redirect
        // return redirect()->route('dashboard')->with('success', 'Registration Successful!');

        //For admin approval
        // return redirect()->route('login')->with('success', 'Your account is pending approval by the admin.');
    }


    //Login function
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Auth::attempt($credentials, $request->remember)) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        if (!$user->is_approved) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Your account is pending approval from the admin.',
            ]);
        }

        if (!$user->is_active) { 
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Your account is inactive. Please contact the admin to reactivate your account.',
            ]);
        }
        

        return redirect()->intended('/dashboard');

        //The commented code below is for the normal login without admin approval
        // if (Auth::attempt($credentials, $request->remember)) {
        //     $request->session()->regenerate();
    
        //     return redirect()->intended('/dashboard');
        // }
    
        // return back()->withErrors([
        //     'email' => 'The provided credentials do not match our records.',
        // ])->onlyInput('email');
    }
    

    //Fetch pending users
    public function getPendingUsers()
    {
        if (Auth::user()->position !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        
        $users = User::where('is_approved', false)->get();
        return response()->json($users);
    }

    //Function to approve users
    public function approveUser($id)
    {
        if (Auth::user()->position !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $user = User::findOrFail($id);
        $user->is_approved = true;
        $user->save();

        return back()->with('success', 'User approved successfully.');
    }

    //Function reject approval of users
    public function rejectUser($id)
    {
        if (Auth::user()->position !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'User rejected successfully.');
    }

    //Logout function
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
