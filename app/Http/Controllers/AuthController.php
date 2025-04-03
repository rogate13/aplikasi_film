<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Menampilkan form login
     */
    public function showLoginForm()
    {
        // Gunakan layout 'empty' tanpa navbar
        return view('auth.login')->with('layout', 'empty');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string'
        ], [
            'username.required' => __('messages.username_required'),
            'password.required' => __('messages.password_required')
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Cek credentials khusus untuk user 'aldmic'
        if ($request->username === 'aldmic') {
            $user = User::where('username', 'aldmic')->first();

            if ($user && Hash::check($request->password, $user->password)) {
                Auth::login($user);
                return redirect()->intended(route('movies.index'));
            }
        }

        // Fallback ke auth biasa
        if (Auth::attempt($request->only('username', 'password'))) {
            return redirect()->intended(route('movies.index'));
        }

        // Jika gagal
        return back()
            ->withInput()
            ->withErrors(['username' => __('messages.invalid_credentials')]);
    }

    /**
     * Proses logout
     */
    public function logout()
    {
        Auth::logout();

        // Redirect ke halaman login dengan pesan
        return redirect()
            ->route('login')
            ->with('status', __('messages.logout_success'));
    }
}
