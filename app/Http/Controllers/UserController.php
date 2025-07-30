<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::select('username', 'email', 'role', 'permission_level');
        if ($request->filled('username')) {
            $query->where('username', 'like', '%' . $request->username . '%');
        }
        $users = $query->paginate(10);
        $users->appends($request->query());

        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8'
        ], [
            'email.unique' => 'Email đã được sử dụng.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
        ]);
        $validateData['password'] = Hash::make($validateData['password']);
        $validateData['role'] = 'admin';
        $validateData['permission_level'] = 'read';
        User::create($validateData);
        return redirect()->route('users.index')->with('success', 'Thêm người dùng thành công');
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
