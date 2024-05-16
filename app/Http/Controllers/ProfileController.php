<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;


class ProfileController extends Controller
{
    function myprofile(Request $request)
    {
        return view('admin.user.profile', ['user' => $request->user()]);
    }

    public function updateProfile(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
        ];

        if ($request->user()->email !== $request->email) {
            $rules['email'] = ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class];
        }

        $validatedData = $request->validate($rules);

        $request->user()->update($validatedData);

        return redirect()->route('admin.users.profile.edit')->with('success', 'Profile updated!');
    }

    public function updatePassword(Request $request)
    {
        $validatedData = $request->validate([
            'old_password' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if (!Hash::check($validatedData['old_password'], $request->user()->password)) {
            return redirect()->route('admin.users.profile.edit')->with('warning', 'Old password wrong!');
        }


        $request->user()->update([
            'password' => Hash::make($validatedData['password']),
        ]);

        return redirect()->route('admin.users.profile.edit')->with('success','Password changed successfully!');
    }
}
