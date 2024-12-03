<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        return view('admin.user.index', ['user' => $user]);
    }

    public function updateEmail(Request $request)
    {
        $user = Auth::user(); 

        $request->validate([
            'emailaddress' => 'required|email|unique:users,email,' . $user->id,
            'confirmemailpassword' => 'required',
        ]);

        if (!Hash::check($request->confirmemailpassword, $user->password)) {
            return back()->withErrors(['confirmemailpassword' => 'Password tidak cocok']);
        }

        $user->email = $request->emailaddress;
        $user->save();

        return back()->with('email_updated', true);
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user(); 

        $request->validate([
            'currentpassword' => 'required',
            'newpassword' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->currentpassword, $user->password)) {
            return back()->withErrors(['currentpassword' => 'Password lama tidak cocok']);
        }

        $user->password = Hash::make($request->newpassword);
        $user->save();

        return back()->with('password_updated', true);
    }

    // public function updateProfile(Request $request)
    // {
    //     $user = Auth::user();

    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'no_telp' => 'required|string|max:13',
    //         'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //     ]);

    //     $user->name = $request->name;

    //     if ($request->hasFile('avatar')) {
    //         if ($user->avatar && Storage::exists($user->avatar)) {
    //             Storage::delete($user->avatar);
    //         }

    //         $path = $request->file('avatar')->store('avatars', 'public');
    //         $user->avatar = $path;
    //     }

    //     $user->save();

    //     return back()->with('profile_updated', true);
    // }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
    
        $request->validate([
            'name' => 'required|string|max:255',
            // 'no_telp' => 'required|string|max:13', 
            'no_telp' => 'nullable|string|max:13',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $user->name = $request->name;
        $user->no_telp = $request->no_telp;
    
        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::exists($user->avatar)) {
                Storage::delete($user->avatar);
            }
    
            $pathPublic = $request->file('avatar')->store('avatars', 'public');
            
            $pathStorage = $request->file('avatar')->store('avatars', 'local'); 
    
            $user->avatar = $pathPublic;
        }
    
        $user->save();
    
        return back()->with('profile_updated', true);
    }
    

}
