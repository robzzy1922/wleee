<?php

namespace App\Http\Controllers;

use App\Services\Auth\AuthServiceProxy;
use App\Services\Auth\RealAuthService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    private $authService;

    public function __construct()
    {
        $this->authService = new AuthServiceProxy(new RealAuthService());
    }

    // Tampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            if ($this->authService->login($credentials)) {
                $request->session()->regenerate();

                return $this->authService->getCurrentUser()->role === 'admin'
                    ? redirect()->route('admin.dashboard')
                    : redirect()->route('dashboard');
            }

            return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
        } catch (\Exception $e) {
            return back()->withErrors(['email' => $e->getMessage()])->withInput();
        }
    }

    // Proses logout
    public function logout(Request $request)
    {
        $this->authService->logout($request);
        return redirect('/')->with('status', 'Anda telah logout.');
    }


    // Tampilkan form register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Proses register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Semua yang daftar jadi user biasa
        ]);

        // Setelah berhasil daftar, arahkan ke login dan kirim flash message
        return redirect()->route('login')->with('status', 'Registrasi berhasil! Silakan login.');
    }

    // Tampilkan form lupa password
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    // Kirim link reset password
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', trans($status))
            : back()->withErrors(['email' => trans($status)]);
    }

    // Tampilkan form reset password
    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    // Proses reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->update(['password' => Hash::make($password)]);
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', trans($status))
            : back()->withErrors(['email' => trans($status)]);
    }
}
