<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class AccountController extends Controller
{
    // public function index(Request $request)
    // {
    //     $search = $request->input('search'); 
    
    //     $users = User::with('roles')
    //         ->when($search, function ($query, $search) {
    //             return $query->where('name', 'like', "%{$search}%")
    //                          ->orWhere('email', 'like', "%{$search}%");
    //         })
    //         ->paginate(10);  
    
    //     if ($request->ajax()) {
    //         return view('admin.account.index-content', compact('users'))->render();
    //     }
    
    //     return view('admin.account.index', compact('users'));
    // }

    public function index(Request $request)
    {
        $search = $request->input('search'); 

        $users = User::with('roles')->where('is_verif',0)
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
            })
            ->paginate(10);

        $pendingTeachers = User::whereHas('roles', function ($query) {
            $query->where('name', 'teacher');
        })->where('is_verif', 1)->get();

        if ($request->ajax()) {
            return view('admin.account.index-content', compact('users', 'pendingTeachers'))->render();
        }

        return view('admin.account.index', compact('users', 'pendingTeachers'));
    }

    
    public function verify($id)
    {
        $user = User::findOrFail($id);

        if ($user->hasRole('teacher') && $user->is_verif == 1) {
            $user->update(['is_verif' => 0]);
            return redirect()->route('account.index')->with('success', 'Akun berhasil diverifikasi.');
        }

        return redirect()->route('account.index')->with('error', 'Akun tidak valid untuk verifikasi.');
    }

    public function search(Request $request)
    {
        try {
            $query = $request->input('query');
            $users = User::where('name', 'like', "%{$query}%")
                         ->orWhere('email', 'like', "%{$query}%")
                         ->paginate(10);
    
            // Mengembalikan hasil pencarian dengan format JSON
            return response()->json([
                'status' => 'success',
                'users' => view('account.user-table', compact('users'))->render()
            ]);
        } catch (\Exception $e) {
            // Mengembalikan pesan error jika terjadi masalah
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }    

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|exists:roles,name'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        // return redirect()->route('account.index')->with('success', 'User created successfully');
        return back()->with('success', 'User created successfully');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,name'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $user->syncRoles($request->role);

        return redirect()->route('account.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('account.index')->with('success', 'User deleted successfully');
    }
}
