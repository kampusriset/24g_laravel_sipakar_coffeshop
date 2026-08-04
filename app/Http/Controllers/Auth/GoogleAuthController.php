<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            return redirect()->route('login')->withErrors([
                'email' => 'Akun dengan email ini belum terdaftar. Hubungi admin untuk mendaftarkan akun Anda.',
            ]);
        }

        if ($user->role !== 'pegawai') {
            return redirect()->route('login')->withErrors([
                'email' => 'Akun ini tidak memiliki akses ke halaman login pegawai.',
            ]);
        }

        if (!$user->google_id) {
            $user->update(['google_id' => $googleUser->getId()]);
        }

        Auth::login($user);

        return redirect()->intended(route('dashboard', absolute: false));
    }
}