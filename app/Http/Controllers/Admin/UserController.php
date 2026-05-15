<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all(); // Add this line to fetch all roles

        // Pass the roles variable to the view
        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'roles' => 'required|array',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validate the image
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Handle the upload using Spatie Media Library
        if ($request->hasFile('avatar')) {
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatars');
        }

        $user->assignRole($request->roles);

        return redirect()->route('admin.users.index')->with('success', 'User created with avatar.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user->update($request->only('name', 'email'));

        if ($request->hasFile('avatar')) {
            // This replaces the existing file in the 'avatars' collection
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatars');
        }

        // ... update roles logic ...

        return redirect()->route('admin.users.index')->with('success', 'Profile updated.');
    }

    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        // cann't delete users with role admin
        if ($user->hasRole('admin')) {
            return back()->with('error', 'You cannot delete user with role admin.');
        }


        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }
}