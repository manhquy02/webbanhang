<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 

class AuthController extends Controller
{
    public function showRegisterForm(){
        return view('auth.register');
    }

    public function register(Request $request){
        $validateData = $request->validate([
            'username'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:8',
        ]);
        $users = User::create([
            'username'=>$validateData['username'],
            'email'=>$validateData['email'],
            'password'=>Hash::make($validateData['password']),
            'role'=>'admin',
            'permission_level'=>'read',
        ]);
        $users->makeHidden(['password']);
          return redirect('/login')->with('success', 'Đăng ký thành công, vui lòng đăng nhập');
        // return response()->json([
        //     'message'=>'Đăng ký thành công',
        //     'user'=>$users,
        // ],201);
    } 

    public function showLoginForm(){
        return view('auth.login');
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email'=>'required|email',
            'password'=>'required|string|min:8',
        ]);
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect('/products');
        }
        return back()->withErrors([
            'email'=>"Email hoặc mật khẩu không đúng",
        ])->onlyInput('email');

        // $users= User::where('email',$validateData['email'])->first();
        // if(!$users){
        //     return response()->json(['message'=>'Email không tồn tại'],404);
        // }
        // if(!Hash::check($validateData['password'],$users->password)){
        //     return response()->json(['message'=>'Mật khẩu không đúng'],404);
        // }
        // $token = JWTAuth::fromUser($users);
        // return response()->json([
        //     'message'=>' Đăng nhập thành công',
        //     'user'=>[
        //         'id'=>$users->id,
        //         'email'=>$users->email,
        //     ],
        //     'token'=>$token,
        // ],200);
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
    
}
