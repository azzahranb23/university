<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.index');
    }

    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::user();

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->user_id . ',user_id',
                'phone' => 'required|string',
                'gender' => 'nullable|in:male,female',
                'photo' => 'nullable|image|max:2048'
            ]);

            if ($request->hasFile('photo')) {
                try {
                    if ($user->photo) {
                        Storage::disk('public')->delete($user->photo);
                    }
                    $validated['photo'] = $request->file('photo')->store('profile-photos', 'public');
                } catch (\Exception $e) {
                    return redirect()->back()->with('error', 'Failed to upload profile photo. Please try again.');
                }
            }

            $user->update($validated);
            return redirect()->route('profile')->with('success', 'Profile updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update profile. Please try again.');
        }
    }

    public function password()
    {
        return view('profile.password');
    }

    public function updatePassword(Request $request)
    {
        try {
            $validated = $request->validate([
                'current_password' => 'required',
                'password' => 'required|min:8|confirmed',
            ]);

            $user = Auth::user();

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    'current_password' => 'The provided password does not match your current password.'
                ])->with('error', 'Current password is incorrect.');
            }

            $user->update([
                'password' => Hash::make($validated['password'])
            ]);

            return redirect()->route('profile')->with('success', 'Password changed successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update password. Please try again.');
        }
    }
}
