<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validateData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $validateData['password'] = Hash::make($validateData['password']);
        $validateData['role'] = 'admin';
        $validateData['permission_level'] = 'edit';

        User::create($validateData);

        return redirect()->route('login')->with('success', 'Đăng ký thành công, vui lòng đăng nhập');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()
                ->withErrors(['email' => "Email không đúng"])
                ->withInput();
        }
        
        if (!Auth::attempt($credentials)) {
            return back()
                ->withErrors(['password' => "Mật khẩu không đúng"])
                ->withInput();
        }

        $request->session()->regenerate();

        return redirect('/products');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
