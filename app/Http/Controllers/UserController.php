<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Exports\UsersExport;

use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::select('id', 'username', 'email', 'permission_level')
            ->where('role', 'admin')
            ->where('isDelete', 0);

        if ($request->filled('username')) {
            $username = trim($request->username);
            $query->where('username', 'like', '%' . $username . '%');
        }

        $users = $query->paginate(10);
        $users->appends($request->query());

        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        if (!Gate::allows('edit-content')) {
            abort(403, 'Cấm');
        }

        session()->flash('modal', 'add');

        $validateData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ], [
            'email.unique' => 'Email đã được sử dụng',
        ]);

        $validateData['password'] = Hash::make($validateData['password']);
        $validateData['role'] = 'admin';
        $validateData['permission_level'] = 'read';

        User::create($validateData);

        return redirect()->route('users.index')->with('create_success', 'Thêm người dùng thành công');
    }

    public function update(Request $request, $id)
    {
        session()->flash('modal', 'edit');
        session()->flash('edit_id', $id);

        $user = User::findOrFail($id);

        $validateData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'permission_level' => 'required|in:read,edit',
        ], [
            'email.unique' => 'Email đã được sử dụng',
        ]);

        $user->update($validateData);

        return redirect()->route('users.index')->with('update_success', 'Cập nhật thành công');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->isDelete = 1;
        $user->save();

        return redirect()->route('users.index')->with('delete_success', 'Xóa thành công');
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
