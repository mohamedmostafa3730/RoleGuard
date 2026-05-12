<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', ['user' => auth()->user()]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();

        // Remove ->singleFile() from here
        $user->addMediaFromRequest('avatar')
            ->toMediaCollection('avatars');

        return back()->with('success', 'Profile picture updated successfully!');
    }
}