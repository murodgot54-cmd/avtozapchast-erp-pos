<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            return redirect()->intended(route('dashboard'))
                ->with('success', 'Xush kelibsiz!');
        }

        throw ValidationException::withMessages([
            'email' => 'Kiritilgan ma\'lumotlar noto\'g\'ri.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('login'))->with('success', 'Siz tizimdan chiqtingiz.');
    }

    public function profile()
    {
        return view('auth.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $user->update($request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string',
        ]));

        return back()->with('success', 'Profil yangilandi.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if (!\Hash::check($request->current_password, auth()->user()->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Joriy parol noto\'g\'ri.',
            ]);
        }

        auth()->user()->update([
            'password' => \Hash::make($request->password),
        ]);

        return back()->with('success', 'Parol o\'zgartirildi.');
    }
}
