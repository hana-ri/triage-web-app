<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;


class LoginRegisterController extends Controller
{
    public function loginView()
    {
        return view('auth.login');
    }
    public function login(Request $request): RedirectResponse
    {
        $remember = $request->has('remember');

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::viaRemember()) {
            return redirect()->intended(route('admin.dashboard'));
        }



        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            // dd(Auth::check());
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()
            ->withErrors([
                'message' => 'Your email or password is incorrect.',
            ])
            ->onlyInput();
    }

    public function registerView(Request $request)
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'tos' => 'required',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create($validatedData);

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();

        return redirect()->route('verification.notice');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
